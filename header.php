<?php
/**
 * The header for the theme.
 *
 * Renders the <head>, the site header with Bulma navbar (logo left, menu right),
 * and opens the main content wrapper.
 *
 * @package Bulma_Starter
 */

if ( ! defined( 'ABSPATH' ) ) exit;
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="skip-link is-sr-only" href="#main"><?php esc_html_e( 'Skip to content', 'bulma-starter' ); ?></a>

<header class="site-header">
    <nav class="navbar" role="navigation" aria-label="<?php esc_attr_e( 'Main navigation', 'bulma-starter' ); ?>">
        <div class="container">

            <div class="navbar-brand">
                <?php if ( has_custom_logo() ) : ?>
                    <?php the_custom_logo(); ?>
                <?php else : ?>
                    <a class="navbar-item site-title" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                        <?php bloginfo( 'name' ); ?>
                    </a>
                <?php endif; ?>

                <a role="button" class="navbar-burger" aria-label="<?php esc_attr_e( 'Toggle menu', 'bulma-starter' ); ?>" aria-expanded="false" data-target="mainMenu">
                    <span aria-hidden="true"></span>
                    <span aria-hidden="true"></span>
                    <span aria-hidden="true"></span>
                </a>
            </div>

            <div id="mainMenu" class="navbar-menu">
                <div class="navbar-end">
                    <?php
                    if ( has_nav_menu( 'primary' ) ) {
                        wp_nav_menu( [
                            'theme_location' => 'primary',
                            'container'      => false,
                            'menu_class'     => 'navbar-menu-list',
                            'depth'          => 2,
                            'fallback_cb'    => false,
                            'items_wrap'     => '%3$s',
                            'walker'       =>  new Bulma_NavWalker(),
                            'fallback_cb'      =>  'Bulma_NavWalker::fallback'
                            // If you grab a Bulma navwalker, add: 'walker' => new Bulma_Navwalker(),
                        ] );
                    }
                    ?>

                    <?php if ( bulma_starter_config( 'show_search_in_header' ) ) : ?>
                        <div class="navbar-item">
                            <?php get_search_form(); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </nav>
</header>

<main id="main" class="site-main">
