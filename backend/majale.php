<?php
/**
* implementaion of basic tasks we use frequency
*/
class Majale extends majale_redux_customize
{
	// Redux global variable
	private $majale;

	public function __construct()
	{
		// set global redux variable
		global $majale;
		$this->majale = $majale;
	}

	public static function human_time_diff()
	{
		return human_time_diff( get_the_time('U'), current_time('timestamp') ) . __(" ago", "majale");
	}

	/**
	 * return feature posts on specefic pages.
	 * @return bool
	 */
	public static function show_feature_posts()
	{
		return majale_redux_customize::show_feature_posts_on();
	}

	/**
	 * Generate bootstrap grid system number based on the blog layout settings.
	 * @return string
	 */
	public static function grid_number()
	{
		return majale_redux_customize::one_page_style();
	}

	/**
	 * Generate bootstrap grid system number based on the shop layout settings.
	 * @return string
	 */
	public static function shop_grid_number()
	{
		return majale_redux_customize::shop_layout();
	}

	/**
	 * Generate bootstrap grid system number based on the shop single product layout settings.
	 * @return string
	 */
	public static function shop_single_grid_number()
	{
		return majale_redux_customize::shop_single_layout();
	}

	public static function shop_prooducts_per_row() {
		return majale_redux_customize::products_per_row();
	}

	public static function show_footer_text()
	{
		echo majale_redux_customize::footer_info_text();
	}
	
}