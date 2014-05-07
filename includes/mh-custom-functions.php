<?php

/***** wp_title Output *****/

if (!function_exists('mh_wp_title')) {
	function mh_wp_title($title, $sep) {
		global $paged, $page, $post, $options;
		if (is_feed())
			return $title;
		$title .= get_bloginfo('name');
		$site_description = get_bloginfo('description', 'display');
		if ($site_description && (is_home() || is_front_page()))
			$title = "$title $sep $site_description";
		if ($paged >= 2 || $page >= 2)
			$title = "$title $sep " . sprintf(__('Page %s', 'mh'), max($paged, $page));
		return $title;
	}
}
add_filter('wp_title', 'mh_wp_title', 10, 2);

/***** Page Title Output *****/

if (!function_exists('mh_page_title_output')) {
	function mh_page_title_output() {
		global $options;
		$layout = isset($options['page_title_layout']) ? $options['page_title_layout'] : 'layout1';
		if (!is_front_page()) {
			if ($options['page_title_layout'] == 'layout1') {
				echo '<div class="page-title-top"></div>' . "\n";
			}
			echo '<h1 class="page-title page-title-' . $options['page_title_layout'] . '">';
			mh_page_title();
			echo '</h1>';
		}
	}
}
add_action('mh_before_page_content', 'mh_page_title_output');

if (!function_exists('mh_page_title')) {
	function mh_page_title() {
		if (is_home()) {
			echo get_the_title(get_option('page_for_posts', true));
		} elseif (is_author()) {
			global $author;
			$user_info = get_userdata($author);
			echo __('Articles by ', 'mh') . esc_attr($user_info->display_name);
		} elseif (is_category() || is_tax()) {
			echo single_cat_title("", false);
		} elseif (is_tag()) {
			echo single_tag_title("", false);
		} elseif (is_search()) {
			echo __('Search Results for ', 'mh') . get_search_query();
		} elseif (is_day()) {
			echo get_the_date();
		} elseif (is_month()) {
			echo get_the_date('F Y');
		} elseif (is_year()) {
			echo get_the_date('Y');
		} elseif (is_404()) {
			echo __('Page not found (404)', 'mh');
		} else {
			echo get_the_title();
		}
	}
}

/***** Logo / Header Image Fallback *****/

if (!function_exists('mh_logo')) {
	function mh_logo() {
		$header_img = get_header_image();
		$header_title = get_bloginfo('name');
		$header_desc = get_bloginfo('description');
		echo '<a href="' . esc_url(home_url('/')) . '" title="' . esc_attr($header_title) . '" rel="home">' . "\n";
		echo '<div class="logo-wrap" role="banner">' . "\n";
		if ($header_img) {
			echo '<img src="' . esc_url($header_img) . '" height="' . get_custom_header()->height . '" width="' . get_custom_header()->width . '" alt="' . esc_attr($header_title) . '" />' . "\n";
		}
		if (display_header_text()) {
			$header_img ? $logo_pos = 'logo-overlay' : $logo_pos = 'logo-text';
			$text_color = get_header_textcolor();
			if ($text_color != get_theme_support('custom-header', 'default-text-color')) {
				echo '<style type="text/css" id="mh-header-css">';
					echo '.logo-name, .logo-desc { color: #' . esc_attr($text_color) . '; }';
					echo '.logo-name { border-bottom: 3px solid #' . esc_attr($text_color) . '; }';
				echo '</style>' . "\n";
			}
			echo '<div class="logo ' . $logo_pos . '">' . "\n";
			if ($header_title) {
				echo '<h1 class="logo-name">' . esc_attr($header_title) . '</h1>' . "\n";
			}
			if ($header_desc) {
				echo '<h2 class="logo-desc">' . esc_attr($header_desc) . '</h2>' . "\n";
			}
			echo '</div>' . "\n";
		}
		echo '</div>' . "\n";
		echo '</a>' . "\n";
	}
}

/***** Custom Excerpts *****/

