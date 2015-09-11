<?php
/**
 * The template for displaying search results pages.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
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

		<section class="blog-post-area">
			<header class="article-header">
				<!-- Extra div for margin -->
				<div class="date-author"></div>
				<h2 class="blog-post-title padding-15">
					<i class="fa fa-search"></i>  <?php printf( __( 'Search Results for: <b>%s</b>', 'majale' ), get_search_query() ); ?>
				</h2>
			</header>
		</section>

		<?php
			if ( have_posts() ) :
				// Start the Loop.
				while ( have_posts() ) : the_post();
			
					/*
					 * Include the post format-specific template for the content. If you want to
					 * use this in a child theme, then include a file called called content-___.php
					 * (where ___ is the post format) and that will be used instead.
					 */
					get_template_part( 'content', 'search' );

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
