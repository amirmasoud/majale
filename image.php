<?php
/**
 * The template for displaying image attachments
 *
 */

get_header(); ?>

<div class="main-container max-width center-block">

<?php
		// Include the featured content template.
		get_template_part( 'content', 'featured-post' );
?>

	<div class="row blogroll">
		<!-- Content -->
		<div class="<?php echo Majale::grid_number()['blog-area'] ?> blog-area">

		<?php
			// Start the loop.
			while ( have_posts() ) : the_post();
		?>

		<section class="blog-post-area">
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
				<?php
				/**
				 * Filter the default Twenty Fifteen image attachment size.
				 *
				 * @since Twenty Fifteen 1.0
				 *
				 * @param string $image_size Image size. Default 'large'.
				 */
				$image_size = apply_filters( 'twentyfifteen_attachment_size', 'large' );

				echo wp_get_attachment_image( get_the_ID(), $image_size );
				?>

				<?php if ( has_excerpt() ) : ?>
					<p class="attachment-caption">
						<?php the_excerpt(); ?>
					</p><!-- .entry-caption -->
				<?php else : ?>
					<p>
					<?php the_content() ?>
					</p>
				<?php endif; ?>

				<?php endwhile; ?>
			</article>
		</section>

		<?php
			// Previous/next post navigation.
			majale_attachment_navigation();
		?>

		<?php
			// If comments are open.
			if ( comments_open() ) {
				comments_template();
			}
		?>

 		</div>

		<?php
		/**
		 * get sidebars.
		 */
		get_sidebar();
		get_sidebar('right') 
		?>
	</div><!-- Blog Roll -->
</div><!-- main container -->
<?php
get_footer();