<?php
/*
 * Plugin Name: Maison Dune Reservations
 * Description: Table Reservations Management (integrado con Laravel API)
 * Version: 1.1
 * Author: Maison Admin
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

define('MDR_API_URL',      defined('MAISON_API_URL')      ? MAISON_API_URL      : home_url('/maison_dune_api/public/index.php/api'));
define('MDR_API_NAME',     defined('MAISON_API_NAME')     ? MAISON_API_NAME     : 'AdminMaison');
define('MDR_API_EMAIL',    defined('MAISON_API_EMAIL')    ? MAISON_API_EMAIL    : 'proyectomaison20@gmail.com');
define('MDR_API_PASSWORD', defined('MAISON_API_PASSWORD') ? MAISON_API_PASSWORD : 'admin123');

function mdr_get_token() {
    $cached = get_transient('mdr_api_token');
    if ($cached) return $cached;

    $response = wp_remote_post(MDR_API_URL . '/login', [
        'timeout'   => 15,
        'sslverify' => false,
        'headers'   => ['Accept' => 'application/json'],
        'body'      => [
            'email'    => MDR_API_EMAIL,
            'password' => MDR_API_PASSWORD,
            'name'     => MDR_API_NAME,
        ],
    ]);

    if (is_wp_error($response)) {
        $GLOBALS['mdr_last_error'] = 'WP_Error: ' . $response->get_error_message();
        error_log('MDR LOGIN WP_ERROR: ' . $response->get_error_message());
        return null;
    }

    $code = wp_remote_retrieve_response_code($response);
    $body = wp_remote_retrieve_body($response);
    // Strip UTF-8 BOM if present (some PHP files emit it before the JSON).
    $body = preg_replace('/^\xEF\xBB\xBF/', '', $body);
    $result = json_decode($body, true);

    if (isset($result['access_token'])) {
        set_transient('mdr_api_token', $result['access_token'], 3600);
        return $result['access_token'];
    }

    $GLOBALS['mdr_last_error'] = 'API URL: ' . MDR_API_URL . ' | HTTP ' . $code . ' | Body: ' . substr($body, 0, 300);
    return null;
}

add_action('admin_post_maison_reservation', 'mdr_save_reservation');
add_action('admin_post_nopriv_maison_reservation', 'mdr_save_reservation');

function mdr_save_reservation() {
    if ( ! isset($_POST['mdr_nonce']) || ! wp_verify_nonce($_POST['mdr_nonce'], 'mdr_save_reservation') ) {
        wp_redirect(home_url('/restaurant?error=1'));
        exit;
    }

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

    $token = mdr_get_token();

    $response = wp_remote_post(MDR_API_URL . '/reservations', [
        'timeout'   => 15,
        'sslverify' => false,
        'headers'   => [
            'Authorization' => 'Bearer ' . $token,
            'Accept'        => 'application/json',
        ],
        'body'      => $data,
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

    add_submenu_page(
        'maison-reservations',
        'Restaurant Reservations',
        'Restaurant',
        'manage_options',
        'maison-reservations',
        'mdr_admin_page'
    );

    add_submenu_page(
        'maison-reservations',
        'Event Reservations',
        'Events',
        'manage_options',
        'maison-event-reservations',
        'mdr_event_admin_page'
    );

    add_submenu_page(
        'maison-reservations',
        'Room Bookings',
        'Rooms',
        'manage_options',
        'maison-room-reservations',
        'mdr_room_admin_page'
    );
}

add_action('admin_init', 'mdr_handle_delete');

function mdr_handle_delete() {
    if (!isset($_GET['delete_id']) || !is_numeric($_GET['delete_id'])) {
        return;
    }
    $page = isset($_GET['page']) ? $_GET['page'] : '';
    if ($page !== 'maison-reservations' && $page !== 'maison-event-reservations' && $page !== 'maison-room-reservations') {
        return;
    }

    if ( ! isset($_GET['_wpnonce']) || ! wp_verify_nonce($_GET['_wpnonce'], 'mdr_delete_' . $_GET['delete_id']) ) {
        wp_die('Security check failed.');
    }

    $token = mdr_get_token();
    wp_remote_request(MDR_API_URL . '/reservations/' . intval($_GET['delete_id']), [
        'method'    => 'DELETE',
        'timeout'   => 15,
        'sslverify' => false,
        'headers'   => [
            'Authorization' => 'Bearer ' . $token,
            'Accept'        => 'application/json',
        ],
    ]);
    wp_redirect(admin_url('admin.php?page=' . $page . '&deleted=1'));
    exit;
}

function mdr_fetch_all_reservations() {
    $token = mdr_get_token();
    if (!$token) {
        return [false, []];
    }
    $response = wp_remote_get(MDR_API_URL . '/reservations', [
        'timeout'   => 15,
        'sslverify' => false,
        'headers'   => [
            'Accept'        => 'application/json',
            'Authorization' => 'Bearer ' . $token,
        ],
    ]);
    if (is_wp_error($response)) return [true, []];
    $body = wp_remote_retrieve_body($response);
    // Strip UTF-8 BOM if present (Laravel API can emit it before the JSON).
    $body = preg_replace('/^\xEF\xBB\xBF/', '', $body);
    $result = json_decode($body, true);
    return [true, isset($result['data']) ? $result['data'] : []];
}

function mdr_admin_page() {
    list($connected, $all) = mdr_fetch_all_reservations();

    if (!$connected) {
        echo '<div class="wrap"><p style="color:red;">Could not connect to Laravel API. Check credentials.</p></div>';
        return;
    }

    $reservations = array_values(array_filter($all, function ($r) {
        return empty($r['event_slug']) && empty($r['room_slug']);
    }));
    ?>
    <div class="wrap">
        <h1 style="display:flex;align-items:center;gap:10px;">
            <span class="dashicons dashicons-food" style="font-size:28px;color:#c9a84c;"></span>
            Restaurant Reservations
            <span style="font-size:13px;color:#666;font-weight:400;margin-left:auto;">
                Total: <?= count($reservations) ?>
            </span>
        </h1>

        <p style="color:#666;font-style:italic;margin:6px 0 18px;">
            Reservations made through the dining room booking flow. Event registrations are listed under
            <a href="<?= admin_url('admin.php?page=maison-event-reservations') ?>">Events</a>.
        </p>

        <?php if (isset($_GET['deleted'])) : ?>
            <div class="notice notice-success is-dismissible"><p>Reservation deleted successfully.</p></div>
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
                    <tr><td colspan="9" style="text-align:center;padding:24px;color:#888;">No restaurant reservations yet.</td></tr>
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
                            <a href="<?= wp_nonce_url(admin_url('admin.php?page=maison-reservations&delete_id=' . $r['id']), 'mdr_delete_' . $r['id']) ?>"
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

function mdr_event_admin_page() {
    list($connected, $all) = mdr_fetch_all_reservations();

    if (!$connected) {
        $err = isset($GLOBALS['mdr_last_error']) ? esc_html($GLOBALS['mdr_last_error']) : '';
        echo '<div class="wrap"><p style="color:red;">Could not connect to Laravel API. Check credentials.</p><pre style="background:#fee;padding:10px;">' . $err . '</pre></div>';
        return;
    }

    $events = array_values(array_filter($all, function ($r) {
        return !empty($r['event_slug']);
    }));

    $grouped = [];
    foreach ($events as $r) {
        $slug = $r['event_slug'];
        if (!isset($grouped[$slug])) {
            $grouped[$slug] = [
                'title'   => $r['event_title'] ?: $slug,
                'date'    => $r['date'],
                'time'    => $r['time'],
                'location'=> $r['room_number'] ?? '',
                'rows'    => [],
                'guests'  => 0,
            ];
        }
        $grouped[$slug]['rows'][] = $r;
        $grouped[$slug]['guests'] += (int) $r['guests'];
    }

    uasort($grouped, function ($a, $b) {
        return strcmp($a['date'], $b['date']);
    });
    ?>
    <div class="wrap">
        <h1 style="display:flex;align-items:center;gap:10px;">
            <span class="dashicons dashicons-tickets-alt" style="font-size:28px;color:#c9a84c;"></span>
            Event Reservations
            <span style="font-size:13px;color:#666;font-weight:400;margin-left:auto;">
                <?= count($events) ?> registrations across <?= count($grouped) ?> event<?= count($grouped) === 1 ? '' : 's' ?>
            </span>
        </h1>

        <p style="color:#666;font-style:italic;margin:6px 0 18px;">
            Registrations made from the public events listing.
            Restaurant reservations are listed under
            <a href="<?= admin_url('admin.php?page=maison-reservations') ?>">Restaurant</a>.
        </p>

        <?php if (isset($_GET['deleted'])) : ?>
            <div class="notice notice-success is-dismissible"><p>Registration deleted successfully.</p></div>
        <?php endif; ?>

        <?php if (empty($grouped)) : ?>
            <div class="notice notice-info"><p>No event registrations yet.</p></div>
        <?php else : ?>

            <?php foreach ($grouped as $slug => $g) :
                $event_post = get_page_by_path($slug, OBJECT, 'event');
                $event_link = $event_post ? get_permalink($event_post) : '';
                $capacity   = $event_post ? (int) get_post_meta($event_post->ID, 'event_capacity', true) : 0;
                $remaining  = $capacity ? $capacity - $g['guests'] : null;
            ?>
                <div style="background:#fff;border:1px solid #e5e0d3;border-left:4px solid #c9a84c;margin:0 0 24px;padding:16px 20px;">
                    <div style="display:flex;align-items:center;gap:14px;flex-wrap:wrap;margin-bottom:10px;">
                        <span style="background:linear-gradient(135deg,#ffcf7b,#d9a35a);color:#1a1a1a;font-size:11px;letter-spacing:1.4px;text-transform:uppercase;font-weight:700;padding:4px 10px;border-radius:2px;">★ Event</span>
                        <h2 style="margin:0;font-size:20px;font-weight:500;flex:1;">
                            <?= esc_html($g['title']) ?>
                            <?php if ($event_link) : ?>
                                <a href="<?= esc_url($event_link) ?>" target="_blank" style="font-size:12px;font-weight:400;margin-left:8px;text-decoration:none;">View page ↗</a>
                            <?php endif; ?>
                        </h2>
                        <span style="color:#666;font-size:13px;">
                            <strong><?= esc_html(date('D, j M Y', strtotime($g['date']))) ?></strong>
                            · <?= esc_html(substr($g['time'], 0, 5)) ?>h
                        </span>
                    </div>

                    <div style="display:flex;gap:20px;flex-wrap:wrap;font-size:13px;color:#555;margin-bottom:12px;">
                        <?php if ($g['location']) : ?>
                            <span>📍 <?= esc_html($g['location']) ?></span>
                        <?php endif; ?>
                        <span>👥 <?= count($g['rows']) ?> registration<?= count($g['rows']) === 1 ? '' : 's' ?></span>
                        <span>🎟 <?= $g['guests'] ?> guest<?= $g['guests'] === 1 ? '' : 's' ?> total</span>
                        <?php if ($capacity) : ?>
                            <span style="color:<?= $remaining <= 0 ? '#a33' : ($remaining <= max(3, $capacity * 0.15) ? '#b8862e' : '#2d6e3f') ?>;font-weight:600;">
                                <?= $remaining <= 0 ? 'Sold out' : ($remaining . ' / ' . $capacity . ' seats left') ?>
                            </span>
                        <?php endif; ?>
                    </div>

                    <table class="wp-list-table widefat striped" style="margin-top:6px;">
                        <thead>
                            <tr>
                                <th style="width:60px;">Code</th>
                                <th>Guest</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Guests</th>
                                <th>Notes</th>
                                <th style="width:110px;">Status</th>
                                <th style="width:80px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($g['rows'] as $r) :
                                $code = 'MD-' . str_pad($r['id'], 5, '0', STR_PAD_LEFT);
                                $checked_in = !empty($r['checked_in_at']);
                            ?>
                                <tr>
                                    <td><code style="font-size:11px;"><?= esc_html($code) ?></code></td>
                                    <td><?= esc_html($r['first_name'] . ' ' . $r['last_name']) ?></td>
                                    <td><?= esc_html($r['email']) ?></td>
                                    <td><?= esc_html($r['phone']) ?></td>
                                    <td><?= esc_html($r['guests']) ?></td>
                                    <td><?= esc_html($r['notes'] ?? '-') ?></td>
                                    <td>
                                        <?php if ($checked_in) : ?>
                                            <span style="background:#e1f5e1;color:#2d6e3f;padding:3px 8px;font-size:11px;font-weight:600;border-radius:3px;">✓ Checked in</span>
                                        <?php else : ?>
                                            <span style="background:#f0ece0;color:#8a7d6b;padding:3px 8px;font-size:11px;border-radius:3px;">Pending</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="<?= wp_nonce_url(admin_url('admin.php?page=maison-event-reservations&delete_id=' . $r['id']), 'mdr_delete_' . $r['id']) ?>"
                                           onclick="return confirm('Cancel registration of <?= esc_js($r['first_name'] . ' ' . $r['last_name']) ?>?')"
                                           style="color:red;text-decoration:none;">
                                            Delete
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endforeach; ?>

        <?php endif; ?>
    </div>
    <?php
}

function mdr_room_admin_page() {
    list($connected, $all) = mdr_fetch_all_reservations();

    if (!$connected) {
        $err = isset($GLOBALS['mdr_last_error']) ? esc_html($GLOBALS['mdr_last_error']) : '';
        echo '<div class="wrap"><p style="color:red;">Could not connect to Laravel API. Check credentials.</p><pre style="background:#fee;padding:10px;">' . $err . '</pre></div>';
        return;
    }

    $reservations = array_values(array_filter($all, function ($r) {
        return !empty($r['room_slug']);
    }));
    ?>
    <div class="wrap">
        <h1 style="display:flex;align-items:center;gap:10px;">
            <span class="dashicons dashicons-admin-home" style="font-size:28px;color:#c9a84c;"></span>
            Room Bookings
            <span style="font-size:13px;color:#666;font-weight:400;margin-left:auto;">
                Total: <?= count($reservations) ?>
            </span>
        </h1>

        <p style="color:#666;font-style:italic;margin:6px 0 18px;">
            Reservations made through the room booking flow.
            Restaurant reservations are listed under
            <a href="<?= admin_url('admin.php?page=maison-reservations') ?>">Restaurant</a>.
        </p>

        <?php if (isset($_GET['deleted'])) : ?>
            <div class="notice notice-success is-dismissible"><p>Room booking deleted successfully.</p></div>
        <?php endif; ?>

        <table class="wp-list-table widefat fixed striped">
            <thead>
                <tr>
                    <th>Guest</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Room</th>
                    <th>Check-in</th>
                    <th>Check-out</th>
                    <th>Nights</th>
                    <th>Guests</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($reservations)) : ?>
                    <tr><td colspan="10" style="text-align:center;padding:24px;color:#888;">No room bookings yet.</td></tr>
                <?php else : ?>
                    <?php foreach ($reservations as $r) :
                        $checkin  = !empty($r['date'])          ? strtotime($r['date'])          : null;
                        $checkout = !empty($r['checkout_date']) ? strtotime($r['checkout_date']) : null;
                        $nights   = ($checkin && $checkout) ? max(1, round(($checkout - $checkin) / 86400)) : '-';
                        $price    = isset($r['total_price']) ? number_format((float) $r['total_price'], 2, ',', '.') . ' &euro;' : '-';
                    ?>
                    <tr>
                        <td><?= esc_html(trim($r['first_name'] . ' ' . $r['last_name'])) ?></td>
                        <td><?= esc_html($r['email']) ?></td>
                        <td><?= esc_html($r['phone'] ?? '-') ?></td>
                        <td><?= esc_html($r['room_title'] ?? $r['room_slug']) ?></td>
                        <td><?= $checkin  ? esc_html(date('d/m/Y', $checkin))  : '-' ?></td>
                        <td><?= $checkout ? esc_html(date('d/m/Y', $checkout)) : '-' ?></td>
                        <td><?= esc_html($nights) ?></td>
                        <td><?= esc_html($r['guests']) ?></td>
                        <td><?= esc_html($price) ?></td>
                        <td>
                            <a href="<?= wp_nonce_url(admin_url('admin.php?page=maison-room-reservations&delete_id=' . $r['id']), 'mdr_delete_' . $r['id']) ?>"
                               onclick="return confirm('Are you sure you want to delete this room booking?')"
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

/**
 * When an admin trashes/deletes an Event or Room post, ask Laravel to cancel
 * every reservation tied to that post slug and email all affected guests.
 */
function mdr_cancel_reservations_for_post($post_id) {
    $post = get_post($post_id);
    if (!$post) return;

    if (!in_array($post->post_type, ['event', 'room'], true)) {
        return;
    }

    // Avoid running twice (trash + delete).
    static $handled = [];
    if (isset($handled[$post_id])) return;
    $handled[$post_id] = true;

    $slug = $post->post_name;
    if (empty($slug)) return;

    $token = mdr_get_token();
    if (!$token) return;

    wp_remote_post(MDR_API_URL . '/reservations/cancel-by-slug', [
        'timeout'   => 30,
        'sslverify' => false,
        'headers'   => [
            'Authorization' => 'Bearer ' . $token,
            'Accept'        => 'application/json',
        ],
        'body'      => [
            'type' => $post->post_type,
            'slug' => $slug,
        ],
    ]);
}

add_action('wp_trash_post', 'mdr_cancel_reservations_for_post', 10, 1);
add_action('before_delete_post', 'mdr_cancel_reservations_for_post', 10, 1);