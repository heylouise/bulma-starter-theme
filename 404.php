<?php
/**
 * 404 — page not found template.
 *
 * @package Bulma_Starter
 */

if ( ! defined( 'ABSPATH' ) ) exit;

get_header();
?>

<section class="section error-404-section">
    <div class="container has-text-centered">

        <h1 class="title is-1 error-404-title">404</h1>

        <h2 class="subtitle is-3">
            <?php esc_html_e( 'Page not found', 'bulma-starter' ); ?>
        </h2>

        <div class="content error-404-content">
            <p>
                <?php esc_html_e( "Sorry — the page you're looking for doesn't exist, or it's been moved.", 'bulma-starter' ); ?>
            </p>
        </div>

        <div class="error-404-search">
            <?php get_search_form(); ?>
        </div>

        <p class="error-404-home">
            <a class="button is-primary" href="<?php echo esc_url( home_url( '/' ) ); ?>">
                <?php esc_html_e( 'Back to home', 'bulma-starter' ); ?>
            </a>
        </p>

    </div>
</section>

<?php
get_footer();
