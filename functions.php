<?php
/**
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 *
 * @link http://codex.wordpress.org/Theme_Development
 * @link http://codex.wordpress.org/Child_Themes
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * @link http://codex.wordpress.org/Plugin_API
 *
 */

/**
 * Set up the content width
 */
if ( ! isset( $content_width ) ) {
	$content_width = 580;
}

/**
 * add customization functions
 */
require_once('backend/customize.php');
require_once('backend/majale.php');

/**
 * css 3 menu.
 * 
 * NOTE:we use custom navigation instead of
 * bootstrap navigation, because it's not
 * supporting more than 2 level sub-menu
 * 
 */
require_once('backend/CSS_Menu_Maker_Walker.php');

/**
 * redux framework
 *
 * A customization framework.
 */
require_once('backend/majale_redux_Framework_config.php');


require_once('backend/class-tgm-plugin-activation.php');


/**
 * Custom functionality for WooCommerce.
 */
require_once('backend/woocommerce.php');

if ( ! function_exists( 'majale_setup' ) ) :

	/**
	 *
	 * Set up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support post thumbnails.
	 *
	 */
	function majale_setup() {

		/*
		 * Translations can be added to the /languages/ directory.
		 * If you're building a theme based on Twenty Fourteen, use a find and
		 * replace to change 'majale' to the name of your theme in all
		 * template files.
		 */
		load_theme_textdomain( 'majale', get_template_directory() . '/languages' );


		// Add RSS feed links to <head> for posts and comments.
		add_theme_support( 'automatic-feed-links' );

		// Enable support for Post Thumbnails, and declare four sizes.
		add_theme_support( 'post-thumbnails' );
		add_image_size( 'majale-large', 300, 300, array( 'center', 'center' ) );
		add_image_size( 'majale-medium', 300, 150, array( 'center', 'center' ) );
		add_image_size( 'majale-small', 150, 150, array( 'center', 'center' ) );
		add_image_size( 'majale-home', 600, 9999, array( 'center', 'center' ) );

		// register navigaion menu
		register_nav_menus( 
			array(
		    	'primary' => __( 'Primary Menu', 'majale' ),
			) 
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
		) );

		/*
		 * Enable support for Post Formats.
		 * See http://codex.wordpress.org/Post_Formats
		 */
		add_theme_support( 'post-formats', array(
			'aside', 'image', 'video', 'audio', 'quote', 'link', 'gallery',
		) );

		// Add support for featured content.
		add_theme_support( 'featured-content', array(
			'max_posts' => 8
		) );

		// Add WooCommerce Support
		add_theme_support( 'woocommerce' );

		// This theme uses its own gallery styles.
		add_filter( 'use_default_gallery_style', '__return_false' );
	}
	add_action( 'after_setup_theme', 'majale_setup' );

endif; // function exists

if ( ! function_exists('majale_content_width') ) :

	/**
	 * Adjust content_width value for image attachment template.
	 */
	function majale_content_width() {
		if ( is_attachment() && wp_attachment_is_image() ) {
			$GLOBALS['content_width'] = 810;
		}
	}
	add_action( 'template_redirect', 'majale_content_width' );

endif; // function exists

