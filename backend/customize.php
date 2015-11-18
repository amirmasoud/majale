<?php
/**
* helper class for printing redux
* value in proper place
*/
class majale_redux_customize
{
	/**
	 * get redux variable
	 * @param  mix $id param name
	 * @return mix
	 */
	private static function get($id)
	{
		global $majale;

		if ( is_array($id) )
			return $majale[$id[0]][$id[1]];

		return $majale[$id];
	}

	/**
	 * output redux value
	 * @param  mix $id param name
	 * @param string before
	 * @param string after
	 * @return mix
	 */
	private static function output($id, $before = "", $after = "")
	{
		echo self::get($id);
	}

	/**
	 * check existance of a value
	 * @param  mix $id param name
	 * @return bool
	 */
	private static function isfilled($id)
	{
		if ( null !== self::get($id) )
			return  1;
		return 0;
	}

	/**
	 * if isset echo
	 * check existance of a param and print it
	 * @param  mix $id     param name
	 * @param  html $before
	 * @param  html $after
	 * @return mix
	 */
	private static function iie($id, $before = "", $after = "")
	{
		if ( self::isfilled($id) )
			echo $before . self::get($id) . $after;
	}

	/**
	 * isset echo
	 * @param mix $before
	 * @param mix $after
	 * @param mix $after
	 * @return mix
	 */
	private static function ie($middle = "", $before = "", $after = "")
	{
		if ( self::isfilled($id) )
			echo $before . $middle . $after;		
	}

	/**
	 * 1.0 General Settings
	 */

	/**
	 * Favicon
	 * add favicon to the site
	 */
	public static function favicon()
	{
		self::iie(array('favicon', 'url'), '<link rel="shortcut icon" type="image/x-icon" href="', '">' );
	}

	/**
	 * Apple Touch Icon
	 * print link to apple icons
	 */
	public static function apple_touch_icon()
	{
		// apple Iphone Icon
		@self::iie(array('apple_iphone', 'url'), '<link rel="apple-touch-icon" href="', '" />');

		// Apple Iphone Retina
		@self::iie(array('apple_iphone_retina', 'url'), '<link rel="apple-touch-icon" sizes="72x72" href="', '" />');

		// Apple Ipad
		@self::iie(array('apple_ipad', 'url'), '<link rel="apple-touch-icon" sizes="114x114" href="', '" />');

		// Apple Ipad Retina
		@self::iie(array('apple_ipad_retina', 'url'), '<link rel="apple-touch-icon" sizes="144x144" href="', '" />');
	}

	/**
	 * Add custom js between head tags
	 * @return html
	 */
	public static function header_custom_code()
	{
		self::iie('header_code');
	}

	/**
	 * Add custom js at end of the footer.
	 * @return html
	 */
	public static function footer_custom_code()
	{
		self::iie('footer_code');
	}

	/**
	 * Add custom js at end of the footer.
	 * @return html
	 */
	public static function custom_style()
	{
		self::iie('style_code', '<style type="text/css">', '</style>');
	}

	/**
	 * print wheter image or text as logo.
	 * @param  text $title WP default title
	 * @param  integer $id WP post id
	 * @return image/text
	 */
    public static function logo($title = get_, $id = null)
    {
        // if not defined so it is text
        if ( ! self::isfilled('logo_type') )
            echo '<h1 class="site-title text-overflow">' . get_option('blogname') . '</h1>';

        // if it is defined and is 1 so it is text
        if ( self::get('logo_type') == 1 )
            echo '<h1 class="site-title text-overflow">' . get_option('blogname') . '</h1>';

        // else it is image so we print that image
        else
            return self::iie(array('logo_image', 'url'), '<img title="' . get_option('blog_name') . '" src="', '"/>');
    }