if (!function_exists('mh_trim_excerpt')) {
	function mh_trim_excerpt($text = '') {
		$raw_excerpt = $text;
		if ('' == $text) {
			$text = get_the_content('');
			$text = do_shortcode($text);
			$text = apply_filters('the_content', $text);
			$text = str_replace(']]>', ']]>', $text);
			$excerpt_length = apply_filters('excerpt_length', '200');
			$excerpt_more = apply_filters('excerpt_more', ' [...]');
			$text = wp_trim_words($text, $excerpt_length, $excerpt_more);
		}
		return apply_filters('wp_trim_excerpt', $text, $raw_excerpt);
	}
}
remove_filter('get_the_excerpt', 'wp_trim_excerpt');
add_filter('get_the_excerpt', 'mh_trim_excerpt');

if (!function_exists('mh_excerpt')) {
	function mh_excerpt($excerpt_length = '175') {
		global $options, $post;
		$permalink = get_permalink($post->ID);
		$excerpt_more = empty($options['excerpt_more']) ? '[...]' : $options['excerpt_more'];
		$excerpt = get_the_excerpt();
		if (!has_excerpt()) {
			$excerpt = substr($excerpt, 0, $excerpt_length);
			$excerpt = substr($excerpt, 0, strrpos($excerpt, ' '));
		}
		echo '<div class="mh-excerpt">' . wp_kses_post($excerpt) . ' <a href="' . $permalink . '" title="' . get_the_title() . '">' . esc_attr($excerpt_more) . '</a></div>' . "\n";
	}
}

/***** Enable Custom Excerpts for Pages *****/

if (!function_exists('mh_excerpts_pages')) {
	function mh_excerpts_pages() {
		add_post_type_support('page', 'excerpt');
	}
}
add_action('init', 'mh_excerpts_pages');

/***** Custom Commentlist *****/

