<?php
/**
 * Template Name: Blank (no header/footer)
 *
 * For squeeze pages, landing pages, thank-you pages.
 * Loads minimal HTML wrapper — no site header, no site footer, no nav.
 */

if ( ! defined( 'ABSPATH' ) ) exit;
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class( 'is-blank-template' ); ?>>
<?php wp_body_open(); ?>

<main class="blank-main">
    <?php while ( have_posts() ) : the_post(); ?>
        <?php the_content(); ?>
    <?php endwhile; ?>
</main>

<?php wp_footer(); ?>
</body>
</html>