    /**
     * Set logo align.
     * @return css
     */
    private static function logo_align()
    {
		if ( self::get('logo_image_align') == 1 )
			echo ".logo img {float: left;} .logo {text-align: left}";
		elseif ( self::get('logo_image_align') == 2 )
			echo ".logo img {margin: 0 auto; text-align-center;} .logo {text-align: center}";
		elseif ( self::get('logo_image_align') == 3 )
			echo ".logo img {float: right;} .logo {text-align: right}";
    }

    /**
     * Set Search Icon posotion in the header.
     * @return css
     */
    private static function search_icon_position()
    {
		if ( self::get('search_icon_position') == 1 )
			echo ".search-icon {left: 31px; right: initial;}";
		elseif ( self::get('search_icon_position') == 2 )
			echo ".search-icon {right: 31px; left: initial;}";
		elseif ( self::get('search_icon_position') == 3 )
			echo ".search-icon {display: none;}";
    }

    /**
     * Set Navigation menu visibility.
     * @return css
     */
    private static function navigation_menu()
    {
		if ( self::get('navigation_menu') == 1 )
			echo ".main-navigation-container {display: block;}";
		elseif ( self::get('navigation_menu') == 2 )
			echo ".main-navigation-container {display: none;}";
    }

    /**
     * Set feature posts css class.
     * @return css class
     */
    public static function feature_posts_html()
    {
    	if ( self::get('feature_posts_width') == 1 )
    		echo "feature-posts-container";
    	elseif ( self::get('feature_posts_width') == 2 )
    		echo "feature-posts-container max-width center-block";
    }

    /**
     * Set featured posts style.
     * @return css
     */
    private static function feature_posts_css()
    {
    	if ( self::get('feature_posts_width') == 1 )
    		echo ".featured-container {padding: 0}";
    	elseif ( self::get('feature_posts_width') == 2 )
    		echo "";
    }

    /**
     * detemine to show or hide features post on specefic pages.
     * @return bool
     */
    public static function show_feature_posts_on()
    {
    	if ( is_archive() 	AND self::get(array('show_feature_posts', 1))
		OR ( is_author() 	AND self::get(array('show_feature_posts', 2)) )
		OR ( is_category() 	AND self::get(array('show_feature_posts', 3)) )
		OR ( is_home() 		AND self::get(array('show_feature_posts', 4)) )
		OR ( is_page() 		AND self::get(array('show_feature_posts', 5)) )
		OR ( is_search() 	AND self::get(array('show_feature_posts', 6)) )
    	OR ( is_single() 	AND self::get(array('show_feature_posts', 7)) )
    	OR ( is_tag() 		AND self::get(array('show_feature_posts', 7)) ) )
    		return 1;
    }

    /**
     * return count of the feature posts
     * @return integer
     */
    public static function feature_posts_count()
    {
    	return self::get('feature_posts_count');
    }

    /**
     * set max width of the site
     * @return css
     */
    private static function site_width()
    {
    	echo ".shop-page, .blogroll, #cssmenu, .max-width {max-width: " . self::get('site_width') . "px;}";
    }

