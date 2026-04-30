<?php
/*
 * Plugin Name: Maison Dune Contact
 * Description: Contact Messages Management (integrado con Laravel API)
 * Version: 2.2
 * Author: Maison Admin
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

define('MDC_API_URL',      defined('MAISON_API_URL')      ? MAISON_API_URL      : home_url('/maison_dune_api/public/index.php/api'));
define('MDC_API_NAME',     defined('MAISON_API_NAME')     ? MAISON_API_NAME     : 'AdminMaison');
define('MDC_API_EMAIL',    defined('MAISON_API_EMAIL')    ? MAISON_API_EMAIL    : 'proyectomaison20@gmail.com');
define('MDC_API_PASSWORD', defined('MAISON_API_PASSWORD') ? MAISON_API_PASSWORD : 'admin123');

function mdc_get_token() {
    $cached = get_transient('mdc_api_token');
    if ($cached) return $cached;

    $response = wp_remote_post(MDC_API_URL . '/login', [
        'timeout'   => 15,
        'sslverify' => false,
        'headers'   => ['Accept' => 'application/json'],
        'body'      => [
            'email'    => MDC_API_EMAIL,
            'password' => MDC_API_PASSWORD,
            'name'     => MDC_API_NAME,
        ],
    ]);

    if (is_wp_error($response)) {
        $GLOBALS['mdc_last_error'] = 'WP_Error: ' . $response->get_error_message();
        error_log('MDC LOGIN WP_ERROR: ' . $response->get_error_message());
        return null;
    }

    $code = wp_remote_retrieve_response_code($response);
    $body = wp_remote_retrieve_body($response);
    // Strip UTF-8 BOM if present (some PHP files emit it before the JSON).
    $body = preg_replace('/^\xEF\xBB\xBF/', '', $body);
    $result = json_decode($body, true);

    if (isset($result['access_token'])) {
        set_transient('mdc_api_token', $result['access_token'], 3600);
        return $result['access_token'];
    }

    $GLOBALS['mdc_last_error'] = 'API URL: ' . MDC_API_URL . ' | HTTP ' . $code . ' | Body: ' . substr($body, 0, 300);
    return null;
}

add_action('admin_post_maison_contact', 'mdc_save_message');
add_action('admin_post_nopriv_maison_contact', 'mdc_save_message');

function mdc_save_message() {
    if ( ! isset($_POST['mdc_nonce']) || ! wp_verify_nonce($_POST['mdc_nonce'], 'mdc_save_message') ) {
        wp_redirect(home_url('/contact?error=1'));
        exit;
    }

    $data = [
        'name'    => sanitize_text_field($_POST['name']),
        'email'   => sanitize_email($_POST['email']),
        'subject' => sanitize_text_field($_POST['subject']),
        'message' => sanitize_textarea_field($_POST['message']),
    ];

    $response = wp_remote_post(MDC_API_URL . '/messages', [
        'timeout'   => 15,
        'sslverify' => false,
        'headers'   => ['Accept' => 'application/json'],
        'body'      => $data,
    ]);

    if (is_wp_error($response)) {
        error_log('CONTACT ERROR: ' . $response->get_error_message());
        wp_redirect(home_url('/contact?error=1'));
        exit;
    }

    $result = json_decode(wp_remote_retrieve_body($response), true);

    if (isset($result['success']) && $result['success']) {
        wp_redirect(home_url('/contact?sent=1'));
    } else {
        error_log('CONTACT FAILED: ' . print_r($result, true));
        wp_redirect(home_url('/contact?error=1'));
    }
    exit;
}

add_action('admin_menu', 'mdc_menu');

function mdc_menu() {
    add_menu_page(
        'Contact Messages', 'Contact', 'manage_options',
        'maison-contact', 'mdc_admin_page', 'dashicons-email', 30
    );
}

add_action('admin_init', 'mdc_handle_delete');

function mdc_handle_delete() {
    if (isset($_GET['page']) && $_GET['page'] === 'maison-contact'
        && isset($_GET['delete_id']) && is_numeric($_GET['delete_id'])) {

        if ( ! isset($_GET['_wpnonce']) || ! wp_verify_nonce($_GET['_wpnonce'], 'mdc_delete_' . $_GET['delete_id']) ) {
            wp_die('Security check failed.');
        }

        $token = mdc_get_token();
        wp_remote_request(MDC_API_URL . '/messages/' . intval($_GET['delete_id']), [
            'method'    => 'DELETE',
            'timeout'   => 15,
            'sslverify' => false,
            'headers'   => [
                'Authorization' => 'Bearer ' . $token,
                'Accept'        => 'application/json',
            ],
        ]);
        wp_redirect(admin_url('admin.php?page=maison-contact&deleted=1'));
        exit;
    }
}

function mdc_fetch_messages($token) {
    $response = wp_remote_get(MDC_API_URL . '/messages', [
        'timeout'   => 15,
        'sslverify' => false,
        'headers'   => [
            'Accept'        => 'application/json',
            'Authorization' => 'Bearer ' . $token,
        ],
    ]);
    if (is_wp_error($response)) {
        return ['error' => 'WP_Error: ' . $response->get_error_message(), 'code' => 0];
    }
    $code = wp_remote_retrieve_response_code($response);
    $body = wp_remote_retrieve_body($response);
    $body = preg_replace('/^\xEF\xBB\xBF/', '', $body);
    return ['code' => $code, 'body' => $body];
}

function mdc_admin_page() {
    $token = mdc_get_token();

    if (!$token) {
        $err = isset($GLOBALS['mdc_last_error']) ? esc_html($GLOBALS['mdc_last_error']) : '';
        echo '<div class="wrap"><p style="color:red;">Could not connect to Laravel API. Check credentials.</p><pre style="background:#fee;padding:10px;">' . $err . '</pre></div>';
        return;
    }

    // First attempt with cached token.
    $res = mdc_fetch_messages($token);

    // If token is stale (401/403/500), drop the cache and retry once with a fresh one.
    if (!empty($res['code']) && in_array($res['code'], [401, 403, 419, 500], true)) {
        delete_transient('mdc_api_token');
        $token = mdc_get_token();
        if ($token) {
            $res = mdc_fetch_messages($token);
        }
    }

    $messages = [];
    $fetch_error = '';
    if (isset($res['error'])) {
        $fetch_error = $res['error'];
    } elseif ($res['code'] !== 200) {
        $fetch_error = 'HTTP ' . $res['code'] . ' — ' . substr($res['body'], 0, 200);
    } else {
        $result = json_decode($res['body'], true);
        if (isset($result['data']['data'])) {
            $messages = $result['data']['data'];
        } elseif (json_last_error() !== JSON_ERROR_NONE) {
            $fetch_error = 'JSON decode failed: ' . json_last_error_msg();
        }
    }
    ?>
    <div class="wrap">
        <h1>Contact Messages</h1>

        <?php if (isset($_GET['deleted'])) : ?>
            <div class="notice notice-success"><p>Message deleted successfully.</p></div>
        <?php endif; ?>

        <?php if ($fetch_error) : ?>
            <div class="notice notice-error"><p><strong>Could not load messages:</strong> <?= esc_html($fetch_error) ?></p></div>
        <?php endif; ?>

        <table class="wp-list-table widefat fixed striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Subject</th>
                    <th>Message</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($messages)) : ?>
                    <tr><td colspan="6">No messages yet.</td></tr>
                <?php else : ?>
                    <?php foreach ($messages as $m) : ?>
                    <tr>
                        <td><?= esc_html($m['name']) ?></td>
                        <td><?= esc_html($m['email']) ?></td>
                        <td><?= esc_html($m['subject']) ?></td>
                        <td><?= esc_html($m['message']) ?></td>
                        <td><?= esc_html(date('d/m/Y H:i', strtotime($m['created_at']))) ?></td>
                        <td>
                            <a href="<?= wp_nonce_url(admin_url('admin.php?page=maison-contact&delete_id=' . $m['id']), 'mdc_delete_' . $m['id']) ?>"
                               onclick="return confirm('Are you sure you want to delete this message?')"
                               style="color:red; text-decoration:none;">
                                Delete
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php
}