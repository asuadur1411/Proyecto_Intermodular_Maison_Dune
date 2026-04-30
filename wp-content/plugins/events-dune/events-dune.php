<?php
/*
Plugin Name: Events Dune
Description: Custom Post Type y panel de programación para los eventos de Maison Dune.
Version: 1.1.0
Author: Maison Dune
*/

if (!defined('ABSPATH')) {
    exit;
}

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
        'has_archive'        => false,
        'rewrite'            => array('slug' => 'event'),
        'menu_icon'          => 'dashicons-calendar-alt',
        'supports'           => array('title', 'editor', 'excerpt', 'thumbnail', 'custom-fields'),
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

    // Register meta fields so they are exposed to the REST API and the block editor
    // can save them without breaking the JSON response.
    $string_meta = array('event_date', 'event_time', 'event_location');
    foreach ($string_meta as $key) {
        register_post_meta('event', $key, array(
            'type'              => 'string',
            'single'            => true,
            'show_in_rest'      => true,
            'sanitize_callback' => 'sanitize_text_field',
            'auth_callback'     => function () {
                return current_user_can('edit_posts');
            },
        ));
    }

    register_post_meta('event', 'event_capacity', array(
        'type'              => 'integer',
        'single'            => true,
        'show_in_rest'      => true,
        'sanitize_callback' => 'absint',
        'auth_callback'     => function () {
            return current_user_can('edit_posts');
        },
    ));
}
add_action('init', 'events_dune_register_event_cpt');

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

function events_dune_add_schedule_metabox()
{
    add_meta_box(
        'events_dune_schedule_settings',
        'Event Schedule',
        'events_dune_render_schedule_metabox',
        'event',
        'side',
        'default'
    );
}
add_action('add_meta_boxes', 'events_dune_add_schedule_metabox');

function events_dune_render_schedule_metabox($post)
{
    wp_nonce_field('events_dune_save_schedule_meta', 'events_dune_schedule_nonce');

    $event_date     = get_post_meta($post->ID, 'event_date', true);
    $event_time     = get_post_meta($post->ID, 'event_time', true);
    $event_location = get_post_meta($post->ID, 'event_location', true);
    $event_capacity = get_post_meta($post->ID, 'event_capacity', true);
    ?>
    <p>
        <label for="event_date"><strong>Event date</strong></label>
        <input type="date" id="event_date" name="event_date"
               value="<?php echo esc_attr($event_date); ?>" style="width: 100%;">
    </p>
    <p>
        <label for="event_time"><strong>Start time</strong></label>
        <input type="time" id="event_time" name="event_time"
               value="<?php echo esc_attr($event_time); ?>" style="width: 100%;">
    </p>
    <p>
        <label for="event_location"><strong>Location</strong></label>
        <input type="text" id="event_location" name="event_location"
               value="<?php echo esc_attr($event_location); ?>"
               placeholder="Maison Dune &mdash; Obsidian Ballroom" style="width: 100%;">
    </p>
    <p>
        <label for="event_capacity"><strong>Capacity</strong></label>
        <input type="number" id="event_capacity" name="event_capacity"
               value="<?php echo esc_attr($event_capacity); ?>" min="1" step="1" style="width: 100%;">
        <small>Total seats. Leave empty for unlimited.</small>
    </p>
    <?php
}

function events_dune_save_schedule_meta($post_id)
{
    if (!isset($_POST['events_dune_schedule_nonce'])) {
        return;
    }

    if (!wp_verify_nonce($_POST['events_dune_schedule_nonce'], 'events_dune_save_schedule_meta')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    foreach (array('event_date', 'event_time', 'event_location') as $field) {
        if (isset($_POST[$field]) && $_POST[$field] !== '') {
            update_post_meta($post_id, $field, sanitize_text_field($_POST[$field]));
        } else {
            delete_post_meta($post_id, $field);
        }
    }

    if (isset($_POST['event_capacity']) && $_POST['event_capacity'] !== '') {
        update_post_meta($post_id, 'event_capacity', absint($_POST['event_capacity']));
    } else {
        delete_post_meta($post_id, 'event_capacity');
    }
}
add_action('save_post_event', 'events_dune_save_schedule_meta');

function events_dune_event_columns($columns)
{
    $new_columns = array();

    foreach ($columns as $key => $value) {
        $new_columns[$key] = $value;

        if ($key === 'title') {
            $new_columns['event_date']     = 'Event date';
            $new_columns['event_capacity'] = 'Capacity';
        }
    }

    return $new_columns;
}
add_filter('manage_event_posts_columns', 'events_dune_event_columns');

function events_dune_event_column_content($column, $post_id)
{
    if ($column === 'event_date') {
        $date = get_post_meta($post_id, 'event_date', true);
        $time = get_post_meta($post_id, 'event_time', true);
        if ($date) {
            echo esc_html(date_i18n('d M Y', strtotime($date)))
               . ($time ? ' &middot; ' . esc_html($time) : '');
        } else {
            echo '&mdash;';
        }
    }

    if ($column === 'event_capacity') {
        $cap = get_post_meta($post_id, 'event_capacity', true);
        echo $cap ? esc_html($cap) : '&mdash;';
    }
}
add_action('manage_event_posts_custom_column', 'events_dune_event_column_content', 10, 2);
