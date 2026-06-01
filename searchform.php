<?php
/**
 * Search form template.
 *
 * @package Bulma_Starter
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$unique_id = wp_unique_id( 'search-form-' );
?>

<form role="search" method="get" class="search-form field has-addons" action="<?php echo esc_url( home_url( '/' ) ); ?>">

    <label class="is-sr-only" for="<?php echo esc_attr( $unique_id ); ?>">
        <?php esc_html_e( 'Search for:', 'bulma-starter' ); ?>
    </label>

    <div class="control is-expanded">
        <input
            type="search"
            id="<?php echo esc_attr( $unique_id ); ?>"
            class="input search-field"
            placeholder="<?php esc_attr_e( 'Search&hellip;', 'bulma-starter' ); ?>"
            value="<?php echo esc_attr( get_search_query() ); ?>"
            name="s"
        />
    </div>

    <div class="control">
        <button type="submit" class="button is-primary search-submit">
            <?php esc_html_e( 'Search', 'bulma-starter' ); ?>
        </button>
    </div>

</form>