    /**
     * generate blog layout grid system numbers.
     * @return string
     */
    private static function blog_layout()
    {
    	switch (self::get('blog_layout')) {
    		case '1':
				return array(
						'blog-area' => 'col-md-12 col-sm-12 col-xs-12',
						'sidebar-1' => 'off',
						'sidebar-2'	=> 'off'
					);
				break;

    		case '2':
				return array(
						'blog-area' => 'col-md-8 col-xs-12 col-md-push-4',
						'sidebar-1' => 'col-md-4 col-xs-12 col-md-pull-8',
						'sidebar-2'	=> 'off'
						);
					break;

    		case '3':
				return array(
						'blog-area' => 'col-md-8 col-xs-12',
						'sidebar-1' => 'off',
						'sidebar-2'	=> 'col-md-4 col-xs-12'
						);
					break;

    		case '4':
				return array(
						'blog-area' => 'col-md-6 col-sm-12 col-xs-12 col-md-push-3',
						'sidebar-1' => 'col-md-3 col-sm-6 col-xs-12 col-md-pull-6',
						'sidebar-2'	=> 'col-md-3 col-sm-6 col-xs-12'
						);
					break;

    		case '5':
				return array(
						'blog-area' => 'col-md-6 col-sm-12 col-xs-12 col-md-push-6',
						'sidebar-1' => 'col-md-3 col-sm-6 col-xs-12 col-md-pull-6',
						'sidebar-2'	=> 'col-md-3 col-sm-6 col-xs-12 col-md-pull-6 fix-sidebar-2'
						);
					break;

    		case '6':
				return array(
						'blog-area' => 'col-md-6 col-sm-12 col-xs-12',
						'sidebar-1' => 'col-md-3 col-sm-6 col-xs-12 fix-sidebar-1',
						'sidebar-2'	=> 'col-md-3 col-sm-6 col-xs-12'
						);
					break;
    		
    		default:
    			// style no. 1
				return array(
						'blog-area' => 'col-md-12 col-sm-12 col-xs-12',
						'sidebar-1' => 'off',
						'sidebar-2'	=> 'off'
					);
    	}// switch (self::get('blog_layout'))
    }

    /**
     * generate blog layout grid system numbers according to post/page selected option
     * in the meta box.
     * call in th loop
     * 
     * @return string
     */
    protected static function one_page_style()
    {
    	global $post;

    	/**
    	 * if cluase is for content-none page
    	 * @var string
    	 */
    	$majale_one_page_style = '';
    	if (isset($post->ID))
    		$majale_one_page_style = get_post_meta( $post->ID, 'majale_one_page_style', true);

    	/**
    	 * one page style only apply to page/post view 
    	 * not on the home page
    	 */
    	if (is_home())
    		return self::blog_layout();

    	switch ($majale_one_page_style) {
    		case 'one-c':
				return array(
						'blog-area' => 'col-md-12 col-sm-12 col-xs-12',
						'sidebar-1' => 'off',
						'sidebar-2'	=> 'off'
					);
				break;

    		case 'two-c-l':
				return array(
						'blog-area' => 'col-md-8 col-xs-12 col-md-push-4',
						'sidebar-1' => 'col-md-4 col-xs-12 col-md-pull-8',
						'sidebar-2'	=> 'off'
						);
					break;

    		case 'two-c-r':
				return array(
						'blog-area' => 'col-md-8 col-xs-12',
						'sidebar-1' => 'off',
						'sidebar-2'	=> 'col-md-4 col-xs-12'
						);
					break;

    		case 'three-c-m':
				return array(
						'blog-area' => 'col-md-6 col-sm-12 col-xs-12 col-md-push-3',
						'sidebar-1' => 'col-md-3 col-sm-6 col-xs-12 col-md-pull-6',
						'sidebar-2'	=> 'col-md-3 col-sm-6 col-xs-12'
						);
					break;

    		case 'three-c-l':
				return array(
						'blog-area' => 'col-md-6 col-sm-12 col-xs-12 col-md-push-6',
						'sidebar-1' => 'col-md-3 col-sm-6 col-xs-12 col-md-pull-6',
						'sidebar-2'	=> 'col-md-3 col-sm-6 col-xs-12 col-md-pull-6 fix-sidebar-2'
						);
					break;

    		case 'three-c-r':
				return array(
						'blog-area' => 'col-md-6 col-sm-12 col-xs-12',
						'sidebar-1' => 'col-md-3 col-sm-6 col-xs-12 fix-sidebar-1',
						'sidebar-2'	=> 'col-md-3 col-sm-6 col-xs-12'
						);
					break;
    		
    		default:
				return self::blog_layout();
    	}// switch (self::get('blog_layout'))
    }

