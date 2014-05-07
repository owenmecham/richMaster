<?php

/***** Fetch Options *****/

$options = get_option('mh_options');

/***** Custom Hooks *****/

function mh_html_class() {
    do_action('mh_html_class');
}
function mh_html_tag() {
    do_action('mh_html_tag');
}
function mh_body_id() {
    do_action('mh_body_id');
}
function mh_container_class() {
    do_action('mh_container_class');
}
function mh_before_header() {
    do_action('mh_before_header');
}
function mh_after_header() {
    do_action('mh_after_header');
}
function mh_content_class() {
    do_action('mh_content_class');
}
function mh_before_page_content() {
    do_action('mh_before_page_content');
}
function mh_before_post_content() {
    do_action('mh_before_post_content');
}
function mh_post_header() {
    do_action('mh_post_header');
}
function mh_post_content() {
    do_action('mh_post_content');
}
function mh_loop_content() {
    do_action('mh_loop_content');
}
function mh_after_post_content() {
    do_action('mh_after_post_content');
}
function mh_sb_class() {
    do_action('mh_sb_class');
}

/***** Enable Shortcodes inside Widgets	*****/

add_filter('widget_text', 'do_shortcode');

/***** Theme Setup *****/

function mh_themes_setup() {

	global $content_width, $options;

	if (!isset($content_width)) {
		if (isset($options['site_width']) && $options['site_width'] == 'large' && isset($options['sidebars']) && $options['sidebars'] != 'two' || isset($options['sidebars']) && $options['sidebars'] == 'no') {
			$content_width = 940;
		} else {
			$content_width = 620;
		}
	}

	$header = array(
		'default-image'	=> get_template_directory_uri() . '/images/logo.png',
		'default-text-color' => '000',
		'width' => 300,
		'height' => 100,
		'flex-width' => true,
		'flex-height' => true
	);
	add_theme_support('custom-header', $header);

	load_theme_textdomain('mh', get_template_directory() . '/languages');

	add_theme_support('automatic-feed-links');
	add_theme_support('custom-background');
	add_theme_support('post-thumbnails');

	add_image_size('slider', 940, 400, true);
	add_image_size('content', 620, 264, true);
	add_image_size('spotlight', 580, 326, true);
	add_image_size('loop', 174, 131, true);
	add_image_size('carousel', 174, 98, true);
	add_image_size('cp_large', 300, 225, true);
	add_image_size('cp_small', 70, 53, true);

	add_editor_style();

	register_nav_menus(array(
		'header_nav' => __('Header Navigation', 'mh'),
		'main_nav' => __('Main Navigation', 'mh'),
		'info_nav' => __('Additional Navigation (below Main Navigation)', 'mh'),
		'footer_nav' => __('Footer Navigation', 'mh')
	));
}
add_action('after_setup_theme', 'mh_themes_setup');

/***** Load CSS & JavaScript *****/

if (!function_exists('mh_scripts')) {
	function mh_scripts() {
		wp_enqueue_style('mh-style', get_stylesheet_uri(), false, '2.0.2');
		wp_enqueue_script('jquery migrate', 'http://code.jquery.com/jquery-migrate-1.2.1.min.js');
		wp_enqueue_script('scripts', get_template_directory_uri() . '/js/scripts.js', array('jquery'));
		if (!is_admin()) {
			if (is_singular() && comments_open() && (get_option('thread_comments') == 1))
				wp_enqueue_script('comment-reply');
		}
	}
}
add_action('wp_enqueue_scripts', 'mh_scripts');

if (!function_exists('mh_admin_scripts')) {
	function mh_admin_scripts() {
		wp_enqueue_style('mh-admin', get_template_directory_uri() . '/admin/admin.css');
	}
}
add_action('admin_enqueue_scripts', 'mh_admin_scripts');

/***** Register Widget Areas / Sidebars	*****/

