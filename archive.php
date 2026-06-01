<?php
/**
 * Archive template — blog index, category, tag, author, date archives.
 *
 * Renders an elegant Bulma column grid of post cards. Column count is set
 * in theme-setup.php via 'blog_archive_columns' (2, 3, or 4).
 *
 * @package Bulma_Starter
 */

if ( ! defined( 'ABSPATH' ) ) exit;

get_header();

$cols = (int) bulma_starter_config( 'blog_archive_columns', 3 );
$cols = in_array( $cols, [ 2, 3, 4 ], true ) ? $cols : 3;

$col_class_map = [
    2 => 'is-half',
    3 => 'is-one-third',
    4 => 'is-one-quarter',
];
$col_class = $col_class_map[ $cols ];
?>

<?php if ( bulma_starter_config( 'show_breadcrumbs' ) && function_exists( 'yoast_breadcrumb' ) ) : ?>
    <div class="breadcrumb-wrapper section is-small">
        <div class="container">
            <?php yoast_breadcrumb( '<nav class="breadcrumb" aria-label="breadcrumbs"><ul>', '</ul></nav>' ); ?>
        </div>
    </div>
<?php endif; ?>

<header class="archive-header section">
    <div class="container">
        <h1 class="title is-2">
            <?php
            if ( is_home() ) {
                $blog_page_id = (int) get_option( 'page_for_posts' );
                echo $blog_page_id ? esc_html( get_the_title( $blog_page_id ) ) : esc_html__( 'Blog', 'bulma-starter' );
            } else {
                the_archive_title();
            }
            ?>
        </h1>
        <?php
        $description = get_the_archive_description();
        if ( $description ) :
        ?>
            <div class="subtitle archive-description">
                <?php echo wp_kses_post( $description ); ?>
            </div>
        <?php endif; ?>
    </div>
</header>

<section class="section archive-grid-section">
    <div class="container">

        <?php if ( have_posts() ) : ?>

            <div class="columns is-multiline archive-grid">
                <?php while ( have_posts() ) : the_post(); ?>
                    <div class="column <?php echo esc_attr( $col_class ); ?>">
                        <?php get_template_part( 'template-parts/content', 'card' ); ?>
                    </div>
                <?php endwhile; ?>
            </div>

            <?php
            the_posts_pagination( [
                'mid_size'  => 1,
                'prev_text' => __( '&larr; Previous', 'bulma-starter' ),
                'next_text' => __( 'Next &rarr;', 'bulma-starter' ),
                'class'     => 'pagination is-centered archive-pagination',
            ] );
            ?>

        <?php else : ?>
            <?php get_template_part( 'template-parts/content', 'none' ); ?>
        <?php endif; ?>

    </div>
</section>

<?php
get_footer();
