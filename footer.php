<?php
/**
 * The footer for the theme.
 *
 * Closes #main, renders footer widget columns (count from theme-setup.php),
 * footer menu, copyright line, and wp_footer().
 *
 * @package Bulma_Starter
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$footer_columns = (int) bulma_starter_config( 'footer_columns', 3 );
$footer_columns = max( 1, min( 4, $footer_columns ) );

// Map column count to Bulma column class
$col_class_map = [
    1 => 'is-full',
    2 => 'is-half',
    3 => 'is-one-third',
    4 => 'is-one-quarter',
];
$col_class = $col_class_map[ $footer_columns ];
?>

</main><!-- #main -->

<footer class="site-footer section">
    <div class="container">

        <?php if ( $footer_columns >= 1 ) : ?>
            <div class="columns footer-widgets">
                <?php for ( $i = 1; $i <= $footer_columns; $i++ ) : ?>
                    <?php if ( is_active_sidebar( 'footer-' . $i ) ) : ?>
                        <div class="column <?php echo esc_attr( $col_class ); ?>">
                            <?php dynamic_sidebar( 'footer-' . $i ); ?>
                        </div>
                    <?php else : ?>
                        <div class="column <?php echo esc_attr( $col_class ); ?>"></div>
                    <?php endif; ?>
                <?php endfor; ?>
            </div>
        <?php endif; ?>

        <div class="footer-bottom">
            <div class="columns is-vcentered">
                <div class="column">
                    <p class="copyright">
                        &copy; <?php echo esc_html( date_i18n( 'Y' ) ); ?>
                        <?php bloginfo( 'name' ); ?>.
                        <?php esc_html_e( 'All rights reserved.', 'bulma-starter' ); ?>
                    </p>
                </div>
                <div class="column has-text-right-tablet">
                    <?php
                    if ( has_nav_menu( 'footer' ) ) {
                        wp_nav_menu( [
                            'theme_location' => 'footer',
                            'container'      => 'nav',
                            'container_class' => 'footer-nav',
                            'menu_class'     => 'footer-menu',
                            'depth'          => 1,
                            'fallback_cb'    => false,
                        ] );
                    }
                    ?>
                </div>
            </div>
        </div>

    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
