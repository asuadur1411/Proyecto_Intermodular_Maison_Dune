<?php
/*
 * Plugin Name: Maison Dune Reservations
 * Description: Table Reservations Management (integrado con Laravel API)
 * Version: 1.0
 * Author: Maison Admin
 */

define('MDR_API_URL', 'http://maison.test/maison_dune_api/public/index.php/api');
define('MDR_API_NAME', 'AdminMaison');
define('MDR_API_EMAIL', 'proyectomaison20@gmail.com');
define('MDR_API_PASSWORD', 'admin123');

function mdr_get_token() {
    $response = wp_remote_post(MDR_API_URL . '/login', [
        'timeout' => 15,
        'headers' => ['Content-Type' => 'application/json'],
        'body'    => json_encode([
            'email'    => MDR_API_EMAIL,
            'password' => MDR_API_PASSWORD,
            'name'     => MDR_API_NAME,
        ]),
    ]);

    if (is_wp_error($response)) {
        error_log('MDR LOGIN WP_ERROR: ' . $response->get_error_message());
        return null;
    }

    $result = json_decode(wp_remote_retrieve_body($response), true);

    if (isset($result['access_token'])) {
        return $result['access_token'];
    }

    return null;
}

add_action('admin_post_maison_reservation', 'mdr_save_reservation');
add_action('admin_post_nopriv_maison_reservation', 'mdr_save_reservation');

function mdr_save_reservation() {
    $data = [
        'first_name' => sanitize_text_field($_POST['first_name']),
        'last_name'  => sanitize_text_field($_POST['last_name']),
        'email'      => sanitize_email($_POST['email']),
        'phone'      => sanitize_text_field($_POST['phone']),
        'date'       => sanitize_text_field($_POST['date']),
        'time'       => sanitize_text_field($_POST['time']),
        'guests'     => sanitize_text_field($_POST['guests']),
        'section'    => sanitize_text_field($_POST['section']),
        'notes'      => sanitize_textarea_field($_POST['notes']),
    ];

    $response = wp_remote_post(MDR_API_URL . '/reservations', [
        'timeout' => 15,
        'headers' => ['Content-Type' => 'application/json'],
        'body'    => json_encode($data),
    ]);
    $body = wp_remote_retrieve_body($response);
    $code = wp_remote_retrieve_response_code($response);
    error_log('RESERVATION CODE: ' . $code);
    error_log('RESERVATION BODY: ' . $body);
    if (is_wp_error($response)) {
        error_log('RESERVATION ERROR: ' . $response->get_error_message());
        wp_redirect(home_url('/restaurant?error=1'));
        exit;
    }

    $result = json_decode(wp_remote_retrieve_body($response), true);

    if (isset($result['success']) && $result['success']) {
        wp_redirect(home_url('/restaurant?sent=1'));
    } else {
        error_log('RESERVATION FAILED: ' . print_r($result, true));
        wp_redirect(home_url('/restaurant?error=1'));
    }
    exit;
}

add_action('admin_menu', 'mdr_menu');

function mdr_menu() {
    add_menu_page(
        'Reservations', 'Reservations', 'manage_options',
        'maison-reservations', 'mdr_admin_page', 'dashicons-calendar-alt', 31
    );
}

function mdr_admin_page() {
    // Manejar borrado
    if (isset($_GET['delete_id']) && is_numeric($_GET['delete_id'])) {
        $token = mdr_get_token();
        wp_remote_request(MDR_API_URL . '/reservations/' . intval($_GET['delete_id']), [
            'method'  => 'DELETE',
            'timeout' => 15,
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
                'Accept'        => 'application/json',
            ],
        ]);
        wp_redirect(admin_url('admin.php?page=maison-reservations&deleted=1'));
        exit;
    }

    $token = mdr_get_token();

    if (!$token) {
        echo '<div class="wrap"><p style="color:red;">⚠️ Could not connect to Laravel API. Check credentials.</p></div>';
        return;
    }

    $response = wp_remote_get(MDR_API_URL . '/reservations', [
        'timeout' => 15,
        'headers' => [
            'Accept'        => 'application/json',
            'Authorization' => 'Bearer ' . $token,
        ],
    ]);

    $reservations = [];
    if (!is_wp_error($response)) {
        $result = json_decode(wp_remote_retrieve_body($response), true);
        if (isset($result['data'])) {
            $reservations = $result['data'];
        }
    }
    ?>
    <div class="wrap">
        <h1>Table Reservations</h1>

        <?php if (isset($_GET['deleted'])) : ?>
            <div class="notice notice-success"><p>Reservation deleted successfully.</p></div>
        <?php endif; ?>

        <table class="wp-list-table widefat fixed striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Guests</th>
                    <th>Section</th>
                    <th>Notes</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($reservations)) : ?>
                    <tr><td colspan="9">No reservations yet.</td></tr>
                <?php else : ?>
                    <?php foreach ($reservations as $r) : ?>
                    <tr>
                        <td><?= esc_html($r['first_name'] . ' ' . $r['last_name']) ?></td>
                        <td><?= esc_html($r['email']) ?></td>
                        <td><?= esc_html($r['phone']) ?></td>
                        <td><?= esc_html(date('d/m/Y', strtotime($r['date']))) ?></td>
                        <td><?= esc_html($r['time']) ?></td>
                        <td><?= esc_html($r['guests']) ?></td>
                        <td><?= esc_html($r['section'] ?? '-') ?></td>
                        <td><?= esc_html($r['notes'] ?? '-') ?></td>
                        <td>
                            <a href="<?= admin_url('admin.php?page=maison-reservations&delete_id=' . $r['id']) ?>"
                               onclick="return confirm('Are you sure you want to delete this reservation?')"
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