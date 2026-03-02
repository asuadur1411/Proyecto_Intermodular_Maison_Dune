<?php
/*
 * Plugin Name: Maison Dune Contact
 * Description: Contact Messages Management 
 * Version: 1.0
 * Author: Maison Admin
 */


/**
 * Contact Form Management
 * 
*/
register_activation_hook(__FILE__, 'mdc_create_table');

function mdc_create_table() {
    global $wpdb;
    $table =  $wpdb->prefix . 'contact_messages';
    $charset = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE IF NOT EXISTS $table (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100),
        email VARCHAR(100),
        subject VARCHAR(100),
        message TEXT,
        date DATETIME DEFAULT CURRENT_TIMESTAMP
    ) $charset;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}

/* Recibir y guardar el formulario */

add_action('admin_post_maison_contact', 'mdc_save_message');
add_action('admin_post_nopriv_maison_contact', 'mdc_save_message');

function mdc_save_message() {
    global $wpdb;

    $name  = sanitize_text_field($_POST['name']);
    $email   = sanitize_email($_POST['email']);
    $subject  = sanitize_text_field($_POST['subject']);
    $message = sanitize_textarea_field($_POST['message']);

    $wpdb->insert(
        $wpdb->prefix . 'contact_messages',
        compact('name', 'email', 'subject', 'message')
    );

    wp_redirect(home_url('/contact?sent=1'));
    exit;
}

/* Crear menu en el admin */

add_action('admin_menu', 'mdc_menu');

function mdc_menu() {
    add_menu_page(
        'Contact Messages',
        'Contact',
        'manage_options',
        'maison-contact',
        'mdc_admin_page',
        'dashicons-email',
        30
    );
}



/*  Mostrar los mensajes en el admin */

function mdc_admin_page() {
    global $wpdb;
    $messages = $wpdb->get_results(
        "SELECT * FROM {$wpdb->prefix}contact_messages ORDER BY date DESC"
    );
    ?>
    <div class="wrap">
        <h1>Contact Messages</h1>

        <?php if (isset($_GET['deleted'])) : ?>
            <div class="notice notice-success is-dismissible"><p>Message deleted.</p></div>
        <?php endif; ?>

        <table class="wp-list-table widefat fixed striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Subject</th>
                    <th>Message</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($messages as $m) : ?>
                <tr>
                    <td><?= esc_html($m->name) ?></td>
                    <td><?= esc_html($m->email) ?></td>
                    <td><?= esc_html($m->subject) ?></td>
                    <td><?= esc_html($m->message) ?></td>
                    <td><?= esc_html($m->date) ?></td>
                    <td>
                        <a href="<?php echo admin_url('admin-post.php?action=mdc_delete&id=' . $m->id); ?>"
                           onclick="return confirm('Delete this message?')"
                           style="color:red;">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php
}


add_action('admin_post_mdc_delete', 'mdc_delete_message');

function mdc_delete_message() {
    if (!current_user_can('manage_options')) wp_die('No permission');

    global $wpdb;
    $id = intval($_GET['id']);

    $wpdb->delete(
        $wpdb->prefix . 'contact_messages',
        ['id' => $id]
    );

    wp_redirect(admin_url('admin.php?page=maison-contact&deleted=1'));
    exit;
}