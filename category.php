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
			if ( have_posts() ) :
				// showing category title
				?>
				<section class="blog-post-area">
					<header class="article-header">
						<div class="date-author"></div>
						<h2 class="blog-post-title padding-15">
							<i class="fa fa-folder"></i> <?php printf( __( 'Category Archives: %s', 'majale' ), single_cat_title( '', false ) ); ?>
						</h2>
					</header>

					<article class="article-content padding-15">
						<?php
							// Show an optional term description.
							$majale_term_description = term_description();
							if ( ! empty( $majale_term_description ) ) :
								printf( '%s', $majale_term_description );
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
