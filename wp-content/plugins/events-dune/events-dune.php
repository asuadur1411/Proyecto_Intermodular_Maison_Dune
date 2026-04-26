<?php
/*
Plugin Name: Events Dune
Description: Custom Post Type y gestión premium para los eventos de Maison Dune.
Version: 1.0.0
Author: Maison Dune
*/

if (!defined('ABSPATH')) {
    exit;
}

/* =========================
   REGISTER CPT + TAXONOMY
========================= */
function events_dune_register_event_cpt()
{
    register_post_type('event', array(
        'labels' => array(
            'name'               => 'Events',
            'singular_name'      => 'Event',
            'add_new'            => 'Add Event',
            'add_new_item'       => 'Add New Event',
            'edit_item'          => 'Edit Event',
            'new_item'           => 'New Event',
            'view_item'          => 'View Event',
            'search_items'       => 'Search Events',
            'not_found'          => 'No events found',
            'not_found_in_trash' => 'No events found in Trash',
            'all_items'          => 'All Events',
            'menu_name'          => 'Events',
        ),
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'has_archive'        => true,
        'rewrite'            => array('slug' => 'events'),
        'menu_icon'          => 'dashicons-calendar-alt',
        'supports'           => array('title', 'editor', 'excerpt', 'thumbnail'),
        'show_in_rest'       => true,
        'menu_position'      => 7,
    ));

    register_taxonomy('event_category', 'event', array(
        'labels' => array(
            'name'              => 'Event Categories',
            'singular_name'     => 'Event Category',
            'search_items'      => 'Search Event Categories',
            'all_items'         => 'All Event Categories',
            'parent_item'       => 'Parent Event Category',
            'parent_item_colon' => 'Parent Event Category:',
            'edit_item'         => 'Edit Event Category',
            'update_item'       => 'Update Event Category',
            'add_new_item'      => 'Add New Event Category',
            'new_item_name'     => 'New Event Category Name',
            'menu_name'         => 'Event Categories',
        ),
        'hierarchical'      => true,
        'show_in_rest'      => true,
        'show_admin_column' => true,
        'rewrite'           => array('slug' => 'event-category'),
    ));
}
add_action('init', 'events_dune_register_event_cpt');

/* =========================
   ACTIVATION / DEACTIVATION
========================= */
function events_dune_activate_plugin()
{
    events_dune_register_event_cpt();
    flush_rewrite_rules();
}
register_activation_hook(__FILE__, 'events_dune_activate_plugin');

function events_dune_deactivate_plugin()
{
    flush_rewrite_rules();
}
register_deactivation_hook(__FILE__, 'events_dune_deactivate_plugin');

/* =========================
   META BOX PREMIUM
========================= */
function events_dune_add_premium_metabox()
{
    add_meta_box(
        'events_dune_premium_settings',
        'Premium Settings',
        'events_dune_render_premium_metabox',
        'event',
        'side',
        'default'
    );
}
add_action('add_meta_boxes', 'events_dune_add_premium_metabox');

function events_dune_render_premium_metabox($post)
{
    wp_nonce_field('events_dune_save_premium_meta', 'events_dune_premium_nonce');

    $featured_event = get_post_meta($post->ID, 'featured_event', true);
    $premium_order  = get_post_meta($post->ID, 'premium_order', true);
    ?>
    <p>
        <label>
            <input type="checkbox" name="featured_event" value="1" <?php checked($featured_event, '1'); ?>>
            Mark as premium event
        </label>
    </p>

    <p>
        <label for="premium_order"><strong>Premium order</strong></label>
        <input
            type="number"
            id="premium_order"
            name="premium_order"
            value="<?php echo esc_attr($premium_order); ?>"
            min="1"
            step="1"
            style="width: 100%;"
        >
        <small>Use 1, 2, 3... Lower numbers appear first.</small>
    </p>
    <?php
}

/* =========================
   SAVE META BOX
========================= */
function events_dune_save_premium_meta($post_id)
{
    if (!isset($_POST['events_dune_premium_nonce'])) {
        return;
    }

    if (!wp_verify_nonce($_POST['events_dune_premium_nonce'], 'events_dune_save_premium_meta')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    $featured_value = isset($_POST['featured_event']) ? '1' : '0';
    update_post_meta($post_id, 'featured_event', $featured_value);

    if (isset($_POST['premium_order']) && $_POST['premium_order'] !== '') {
        update_post_meta($post_id, 'premium_order', absint($_POST['premium_order']));
    } else {
        delete_post_meta($post_id, 'premium_order');
    }
}
add_action('save_post_event', 'events_dune_save_premium_meta');

/* =========================
   ADMIN COLUMNS
========================= */
function events_dune_event_columns($columns)
{
    $new_columns = array();

    foreach ($columns as $key => $value) {
        $new_columns[$key] = $value;

        if ($key === 'title') {
            $new_columns['featured_event'] = 'Premium';
            $new_columns['premium_order']  = 'Premium Order';
        }
    }

    return $new_columns;
}
add_filter('manage_event_posts_columns', 'events_dune_event_columns');

function events_dune_event_column_content($column, $post_id)
{
    if ($column === 'featured_event') {
        $featured = get_post_meta($post_id, 'featured_event', true);
        echo ($featured === '1') ? 'Yes' : 'No';
    }

    if ($column === 'premium_order') {
        $order = get_post_meta($post_id, 'premium_order', true);
        echo $order ? esc_html($order) : '—';
    }
}
add_action('manage_event_posts_custom_column', 'events_dune_event_column_content', 10, 2);