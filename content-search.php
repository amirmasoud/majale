<?php
/**
 * 
 * The template part for displaying results in search pages
 *
 * Learn more: {@link https://codex.wordpress.org/Template_Hierarchy}
 * 
 */

?>
<section id="post-<?php the_ID() ?>" <?php post_class(array('blog-post-area')) ?>>
	<header class="article-header">
		<?php majale_home_thumbnail() ?>
		<div class="date-author">
			<?php majale_date_author() ?>
		</div>

		<?php
			if ( is_single() ) :
				the_title( '<h2 class="blog-post-title padding-15">', '</h2>' );
			else :
				the_title( sprintf( '<a href="%s" class="blog-post-title-link" rel="bookmark"><h2 class="blog-post-title padding-15">', esc_url( get_permalink() ) ), '</h2></a>' );
			endif;
		?>
		
	</header>
	<article class="article-content padding-15">
		<?php the_excerpt(); ?>

		<?php wp_link_pages( array(
			'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'majale' ) . '</span>',
			'after'       => '</div>',
			'link_before' => '<span>',
			'link_after'  => '</span>',
			) );
		?>
	</article>
</section>