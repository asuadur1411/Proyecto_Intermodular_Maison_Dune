<?php


function maison_scripts() {
    wp_enqueue_style( 'my-style', get_stylesheet_uri() );

    wp_enqueue_script('faq', get_template_directory_uri() . '/assets/js/faq.js', [], false, true);
}
add_action('wp_enqueue_scripts', 'maison_scripts');

register_nav_menus( array(
    'menu-izquierdo' => 'Menú Cabecera Izquierda',
    'menu-derecho'   => 'Menú Cabecera Derecha',
) );

function maison_dune_theme_setup() {
    register_nav_menus( array(
        'left-menu'  => __( 'Header Left Menu', 'maison-dune' ),
        'right-menu' => __( 'Header Right Menu', 'maison-dune' ),
    ) );

    // ← AÑADE ESTA LÍNEA:
    add_theme_support( 'post-thumbnails' );
}
add_action( 'after_setup_theme', 'maison_dune_theme_setup' );


// Register Custom Post Type for Menu Dishes
function create_menu_post_type() {
    register_post_type('menu_dish',
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
    
    // Taxonomy for menu categories
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

// Register Custom Post Type for Wines
function create_wine_post_type() {
    register_post_type('wine',
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
    
    // Taxonomy for wine type
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