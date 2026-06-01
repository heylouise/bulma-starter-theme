<?php
/**
 * Template helper functions.
 *
 * Small reusable bits used across templates. Add new helpers here as needs
 * arise. Keep them stateless and focused — one job per function.
 *
 * @package Bulma_Starter
 */

if ( ! defined( 'ABSPATH' ) ) exit;


/**
 * Render a posted-on byline ("Posted on <date> by <author>") as Bulma tags.
 * Used by single.php and content-card.php if you want to standardise.
 *
 * @return void
 */
if ( ! function_exists( 'bulma_starter_posted_on' ) ) {
    function bulma_starter_posted_on() {
        printf(
            '<div class="post-meta tags">
                <span class="tag is-light"><time datetime="%1$s">%2$s</time></span>
                <span class="tag is-light">%3$s %4$s</span>
            </div>',
            esc_attr( get_the_date( 'c' ) ),
            esc_html( get_the_date() ),
            esc_html__( 'By', 'bulma-starter' ),
            esc_html( get_the_author() )
        );
    }
}


/**
 * Render Yoast breadcrumbs wrapped in Bulma's breadcrumb component.
 * Skips silently if Yoast isn't active or breadcrumbs are disabled in setup.
 *
 * @return void
 */
if ( ! function_exists( 'bulma_starter_breadcrumbs' ) ) {
    function bulma_starter_breadcrumbs() {
        if ( ! bulma_starter_config( 'show_breadcrumbs' ) ) return;
        if ( ! function_exists( 'yoast_breadcrumb' ) ) return;
        if ( is_front_page() ) return;

        echo '<div class="breadcrumb-wrapper section is-small"><div class="container">';
        yoast_breadcrumb( '<nav class="breadcrumb" aria-label="breadcrumbs"><ul>', '</ul></nav>' );
        echo '</div></div>';
    }
}


/**
 * Return a trimmed excerpt with a custom word count and ellipsis.
 *
 * @param int $words  Number of words to keep. Default 22.
 * @return string     The trimmed excerpt, KSES-safe.
 */
if ( ! function_exists( 'bulma_starter_excerpt' ) ) {
    function bulma_starter_excerpt( $words = 22 ) {
        $raw = get_the_excerpt();
        $trimmed = wp_trim_words( $raw, (int) $words, '&hellip;' );
        return wp_kses_post( $trimmed );
    }
}


/**
 * Output the primary post category as a linked badge.
 * Returns the first category assigned to the current post, if any.
 *
 * @return void
 */
if ( ! function_exists( 'bulma_starter_primary_category' ) ) {
    function bulma_starter_primary_category() {
        $cats = get_the_category();
        if ( empty( $cats ) ) return;

        $cat = $cats[0];
        printf(
            '<span class="post-card-category"><a href="%1$s">%2$s</a></span>',
            esc_url( get_category_link( $cat->term_id ) ),
            esc_html( $cat->name )
        );
    }
}


/**
 * Return the Bulma column class for a given numeric column count (2–4).
 * Useful for the archive grid and footer widget rows.
 *
 * @param int $cols  Number of columns in the row (1–4).
 * @return string    Bulma column class (e.g. 'is-one-third').
 */
if ( ! function_exists( 'bulma_starter_col_class' ) ) {
    function bulma_starter_col_class( $cols ) {
        $map = [
            1 => 'is-full',
            2 => 'is-half',
            3 => 'is-one-third',
            4 => 'is-one-quarter',
        ];
        $cols = (int) $cols;
        return $map[ $cols ] ?? 'is-full';
    }
}


/**
 * Determine whether the current page is using the blank/squeeze template.
 * Handy if you ever need to suppress something globally on those pages.
 *
 * @return bool
 */
if ( ! function_exists( 'bulma_starter_is_blank_template' ) ) {
    function bulma_starter_is_blank_template() {
        return is_page_template( 'template-blank.php' );
    }
}
