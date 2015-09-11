<?php
/**
 * The template for displaying posts in the Quote post format
 */
?>

<section id="post-<?php the_ID(); ?>" <?php post_class(" blog-post-area blog-post-quote"); ?>>
	<header class="article-header">
	
		<?php
			if ( is_single() ) :
				the_title( '<h2 class="blog-post-title padding-15">', '</h2>' );
			else :
				the_title( sprintf( '<a href="%s" class="blog-post-title-link" rel="bookmark"><h2 class="blog-post-title padding-15">', esc_url( get_permalink() ) ), '</h2></a>' );
			endif;
		?>
		
	</header>
	<i class="fa fa-quote-left bg"></i>
	<blockquote>
		<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'solid' ) ); ?>

		<?php wp_link_pages( array(
			'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'majale' ) . '</span>',
			'after'       => '</div>',
			'link_before' => '<span>',
			'link_after'  => '</span>',
			) );
		?>
	</blockquote>
</section>