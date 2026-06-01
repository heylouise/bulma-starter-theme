<?php
/**
 * Comments template.
 *
 * @package Bulma_Starter
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// Don't load if password-protected and password not entered.
if ( post_password_required() ) {
    return;
}
?>

<section class="comments-section section" id="comments">
    <div class="container">

        <?php if ( have_comments() ) : ?>

            <h2 class="title is-4 comments-title">
                <?php
                $comments_number = get_comments_number();
                if ( $comments_number === 1 ) {
                    esc_html_e( '1 Comment', 'bulma-starter' );
                } else {
                    printf(
                        /* translators: %s: comment count */
                        esc_html( _n( '%s Comment', '%s Comments', $comments_number, 'bulma-starter' ) ),
                        esc_html( number_format_i18n( $comments_number ) )
                    );
                }
                ?>
            </h2>

            <ol class="comment-list content">
                <?php
                wp_list_comments( [
                    'style'       => 'ol',
                    'short_ping'  => true,
                    'avatar_size' => 48,
                ] );
                ?>
            </ol>

            <?php
            the_comments_pagination( [
                'prev_text' => __( '&larr; Older comments', 'bulma-starter' ),
                'next_text' => __( 'Newer comments &rarr;', 'bulma-starter' ),
                'class'     => 'pagination comments-pagination',
            ] );
            ?>

            <?php if ( ! comments_open() ) : ?>
                <p class="no-comments notification is-light">
                    <?php esc_html_e( 'Comments are closed.', 'bulma-starter' ); ?>
                </p>
            <?php endif; ?>

        <?php endif; ?>

        <?php
        comment_form( [
            'class_form'           => 'comment-form',
            'class_submit'         => 'button is-primary',
            'title_reply_before'   => '<h3 class="title is-5 comment-reply-title">',
            'title_reply_after'    => '</h3>',
            'comment_field'        => '<div class="field"><label class="label" for="comment">' . esc_html__( 'Comment', 'bulma-starter' ) . '</label><div class="control"><textarea id="comment" name="comment" class="textarea" rows="5" required></textarea></div></div>',
        ] );
        ?>

    </div>
</section>
