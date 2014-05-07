<!DOCTYPE html>
<html class="no-js<?php mh_html_class(); ?>" <?php language_attributes(); mh_html_tag(); ?>>
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<title><?php wp_title('|', true, 'right'); ?></title>
<?php wp_head(); ?>
</head>
<body id="<?php mh_body_id(); ?>" <?php body_class(); ?>> 
<?php if (is_active_sidebar('header')) { ?>
<aside class="header-widget">
	<?php dynamic_sidebar('header'); ?>
</aside>
<?php } ?>
<div class="container <?php mh_container_class(); ?>">
<?php mh_before_header(); ?>
<header class="header-wrap">
	<?php if (has_nav_menu('header_nav')) { ?>
	<nav class="header-nav clearfix">
		<?php wp_nav_menu(array('theme_location' => 'header_nav', 'fallback_cb' => '')); ?>
	</nav>
	<?php } ?>
	<?php mh_logo(); ?>
	<nav class="main-nav clearfix">
		<?php wp_nav_menu(array('theme_location' => 'main_nav')); ?>
	</nav>
	<?php if (has_nav_menu('info_nav')) { ?>
	<nav class="info-nav clearfix">
		<?php wp_nav_menu(array('theme_location' => 'info_nav', 'fallback_cb' => '')); ?>
	</nav>
	<?php } ?>
</header>
<?php mh_after_header(); ?>