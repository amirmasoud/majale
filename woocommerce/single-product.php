<?php
/**
 * The Template for displaying all single products.
 *
 * Override this template by copying it to yourtheme/woocommerce/single-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}


if (isset($_GET['ajax']) && $_GET['ajax']) { 

	while ( have_posts() ) : the_post();

		wc_get_template_part( 'content', 'single-product' );

	endwhile; // end of the loop.

}

else {
	get_header( 'shop' ); ?>

	<div class="main-container max-width center-block">

		<div class="row shop-page single-product-page">

			<div class="shop-area <?php echo Majale::shop_single_grid_number()['shop-single-area'] ?>">
		
		<?php
			/**
			 * woocommerce_before_main_content hook
			 *
			 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
			 * @hooked woocommerce_breadcrumb - 20
			 */
			do_action( 'woocommerce_before_main_content' );
		?>
			
			<?php while ( have_posts() ) : the_post(); ?>

				<?php wc_get_template_part( 'content', 'single-product' ); ?>

			<?php endwhile; // end of the loop. ?>

		<?php
			/**
			 * woocommerce_after_main_content hook
			 *
			 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
			 */
			do_action( 'woocommerce_after_main_content' );
		?>

		</div><!-- .shop-area -->

		<?php
			/**
			 * woocommerce_sidebar hook
			 *
			 * @hooked woocommerce_get_sidebar - 10
			 */
			do_action( 'woocommerce_sidebar' );
		?>

	</div><!-- .shop-page -->

</div><!-- .main-container -->

	<?php get_footer( 'shop' );
}