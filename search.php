<?php
/**
 * Search results template.
 *
 * Same grid layout as archive.php, but with a search-specific heading and
 * a re-shown search form at the top of the results.
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

$search_query = get_search_query();
?>

<header class="search-header section">
    <div class="container">
        <h1 class="title is-2">
            <?php
            if ( $search_query !== '' ) {
                printf(
                    /* translators: %s: search query */
                    esc_html__( 'Search results for: %s', 'bulma-starter' ),
                    '<em>' . esc_html( $search_query ) . '</em>'
                );
            } else {
                esc_html_e( 'Search', 'bulma-starter' );
            }
            ?>
        </h1>

        <div class="search-header-form">
            <?php get_search_form(); ?>
        </div>

        <?php if ( have_posts() ) : ?>
            <p class="subtitle is-6 search-result-count">
                <?php
                global $wp_query;
                $found = (int) $wp_query->found_posts;
                printf(
                    /* translators: %s: number of results */
                    esc_html( _n( '%s result found.', '%s results found.', $found, 'bulma-starter' ) ),
                    esc_html( number_format_i18n( $found ) )
                );
                ?>
            </p>
        <?php endif; ?>
    </div>
</header>

<section class="section search-grid-section">
    <div class="container">

        <?php if ( have_posts() ) : ?>

            <div class="columns is-multiline search-grid archive-grid">
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
                'class'     => 'pagination is-centered search-pagination',
            ] );
            ?>

        <?php else : ?>
            <?php get_template_part( 'template-parts/content', 'none' ); ?>
        <?php endif; ?>

    </div>
</section>

<?php
get_footer();
