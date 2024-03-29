<?php

// Gebruiker Centraal
// ----------------------------------------------------------------------------------
// Vormgeving en structuur voor de comments
// ----------------------------------------------------------------------------------
// @package gebruiker-centraal
// @author  Paul van Buuren
// @license GPL-2.0+
// @version 3.15.3
// @desc.   Translation improved (most string now originally in English)
// @link    https://github.com/ICTU/gebruiker-centraal-wordpress-theme


if ( post_password_required() ) {
	return;
}
?>

<?php if ( comments_open() ): ?>
    <div id="comments" class="comments-area">

		<?php if ( have_comments() ) : ?>
            <h2 class="comments-title"><?php printf( __( 'Comments <span>(%s)</span>', 'gebruikercentraal' ), get_comments_number() ) ?></h2>

			<?php gc_wbvb_comment_nav(); ?>

            <ul class="comment-list">
				<?php
				wp_list_comments( array(
					'style'       => 'ul',
					'short_ping'  => false,
					'avatar_size' => 82,
					'callback'    => 'gc_wbvb_comment_item'
				) );
				?>
            </ul><!-- .comment-list -->

			<?php gc_wbvb_comment_nav(); ?>

		<?php endif; // have_comments() ?>

		<?php
		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
			?>
            <p class="no-comments"><?php _e( 'Comments are closed.', 'gebruikercentraal' ); ?></p>
		<?php endif; ?>


		<?php if ( comment_form() ) : ?>
            <div class="comment-form">
				<?php comment_form(); ?>
            </div>
		<?php endif; ?>
    </div>
<?php endif; ?>

