<?php
/**
 * The Sidebar containing the main widget area
 *
 * @package WordPress
 */

if ( function_exists('is_shop') ) :
	if ( (is_shop() OR is_product_category() OR is_product_tag()) AND ! is_product() AND Majale::shop_grid_number()['sidebar-2'] != 'off') : ?>

		<div id="sidebar-2" class="<?php echo Majale::shop_grid_number()['sidebar-2'] ?> sidebar-2" role="complementary">
			<?php  if ( is_active_sidebar( 'sidebar-2' ) ) : ?>
				<?php dynamic_sidebar( 'sidebar-2' ); ?>
			<?php endif;  ?>
		</div>

	<?php elseif ( ! (is_shop() OR is_product_category() OR is_product_tag()) AND is_product() AND Majale::shop_single_grid_number()['sidebar-2'] != 'off' ) : ?>

		<div id="sidebar-2" class="<?php echo Majale::shop_single_grid_number()['sidebar-2'] ?> sidebar-2" role="complementary">
			<?php  if ( is_active_sidebar( 'sidebar-2' ) ) : ?>
				<?php dynamic_sidebar( 'sidebar-2' ); ?>			
			<?php endif;  ?>
		</div>

	<?php elseif ( ! (is_shop() OR is_product_category() OR is_product_tag()) AND ! is_product() AND Majale::grid_number()['sidebar-2'] != 'off' ) : ?>

		<div id="sidebar-2" class="<?php echo Majale::grid_number()['sidebar-2'] ?> sidebar-2" role="complementary">
			<?php  if ( is_active_sidebar( 'sidebar-2' ) ) : ?>
				<?php dynamic_sidebar( 'sidebar-2' ); ?>			
			<?php endif;  ?>
		</div>

	<?php endif;
else : ?>
	<div id="sidebar-2" class="<?php echo Majale::grid_number()['sidebar-2'] ?> sidebar-2" role="complementary">
		<?php  if ( is_active_sidebar( 'sidebar-2' ) ) : ?>
			<?php dynamic_sidebar( 'sidebar-2' ); ?>			
		<?php endif;  ?>
	</div>
<?php endif; ?>