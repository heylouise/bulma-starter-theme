<?php
/**
 * Post card for the blog archive grid.
 *
 * @package Bulma_Starter
 */

if ( ! defined( 'ABSPATH' ) ) exit;
?>

<article <?php post_class( 'card post-card' ); ?> id="post-<?php the_ID(); ?>">

    <?php if ( has_post_thumbnail() ) : ?>
        <a href="<?php the_permalink(); ?>" class="card-image-link" aria-label="<?php echo esc_attr( get_the_title() ); ?>">
            <figure class="card-image">
                <?php
                the_post_thumbnail( 'medium_large', [
                    'class' => 'post-card-thumb',
                    'alt'   => esc_attr( get_the_title() ),
                ] );
                ?>
            </figure>
        </a>
    <?php endif; ?>

    <div class="card-content">

        <div class="post-card-meta">
            <time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>" class="post-card-date">
                <?php echo esc_html( get_the_date() ); ?>
            </time>
            <?php
            $primary_cat = get_the_category();
            if ( ! empty( $primary_cat ) ) :
                $cat = $primary_cat[0];
            ?>
                <span class="post-card-category">
                    <a href="<?php echo esc_url( get_category_link( $cat->term_id ) ); ?>">
                        <?php echo esc_html( $cat->name ); ?>
                    </a>
                </span>
            <?php endif; ?>
        </div>

        <h2 class="title is-5 post-card-title">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h2>

        <div class="post-card-excerpt content is-small">
            <?php echo wp_kses_post( wp_trim_words( get_the_excerpt(), 22, '&hellip;' ) ); ?>
        </div>

        <a href="<?php the_permalink(); ?>" class="post-card-readmore">
            <?php esc_html_e( 'Read more', 'bulma-starter' ); ?> &rarr;
        </a>

    </div>

</article>
