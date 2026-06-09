<?php
/**
 * Single post template.
 *
 * @package Bulma_Starter
 */

if ( ! defined( 'ABSPATH' ) ) exit;

get_header();
?>
<?php while ( have_posts() ) : the_post(); ?>

<?php if ( bulma_starter_config( 'show_breadcrumbs' ) && function_exists( 'yoast_breadcrumb' ) ) : ?>
    <div class="breadcrumb-wrapper section is-small">
        <div class="container">
            <?php yoast_breadcrumb( '<nav class="breadcrumb" aria-label="breadcrumbs"><ul>', '</ul></nav>' ); ?>
        </div>
    </div>
<?php endif; ?>

<section class="section">
    <div class="container">

        <?php if ( has_post_thumbnail() ) : ?>
        <figure class="post-featured-image image">
            <?php the_post_thumbnail( 'full' ); ?>
            </figure>
        <?php endif; ?>

            <article id="post-<?php the_ID(); ?>" <?php post_class( 'single-post' ); ?>>

                <header class="post-header">
                    <h1 class="title is-2"><?php the_title(); ?></h1>

                    <div class="post-meta tags">
                        <span class="tag is-light">
                            <time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
                                <?php echo esc_html( get_the_date() ); ?>
                            </time>
                        </span>
                        <span class="tag is-light">
                            <?php esc_html_e( 'By', 'bulma-starter' ); ?>
                            <?php the_author(); ?>
                        </span>
                        <?php
                        $categories = get_the_category_list( ', ' );
                        if ( $categories ) :
                        ?>
                            <span class="tag is-light">
                                <?php echo wp_kses_post( $categories ); ?>
                            </span>
                        <?php endif; ?>
                    </div>
                </header>

 

                <div class="content post-content">
                    <?php the_content(); ?>

                    <?php
                    wp_link_pages( [
                        'before' => '<nav class="pagination is-small post-pagination" role="navigation"><span>' . esc_html__( 'Pages:', 'bulma-starter' ) . '</span>',
                        'after'  => '</nav>',
                    ] );
                    ?>
                </div>

                <?php
                $tags_list = get_the_tag_list( '', ' ' );
                if ( $tags_list ) :
                ?>
                    <footer class="post-footer">
                        <div class="tags">
                            <?php echo wp_kses_post( $tags_list ); ?>
                        </div>
                    </footer>
                <?php endif; ?>

            </article>

            <nav class="post-nav columns" aria-label="<?php esc_attr_e( 'Post navigation', 'bulma-starter' ); ?>">
                <div class="column">
                    <?php previous_post_link( '<div class="post-nav-prev">&larr; %link</div>' ); ?>
                </div>
                <div class="column has-text-right">
                    <?php next_post_link( '<div class="post-nav-next">%link &rarr;</div>' ); ?>
                </div>
            </nav>


        

    </div>
</section>

<?php endwhile; ?>

<?php
get_footer();