    /**
     * Determine type of the layout, boxed, layout.
     * @return css
     */
    private static function layout_type()
    {
    	if (self::get('layout_type') == 1) :
    		$max_width = self::get('site_width') - 40;
    		echo ".logo, .main-navigation-container, .footer, .footer-info {max-width: " . $max_width . "px;}";
    	else :
    		echo ".logo, .main-navigation-container, .footer, .footer-info {max-width: auto}";
    	endif;
    }

    /**
     * generate shop layout grid system numbers.
     * @return string
     */
    protected static function shop_layout()
    {
    	switch (self::get('shop_layout')) {
    		case '1':
				return array(
						'shop-area' => 'col-md-12 col-sm-12 col-xs-12',
						'sidebar-1' => 'off',
						'sidebar-2'	=> 'off'
					);
				break;

    		case '2':
				return array(
						'shop-area' => 'col-md-8 col-xs-12 col-md-push-4',
						'sidebar-1' => 'col-md-4 col-xs-12 col-md-pull-8',
						'sidebar-2'	=> 'off'
						);
					break;

    		case '3':
				return array(
						'shop-area' => 'col-md-8 col-xs-12',
						'sidebar-1' => 'off',
						'sidebar-2'	=> 'col-md-4 col-xs-12'
						);
					break;

    		case '4':
				return array(
						'shop-area' => 'col-md-6 col-sm-12 col-xs-12 col-md-push-3',
						'sidebar-1' => 'col-md-3 col-sm-6 col-xs-12 col-md-pull-6',
						'sidebar-2'	=> 'col-md-3 col-sm-6 col-xs-12'
						);
					break;

    		case '5':
				return array(
						'shop-area' => 'col-md-6 col-sm-12 col-xs-12 col-md-push-6',
						'sidebar-1' => 'col-md-3 col-sm-6 col-xs-12 col-md-pull-6',
						'sidebar-2'	=> 'col-md-3 col-sm-6 col-xs-12 col-md-pull-6 fix-sidebar-2'
						);
					break;

    		case '6':
				return array(
						'shop-area' => 'col-md-6 col-sm-12 col-xs-12',
						'sidebar-1' => 'col-md-3 col-sm-6 col-xs-12 fix-sidebar-1',
						'sidebar-2'	=> 'col-md-3 col-sm-6 col-xs-12'
						);
					break;
    		
    		default:
    			// style no. 1
				return array(
						'shop-area' => 'col-md-12 col-sm-12 col-xs-12',
						'sidebar-1' => 'off',
						'sidebar-2'	=> 'off'
					);
    	}// switch (self::get('shop_layout'))
    }

    /**
     * generate shop single product layout grid system numbers.
     * @return string
     */
    protected static function shop_single_layout()
    {
    	switch (self::get('shop_single_layout')) {
    		case '1':
				return array(
						'shop-single-area' => 'col-md-12 col-sm-12 col-xs-12',
						'sidebar-1' => 'off',
						'sidebar-2'	=> 'off'
					);
				break;

    		case '2':
				return array(
						'shop-single-area' => 'col-md-8 col-xs-12 col-md-push-4',
						'sidebar-1' => 'col-md-4 col-xs-12 col-md-pull-8',
						'sidebar-2'	=> 'off'
						);
					break;

    		case '3':
				return array(
						'shop-single-area' => 'col-md-8 col-xs-12',
						'sidebar-1' => 'off',
						'sidebar-2'	=> 'col-md-4 col-xs-12'
						);
					break;

    		case '4':
				return array(
						'shop-single-area' => 'col-md-6 col-sm-12 col-xs-12 col-md-push-3',
						'sidebar-1' => 'col-md-3 col-sm-6 col-xs-12 col-md-pull-6',
						'sidebar-2'	=> 'col-md-3 col-sm-6 col-xs-12'
						);
					break;

    		case '5':
				return array(
						'shop-single-area' => 'col-md-6 col-sm-12 col-xs-12 col-md-push-6',
						'sidebar-1' => 'col-md-3 col-sm-6 col-xs-12 col-md-pull-6',
						'sidebar-2'	=> 'col-md-3 col-sm-6 col-xs-12 col-md-pull-6 fix-sidebar-2'
						);
					break;

    		case '6':
				return array(
						'shop-single-area' => 'col-md-6 col-sm-12 col-xs-12',
						'sidebar-1' => 'col-md-3 col-sm-6 col-xs-12 fix-sidebar-1',
						'sidebar-2'	=> 'col-md-3 col-sm-6 col-xs-12'
						);
					break;
    		
    		default:
    			// style no. 1
				return array(
						'shop-single-area' => 'col-md-12 col-sm-12 col-xs-12',
						'sidebar-1' => 'off',
						'sidebar-2'	=> 'off'
					);
    	}// switch (self::get('blog_layout'))
    }

