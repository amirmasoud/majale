<?php
/**
 * 
 * The default template for displaying content
 */
?>
<section id="post-<?php the_ID() ?>" <?php post_class(array('blog-post-area')) ?>>
	<header class="article-header">
		<div class="date-author"></div>

		<h2 class="blog-post-title padding-15"><?php _e( 'Nothing Found', 'majale' ); ?></h2>
		
	</header>

	<article class="article-content padding-15">
		<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

			<p><?php printf( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'majale' ), esc_url( admin_url( 'post-new.php' ) ) ); ?></p>

		<?php elseif ( is_search() ) : ?>

			<p><?php _e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'majale' ); ?></p>
			<?php get_search_form(); ?>

		<?php else : ?>

			<p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'majale' ); ?></p>
			<?php get_search_form(); ?>

		<?php endif; ?>
	</article>
</section>