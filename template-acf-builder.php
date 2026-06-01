<?php
/**
 * Template Name: ACF Builder
 *
 * Renders a page built with the ACF flexible content "page_sections" field.
 * Layout logic lives in inc/acf-layouts.php.
 *
 * @package Bulma_Starter
 */

if ( ! defined( 'ABSPATH' ) ) exit;

get_header();
?>

<?php if ( bulma_starter_config( 'show_breadcrumbs' ) && ! is_front_page() && function_exists( 'yoast_breadcrumb' ) ) : ?>
    <div class="breadcrumb-wrapper section is-small">
        <div class="container">
            <?php yoast_breadcrumb( '<nav class="breadcrumb" aria-label="breadcrumbs"><ul>', '</ul></nav>' ); ?>
        </div>
    </div>
<?php endif; ?>

<?php while ( have_posts() ) : the_post(); ?>

    <article id="post-<?php the_ID(); ?>" <?php post_class( 'acf-builder-page' ); ?>>

        <?php
        // If ACF flexible content is populated, render the rows.
        if ( function_exists( 'have_rows' ) && have_rows( 'page_sections' ) ) :
            while ( have_rows( 'page_sections' ) ) :
                the_row();

                $layout = get_row_layout();

                if ( $layout === 'row' && function_exists( 'bulma_starter_render_row' ) ) {
                    bulma_starter_render_row();
                }
                // Add more layout types here as you extend the builder (hero, cta, gallery, etc.)
            endwhile;
        else :
            // Fallback: render the regular post content if no ACF rows exist.
            ?>
            <section class="section">
                <div class="container">
                    <header class="page-header">
                        <h1 class="title is-2"><?php the_title(); ?></h1>
                    </header>
                    <div class="content">
                        <?php the_content(); ?>
                    </div>
                </div>
            </section>
            <?php
        endif;
        ?>

    </article>

<?php endwhile; ?>

<?php
get_footer();