if (!function_exists('mh_comments')) {
	function mh_comments($comment, $args, $depth) {
		$GLOBALS['comment'] = $comment; ?>
		<li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
			<div id="comment-<?php comment_ID(); ?>">
				<div class="vcard meta">
					<?php echo get_avatar($comment->comment_author_email, 30); ?>
					<?php echo get_comment_author_link() ?> //
					<a href="<?php echo esc_url(get_comment_link($comment->comment_ID)) ?>"><?php printf(__('%1$s at %2$s', 'mh'), get_comment_date(),  get_comment_time()) ?></a> //
					<?php if (comments_open() && $args['max_depth']!=$depth) { ?>
					<?php comment_reply_link(array_merge($args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
					<?php } ?>
					<?php edit_comment_link(__('(Edit)', 'mh'),'  ','') ?>
				</div>
				<?php if ($comment->comment_approved == '0') : ?>
					<div class="comment-info"><?php _e('Your comment is awaiting moderation.', 'mh') ?></div>
				<?php endif; ?>
				<div class="comment-text">
					<?php comment_text() ?>
				</div>
			</div><?php
	}
}

/***** Custom Comment Fields *****/

if (!function_exists('mh_comment_fields')) {
	function mh_comment_fields($fields) {
		$commenter = wp_get_current_commenter();
		$req = get_option('require_name_email');
		$aria_req = ($req ? " aria-required='true'" : '');
		$fields =  array(
			'author'	=>	'<p class="comment-form-author"><label for="author">' . __('Name ', 'mh') . '</label>' . ($req ? '<span class="required">*</span>' : '') . '<br/><input id="author" name="author" type="text" value="' . esc_attr($commenter['comment_author']) . '" size="30"' . $aria_req . ' /></p>',
			'email' 	=>	'<p class="comment-form-email"><label for="email">' . __('Email ', 'mh') . '</label>' . ($req ? '<span class="required">*</span>' : '' ) . '<br/><input id="email" name="email" type="text" value="' . esc_attr($commenter['comment_author_email']) . '" size="30"' . $aria_req . ' /></p>',
			'url' 		=>	'<p class="comment-form-url"><label for="url">' . __('Website', 'mh') . '</label><br/><input id="url" name="url" type="text" value="' . esc_attr($commenter['comment_author_url']) . '" size="30" /></p>'
		);
		return $fields;
	}
}
add_filter('comment_form_default_fields', 'mh_comment_fields');

/***** Pagination *****/

if (!function_exists('mh_pagination')) {
	function mh_pagination() {
		global $wp_query;
	    $big = 9999;
		echo paginate_links(array('base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))), 'format' => '?paged=%#%', 'current' => max(1, get_query_var('paged')), 'prev_next' => true, 'prev_text' => __('&laquo;', 'mh'), 'next_text' => __('&raquo;', 'mh'), 'total' => $wp_query->max_num_pages));
	}
}

/***** Second Sidebar *****/

if (!function_exists('mh_second_sb')) {
	function mh_second_sb() {
		global $options;
		if (isset($options['sidebars']) && $options['sidebars'] == 'two') {
			echo '<aside class="sidebar-2 sb-right">';
			dynamic_sidebar('sidebar-2');
			echo '</aside>' . "\n";
    	}
	}
}

/***** Load social scripts *****/

if (!function_exists('mh_social_scripts')) {
	function mh_social_scripts() {
		global $options;
		if (is_single() && !isset($options['social_buttons']) || is_single() && isset($options['social_buttons']) && $options['social_buttons'] != 'no_social') {
			echo '<script src="http://platform.twitter.com/widgets.js"></script>' . "\n";
			echo '<script src="https://apis.google.com/js/plusone.js"></script>' . "\n";
		}
		if (is_active_widget('', '', 'mh_facebook') || is_single() && !isset($options['social_buttons']) || is_single() && isset($options['social_buttons']) && $options['social_buttons'] != 'no_social') {
			global $locale;
			echo "<div id='fb-root'></div><script>(function(d, s, id) { var js, fjs = d.getElementsByTagName(s)[0]; if (d.getElementById(id)) return; js = d.createElement(s); js.id = id; js.src = 'https://connect.facebook.net/" . $locale . "/all.js#xfbml=1'; fjs.parentNode.insertBefore(js, fjs); }(document, 'script', 'facebook-jssdk'));</script>" . "\n";
		}
	}
}
add_action('wp_footer', 'mh_social_scripts');

/***** Fix links of carousel widget to work on mobile devices *****/

if (!function_exists('mh_carousel_fix')) {
	function mh_carousel_fix() {
		if (wp_is_mobile() && is_active_widget('', '', 'mh_carousel_hp')) {
			echo '<style type="text/css">.flex-direction-nav { display: none; }</style>';
		}
	}
}
add_action('wp_head', 'mh_carousel_fix');

/***** Add CSS classes to content container *****/

if (!function_exists('mh_content_css')) {
	function mh_content_css() {
		global $options;
		if (isset($options['sb_position']) && $options['sb_position'] == 'left') {
			$float = 'right';
		} else {
			$float = 'left';
		}
		echo $float;
	}
}
add_action('mh_content_class', 'mh_content_css');

/***** Add CSS classes to sidebar container *****/

if (!function_exists('mh_sb_css')) {
	function mh_sb_css($sb_pos = '') {
		global $options;
		if (isset($options['sb_position']) && $options['sb_position'] == 'left') {
			$sb_pos = 'sb-left';
		} else {
			$sb_pos = 'sb-right';
		}
		echo $sb_pos;
	}
}
add_action('mh_sb_class', 'mh_sb_css');

/***** Automatically add rel="prettyPhoto" *****/

if (!function_exists('mh_add_prettyphoto')) {
	if (isset($options['no_prettyphoto']) ? !$options['no_prettyphoto'] : true) {
		function mh_add_prettyphoto($content) {
    		global $post;
			$pattern = "/<a(.*?)href=('|\")(.*?).(bmp|gif|jpeg|jpg|png)('|\")(.*?)>/i";
			$replacement = '<a$1href=$2$3.$4$5 rel="prettyPhoto">';
			$content = preg_replace($pattern, $replacement, $content);
			return $content;
		}
		add_filter('the_content', 'mh_add_prettyphoto');
	}
}

/***** Add Featured Image Size to Media Gallery Selection *****/

if (!function_exists('custom_image_size_choose')) {
	function custom_image_size_choose($sizes) {
		global $options;
		if (isset($options['site_width']) && $options['site_width'] == 'large' && isset($options['sidebars']) && $options['sidebars'] != 'two' || isset($options['sidebars']) && $options['sidebars'] == 'no') {
			$custom_sizes = array('slider' => 'Featured Image (large)', 'content' => 'Featured Image (normal)');
		} else {
			$custom_sizes = array('content' => 'Featured Image');
		}
		return array_merge($sizes, $custom_sizes);
	}
}
add_filter('image_size_names_choose', 'custom_image_size_choose');

?>