<?php
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'wp_enqueue_scripts', function() {
    $theme_dir = get_template_directory_uri();
    $version   = wp_get_theme()->get( 'Version' );

    // Bulma framework
    wp_enqueue_style( 'bulma', $theme_dir . '/assets/css/bulma.min.css', [], '1.0.2' );

    // Theme variables (loaded AFTER Bulma so it can override)
    wp_enqueue_style( 'theme-variables', $theme_dir . '/theme-variables.css', [ 'bulma' ], $version );

    // Block / plugin overrides
    wp_enqueue_style( 'theme-blocks',  $theme_dir . '/assets/css/blocks.css',  [ 'theme-variables' ], $version );
    wp_enqueue_style( 'theme-plugins', $theme_dir . '/assets/css/plugins.css', [ 'theme-variables' ], $version );

    // Main stylesheet (for WP compatibility — even if mostly empty)
    wp_enqueue_style( 'theme-style', get_stylesheet_uri(), [ 'theme-variables' ], $version );

    // Navbar burger toggle
    wp_enqueue_script( 'theme-navbar', $theme_dir . '/assets/js/navbar.js', [], $version, true );

    // Comments
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
} );

// Also load theme-variables.css in the block editor so dark mode + colours preview correctly
add_action( 'enqueue_block_editor_assets', function() {
    wp_enqueue_style(
        'theme-variables-editor',
        get_template_directory_uri() . '/theme-variables.css',
        [],
        wp_get_theme()->get( 'Version' )
    );
} );