if ( ! function_exists('majale_widgets_init') ) :

	/**
	 * Register widget areas.
	 */
	function majale_widgets_init() {
		// sidebar 1 - main content
		register_sidebar( array(
			'name'          => __( 'left Sidebar', 'majale' ),
			'id'            => 'sidebar-1',
			'description'   => __( 'Main sidebar that appears on the left.', 'majale' ),
			'before_widget' => '<aside id="%1$s" class="widget-area %2$s"><div class="widget-content">',
			'after_widget'  => '</div></aside>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		) );

		// sidebar 2 - main content
		register_sidebar( array(
			'name'          => __( 'Right Sidebar', 'majale' ),
			'id'            => 'sidebar-2',
			'description'   => __( 'Additional sidebar that appears on the right.', 'majale' ),
			'before_widget' => '<aside id="%1$s" class="widget-area %2$s"><div class="widget-content">',
			'after_widget'  => '</div></aside>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		) );

		// widget area number 1 - footer secion
		register_sidebar( array(
			'name'          => __( 'Footer first sidebar', 'majale' ),
			'id'            => 'footer-1',
			'description'   => __( 'First footer widget area from left', 'majale' ),
			'before_widget' => '<aside id="%1$s" class="widget-area %2$s"><div class="widget-content">',
			'after_widget'  => '</div></aside>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		) );

		// widget area number 2 - footer secion
		register_sidebar( array(
			'name'          => __( 'Footer second sidebar', 'majale' ),
			'id'            => 'footer-2',
			'description'   => __( 'Second footer widget area from left', 'majale' ),
			'before_widget' => '<aside id="%1$s" class="widget-area %2$s"><div class="widget-content">',
			'after_widget'  => '</div></aside>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		) );

		// widget area number 3 - footer secion
		register_sidebar( array(
			'name'          => __( 'Footer third sidebar', 'majale' ),
			'id'            => 'footer-3',
			'description'   => __( 'Third footer widget area from left', 'majale' ),
			'before_widget' => '<aside id="%1$s" class="widget-area %2$s"><div class="widget-content">',
			'after_widget'  => '</div></aside>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		) );

		// widget area number 4 - footer secion
		register_sidebar( array(
			'name'          => __( 'Footer fourth sidebar', 'majale' ),
			'id'            => 'footer-4',
			'description'   => __( 'Fourth footer widget area from left', 'majale' ),
			'before_widget' => '<aside id="%1$s" class="widget-area %2$s"><div class="widget-content">',
			'after_widget'  => '</div></aside>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		) );
	}
	add_action( 'widgets_init', 'majale_widgets_init' );

endif; // function exists

if ( ! function_exists('majale_scripts') ) :

	/**
	 * Enqueue scripts and styles for the front end.
	 */
	function majale_scripts() {

		// Add Twitter Bootstrap font, used in the main stylesheet.
		wp_enqueue_style( 'majale-bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css');

		// Add Font Awesome font, used in the main stylesheet.
		wp_enqueue_style( 'majale-font-awesome', get_template_directory_uri() . '/css/font-awesome.min.css');

		// Load our main stylesheet.
		wp_enqueue_style( 'majale-style', get_stylesheet_uri(), array( 'majale-bootstrap', 'majale-font-awesome' ) );

		// multi-level css menu stylesheet.
		wp_enqueue_style( 'majale-cssmenu-styles', get_template_directory_uri() . '/css/navigation.css');

		// hover effect
		wp_enqueue_style( 'majale-hover', get_template_directory_uri() . '/css/hover-min.css');

		// make reply to comment dynamic and prevent from refreshing on reply link click.
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}

		// Load jQuery 2.1.1
		wp_enqueue_script( 'majale-jquery', get_template_directory_uri() . '/js/jquery-2.1.1.min.js');

		// Load Bootstrap JS. It requires jQuery.
		wp_enqueue_script( 'majale-bootstrapJS', get_template_directory_uri() . '/js/bootstrap.min.js', array( 'majale-jquery' ));

		// Include textfill JS for home page, It make text fit in certain box.
		// For featured posts tiles.
		if( is_front_page() )
			wp_enqueue_script( 'majale-textfill', get_template_directory_uri() . '/js/textfill.min.js');

		// Our custom JS file used for some custom functionality 
		// and initialzing above libaray(some of them).
		wp_enqueue_script( 'majale-script', get_template_directory_uri() . '/js/functions.js', array( 'majale-jquery', 'majale-bootstrapJS' ) );
	}
	add_action( 'wp_enqueue_scripts', 'majale_scripts' );

endif; // function exists

if ( ! function_exists('majale_thumbnail') ) :

	/**
	 * we use css to make thumbail apears instead of html.
	 * in this way we can make them cover to coresspond 
	 * in every screen resolution.
	 * 
	 * @return none/thumbnail url
	 */
	function majale_thumbnail($size) {
		if( has_post_thumbnail() ) {
			GLOBAL $post;
			
			// get thumbnail url with given size.
			$url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), '$size' );

			// return it as an CSS property.
			$backgroundImage = 'background-image: url(' . $url[0] . ');';
			echo $backgroundImage;
		}
	}

endif; // function exists

if ( ! function_exists('majale_home_thumbnail') ) :

	/**
	 * home thumbnail - shown thumbnail on index/home page
	 * 
	 * @return image
	 */
	function majale_home_thumbnail() {
		// thumbnail for posts with thumbnail
		if ( has_post_thumbnail() ) {
			GLOBAL $post;

			/**
			 * It's simple feature, when user click on the title or eighter thumbnail image
			 * it will navigate the user to page/single template. then on home thumnail is 
			 * a link and on single or page template it's just an image.
			 */
			if ( is_single() OR is_page() ) :
				echo get_the_post_thumbnail( $post->ID, 'home-thumbnail' );
			else :
				echo '<a href="' . esc_url( get_permalink() ) . '" title="' . esc_attr( $post->title ) . '">' . get_the_post_thumbnail( $post->ID, 'home-thumbnail' ) . '</a>';
			endif;
		}
	}

endif; // function exists

if ( ! function_exists('majale_sticky_post_count') ) :

	/**
	 * Count sticky posts
	 * @return integer
	 */
	function majale_sticky_post_count()
	{
		$majale_sticky_pst_count;
		query_posts(
			array(
				'post__in' => get_option('sticky_posts')
				)
			);

			for($majale_sticky_post_count = 0;
				have_posts();
				$majale_sticky_post_count++)
					the_post();

		wp_reset_query();

		return $majale_sticky_post_count;
	}

endif; // function exists

if (! function_exists('majale_pagination') ) :

	/**
	 * Change Wordpress pagination defaults
	 * @param  string  $pages
	 * @param  integer $range
	 * @return pagination
	 */
	function majale_pagination($wp_query = '')
	{
		if ($wp_query == '')
			global $wp_query;

		// need an unlikely integer
		$big = 999999999;

		// main pagination section
		echo '<section class="blog-navigation text-center">';

		// wordpress pagination function
		echo paginate_links( array(
			'base' 		=> str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
			'format' 	=> '?page=%#%',
			'current' 	=> max( 1, get_query_var('paged') ),
			'total' 	=> $wp_query->max_num_pages,
			'prev_text' => '<i class="fa fa-chevron-left"></i>',
			'next_text' => '<i class="fa fa-chevron-right"></i>'
		) );

		// close pagination
		echo '</section>';
	}

endif; // function exists


if ( ! function_exists('majale_remove_admin_bar') ) :
/**
 * Manging WordPress admin bar
 */
add_action('after_setup_theme', 'majale_remove_admin_bar');

	/**
	 * show admin bar to admin only
	 * @return admin bar
	 */
	function majale_remove_admin_bar() {
		if (!current_user_can('administrator') && !is_admin()) {
			show_admin_bar(false);
		}
	}

endif; // function exists

if ( ! function_exists('majale_post_nav') ) :

	/**
	 * navigation for single page blog posts
	 * 
	 * @return HTML
	 */
	function majale_post_nav()
	{
		/**
		 * Check if one page meta data is set hidden so we also
		 * hide post navigation.
		 */
		global $post;

		$majale_one_page_meta = get_post_meta( $post->ID, 'majale_one_page_meta', true );
		if ($majale_one_page_meta == 'hide')
			return;

		/**
		 * Check if we are on the first blog post
		 * so we don't have a previous post
		 */
		if ( ! empty(get_previous_post_link()) ) : ?>
			<section class="previous-post-section padding-15 text-center">
				<p class="prev-post-text">
				<?php
				if ( is_single() ) :
					_e('Next post: ', 'majale');
				else :
					_e('Next page: ', 'majale');
				endif;
				?>
				</p>
				<?php previous_post_link('<strong>%link</strong>') ?>
			</section>
		<?php endif;

		/**
		 * Check if we are on the last blog post
		 * so we don't have a next post
		 */
		if ( ! empty(get_next_post_link()) ) : ?>
			<section class="next-post-section padding-15 text-center">
				<p class="next-post-text">
				<?php 
				if ( is_single() ) :
					_e('Previous post: ', 'majale');
				else :
					_e('Previous page: ', 'majale');
				endif;
				?>
				</p>
				<?php next_post_link('<strong>%link</strong>') ?>
			</section>
		<?php 
		endif;

	}

endif; // function exists

if ( ! function_exists('majale_attachment_navigation') ) :

	/**
	 * Get next/previous images in navigatiuon for attachment page.
	 * @return html
	 */
	function majale_attachment_navigation()
	{
		/**
		 * Check if one page meta data is set hidden so we also
		 * hide post navigation.
		 */
		global $post;

		$majale_one_page_meta = get_post_meta( $post->ID, 'majale_one_page_meta', true );
		if ($majale_one_page_meta == 'hide')
			return;

		/**
		 * Check if we are on the first blog post
		 * so we don't have a previous post
		 */
		//if ( ! empty(previous_image_link(false)) ) : ?>
			<section class="previous-post-section padding-15 text-center">
				<p class="prev-post-text">
				<?php _e('Next image: ', 'majale') ?>
				</p>
				<?php previous_image_link() ?>
			</section>
		<?php //endif;

		/**
		 * Check if we are on the last blog post
		 * so we don't have a next post
		 */
		//if ( ! empty(next_image_link(false)) ) : ?>
			<section class="next-post-section padding-15 text-center">
				<p class="next-post-text">
				<?php _e('Previous image: ', 'majale') ?>
				</p>
				<?php next_image_link() ?>
			</section>
		<?php 
		//endif;
		//echo previous_image_link( false, __( 'Previous Image', 'majale' ) );
		//echo next_image_link( false, __( 'Next Image', 'majale' ) );
	}

endif; // function exists

if ( ! function_exists('majale_get_tags') ) :

	/**
	 * get tags list.
	 * @return html
	 */
	function majale_get_tags()
	{
		// simply get tags and print them on the screen.
		echo get_the_tag_list('<h5 class="tag-title"><i class="fa fa-tags"></i> ' . __('Tags:', 'majale') . '</h5><span class="tag-list"> ',', ','</span><hr>');
	}

endif; // function exists

/**
 *
 * TODO
 */
if ( ! function_exists('majale_get_category') ) :

	/**
	 * Get categories list in our custom style
	 *
	 * @param string $seprator
	 * @return category
	 */
	function majale_get_category($separator = ', ')
	{
		// solid list of tags.
		$categories = get_the_category();
		
		// get number of items in categories array.
		$count_separator = count($categories);

		// define category title.
		$title = '<h5 class="cat-title"><i class="fa fa-folder"></i> ' . __('Categories: ', 'majale') . '</h5>';

		// start outputing actual category list.
		$output = '<span class="cat-list"> ';

		// if we have some.
		if($categories)
		{
			/**
			 * we do  all of these staff because of preventing output to 
			 * print extra seprator, all for design.
			 */
			foreach($categories as $category)
			{
				// prevent last extra separator
				$count_separator--;
				$separator = ($count_separator) ? $separator : "";

				$output .= '<a href="' . get_category_link( $category->term_id ) . '" title="' . esc_attr( sprintf( __( "View all posts in %s", "majale" ), $category->name ) ) . '">' . $category->cat_name . '</a>' . $separator;
			}
			$output .= '</span>';
			$output = $title .= $output;

			// remove spaces and print
			echo trim($output, $separator);
		}
	}

endif; // function exists

if ( ! function_exists( 'majale_comment_nav' ) ) :

	/**
	 * Display navigation to next/previous comments when applicable.
	 *
	 * @return html
	 */
	function majale_comment_nav() 
	{
		// get next/prev comment navigation links
		$next_comments_link = get_next_comments_link();
		$prev_comments_link = get_previous_comments_link();

		// on last page
		if ( empty($next_comments_link) AND ! empty($prev_comments_link) ) : ?>
			<section class="row comments-navigation padding-15 text-center">
				<?php echo $prev_comments_link ?>
			</section><!-- .comments-navigation -->
		<?php

		// on first page
		elseif ( empty($prev_comments_link) AND ! empty($next_comments_link) ) : ?>
			<section class="row comments-navigation padding-15 text-center">
				<?php echo $next_comments_link ?>
			</section><!-- .comments-navigation -->
		<?php

		// on no paginated comment
		// we also remove that <section> tag
		elseif ( empty($prev_comments_link) AND empty($next_comments_link) ) : 
			return;

		// on other page than first and last
		else : ?>
			<section class="row comments-navigation padding-15">
				<div class="col-md-6 col-sm-12 text-center">
					<?php echo $prev_comments_link ?>
				</div>

				<div class="col-md-6 col-sm-12 text-center">
					<?php echo $next_comments_link ?>
				</div>
			</section><!-- .comments-navigation -->
		<?php 
		endif;
	}

endif; // function exists

if ( ! function_exists('majale_comment_form_fields') ) :

	add_filter( 'comment_form_default_fields', 'majale_comment_form_fields' );
	/**
	 * change wordpress default author/email/url input
	 * to match our custom bootstrap style.
	 * 
	 * @param  array $fields
	 * @return html
	 */
	function majale_comment_form_fields( $fields ) {

		$commenter = wp_get_current_commenter();
		$req = get_option( 'require_name_email' );
		$aria_req = ( $req ? " aria-required='true' " : '' );
		$html5 = current_theme_supports( 'html5', 'comment-form' ) ? 1 : 0;
		$fields = array(
			'author' => '<div class="col-md-6 col-xs-12"><input class="commenter-name" name="author" type="text" dir="auto" placeholder="' . __("Your Name", "majale") . '" value="' . esc_attr( $commenter['comment_author'] ) . '" ' . $aria_req . ' ></div>',
			'email' => '<div class="col-md-6 col-xs-12"><input class="commenter-email" name="email" ' . ( $html5 ? 'type="email"' : 'type="text"' ) . $aria_req . ' placeholder="' . __( 'Email(*)', "majale" ) . '" value="' . esc_attr( $commenter['comment_author_email'] ) . '" dir="ltr"/></div>',
			'url' => '<div class="col-md-12 col-xs-12"><input class="commenter-url" name="url" ' . ( $html5 ? 'type="url"' : 'type="text"' ) . ' value="' . esc_attr( $commenter['comment_author_url'] ) . '" placeholder="' . __( "URL", "majale" ) . '" dir="ltr" /></div>',
		);

		return $fields;
	}
endif; // function exsits

if ( ! function_exists('majale_comment_form') ) :

	add_filter( 'comment_form_defaults', 'majale_comment_form' );
	/**
	 * change default wordpress comment's textarea to
	 * match our customized style. also we add new
	 * submit button instead of default one.
	 * 
	 * @param  array $args
	 * @return html textarea and submit
	 */
	function majale_comment_form( $args ) {
		$args['comment_field'] = '<div class="col-md-12 col-xs-12">
		<textarea class="commenter-text" id="comment" name="comment" rows="6" aria-required="true" placeholder="' . __( 'Your idea', "majale" ) . '"></textarea>
		</div><div class="col-md-4 col-xs-12"><button type="submit" class="commenter-send btn btn-default btn-block"><i class="fa fa-send"></i>' . __('Send', 'majale') . '</button></div>';
		return $args;
	}

endif; // function exists

if ( ! function_exists('majale_wp_title') ) :

	/**
	 * Filters the page title appropriately depending on the current page
	 *
	 * This function is attached to the 'wp_title' filter hook.
	 *
	 * @uses	get_bloginfo()
	 * @uses	is_home()
	 * @uses	is_front_page()
	 */
	function majale_wp_title( $title ) {
		global $page, $paged;

		if ( is_feed() )
			return $title;

		$site_description = get_bloginfo( 'description' );

		$filtered_title = $title . get_bloginfo( 'name' );
		$filtered_title .= ( ! empty( $site_description ) && ( is_home() || is_front_page() ) ) ? ' | ' . $site_description: '';
		$filtered_title .= ( 2 <= $paged || 2 <= $page ) ? ' | ' . sprintf( __( 'Page %s', 'majale' ), max( $paged, $page ) ) : '';

		return $filtered_title;
	}

endif; // function exists
add_filter( 'wp_title', 'majale_wp_title' );

/**
 * Show date and author of the post.
 * 
 * @return html
 */
if ( ! function_exists('majale_date_author') ) :

	function majale_date_author()
	{
		global $majale;
		global $post;

		// if it set to hide meta data of the page
		if (get_post_meta( $post->ID, 'majale_one_page_meta', true ) == 'hide')
			return;
		
		// read option an make date according to the option
		if ( isset($majale['time_format']) ) :
			if ( $majale['time_format'] == 1 ) :
				$majale_date = "";
			elseif ( $majale['time_format'] == 2 ) :
				$majale_date = get_the_date( get_option('date_format') );
			else :
				$majale_date = Majale::human_time_diff();
			endif;
		endif;

		// if the date is disable make the time permalink
		if ( empty($majale_date) ) : ?>
			<a rel="bookmark" href="<?php echo esc_url( get_permalink() ); ?>">
				<span class="date padding-15"><i class="fa fa-link"></i> <?php _e('Permalink', 'majale') ?></span>
			</a>
		<?php else : ?>
			<a rel="bookmark" href="<?php echo esc_url( get_permalink() ); ?>">
				<span class="date padding-15"><i class="fa fa-clock-o"></i> <?php echo $majale_date ?></span>
			</a>
		<?php endif ?>

		<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>">
			<span class="author padding-15"><i class="fa fa-user"></i> <?php _e('By', 'majale') ?> <?php echo get_the_author() ?></span>
		</a>
		<?php
	}

endif; // function_exists

/**
 * Add custom field to page editing section
 */
if ( ! function_exists('majale_add_custom_box') ) :

	add_action( 'add_meta_boxes', 'majale_add_custom_box' );
	function majale_add_custom_box() {
	    $screens = array( 'post', 'page' );

	    foreach ( $screens as $screen ) {
	        add_meta_box(
	            'majale_one_page_style',      					// Unique ID
	            __('This page only style', 'majale'),      // Box title
	            'majale_inner_custom_box',  					// Content callback
	             $screen                      					// post type
	        );

	        add_meta_box(
	            'majale_one_page_meta',            			// Unique ID
	            __('This page only meta', 'majale'),      		// Box title
	            'majale_inner_custom_box_meta',  					// Content callback
	            $screen                      					// post type
	        );
	    }

	}

endif; // function_exists

/**
 * meta box callback
 */
if ( ! function_exists('majale_meta_box_callback') ) :

	function majale_meta_box_callback( $post ) {
	    $majale_screens = array( 'page' );
	    foreach ( $majale_screens as $screen ) :
	        add_meta_box(
	            'majale_one_page_style',            			// Unique ID
	            __('This page only style', 'majale'),      		// Box title
	            'majale_inner_custom_box',  					// Content callback
	            $screen                      					// post type
	        );

	    	add_meta_box(
	            'majale_one_page_meta',            				// Unique ID
	            __('This page only meta', 'majale'),      		// Box title
	            'majale_inner_custom_box_meta',  				// Content callback
	            $screen                      					// post type
	        );
	    endforeach;
	}

endif; // function_exists

/**
 * Print select options
 */
if ( ! function_exists('majale_inner_custom_box') ) :

	function majale_inner_custom_box( $post ) {
		$majale_value = get_post_meta( $post->ID, 'majale_one_page_style', true );
	?>
	    <select name="majale_field" id="majale_field" class="postbox">
	    	<option value="default" <?php if ( 'default' == $majale_value ) echo 'selected'; ?>><?php _e('Default', 'majale') ?></option>
	        <option value="one-c" <?php if ( 'one-c' == $majale_value ) echo 'selected'; ?>><?php _e('One column', 'majale') ?></option>
	        <option value="two-c-r" <?php if ( 'one-c-r' == $majale_value ) echo 'selected'; ?>><?php _e('Two columns - right sidebar', 'majale') ?></option>
	        <option value="two-c-l" <?php if ( 'one-c-l' == $majale_value ) echo 'selected'; ?>><?php _e('Two columns - left sidebar', 'majale') ?></option>
	        <option value="three-c-m" <?php if ( 'three-c-m' == $majale_value ) echo 'selected'; ?>><?php _e('Three columns - Main content in middle', 'majale') ?></option>
	        <option value="three-c-r" <?php if ( 'three-c-r' == $majale_value ) echo 'selected'; ?>><?php _e('Three columns - Main content in right', 'majale') ?></option>
	        <option value="three-c-l" <?php if ( 'three-c-l' == $majale_value ) echo 'selected'; ?>><?php _e('Three columns - Main content in left', 'majale') ?></option>
	    </select>
	<?php
	}

endif; // function_exists

/**
 * Print select options
 */
if ( ! function_exists('majale_inner_custom_box_meta') ) :

	function majale_inner_custom_box_meta( $post ) {
		$majale_value = get_post_meta( $post->ID, 'majale_one_page_meta', true );
	?>
		<input value="show" id="majale_meta_show" type="radio" name="majale_meta" <?php if ( 'show' == $majale_value ) echo 'checked="checked"'; ?>> 
		<label for="majale_meta_show"><?php _e('Show', 'majale') ?></label>
		<br />
		<input value="hide" id="majale_meta_hide" type="radio" name="majale_meta" <?php if ( 'hide' == $majale_value ) echo 'checked="checked"'; ?>>
		<label for="majale_meta_hide"><?php _e('Hide', 'majale') ?></label>
	<?php
	}

endif; // function_exists

/**
 * save page meta values
 */
if ( ! function_exists('majale_save_postdata') ) :

	add_action( 'save_post', 'majale_save_postdata' );
	function majale_save_postdata( $post_id ) {
	    if ( array_key_exists('majale_field', $_POST ) ) {
	        update_post_meta( $post_id,
	           'majale_one_page_style',
	            $_POST['majale_field']
	        );
	    }

	    if ( array_key_exists('majale_meta', $_POST ) ) {
	        update_post_meta( $post_id,
	           'majale_one_page_meta',
	            $_POST['majale_meta']
	        );
	    }
	}

endif; // function_exists

if ( ! function_exists('majale_primary_navigation') ) :

	function majale_primary_navigation() {
		if ( function_exists('max_mega_menu_is_enabled') && max_mega_menu_is_enabled('primary') ) : ?>
			<div class="main-navigation-container">
				<nav class="main-navigation max-width center-block">
					<?php wp_nav_menu( array( 'theme_location' => 'primary') ); ?>
				</nav>
			</div>

		<?php else: ?>
			<div class="main-navigation-container">
				<nav class="main-navigation">
					<?php 
						$majale_menu = wp_nav_menu(array(
							'menu' => 'Main Navigation', 
							'container_id' => 'cssmenu',
							'theme_location' => 'primary',
							'walker' => new CSS_Menu_Maker_Walker(),
							'echo' => FALSE,
							'fallback_cb' => '__return_false'
						));

						if ( empty( $majele_menu ) )
							echo $majale_menu;
					?>
				</nav><!-- .main-navigation -->
			<nav class="mobile-navigation">
		<?php

			$majale_menu = wp_nav_menu(array(
				'menu' => 'Main Navigation', 

				'theme_location' => 'primary',
				'echo' => FALSE,
				'fallback_cb' => '__return_false'
			));

			if ( empty ( $majele_menu ) )
				echo $majale_menu;
			?>
			</nav><!-- .mobile-navigation -->
		</div>
		<?php endif;
	}

endif; // function_exists

add_action( 'tgmpa_register', 'majale_register_required_plugins' );
/**
 * Register the required plugins for this theme.
 *
 * This function is hooked into tgmpa_init, which is fired within the
 * TGM_Plugin_Activation class constructor.
 */
function majale_register_required_plugins() {
	/*
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	$plugins = array(

		// include a plugin from the WordPress Plugin Repository.
		array(
			'name'      => 'Redux Framework',
			'slug'      => 'redux-framework',
			'required'  => true,
		),

		array(
			'name'      => 'WooCommerce - excelling eCommerce',
			'slug'      => 'woocommerce',
			'required'  => false,
		),

		array(
			'name'      => 'Redux Developer Mode Disabler',
			'slug'      => 'redux-developer-mode-disabler',
			'required'  => true,
		),

		array(
			'name'      => 'Contact Form 7',
			'slug'      => 'contact-form-7',
			'required'  => false,
		)
	);

	/*
	 * Array of configuration settings. Amend each line as needed.
	 *
	 * TGMPA will start providing localized text strings soon. If you already have translations of our standard
	 * strings available, please help us make TGMPA even better by giving us access to these translations or by
	 * sending in a pull-request with .po file(s) with the translations.
	 *
	 * Only uncomment the strings in the config array if you want to customize the strings.
	 */
	$config = array(
		'id'           => 'majale_tgmpa',          // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      // Default absolute path to bundled plugins.
		'menu'         => 'tgmpa-install-plugins', // Menu slug.
		'parent_slug'  => 'themes.php',            // Parent menu slug.
		'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => false,                   // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.

		'strings'      => array(
			'page_title'                      => __( 'Install Required Plugins', 'majale' ),
			'menu_title'                      => __( 'Install Plugins', 'majale' ),
			'installing'                      => __( 'Installing Plugin: %s', 'majale' ), // %s = plugin name.
			'oops'                            => __( 'Something went wrong with the plugin API.', 'majale' ),
			'notice_can_install_required'     => _n_noop(
				'This theme requires the following plugin: %1$s.',
				'This theme requires the following plugins: %1$s.',
				'majale'
			), // %1$s = plugin name(s).
			'notice_can_install_recommended'  => _n_noop(
				'This theme recommends the following plugin: %1$s.',
				'This theme recommends the following plugins: %1$s.',
				'majale'
			), // %1$s = plugin name(s).
			'notice_cannot_install'           => _n_noop(
				'Sorry, but you do not have the correct permissions to install the %1$s plugin.',
				'Sorry, but you do not have the correct permissions to install the %1$s plugins.',
				'majale'
			), // %1$s = plugin name(s).
			'notice_ask_to_update'            => _n_noop(
				'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.',
				'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.',
				'majale'
			), // %1$s = plugin name(s).
			'notice_ask_to_update_maybe'      => _n_noop(
				'There is an update available for: %1$s.',
				'There are updates available for the following plugins: %1$s.',
				'majale'
			), // %1$s = plugin name(s).
			'notice_cannot_update'            => _n_noop(
				'Sorry, but you do not have the correct permissions to update the %1$s plugin.',
				'Sorry, but you do not have the correct permissions to update the %1$s plugins.',
				'majale'
			), // %1$s = plugin name(s).
			'notice_can_activate_required'    => _n_noop(
				'The following required plugin is currently inactive: %1$s.',
				'The following required plugins are currently inactive: %1$s.',
				'majale'
			), // %1$s = plugin name(s).
			'notice_can_activate_recommended' => _n_noop(
				'The following recommended plugin is currently inactive: %1$s.',
				'The following recommended plugins are currently inactive: %1$s.',
				'majale'
			), // %1$s = plugin name(s).
			'notice_cannot_activate'          => _n_noop(
				'Sorry, but you do not have the correct permissions to activate the %1$s plugin.',
				'Sorry, but you do not have the correct permissions to activate the %1$s plugins.',
				'majale'
			), // %1$s = plugin name(s).
			'install_link'                    => _n_noop(
				'Begin installing plugin',
				'Begin installing plugins',
				'majale'
			),
			'update_link' 					  => _n_noop(
				'Begin updating plugin',
				'Begin updating plugins',
				'majale'
			),
			'activate_link'                   => _n_noop(
				'Begin activating plugin',
				'Begin activating plugins',
				'majale'
			),
			'return'                          => __( 'Return to Required Plugins Installer', 'majale' ),
			'plugin_activated'                => __( 'Plugin activated successfully.', 'majale' ),
			'activated_successfully'          => __( 'The following plugin was activated successfully:', 'majale' ),
			'plugin_already_active'           => __( 'No action taken. Plugin %1$s was already active.', 'majale' ),  // %1$s = plugin name(s).
			'plugin_needs_higher_version'     => __( 'Plugin not activated. A higher version of %s is needed for this theme. Please update the plugin.', 'majale' ),  // %1$s = plugin name(s).
			'complete'                        => __( 'All plugins installed and activated successfully. %1$s', 'majale' ), // %s = dashboard link.
			'contact_admin'                   => __( 'Please contact the administrator of this site for help.', 'majale' ),

			'nag_type'                        => 'updated', // Determines admin notice type - can only be 'updated', 'update-nag' or 'error'.
		),
	);

	tgmpa( $plugins, $config );
}