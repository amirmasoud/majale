
<form class="woocommerce-product-search" role="search" method="get" action="<?php echo esc_url( home_url( '/'  ) ); ?>">
	<div class="input-group">
		<input type="text" class="form-control search-field" placeholder="<?php echo esc_attr_x( 'Search Products&hellip;', 'placeholder', 'woocommerce' ); ?>" name="s" title="<?php echo esc_attr_x( 'Search for:', 'label', 'woocommerce' ); ?>">
		<span class="input-group-btn">
			<button class="btn" type="submit"><?php echo esc_attr_x( 'Search', 'submit button', 'woocommerce' ); ?></button>
		</span>
		<input type="hidden" name="post_type" value="product" />
	</div>
</form>