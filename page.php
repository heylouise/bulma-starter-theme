<?php
/**
 * Default page template.
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

<section class="section">
    <div class="container">

        <?php while ( have_posts() ) : the_post(); ?>

            <article id="post-<?php the_ID(); ?>" <?php post_class( 'page-article' ); ?>>

                <?php if ( has_post_thumbnail() ) : ?>
                    <figure class="page-featured-image image">
                        <?php the_post_thumbnail( 'large' ); ?>
                    </figure>
                <?php endif; ?>

                <header class="page-header">
                    <h1 class="title is-2"><?php the_title(); ?></h1>
                </header>

                <div class="content page-content">
                    <?php the_content(); ?>

                    <?php
                    wp_link_pages( [
                        'before' => '<nav class="pagination is-small page-pagination" role="navigation"><span>' . esc_html__( 'Pages:', 'bulma-starter' ) . '</span>',
                        'after'  => '</nav>',
                    ] );
                    ?>
                </div>

            </article>

            <?php
            if ( comments_open() || get_comments_number() ) {
                comments_template();
            }
            ?>

        <?php endwhile; ?>

    </div>
</section>

<?php
get_footer();
