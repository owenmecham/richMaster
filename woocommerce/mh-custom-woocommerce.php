<?php

/***** Custom WooCommerce Markup *****/

remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar', 10);

function mh_themes_wrapper_start() { ?>
	<div class="wrapper clearfix">
		<div class="main">
			<div class="content entry <?php mh_content_class(); ?>"> <?php
}
remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
add_action('woocommerce_before_main_content', 'mh_themes_wrapper_start', 10);

function mh_themes_wrapper_end() { ?>
			</div>
			<?php global $options; ?>
			<?php if (isset($options['sidebars']) ? $options['sidebars'] != 'no' : true) : ?>
			<aside class="sidebar <?php mh_sb_class(); ?>">
	  			<?php dynamic_sidebar('woocommerce'); ?>
	  		</aside>
	  		<?php endif; ?>
	  	</div>
	  	<?php mh_second_sb(); ?>
  	</div> <?php
}
remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);
add_action('woocommerce_after_main_content', 'mh_themes_wrapper_end', 10);

/***** Disable WooCommerce CSS *****/

define('WOOCOMMERCE_USE_CSS', false);

/***** Load Custom WooCommerce CSS *****/

function mh_woocommerce_css() {
    wp_register_style('mh-woocommerce', get_template_directory_uri() . '/woocommerce/woocommerce.css');
    wp_enqueue_style('mh-woocommerce');
}
add_action('wp_enqueue_scripts', 'mh_woocommerce_css');

?>