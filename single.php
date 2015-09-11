<?php get_header() ?>

<div class="main-container max-width center-block">

	<div class="row blogroll">
		<!-- Content -->
		<div class="<?php echo Majale::grid_number()['blog-area'] ?> blog-area">
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
			?>

			<?php
				// Previous/next post navigation.
				majale_post_nav();
			?>

			<section class="single-post-metadata padding-15">

				<?php majale_get_tags() ?>

				<?php majale_get_category() ?>

			</section>

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
<?php get_footer() ?>