    /**
     * number of products to show in a row.
     * @return [type] [description]
     */
    protected static function products_per_row()
    {
		if(self::get('products_per_row') == 1) :
			return 'col-xs-12';
		elseif(self::get('products_per_row') == 2) :
			return 'col-xs-12 col-sm-6';
		elseif(self::get('products_per_row') == 3) :
			return 'col-xs-12 col-sm-6 col-md-4';
		elseif(self::get('products_per_row') == 4) :
			return 'col-xs-12 col-sm-6 col-md-3';
		elseif(self::get('products_per_row') == 5) :
			return 'col-xs-15';
		else :
			return 'col-xs-12 col-sm-6 col-md-3';
    	endif;
    }

    /**
     * @return set color link for navigation
     */
    private static function navigation_link_color()
    {
		// link color regular
		self::iie(array('navigation_link_color', 'regular'), '#cssmenu a, .mobile-navigation ul li a {color:', '}');

		// link color on hover
		self::iie(array('navigation_link_color', 'hover'), '#cssmenu ul li:hover > a, #cssmenu ul li:focus > a, #cssmenu ul ul li:hover > a, #cssmenu ul ul li:focus > a, .mobile-navigation ul li a:hover, .mobile-navigation ul li a:focus  {color:', '}');

		// link color on active
		self::iie(array('navigation_link_color', 'active'), '#cssmenu ul li.active > a, .mobile-navigation ul li a:active  {color:', '}');
    }

    /**
     * also for the mobile search and menu
     * @return set color link for search icon
     */
    private static function search_icon_link_color()
    {
		// link color regular
		self::iie(array('search_icon_link_color', 'regular'), '.search-icon, .mobile-menu, .mobile-search {color:', ' !important}');

		// link color on hover
		self::iie(array('search_icon_link_color', 'hover'), '.search-icon:hover, .search-icon:focus, .mobile-menu:focus, .mobile-search:focus, .mobile-menu:hver, .mobile-search:hver {color:', ' !important}');

		// link color on active
		self::iie(array('search_icon_link_color', 'active'), '.search-icon:active, .mobile-menu:active, .mobile-search:active {color:', ' !important}');
    }

    /**
     * Set widget link color.
     * @return css
     */
    private static function widget_link_color()
    {
		// link color regular
		self::iie(array('widget_link_color', 'regular'), '.sidebar-1 .widget-area a, .sidebar-2 .widget-area a {color:', ' !important}');

		// link color on hover
		self::iie(array('widget_link_color', 'hover'), '.sidebar-1 .widget-area a:hover, .sidebar-1 .widget-area a:focus, .sidebar-2 .widget-area a:hover, .sidebar-2 .widget-area a:focus {color:', ' !important}');

		// link color on active
		self::iie(array('widget_link_color', 'active'), '.sidebar-1 .widget-area a:active, .sidebar-2 .widget-area a:active {color:', ' !important}');
    }

