<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme and one
 * of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query,
 * e.g., it puts together the home page when no home.php file exists.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 */

get_header(); ?>

<div class="main-container max-width center-block">

	<div class="row blogroll">
		<!-- Content -->
		<div class="<?php echo Majale::grid_number()['blog-area'] ?> blog-area">

		<?php
			/**
			 * Display posts from the current page and 
			 * set the 'paged' parameter to 1 when the 
			 * query variable is not set (first page).
			 */
			//$majale_paged = 

			/**
			 * Exclude Sticky posts
			 * and paginate current
			 * posts
			 */
			$majale_blog_query = new WP_Query(
											array(
												'ignore_sticky_posts' => 1,
												'post__not_in' => get_option("sticky_posts"),
												'paged' => (get_query_var('paged')) ? get_query_var('paged') : 1
												)
											);
			if ( have_posts() ) :
				// Start the Loop.
				while ( $majale_blog_query->have_posts() ) : $majale_blog_query->the_post();
			
					/*
					 * Include the post format-specific template for the content. If you want to
					 * use this in a child theme, then include a file called called content-___.php
					 * (where ___ is the post format) and that will be used instead.
					 */
					get_template_part( 'content', get_post_format() );

				endwhile;

				majale_pagination($majale_blog_query);

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
