<?php

function maison_scripts()
{
    wp_enqueue_style('my-style', get_stylesheet_uri(), [], '9.18');
    wp_enqueue_style('chatbot-style', get_template_directory_uri() . '/assets/css/chatbot.css', [], '4.0');
    wp_enqueue_script('faq', get_template_directory_uri() . '/assets/js/faq.js', [], '4.0', true);
    wp_enqueue_script('canvas-confetti', 'https://cdn.jsdelivr.net/npm/canvas-confetti@1.9.3/dist/confetti.browser.min.js', [], '1.9.3', true);
    wp_enqueue_script('qrcodejs', 'https://cdn.jsdelivr.net/npm/qrcodejs@1.0.0/qrcode.min.js', [], '1.0.0', true);
    wp_enqueue_script('auth-bridge', get_template_directory_uri() . '/assets/js/auth-bridge.js', ['canvas-confetti', 'qrcodejs'], '6.2', true);
    wp_enqueue_script('chatbot', get_template_directory_uri() . '/assets/js/chatbot.js', [], '4.1', true);
    wp_enqueue_style('maison-login-style', get_template_directory_uri() . '/style.css', [], '9.18');

    if (is_page_template('page-dashboard.php') || is_page('dashboard')) {
        wp_enqueue_script('chartjs', 'https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js', [], '4.4.7', true);
        wp_enqueue_script('fullcalendar', 'https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js', [], '6.1.11', true);
        wp_enqueue_script('html5-qrcode', 'https://cdn.jsdelivr.net/npm/html5-qrcode@2.3.8/html5-qrcode.min.js', [], '2.3.8', true);
        wp_enqueue_script('dashboard', get_template_directory_uri() . '/assets/js/dashboard.js', ['chartjs', 'fullcalendar', 'html5-qrcode'], '6.4', true);
    }
}
add_action('wp_enqueue_scripts', 'maison_scripts');

register_nav_menus(array(
    'menu-izquierdo' => 'Menú Cabecera Izquierda',
    'menu-derecho' => 'Menú Cabecera Derecha',
));

function maison_dune_theme_setup()
{
    register_nav_menus(array(
        'left-menu' => __('Header Left Menu', 'maison-dune'),
        'right-menu' => __('Header Right Menu', 'maison-dune'),
    ));

    add_theme_support('post-thumbnails');
}
add_action('after_setup_theme', 'maison_dune_theme_setup');

function create_menu_post_type()
{
    register_post_type(
        'menu_dish',
        array(
            'labels' => array(
                'name' => 'Menu Dishes',
                'singular_name' => 'Dish',
                'add_new' => 'Add Dish',
                'add_new_item' => 'Add New Dish',
                'edit_item' => 'Edit Dish',
                'all_items' => 'All Dishes',
                'view_item' => 'View Dish',
                'search_items' => 'Search Dishes',
            ),
            'public' => true,
            'has_archive' => false,
            'menu_icon' => 'dashicons-food',
            'supports' => array('title', 'editor', 'thumbnail'),
            'show_in_rest' => true,
            'menu_position' => 5,
        )
    );

    register_taxonomy('menu_category', 'menu_dish', array(
        'labels' => array(
            'name' => 'Menu Categories',
            'singular_name' => 'Category',
            'add_new_item' => 'Add New Category',
        ),
        'hierarchical' => true,
        'show_in_rest' => true,
        'show_admin_column' => true,
    ));
}
add_action('init', 'create_menu_post_type');

function create_wine_post_type()
{
    register_post_type(
        'wine',
        array(
            'labels' => array(
                'name' => 'Wines',
                'singular_name' => 'Wine',
                'add_new' => 'Add Wine',
                'add_new_item' => 'Add New Wine',
                'edit_item' => 'Edit Wine',
                'all_items' => 'All Wines',
            ),
            'public' => true,
            'has_archive' => false,
            'menu_icon' => 'dashicons-star-filled',
            'supports' => array('title', 'editor', 'thumbnail'),
            'show_in_rest' => true,
            'menu_position' => 6,
        )
    );

    register_taxonomy('wine_type', 'wine', array(
        'labels' => array(
            'name' => 'Wine Types',
            'singular_name' => 'Type',
            'add_new_item' => 'Add New Type',
        ),
        'hierarchical' => true,
        'show_in_rest' => true,
        'show_admin_column' => true,
    ));
}
add_action('init', 'create_wine_post_type');

function create_room_post_type()
{
    register_post_type(
        'room',
        array(
            'labels' => array(
                'name' => 'Rooms',
                'singular_name' => 'Room',
                'add_new' => 'Add Room',
                'add_new_item' => 'Add New Room',
                'edit_item' => 'Edit Room',
                'all_items' => 'All Rooms',
            ),
            'public' => true,
            'has_archive' => false,
            'menu_icon' => 'dashicons-admin-home',
            'supports' => array('title', 'editor', 'excerpt', 'thumbnail'),
            'taxonomies' => array('room_type'),
            'show_in_rest' => true,
            'menu_position' => 7,
            'rewrite' => array('slug' => 'room'),
        )
    );
}
add_action('init', 'create_room_post_type');

