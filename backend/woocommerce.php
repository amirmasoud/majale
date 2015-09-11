<?php 

/** Breadcrumb */

/**
 * Adding 
 */
add_filter( 'woocommerce_breadcrumb_defaults', 'majale_woocommerce_breadcrumbs' );
function majale_woocommerce_breadcrumbs() {
    return array(
            'delimiter'   => ' &#47; ',
            'wrap_before' => '<nav class="breadcrumb" itemprop="breadcrumb">',
            'wrap_after'  => '</nav>',
            'before'      => '<li>',
            'after'       => '</li>',
            'home'        => _x( 'home', 'breadcrumb', 'woocommerce' ),
        );
}

/**
 * removing woocommerce default seprator
 * using bootstrap seprator instead.
 */
add_filter( 'woocommerce_breadcrumb_defaults', 'majale_change_breadcrumb_delimiter' );
function majale_change_breadcrumb_delimiter( $defaults ) {
	$defaults['delimiter'] = '';
	return $defaults;
}

// Display 24 products per page. Goes in functions.php
add_filter( 'loop_shop_per_page', create_function( '$cols', 'return ' . get_option('posts_per_page') . ';' ), 20 );