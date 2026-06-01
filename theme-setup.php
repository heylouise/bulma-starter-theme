<?php
/**
 * THEME SETUP — edit per project
 *
 * Toggle features and set per-project values here. functions.php reads this
 * array and wires everything up. Only put things here that genuinely vary
 * between projects — always-on features (e.g. primary nav) stay hardcoded.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

return [

    // -----------------------------------------------------------------------
    // FOOTER
    // -----------------------------------------------------------------------
    'footer_columns' => 3,                  // 1–4 widget areas in footer

    // -----------------------------------------------------------------------
    // PAGE TEMPLATES — which appear in the WP page template dropdown
    // -----------------------------------------------------------------------
    'page_templates' => [
        'default'     => true,
        'blank'       => true,               // Squeeze / landing pages
        'acf-builder' => true,               // ACF flexible content builder
    ],

    // -----------------------------------------------------------------------
    // BLOG ARCHIVE
    // -----------------------------------------------------------------------
    'blog_archive_columns' => 3,             // 2, 3, or 4 columns in grid
    'posts_per_page'       => 9,             // Posts per archive page

    // -----------------------------------------------------------------------
    // SITE-WIDE TOGGLES
    // -----------------------------------------------------------------------
    'show_breadcrumbs'       => false,        // Yoast breadcrumbs on inner pages
    'show_search_in_header'  => false,       // Search icon in main nav

    // -----------------------------------------------------------------------
    // FEATURE FLAGS
    // -----------------------------------------------------------------------
    'enable_acf_options_page' => true,       // "Theme Options" page in WP admin
    'enable_woocommerce_pack' => false,      // Load /woocommerce/ template overrides

];