function create_room_taxonomy() {
    register_taxonomy(
        'room_type',
        'room',
        array(
            'labels' => array(
                'name' => 'Room Types',
                'singular_name' => 'Room Type',
                'menu_name' => 'Types',
                'all_items' => 'All Types',
                'edit_item' => 'Edit Type',
                'add_new_item' => 'Add New Type',
            ),
            'public' => true,
            'hierarchical' => true,
            'show_admin_column' => true,
            'show_in_rest' => true,
            'rewrite' => array('slug' => 'room-type'),
        )
    );

    $defaults = array(
        'classic-rooms'       => 'Classic Rooms',
        'suites'              => 'Suites',
        'exceptional-suites'  => 'Exceptional Suites',
    );
    foreach ($defaults as $slug => $name) {
        if (!term_exists($slug, 'room_type')) {
            wp_insert_term($name, 'room_type', array('slug' => $slug));
        }
    }
}
add_action('init', 'create_room_taxonomy');

function maison_room_metaboxes() {
    add_meta_box(
        'maison_room_details',
        'Room Booking Details',
        'maison_room_metabox_render',
        'room',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'maison_room_metaboxes');

function maison_room_metabox_render($post) {
    wp_nonce_field('maison_room_save', 'maison_room_nonce');
    $price    = get_post_meta($post->ID, '_room_price', true);
    $capacity = get_post_meta($post->ID, '_room_capacity', true);
    $bed      = get_post_meta($post->ID, '_room_bed', true);
    $area     = get_post_meta($post->ID, '_room_area', true);
    $status   = get_post_meta($post->ID, '_room_status', true) ?: 'available';
    $amenities = (array) get_post_meta($post->ID, '_room_amenities', true);
    $available_amenities = [
        'wifi'      => 'Wi-Fi',
        'terrace'   => 'Terrace',
        'views'     => 'Sea / Garden Views',
        'breakfast' => 'Breakfast included',
        'spa'       => 'Spa Access',
        'bathtub'   => 'Bathtub',
        'minibar'   => 'Complimentary Minibar',
        'butler'    => 'Butler Service',
    ];
    ?>
    <style>
        .maison-room-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
        .maison-room-grid label { display: block; font-weight: 600; margin-bottom: 4px; }
        .maison-room-grid input[type=number],
        .maison-room-grid input[type=text],
        .maison-room-grid select { width: 100%; }
        .maison-room-amenities { grid-column: 1 / -1; }
        .maison-room-amenities .amen-list { display: grid; grid-template-columns: repeat(4, 1fr); gap: 8px; margin-top: 6px; }
    </style>
    <div class="maison-room-grid">
        <div>
            <label>Price per night (€)</label>
            <input type="number" step="0.01" min="0" name="room_price" value="<?php echo esc_attr($price); ?>">
        </div>
        <div>
            <label>Capacity (guests)</label>
            <input type="number" min="1" max="12" name="room_capacity" value="<?php echo esc_attr($capacity); ?>">
        </div>
        <div>
            <label>Bed type</label>
            <input type="text" name="room_bed" value="<?php echo esc_attr($bed); ?>" placeholder="Queen Size / King Size / Twin">
        </div>
        <div>
            <label>Area (m²)</label>
            <input type="number" min="0" name="room_area" value="<?php echo esc_attr($area); ?>">
        </div>
        <div>
            <label>Availability</label>
            <select name="room_status">
                <option value="available" <?php selected($status, 'available'); ?>>Available</option>
                <option value="limited"   <?php selected($status, 'limited'); ?>>Limited stock</option>
                <option value="sold-out"  <?php selected($status, 'sold-out'); ?>>Sold out</option>
            </select>
        </div>
        <div class="maison-room-amenities">
            <label>Amenities</label>
            <div class="amen-list">
                <?php foreach ($available_amenities as $key => $label) : ?>
                    <label style="font-weight:400">
                        <input type="checkbox" name="room_amenities[]" value="<?php echo esc_attr($key); ?>" <?php checked(in_array($key, $amenities, true)); ?>>
                        <?php echo esc_html($label); ?>
                    </label>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <?php
}

function maison_room_save_meta($post_id) {
    if (!isset($_POST['maison_room_nonce']) || !wp_verify_nonce($_POST['maison_room_nonce'], 'maison_room_save')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;
    if (get_post_type($post_id) !== 'room') return;

    $fields = [
        'room_price'    => '_room_price',
        'room_capacity' => '_room_capacity',
        'room_bed'      => '_room_bed',
        'room_area'     => '_room_area',
        'room_status'   => '_room_status',
    ];
    foreach ($fields as $field => $key) {
        if (isset($_POST[$field])) {
            update_post_meta($post_id, $key, sanitize_text_field($_POST[$field]));
        }
    }
    $amenities = isset($_POST['room_amenities']) && is_array($_POST['room_amenities'])
        ? array_map('sanitize_text_field', $_POST['room_amenities'])
        : [];
    update_post_meta($post_id, '_room_amenities', $amenities);
}
add_action('save_post', 'maison_room_save_meta');

add_filter('custom_menu_order', '__return_true');
add_filter('menu_order', 'maison_admin_menu_order');
function maison_admin_menu_order($menu_ord) {
    if (!$menu_ord) return $menu_ord;

    $hotel = array(
        'index.php',                          // Dashboard
        'edit.php?post_type=room',            // Rooms (CPT)
        'edit.php?post_type=menu_dish',       // Menu Dishes
        'edit.php?post_type=wine',            // Wines
        'edit.php?post_type=event',           // Events (CPT)
        'maison-reservations',                // Reservations (Restaurant + Events submenus)
        'maison-contact',                     // Contact Messages
    );

    $rest = array();
    foreach ($menu_ord as $item) {
        if (!in_array($item, $hotel, true)) {
            $rest[] = $item;
        }
    }

    return array_merge($hotel, $rest);
}

add_action('admin_menu', 'maison_fix_menu_positions', 999);
function maison_fix_menu_positions() {
    global $menu;
}

