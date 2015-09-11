<?php

if ( post_password_required() ) {
	return;
}
?>

	<?php if ( have_comments() ) : ?>
		<section class="comments-title padding-15 text-center">
			<p><i class="fa fa-comment"></i>
			<?php
				printf( _nx( 'One thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', get_comments_number(), 'comments title', 'majale' ),
					number_format_i18n( get_comments_number() ), get_the_title() );
			?>
			</p>
		</section>

		<?php majale_comment_nav() ?>

		<section class="comment-area padding-15">
			<?php
				wp_list_comments( array(
					'style'      => 'div',
					'short_ping' => true,
					'avatar_size'=> 128,
				) );
			?>
		</section><!-- .comment-area .padding-15 -->
	<?php endif; // have_comments() ?>
	
		<?php
			// If comments are closed and there are comments, let's leave a little note, shall we?
			if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
		?>
			<section class="comments-are-colsed comments-title padding-15 text-center"><?php _e( 'Comments are closed.', 'majale' ); ?></section>
		<?php endif; ?>

		<?php comment_form(); ?>