if (!function_exists('mh_widgets_init')) {
	function mh_widgets_init() {
		global $options;
		isset($options['sidebars']) && $options['sidebars'] == 'two' ? $two_sidebars = true : $two_sidebars = false;
		isset($options['site_width']) && $options['site_width'] == 'large' || isset($options['sidebars']) && $options['sidebars'] == 'two' ? $large_site = true : $large_site = false;
		register_sidebar(array('name' => __('Header', 'mh'), 'id' => 'header', 'description' => __('Widget area on top of the site', 'mh'), 'before_widget' => '<div class="sb-widget">', 'after_widget' => '</div>', 'before_title' => '<h4 class="widget-title">', 'after_title' => '</h4>'));
		register_sidebar(array('name' => __('Sidebar', 'mh'), 'id' => 'sidebar', 'description' => __('Widget area (sidebar left/right) on single posts, pages and archives', 'mh'), 'before_widget' => '<div class="sb-widget">', 'after_widget' => '</div>', 'before_title' => '<h4 class="widget-title">', 'after_title' => '</h4>'));
		if ($two_sidebars) {
			register_sidebar(array('name' => __('Sidebar 2', 'mh'), 'id' => 'sidebar-2', 'description' => __('Second sidebar on single posts, pages and archives', 'mh'), 'before_widget' => '<div class="sb-widget">', 'after_widget' => '</div>', 'before_title' => '<h4 class="widget-title">', 'after_title' => '</h4>'));
		}
		register_sidebar(array('name' => __('Home 1', 'mh'), 'id' => 'home-1', 'description' => __('Widget area on homepage', 'mh'), 'before_widget' => '<div class="sb-widget home-1 home-wide">', 'after_widget' => '</div>', 'before_title' => '<h4 class="widget-title">', 'after_title' => '</h4>'));
		register_sidebar(array('name' => __('Home 2', 'mh'), 'id' => 'home-2', 'description' => __('Widget area on homepage', 'mh'), 'before_widget' => '<div class="sb-widget home-2 home-wide">', 'after_widget' => '</div>', 'before_title' => '<h4 class="widget-title">', 'after_title' => '</h4>'));
		register_sidebar(array('name' => __('Home 3', 'mh'), 'id' => 'home-3', 'description' => __('Widget area on homepage', 'mh'), 'before_widget' => '<div class="sb-widget home-3">', 'after_widget' => '</div>', 'before_title' => '<h4 class="widget-title">', 'after_title' => '</h4>'));
		register_sidebar(array('name' => __('Home 4', 'mh'), 'id' => 'home-4', 'description' => __('Widget area on homepage', 'mh'), 'before_widget' => '<div class="sb-widget home-4">', 'after_widget' => '</div>', 'before_title' => '<h4 class="widget-title">', 'after_title' => '</h4>'));
		register_sidebar(array('name' => __('Home 5', 'mh'), 'id' => 'home-5', 'description' => __('Widget area on homepage', 'mh'), 'before_widget' => '<div class="sb-widget home-5 home-wide">', 'after_widget' => '</div>', 'before_title' => '<h4 class="widget-title">', 'after_title' => '</h4>'));
		register_sidebar(array('name' => __('Home 6', 'mh'), 'id' => 'home-6', 'description' => __('Widget area on homepage', 'mh'), 'before_widget' => '<div class="sb-widget home-6 home-wide-2">', 'after_widget' => '</div>', 'before_title' => '<h4 class="widget-title">', 'after_title' => '</h4>'));
		register_sidebar(array('name' => __('Home 7', 'mh'), 'id' => 'home-7', 'description' => __('Widget area on homepage', 'mh'), 'before_widget' => '<div class="sb-widget home-7 home-wide">', 'after_widget' => '</div>', 'before_title' => '<h4 class="widget-title">', 'after_title' => '</h4>'));
		register_sidebar(array('name' => __('Home 8', 'mh'), 'id' => 'home-8', 'description' => __('Widget area on homepage', 'mh'), 'before_widget' => '<div class="sb-widget home-8">', 'after_widget' => '</div>', 'before_title' => '<h4 class="widget-title">', 'after_title' => '</h4>'));
		register_sidebar(array('name' => __('Home 9', 'mh'), 'id' => 'home-9', 'description' => __('Widget area on homepage', 'mh'), 'before_widget' => '<div class="sb-widget home-9">', 'after_widget' => '</div>', 'before_title' => '<h4 class="widget-title">', 'after_title' => '</h4>'));
		register_sidebar(array('name' => __('Home 10', 'mh'), 'id' => 'home-10', 'description' => __('Widget area on homepage', 'mh'), 'before_widget' => '<div class="sb-widget home-10 home-wide-2">', 'after_widget' => '</div>', 'before_title' => '<h4 class="widget-title">', 'after_title' => '</h4>'));
		register_sidebar(array('name' => __('Home 11', 'mh'), 'id' => 'home-11', 'description' => __('Widget area on homepage', 'mh'), 'before_widget' => '<div class="sb-widget home-11 home-wide">', 'after_widget' => '</div>', 'before_title' => '<h4 class="widget-title">', 'after_title' => '</h4>'));
		if ($large_site) {
			register_sidebar(array('name' => __('Home 12', 'mh'), 'id' => 'home-12', 'description' => __('Sidebar on homepage', 'mh'), 'before_widget' => '<div class="sb-widget home-12">', 'after_widget' => '</div>', 'before_title' => '<h4 class="widget-title">', 'after_title' => '</h4>'));
		}
		register_sidebar(array('name' => __('Posts 1', 'mh'), 'id' => 'posts-1', 'description' => __('Widget area above single post content', 'mh'), 'before_widget' => '<div class="sb-widget posts-1">', 'after_widget' => '</div>', 'before_title' => '<h4 class="widget-title">', 'after_title' => '</h4>'));
		register_sidebar(array('name' => __('Posts 2', 'mh'), 'id' => 'posts-2', 'description' => __('Widget area below single post content', 'mh'), 'before_widget' => '<div class="sb-widget posts-2">', 'after_widget' => '</div>', 'before_title' => '<h4 class="widget-title">', 'after_title' => '</h4>'));
		register_sidebar(array('name' => __('Pages 1', 'mh'), 'id' => 'pages-1', 'description' => __('Widget area above single page content', 'mh'), 'before_widget' => '<div class="sb-widget pages-1">', 'after_widget' => '</div>', 'before_title' => '<h4 class="widget-title">', 'after_title' => '</h4>'));
		register_sidebar(array('name' => __('Pages 2', 'mh'), 'id' => 'pages-2', 'description' => __('Widget area below single page content', 'mh'), 'before_widget' => '<div class="sb-widget pages-2">', 'after_widget' => '</div>', 'before_title' => '<h4 class="widget-title">', 'after_title' => '</h4>'));
		register_sidebar(array('name' => __('Footer 1', 'mh'), 'id' => 'footer-1', 'description' => __('Widget area in footer', 'mh'), 'before_widget' => '<div class="footer-widget footer-1">', 'after_widget' => '</div>', 'before_title' => '<h6 class="footer-widget-title">', 'after_title' => '</h6>'));
		register_sidebar(array('name' => __('Footer 2', 'mh'), 'id' => 'footer-2', 'description' => __('Widget area in footer', 'mh'), 'before_widget' => '<div class="footer-widget footer-2">', 'after_widget' => '</div>', 'before_title' => '<h6 class="footer-widget-title">', 'after_title' => '</h6>'));
		register_sidebar(array('name' => __('Footer 3', 'mh'), 'id' => 'footer-3', 'description' => __('Widget area in footer', 'mh'), 'before_widget' => '<div class="footer-widget footer-3">', 'after_widget' => '</div>', 'before_title' => '<h6 class="footer-widget-title">', 'after_title' => '</h6>'));
		register_sidebar(array('name' => __('Footer 4', 'mh'), 'id' => 'footer-4', 'description' => __('Widget area in footer', 'mh'), 'before_widget' => '<div class="footer-widget footer-4">', 'after_widget' => '</div>', 'before_title' => '<h6 class="footer-widget-title">', 'after_title' => '</h6>'));
		register_sidebar(array('name' => __('Contact', 'mh'), 'id' => 'contact', 'description' => __('Widget area (sidebar) on contact page template', 'mh'), 'before_widget' => '<div class="sb-widget contact">', 'after_widget' => '</div>', 'before_title' => '<h4 class="widget-title">', 'after_title' => '</h4>'));
		if ($two_sidebars) {
			register_sidebar(array('name' => __('Contact 2', 'mh'), 'id' => 'contact-2', 'description' => __('2nd widget area (sidebar) on contact page template', 'mh'), 'before_widget' => '<div class="sb-widget">', 'after_widget' => '</div>', 'before_title' => '<h4 class="widget-title">', 'after_title' => '</h4>'));
		}
	}
}
add_action('widgets_init', 'mh_widgets_init');

/***** Include Several Functions *****/

include_once(ABSPATH . 'wp-admin/includes/plugin.php');

if (is_admin()) {
	require_once('admin/admin.php');
}

require_once('includes/mh-head.php');
require_once('includes/mh-breadcrumb.php');
require_once('includes/mh-content.php');
require_once('includes/mh-options.php');
require_once('includes/mh-widgets.php');
require_once('includes/mh-custom-functions.php');
require_once('includes/mh-shortcodes.php');

if (is_plugin_active('woocommerce/woocommerce.php')) {
	add_theme_support('woocommerce');
	require_once('woocommerce/mh-custom-woocommerce.php');
	function mh_woocommerce_sb_init() {
		register_sidebar(array('name' => __('WooCommerce', 'mh'), 'id' => 'woocommerce', 'description' => __('Widget area (sidebar) on WooCommerce pages', 'mh'), 'before_widget' => '<div class="sb-widget sb-woocommerce">', 'after_widget' => '</div>', 'before_title' => '<h4 class="widget-title">', 'after_title' => '</h4>'));
	}
	add_action('widgets_init', 'mh_woocommerce_sb_init');
}

?>