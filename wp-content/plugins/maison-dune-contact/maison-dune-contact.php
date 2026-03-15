<?php
/*
 * Plugin Name: Maison Dune Contact
 * Description: Contact Messages Management (integrado con Laravel API)
 * Version: 2.1
 * Author: Maison Admin
 */

define('MDC_API_URL', 'http://maison.test/maison_dune_api/public/api');
define('MDR_API_NAME', 'AdminMaison');
define('MDC_API_EMAIL', 'proyectomaison20@gmail.com');
define('MDC_API_PASSWORD', 'admin123');

// ── Obtener token de Laravel ──────────────────────────────────────────────────
function mdc_get_token() {
    $token = get_transient('mdc_api_token');

    $response = wp_remote_post(MDC_API_URL . '/login', [
        'timeout'  => 15,
        'headers'  => ['Content-Type' => 'application/json'],
        'body'     => json_encode([
            'email'    => MDC_API_EMAIL,
            'password' => MDC_API_PASSWORD,
            'name'     => MDR_API_NAME,
        ]),
    ]);

    if (is_wp_error($response)) {
        error_log('MDC LOGIN WP_ERROR: ' . $response->get_error_message());
        return null;
    }

    $status = wp_remote_retrieve_response_code($response);
    $body = wp_remote_retrieve_body($response);
    
    error_log('MDC LOGIN STATUS: ' . $status);
    error_log('MDC LOGIN BODY: ' . $body);

    $result = json_decode($body, true);

    if (isset($result['access_token'])) {
        return $result['access_token'];
    }

    return null;
}

// ── Procesar formulario → Laravel ─────────────────────────────────────────────
add_action('admin_post_maison_contact', 'mdc_save_message');
add_action('admin_post_nopriv_maison_contact', 'mdc_save_message');

function mdc_save_message() {
    $data = [
        'name'    => sanitize_text_field($_POST['name']),
        'email'   => sanitize_email($_POST['email']),
        'subject' => sanitize_text_field($_POST['subject']),
        'message' => sanitize_textarea_field($_POST['message']),
    ];

    $response = wp_remote_post(MDC_API_URL . '/messages', [
        'timeout' => 15,
        'headers' => ['Content-Type' => 'application/json'],
        'body'    => json_encode($data),
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

// ── Menú WP Admin ─────────────────────────────────────────────────────────────
add_action('admin_menu', 'mdc_menu');

function mdc_menu() {
    add_menu_page(
        'Contact Messages', 'Contact', 'manage_options',
        'maison-contact', 'mdc_admin_page', 'dashicons-email', 30
    );
}

function mdc_admin_page() {
    // Manejar borrado
    if (isset($_GET['delete_id']) && is_numeric($_GET['delete_id'])) {
        $token = mdc_get_token();
        wp_remote_request(MDC_API_URL . '/messages/' . intval($_GET['delete_id']), [
            'method'  => 'DELETE',
            'timeout' => 15,
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
                'Accept'        => 'application/json',
            ],
        ]);
        wp_redirect(admin_url('admin.php?page=maison-contact&deleted=1'));
        exit;
    }

    $token = mdc_get_token();

    if (!$token) {
        echo '<div class="wrap"><p style="color:red;">⚠️ Could not connect to Laravel API. Check credentials.</p></div>';
        return;
    }

    $response = wp_remote_get(MDC_API_URL . '/messages', [
        'timeout' => 15,
        'headers' => [
            'Accept'        => 'application/json',
            'Authorization' => 'Bearer ' . $token,
        ],
    ]);

    $messages = [];
    if (!is_wp_error($response)) {
        $result = json_decode(wp_remote_retrieve_body($response), true);
        if (isset($result['data']['data'])) {
            $messages = $result['data']['data'];
        }
    }
    ?>
    <div class="wrap">
        <h1>Contact Messages</h1>

        <?php if (isset($_GET['deleted'])) : ?>
            <div class="notice notice-success"><p>Message deleted successfully.</p></div>
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
                            <a href="<?= admin_url('admin.php?page=maison-contact&delete_id=' . $m['id']) ?>"
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