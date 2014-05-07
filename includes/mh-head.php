<?php

/***** Add CSS classes to HTML tag *****/

if (!function_exists('mh_html')) {
	function mh_html() {
		global $options;
		isset($options['site_width']) && $options['site_width'] == 'large' || isset($options['sidebars']) && $options['sidebars'] == 'two' ? $site_width = ' mh-large' : $site_width = ' mh-normal';
		isset($options['sidebars']) && $options['sidebars'] ? $sidebars = $options['sidebars'] : $sidebars = 'one';
		isset($options['wt_layout']) ? $widget_titles = $options['wt_layout'] : $widget_titles = 'layout1';
		isset($options['full_bg']) && $options['full_bg'] == 1 ? $fullbg = ' fullbg' : $fullbg = '';
		echo $site_width . ' mh-' . $sidebars . '-sb' . ' wt-' . $widget_titles . $fullbg;
	}
}
add_action('mh_html_class', 'mh_html');


/***** Load Google Webfonts *****/

if (!function_exists('mh_google_webfonts')) {
	function mh_google_webfonts() {
		global $options;
		$font_body = isset($options['font_body']) ? $options['font_body'] : 'open_sans';
		$font_heading = isset($options['font_heading']) ? $options['font_heading'] : 'open_sans';
		$font_location = array('armata' => 'Armata', 'arvo' => 'Arvo', 'asap' => 'Asap', 'bree_serif' => 'Bree+Serif', 'droid_sans' => 'Droid+Sans', 'droid_sans_mono' => 'Droid+Sans+Mono', 'droid_serif' => 'Droid+Serif', 'lato' => 'Lato', 'lora' => 'Lora', 'merriweather' => 'Merriweather', 'merriweather_sans' => 'Merriweather+Sans', 'monda' => 'Monda', 'nobile' => 'Nobile', 'noto_sans' => 'Noto+Sans', 'noto_serif' => 'Noto+Serif', 'open_sans' => 'Open+Sans', 'oswald' => 'Oswald', 'pt_sans' => 'PT+Sans', 'pt_serif' => 'PT+Serif', 'raleway' => 'Raleway', 'roboto_condensed' => 'Roboto+Condensed', 'ubuntu' => 'Ubuntu', 'yanone_kaffeesatz' => 'Yanone+Kaffeesatz');
		echo '<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=' . $font_location[$font_body]; if ($font_location[$font_heading] != $font_location[$font_body]) { echo '|' . $font_location[$font_heading]; } echo '">' . "\n";
	}
}
add_action('wp_head', 'mh_google_webfonts', 1);


/***** Add Favicon and other stuff *****/

if (!function_exists('mh_head_misc')) {
	function mh_head_misc() {
		global $options;
		if (isset($options['mh_favicon']) && $options['mh_favicon']) {
			echo '<link rel="shortcut icon" href="' . esc_url($options['mh_favicon']) . '">' . "\n";
		}
		if (isset($options['layout']) && $options['layout'] == 'responsive' || !isset($options['layout'])) {
			echo '<!--[if lt IE 9]>' . "\n";
			echo '<script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>' . "\n";
			echo '<![endif]-->' . "\n";
			echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">' . "\n";
		}
		echo '<link rel="pingback" href="' . get_bloginfo('pingback_url') . '"/>' . "\n";
	}
}
add_action('wp_head', 'mh_head_misc', 1);

/***** Enable / Disable Responsive Layout *****/

if (!function_exists('mh_responsive')) {
	function mh_responsive() {
		global $options;
		isset($options['layout']) && $options['layout'] == 'responsive' ? $mh_layout = 'mh-mobile' : $mh_layout = 'fixed-layout';
		echo $mh_layout;
	}
}
add_action('mh_body_id', 'mh_responsive');
add_action('mh_container_class', 'mh_responsive');

?>