    /**
     * Set footer link color.
     * @return css
     */
    private static function footer_link_color()
    {
		// link color regular
		self::iie(array('footer_link_color', 'regular'), '.footer .widget-content a {color:', ' !important}');

		// link color on hover
		self::iie(array('footer_link_color', 'hover'), '.footer .widget-content a:hover, .footer .widget-content a:focus {color:', ' !important}');

		// link color on active
		self::iie(array('footer_link_color', 'active'), '.footer .widget-content a:active {color:', ' !important}');
    }

    /**
     * Set post link color.
     * @return css
     */
    private static function post_link_color()
    {
		// link color regular
		self::iie(array('post_link_color', 'regular'), '.shop-area a, .blog-post-area a, .woocommerce div.products div.product h3, .breadcrumb>li+li:before, .next-post-section a, .previous-post-section a, .comment-edit-link, .comment-reply-link, .logged-in-as a, #cancel-comment-reply-link, .url, .home-link, #goTop {color:', ' !important}');

		// link color on hover
		self::iie(array('post_link_color', 'hover'), '.shop-area a:hover, .shop-area a:focus, .blog-post-area a:hover, .blog-post-area a:focus, .woocommerce div.products div.product h3:hover, .woocommerce div.products div.product h3:focus, .next-post-section a:hover, .previous-post-section a:hover, .next-post-section a:focus, .previous-post-section a:focus, .comment-edit-link:hover, .comment-edit-link:focus, .comment-reply-link:hover, .comment-reply-link:focus, .logged-in-as a:hover, .logged-in-as a:focus, #cancel-comment-reply-link:hover, #cancel-comment-reply-link:focus, .blog-area span.date:hover, .blog-area span.date:hover, .blog-area span.author:hover, .tag-list a:hover, .tag-list a:focus, .cat-list a:hover, .cat-list a:focus, a .blog-post-title:hover, .blog-area span.date:hover, .blog-area span.author:hover, a .blog-post-title:focus, .blog-area span.date:focus, .blog-area span.author:focus, .url:hover, .url:focus, .home-link:hover, .home-link:focus, #goTop:hover, #goTop:focus {color:', ' !important}');

		// link color on active
		self::iie(array('post_link_color', 'active'), '.shop-area a:active, .blog-post-area a:active, a .blog-post-title:active, .blog-area span.date:active, .blog-area span.author:active, .woocommerce div.products div.product h3:active, .next-post-section a:active, .previous-post-section a:active, .comment-edit-link:active, .comment-reply-link:active, .logged-in-as a:active, #cancel-comment-reply-link:active, .url:active, .home-link:active, #goTop:active {color:', ' !important}');
    }

    /**
     * Show the text on the footer info section
     * @return string
     */
    protected static function footer_info_text()
    {
    	return self::get('footer_info_editor');
    }

    /**
     * Change input/textarea/button border color regular/hover/fucus
     * @return css
     */
    private static function input_border()
    {
		self::iie(array('input_border_color', 'rgba'), 'input, select, textarea, .woocommerce form .form-row .input-text, .woocommerce-page form .form-row .input-text, button, input[type=submit], input[type=reset], input[type=button], .button {border: 1px solid ', ' !important}');
		self::iie(array('input_border_color', 'rgba'), '.woocommerce a.button i.fa, .woocommerce #respond input#submit.alt .fa, .woocommerce a.button.alt .fa, .woocommerce button.button.alt .fa, .woocommerce input.button.alt .fa, .woocommerce .widget_price_filter .price_slider_amount .button .fa, .modal-footer .btn .fa {color:', ' !important}');
		self::iie(array('input_border_hover', 'rgba'), 'input:focus, select:focus, textarea:focus, .woocommerce form .form-row .input-text:focus, .woocommerce-page form .form-row .input-text:focus, button:hover, button:focus, input[type=submit]:hover, input[type=submit]:focus, input[type=reset]:hover, input[type=reset]:focus, input[type=button]:hover, input[type=button]:focus, .button:hover, .button:focus {border: 1px solid ', ' !important}');
		self::iie(array('input_border_hover', 'rgba'), 'button:hover, button:focus, input[type=submit]:hover, input[type=submit]:focus, input[type=reset]:hover, input[type=reset]:focus, input[type=button]:hover, input[type=button]:focus, .button:hover, .button:focus {color: ', ' !important}');
    }

