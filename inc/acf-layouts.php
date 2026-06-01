<?php
/**
 * ACF flexible content layout renderers.
 *
 * Called from template-acf-builder.php. Each function renders one ACF layout
 * type inside a flexible content loop. Add more layouts here as you extend
 * the page builder (hero, cta, gallery, etc.).
 *
 * Expected ACF structure (built in WP admin under Custom Fields):
 *
 *   page_sections (Flexible Content)
 *     └── row (Layout)
 *           ├── column_layout (Select: 1, 2, 3, 4, 2-1, 1-2, 1-3, 3-1)
 *           ├── shaded_background (True/False)
 *           ├── bordered (True/False)
 *           └── columns (Repeater)
 *                 └── content (WYSIWYG)
 *
 * @package Bulma_Starter
 */

if ( ! defined( 'ABSPATH' ) ) exit;


/**
 * Map an ACF column_layout value to an array of Bulma column width classes.
 * Order in the array matches the order columns appear in the row.
 *
 * @param string $layout  ACF select value (e.g. '2-1', '3', etc.).
 * @return array          Array of Bulma column class strings.
 */
if ( ! function_exists( 'bulma_starter_column_widths' ) ) {
    function bulma_starter_column_widths( $layout ) {
        $map = [
            '1'   => [ 'is-full' ],
            '2'   => [ 'is-half', 'is-half' ],
            '3'   => [ 'is-one-third', 'is-one-third', 'is-one-third' ],
            '4'   => [ 'is-one-quarter', 'is-one-quarter', 'is-one-quarter', 'is-one-quarter' ],
            '2-1' => [ 'is-two-thirds', 'is-one-third' ],
            '1-2' => [ 'is-one-third', 'is-two-thirds' ],
            '1-3' => [ 'is-one-quarter', 'is-three-quarters' ],
            '3-1' => [ 'is-three-quarters', 'is-one-quarter' ],
        ];
        return $map[ $layout ] ?? [ 'is-full' ];
    }
}


/**
 * Render a "row" layout from the page_sections flexible content field.
 *
 * Outputs:
 *   <section class="acf-row [row--shaded] [row--bordered]">
 *     <div class="container">
 *       <div class="columns">
 *         <div class="column is-X">...</div>
 *         ...
 *       </div>
 *     </div>
 *   </section>
 *
 * Must be called from inside an ACF flexible-content loop where the_row()
 * has already been called for a 'row' layout.
 *
 * @return void
 */
if ( ! function_exists( 'bulma_starter_render_row' ) ) {
    function bulma_starter_render_row() {

        $shaded     = (bool) get_sub_field( 'shaded_background' );
        $bordered   = (bool) get_sub_field( 'bordered' );
        $col_layout = (string) get_sub_field( 'column_layout' );

        $classes = [ 'acf-row' ];
        if ( $shaded )   $classes[] = 'row--shaded';
        if ( $bordered ) $classes[] = 'row--bordered';

        $widths = bulma_starter_column_widths( $col_layout );

        echo '<section class="' . esc_attr( implode( ' ', $classes ) ) . '">';
        echo '<div class="container">';
        echo '<div class="columns is-variable is-6">';

        if ( have_rows( 'columns' ) ) {
            $i = 0;
            while ( have_rows( 'columns' ) ) {
                the_row();
                $width_class = $widths[ $i ] ?? 'is-full';

                echo '<div class="column ' . esc_attr( $width_class ) . '">';
                echo '<div class="content">';
                // Run shortcodes and apply standard content filters on the WYSIWYG field.
                echo apply_filters( 'the_content', get_sub_field( 'content' ) );
                echo '</div>';
                echo '</div>';

                $i++;
            }
        }

        echo '</div>'; // .columns
        echo '</div>'; // .container
        echo '</section>';
    }
}


/* ---------------------------------------------------------------------------
 * Extending the builder
 * ---------------------------------------------------------------------------
 *
 * To add a new layout type (e.g. "hero"):
 *
 * 1. In WP admin, add a new layout called "hero" to the page_sections field
 *    with the sub-fields you want (heading, subheading, background image, etc.).
 *
 * 2. Add a renderer function below, e.g.:
 *
 *    function bulma_starter_render_hero() {
 *        $heading = get_sub_field('heading');
 *        $subheading = get_sub_field('subheading');
 *        ...
 *        echo '<section class="hero is-medium">...</section>';
 *    }
 *
 * 3. In template-acf-builder.php, add a branch:
 *
 *    if ( $layout === 'hero' && function_exists('bulma_starter_render_hero') ) {
 *        bulma_starter_render_hero();
 *    }
 *
 * Keep each renderer focused on one layout — easier to maintain.
 * ------------------------------------------------------------------------- */
