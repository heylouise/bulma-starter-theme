<?php
/**
 * Bulma Starter — functions.php
 *
 * Reads theme-setup.php and registers theme features accordingly.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// ---------------------------------------------------------------------------
// Load per-project config
// ---------------------------------------------------------------------------
$bulma_starter_config = require get_template_directory() . '/theme-setup.php';

// Make config globally accessible via a helper
function bulma_starter_config( $key = null, $default = null ) {
    global $bulma_starter_config;
    if ( $key === null ) return $bulma_starter_config;
    return $bulma_starter_config[ $key ] ?? $default;
}

// ---------------------------------------------------------------------------
// Safety fallback if ACF is missing
// ---------------------------------------------------------------------------


function theme_get_field( $field, $post_id = false ) {
  if( ! function_exists('get_field') ) return null;
  return get_field( $field, $post_id );
}

function theme_get_sub_field( $field ) {
  if( ! function_exists('get_sub_field') ) return null;
  return get_sub_field( $field );
}

function theme_have_rows( $field, $post_id = false ) {
  if( ! function_exists('have_rows') ) return false;
  return have_rows( $field, $post_id );
}

// ---------------------------------------------------------------------------
// Theme support
// ---------------------------------------------------------------------------
add_action( 'after_setup_theme', function() {
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'html5', [ 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'script', 'style' ] );
    add_theme_support( 'responsive-embeds' );
    add_theme_support( 'editor-styles' );
    add_editor_style( 'assets/css/editor.css' );

    // Menus — these are always-on, so hardcoded (not in theme-setup.php)
    register_nav_menus( [
        'primary' => __( 'Primary Navigation', 'bulma-starter' ),
        'footer'  => __( 'Footer Navigation', 'bulma-starter' ),
    ] );
} );

// ---------------------------------------------------------------------------
// Enqueue styles and scripts
// ---------------------------------------------------------------------------
require get_template_directory() . '/inc/enqueue.php';

// ---------------------------------------------------------------------------
// Footer widget areas (count from theme-setup.php)
// ---------------------------------------------------------------------------
add_action( 'widgets_init', function() {
    $columns = (int) bulma_starter_config( 'footer_columns', 3 );
    $columns = max( 1, min( 4, $columns ) ); // clamp 1–4

    for ( $i = 1; $i <= $columns; $i++ ) {
        register_sidebar( [
            'name'          => sprintf( __( 'Footer Column %d', 'bulma-starter' ), $i ),
            'id'            => 'footer-' . $i,
            'before_widget' => '<div class="footer-widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h4 class="footer-widget-title">',
            'after_title'   => '</h4>',
        ] );
    }
} );

// ---------------------------------------------------------------------------
// Filter page templates — hide ones disabled in theme-setup.php
// ---------------------------------------------------------------------------
add_filter( 'theme_page_templates', function( $templates ) {
    $enabled = bulma_starter_config( 'page_templates', [] );

    if ( empty( $enabled['blank'] ) )       unset( $templates['template-blank.php'] );
    if ( empty( $enabled['acf-builder'] ) ) unset( $templates['template-acf-builder.php'] );

    return $templates;
} );

// ---------------------------------------------------------------------------
// Posts per page on blog archive
// ---------------------------------------------------------------------------
add_action( 'pre_get_posts', function( $query ) {
    if ( is_admin() || ! $query->is_main_query() ) return;
    if ( $query->is_home() || $query->is_archive() ) {
        $query->set( 'posts_per_page', (int) bulma_starter_config( 'posts_per_page', 9 ) );
    }
} );

// ---------------------------------------------------------------------------
// ACF Options page
// ---------------------------------------------------------------------------
if ( bulma_starter_config( 'enable_acf_options_page' ) && function_exists( 'acf_add_options_page' ) ) {
    add_action( 'acf/init', function() {
        acf_add_options_page( [
            'page_title' => 'Theme Options',
            'menu_title' => 'Theme Options',
            'menu_slug'  => 'theme-options',
            'capability' => 'edit_posts',
        ] );
    } );
}

// ---------------------------------------------------------------------------
// ACF flexible content layout renderer
// ---------------------------------------------------------------------------
require get_template_directory() . '/inc/acf-layouts.php';

// ---------------------------------------------------------------------------
// Template tag helpers
// ---------------------------------------------------------------------------
require get_template_directory() . '/inc/template-tags.php';

require get_template_directory() . '/inc/bulma-nav-walker.php';

// ---------------------------------------------------------------------------
// WooCommerce pack (conditional)
// ---------------------------------------------------------------------------
if ( bulma_starter_config( 'enable_woocommerce_pack' ) && class_exists( 'WooCommerce' ) ) {
    add_theme_support( 'woocommerce' );
    add_theme_support( 'wc-product-gallery-zoom' );
    add_theme_support( 'wc-product-gallery-lightbox' );
    add_theme_support( 'wc-product-gallery-slider' );
}