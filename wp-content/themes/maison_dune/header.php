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
                <li class="login-icon">
                    <a href="login">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="8" r="4" />
                            <path d="M4 20c0-4 3.6-7 8-7s8 3 8 7" />
                        </svg>
                    </a>
                </li>
            </ul>
        </nav>
    </header>