    /**
     * change woocommerce review section borders to secondary color of main content.
     * @return css
     */
    protected static function post_meta_color()
    {
    	// border-bottom
    	self::iie(array('post_meta', 'rgba'), '.woocommerce div.product .woocommerce-tabs ul.tabs:before, .modal-header {border-bottom: 1px solid ', ' !important}');

    	// border-color
    	self::iie(array('post_meta', 'rgba'), 'table, .woocommerce table.shop_table td, .woocommerce .cart-collaterals .cart_totals table, .woocommerce .cart-collaterals .cart_totals td, .woocommerce .cart-collaterals .cart_totals th, .woocommerce table.shop_table tbody th, .woocommerce table.shop_table tfoot td, .woocommerce table.shop_table tfoot th, .woocommerce-checkout #payment div.payment_box, .woocommerce-checkout #payment ul.payment_methods {border-color: ', ' !important}');
    	
    	// border-top
    	self::iie(array('post_meta', 'rgba'), '.modal-footer, .table>tbody>tr>th, .table>tfoot>tr>th, table>tbody>tr>td, .table>tfoot>tr>td {border-top: 1px solid ', ' !important}');

    	// background
    	self::iie(array('post_meta', 'rgba'), '.woocommerce #reviews #comments ol.commentlist li img.avatar {background: ', ' !important}');

    	// border
    	self::iie(array('post_meta', 'rgba'), '.woocommerce div.product .woocommerce-tabs ul.tabs li, .woocommerce #reviews #comments ol.commentlist li .comment-text, .woocommerce #reviews #comments ol.commentlist li img.avatar {border: 1px solid ', ' !important}');

    	// border-bottom-color
    	self::iie(array('post_meta', 'rgba'), '.woocommerce-checkout #payment div.payment_box:after, .woocommerce div.product .woocommerce-tabs ul.tabs li.active, .table>thead>tr>th {border-bottom-color: ', ' !important}');


    }

    private static function logo_top_margin()
    {
    	self::iie('logo_top_margin', '.home-link {margin-top:', 'px !important}');
    }

    /**
     * Print custom style generated by redux.
     * @return CSS
     */
    public static function style()
    {

?><style type="text/css"><?php
self::logo_align();
self::search_icon_position();
self::navigation_menu();
self::feature_posts_css();
self::site_width();
self::layout_type();
self::navigation_link_color();
self::search_icon_link_color();
self::widget_link_color();
self::footer_link_color();
self::input_border();
self::post_link_color();
self::post_meta_color();
self::logo_top_margin();
?></style>

	<?php
    }

}

/**
 * Now lets use our class with WordPress Action
 */

/**
 * 1.0 General Settings
 */

// Favicon
add_action('wp_head','majale_redux_customize::favicon');

// Apple touch icon
add_action('wp_head','majale_redux_customize::apple_touch_icon');

// haeder custom code
add_action('wp_head','majale_redux_customize::header_custom_code');

// footer custom code
add_action('wp_head','majale_redux_customize::footer_custom_code');

// custom style
add_action('wp_head','majale_redux_customize::custom_style');

// add logo action
add_action('majale_logo', 'majale_redux_customize::logo');

// Logo Image Align
add_action('wp_head','majale_redux_customize::style');

// Print features posts css class.
add_action('majale_feature_posts', 'majale_redux_customize::feature_posts_html' );

// show/hide features posts.
add_action('show_feature_posts_on','majale_redux_customize::show_feature_posts_on');