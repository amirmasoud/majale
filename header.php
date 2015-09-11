<?php
/**
 * The Header for our theme
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 */
?><!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) & !(IE 8)]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width">
  <title><?php wp_title('|', true, 'right'); ?></title>
  <link rel="profile" href="http://gmpg.org/xfn/11">
  <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

  <!--[if lt IE 9]>
  <script src="<?php echo get_template_directory_uri(); ?>/js/html5.js"></script>
  <![endif]-->
  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<!-- go to top -->
<a href="#" id="goTop"><i class="fa fa-fw fa-chevron-up"></i></a>
<div class="mobile-menu open-menu"><i class="fa fa-bars fa-fw"></i></div>
<div class="mobile-search open-searchform"><i class="fa fa-search fa-fw"></i></div>
<div class="search-form">
  <?php get_search_form() ?>
</div><!-- .search-form -->
<header class="logo row">
  <div class="container-fluid max-width">
    <div class="col-xs-12 logo">
      <a class="home-link" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
          <?php do_action('majale_logo') ?>
      </a>
      <h4 class="site-description text-overflow"><?php bloginfo( 'description' ); ?></h4>
    </div>
    <div class="search-icon open-searchform"><i class="fa fa-fw fa-search"></i></div>
  </div><!-- .container-fluid .max-width -->
</header><!-- .logo-search .row -->
<?php 
/**
 * get navigation menu - Default one or max menu if enabled.
 */
majale_primary_navigation();

/**
 * Get features posts template part.
 */
get_template_part('content', 'featured-post') ?>