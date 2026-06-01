<?php
/**
 * "Nothing found" fallback for archive and search pages.
 *
 * @package Bulma_Starter
 */

if ( ! defined( 'ABSPATH' ) ) exit;
?>

<section class="section no-results-section">
    <div class="container has-text-centered">

        <h2 class="title is-4">
            <?php esc_html_e( 'Nothing found', 'bulma-starter' ); ?>
        </h2>

        <?php if ( is_search() ) : ?>
            <p class="subtitle is-6">
                <?php esc_html_e( 'Sorry, no results matched your search. Try different keywords.', 'bulma-starter' ); ?>
            </p>
            <div class="no-results-search">
                <?php get_search_form(); ?>
            </div>
        <?php else : ?>
            <p class="subtitle is-6">
                <?php esc_html_e( "It seems we can't find what you're looking for. Try searching below.", 'bulma-starter' ); ?>
            </p>
            <div class="no-results-search">
                <?php get_search_form(); ?>
            </div>
        <?php endif; ?>

    </div>
</section>
