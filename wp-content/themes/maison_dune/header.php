<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>
    <header>
        <nav>
            <ul>
                <?php 
                    wp_nav_menu( array(
                        'theme_location' => 'left-menu',
                        'container'      => false,
                        'items_wrap'     => '%3$s',
                        'fallback_cb'    => false 
                    ) ); 
                ?>

                <li class="logo">
    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="Maison Dune - Home">
        <span class="screen-reader-text">Home</span>
    </a>
</li>

                <?php 
                    wp_nav_menu( array(
                        'theme_location' => 'right-menu',
                        'container'      => false,
                        'items_wrap'     => '%3$s',
                        'fallback_cb'    => false 
                    ) ); 
                ?>
            </ul>
        </nav>
    </header>