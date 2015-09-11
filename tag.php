<?php
/**
 * The template for displaying archive pages
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * If you'd like to further customize these archive views, you may create a
 * new template file for each one. For example, tag.php (Tag archives),
 * category.php (Category archives), author.php (Author archives), etc.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 */

get_header(); ?>

<div class="main-container max-width center-block">

	<div class="row blogroll">
	
		<!-- Content -->
		<div class="<?php echo Majale::grid_number()['blog-area'] ?> blog-area">

		<?php
			if ( have_posts() ) :
				?>

				<section class="blog-post-area">
					<header class="article-header">
						<!-- Extra div for margin -->
						<div class="date-author"></div>
						<h2 class="blog-post-title padding-15">
							<i class="fa fa-tags"></i> <?php printf( __( 'Tag Archives: %s', 'twentyfourteen' ), single_tag_title( '', false ) ); ?>
						</h2>
					</header>

					<article class="article-content padding-15">
					<?php
						// Show an optional term description.
						$majale_term_description = term_description();
						if ( ! empty( $majale_term_description ) ) :
							printf( '<footer class="article-footer padding-15">%s</footer>', $majale_term_description );
						endif;
					?>
					</article>
				</section>

				<?php
				// Start the Loop.
				while ( have_posts() ) : the_post();
			
					/*
					 * Include the post format-specific template for the content. If you want to
					 * use this in a child theme, then include a file called called content-___.php
					 * (where ___ is the post format) and that will be used instead.
					 */
					get_template_part( 'content', get_post_format() );

				endwhile;

				majale_pagination();

			else :
				// If no content, include the "No posts found" template.
				get_template_part( 'content', 'none' );

			endif;
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
