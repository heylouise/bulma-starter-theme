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

<?php while ( have_posts() ) : the_post();

    $hero     = theme_get_field( 'hero' );
    $has_hero = ! empty( $hero['heading'] );

?>

    <?php if ( $has_hero ) : ?>

        <section class="section hero-section">
            <div class="container is-max-widescreen">

                <div class="columns is-vcentered">

                    <!-- Column 1: Text (~58%) -->
                    <div class="column is-7">

                        <?php if ( ! empty( $hero['eyebrow'] ) ) : ?>
                            <p class="hero-eyebrow"><?php echo esc_html( $hero['eyebrow'] ); ?></p>
                        <?php endif; ?>

                        <h1 class="title is-2"><?php echo esc_html( $hero['heading'] ); ?></h1>

                        <?php if ( ! empty( $hero['subtext'] ) ) : ?>
                            <p class="hero-subtext"><?php echo esc_html( $hero['subtext'] ); ?></p>
                        <?php endif; ?>

                        <?php if ( ! empty( $hero['hero_cta_buttons'] ) ) : ?>
    <div class="buttons mt-5">
        <?php foreach ( $hero['hero_cta_buttons'] as $button ) : ?>
            <a href="<?php echo esc_url( $button['button_url'] ); ?>"
               class="button is-<?php echo esc_attr( $button['button_style'] ); ?>">
                <?php echo esc_html( $button['button_label'] ); ?>
            </a>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

                    </div>

                    <!-- Column 2: Image (~42%) -->
                    <?php if ( ! empty( $hero['image'] ) ) : ?>
                        <div class="column is-5">
                            <img src="<?php echo esc_url( $hero['image']['url'] ); ?>"
                                 alt="<?php echo esc_attr( $hero['image']['alt'] ); ?>"
                                 <?php if ( ! empty( $hero['image_class'] ) ) : ?>
                                     class="<?php echo esc_attr( $hero['image_class'] ); ?>"
                                 <?php endif; ?>
                                 loading="eager">
                        </div>
                    <?php endif; ?>

                </div><!-- /.columns -->

            </div><!-- /.container -->
        </section>

    <?php endif; ?>

    <section class="section">
        <div class="is-bm-content-max">

            <article id="post-<?php the_ID(); ?>" <?php post_class( 'page-article' ); ?>>

                <?php if ( ! $has_hero && has_post_thumbnail() ) : ?>
                    <figure class="page-featured-image image">
                        <?php the_post_thumbnail( 'large' ); ?>
                    </figure>
                <?php endif; ?>

                <?php if ( ! $has_hero ) : ?>
                    <header class="page-header">
                        <h1 class="title is-2"><?php the_title(); ?></h1>
                    </header>
                <?php endif; ?>

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

        </div>
    </section>

<?php endwhile; ?>

<?php
get_footer();
