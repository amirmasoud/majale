<?php
/**
 * The template for displaying 404 pages (not found)
 */

get_header('404'); ?>

		<div class="container-404">
			<div class="content-404">
				<div class="not-found-404">404</div>
				<div class="not-found-text"><?php _e('we lost!', 'majale') ?></div>
				<div class="back-to-home">
					<a class="home-link" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
						<i class="fa fa-chevron-left"></i> <?php _e('Back to home', 'majale') ?>
					</a>
				</div>
			</div>
		</div>

<?php get_footer('404'); ?>