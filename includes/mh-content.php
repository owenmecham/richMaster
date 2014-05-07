<?php

/***** News Ticker *****/

if (!function_exists('mh_newsticker')) {
	function mh_newsticker() {
	global $options;
	if (isset($options['show_ticker']) ? $options['show_ticker'] : false) : ?>
	<section class="news-ticker clearfix">
		<div class="ticker-title"><?php if ($options['ticker_title']) : echo esc_attr($options['ticker_title']); else : _e('News Ticker', 'mh'); endif; ?></div>
		<div class="ticker-content">
			<ul id="ticker">
			<?php
			$ticker_posts = empty($options['ticker_posts']) ? '5' : $options['ticker_posts'];
			$ticker_cats = empty($options['ticker_cats']) ? '' : $options['ticker_cats'];
			$ticker_tags = empty($options['ticker_tags']) ? '' : $options['ticker_tags'];
			$ticker_offset = empty($options['ticker_offset']) ? '' : $options['ticker_offset'];
			$ticker_sticky = isset($options['ticker_sticky']) ? $options['ticker_sticky'] : 0;
			$args = array('posts_per_page' => $ticker_posts, 'cat' => $ticker_cats, 'tag' => $ticker_tags, 'offset' => $ticker_offset, 'ignore_sticky_posts' => $ticker_sticky);
			$ticker_loop = new WP_Query($args);
			while ($ticker_loop->have_posts()) : $ticker_loop->the_post(); ?>
    			<li><a href="<?php the_permalink(); ?>"><?php echo '<span class="meta">' . $date = get_the_date(); $date . _e(' in ', 'mh'); $category = get_the_category(); echo $category[0]->cat_name . ' // </span>' ?><?php the_title() ?></a></li>
			<?php endwhile;
			wp_reset_postdata(); ?>
			</ul>
		</div>
	</section>
	<?php endif;
	}
}
add_action('mh_after_header', 'mh_newsticker');

/***** Subheading on Posts *****/

if (!function_exists('mh_subheading')) {
	function mh_subheading() {
		global $post;
		if (get_post_meta($post->ID, "mh-subheading", true)) {
			echo '<div class="subheading-top"></div>' . "\n";
			echo '<h2 class="subheading">' . esc_attr(get_post_meta($post->ID, "mh-subheading", true)) . '</h2>' . "\n";
		}
	}
}
add_action('mh_post_header', 'mh_subheading');

/***** Post Meta *****/

if (!function_exists('mh_post_meta')) {
	function mh_post_meta() {
		global $options;
		$post_date = isset($options['post_meta_date']) ? !$options['post_meta_date'] : true;
		$post_author = isset($options['post_meta_author']) ? !$options['post_meta_author'] : true;
		$post_cat = isset($options['post_meta_cat']) ? !$options['post_meta_cat'] : true;
		$post_comments = isset($options['post_meta_comments']) ? !$options['post_meta_comments'] : true;
		if ($post_date || $post_author || $post_cat || $post_comments) {
			echo '<p class="meta post-meta">';
			if ($post_date || $post_author || $post_cat) {
				echo __('Posted ', 'mh');
			}
			if ($post_date) {
				echo __('on ', 'mh') . '<span class="updated">' . get_the_date() . '</span>';
			}
			if ($post_author) {
				echo __(' by ', 'mh') . '<span class="vcard author"><span class="fn">';
				the_author_posts_link();
				echo '</span></span>';
			}
			if ($post_cat) {
				echo __(' in ', 'mh');
				the_category(', ');
			}
			if ($post_date && $post_comments || $post_author && $post_comments || $post_cat && $post_comments) {
				echo ' // ';
			}
			if ($post_comments) {
				comments_number(__('0 Comments', 'mh'), __('1 Comment', 'mh'), __('% Comments', 'mh'));
			}
			echo '</p>' . "\n";
		}
	}
}
add_action('mh_post_header', 'mh_post_meta');

/***** Teasertext on Posts *****/

if (!function_exists('mh_teaser')) {
	function mh_teaser() {
		global $post, $more, $options;
		if (isset($options['teaser_text']) ? !$options['teaser_text'] && !is_attachment() : !is_attachment()) {
			if (has_excerpt()) {
				esc_attr(the_excerpt());
			} elseif (strstr($post->post_content, '<!--more-->')) {
				$more = 0;
				$excerpt = get_the_content('');
				$more = 1;
				echo '<p>' . do_shortcode($excerpt) . '</p>';
			}
		}
	}
}
add_action('mh_post_content', 'mh_teaser');

/***** Featured Image on Posts *****/

if (!function_exists('mh_featured_image')) {
	function mh_featured_image() {
		global $post, $options;
		if (isset($options['featured_image']) ? has_post_thumbnail() && !is_attachment() && !$options['featured_image'] && !get_post_meta($post->ID, 'mh-no-image', true) : has_post_thumbnail() && !is_attachment() && !get_post_meta($post->ID, 'mh-no-image', true)) {
			if (isset($options['site_width']) && $options['site_width'] == 'large' && isset($options['sidebars']) && $options['sidebars'] != 'two' || isset($options['sidebars']) && $options['sidebars'] == 'no') {
				$thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id(), 'slider');
			} else {
				$thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id(), 'content');
			}
			$full = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
			$caption_text = get_post(get_post_thumbnail_id())->post_excerpt;
			if (isset($options['no_prettyphoto']) ? !$options['no_prettyphoto'] : true) {
				$attachment_url = '<a href="' . $full[0] . '" rel="prettyPhoto">';
			} else {
				$attachment_page = get_attachment_link(get_post_thumbnail_id());
				$attachment_url = '<a href="' . $attachment_page . '">';
			}
			echo "\n" . '<div class="post-thumbnail">' . "\n";
				echo $attachment_url . '<img src="' . $thumbnail[0] . '" alt="' . get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true) . '" title="' . get_post(get_post_thumbnail_id())->post_title . '" /></a>' . "\n";
				if ($caption_text) {
					echo '<span class="wp-caption-text">' . $caption_text . '</span>' . "\n";
				}
			echo '</div>' . "\n";
		}
	}
}
add_action('mh_post_content', 'mh_featured_image');

/***** Share Buttons above Post Content *****/

if (!function_exists('mh_share_buttons_top')) {
	function mh_share_buttons_top() {
		global $options;
		if (!isset($options['social_buttons']) || isset($options['social_buttons']) && $options['social_buttons'] == 'both_social' || isset($options['social_buttons']) && $options['social_buttons'] == 'top_social') {
			get_template_part('/templates/share-buttons');
		}
	}
}
add_action('mh_post_content', 'mh_share_buttons_top');

/***** Content on Posts *****/

if (!function_exists('mh_the_content')) {
	function mh_the_content() {
		global $post, $more, $options;
		$ad = 1;
		if (isset($options['teaser_text']) ? !$options['teaser_text'] : true) {
			if (strstr($post->post_content, '<!--more-->') && !has_excerpt()) {
				$more = 1;
				$ad = 2;
				$content = get_the_content('', true);
			} else {
				$content = get_the_content();
			}
		} else {
			$content = get_the_content();
		}
		$content = apply_filters('the_content', $content);
		$paragraphs = explode("<p", $content);
		$counter = 0;
		foreach($paragraphs as $content) {
			if ($counter == 0) {
				echo $content;
			}
			if ($counter > 0) {
				echo '<p' . $content;
			}
			if ($counter == $ad) {
           		if (!get_post_meta($post->ID, 'mh-no-ad', true)) {
			   		if (get_post_meta($post->ID, 'mh-alt-ad', true)) {
				   		echo '<div class="content-ad">' . do_shortcode(get_post_meta($post->ID, 'mh-alt-ad', true)) . '</div>' . "\n";
				   	} else {
						$adcode = !empty($options['content_ad']) ? '<div class="content-ad">' . do_shortcode($options['content_ad']) . '</div>' . "\n" : '';
						echo $adcode;
					}
				}
			}
		$counter++;
		}
	}
}
add_action('mh_post_content', 'mh_the_content');

/***** Pagination for paginated Posts *****/

if (!function_exists('mh_posts_pagination')) {
	function mh_posts_pagination($content) {
		if (is_singular() && is_main_query()) {
			$content .= wp_link_pages(array('before' => '<div class="pagination">', 'after' => '</div>', 'link_before' => '<span class="pagelink">', 'link_after' => '</span>', 'nextpagelink' => __('&raquo;', 'mh'), 'previouspagelink' => __('&laquo;', 'mh'), 'pagelink' => '%', 'echo' => 0));
		}
		return $content;
	}
}
add_filter('the_content', 'mh_posts_pagination', 1);

/***** Share Buttons below Post Content *****/

if (!function_exists('mh_share_buttons_bottom')) {
	function mh_share_buttons_bottom() {
		global $options;
		if (!isset($options['social_buttons']) || isset($options['social_buttons']) && $options['social_buttons'] == 'both_social' || isset($options['social_buttons']) && $options['social_buttons'] == 'bottom_social') {
			get_template_part('/templates/share-buttons');
		}
	}
}
add_action('mh_after_post_content', 'mh_share_buttons_bottom');

/***** Author box *****/

if (!function_exists('mh_author_box')) {
	function mh_author_box($author_ID = '') {
		global $options;
		if (is_page_template('authors.php')) {
			$layout = 'layout2';
			$ab_output = true;
		} elseif (isset($options['authorbox_layout']) && $options['authorbox_layout'] == 'no_authorbox') {
			$ab_output = false;
		} elseif (!is_attachment() && get_the_author_meta('description', $author_ID)) {
			$layout = isset($options['authorbox_layout']) ? $options['authorbox_layout'] : 'layout1';
			$author_ID = get_the_author_meta('ID');
			$ab_output = true;
		} else {
			$ab_output = false;
		}
		if ($ab_output) {
			$name = get_the_author_meta('display_name', $author_ID);
			$website = get_the_author_meta('user_url', $author_ID);
			$facebook = get_the_author_meta('facebook', $author_ID);
			$twitter = get_the_author_meta('twitter', $author_ID);
			$googleplus = get_the_author_meta('googleplus', $author_ID);
			$youtube = get_the_author_meta('youtube', $author_ID);
			echo '<section class="author-box author-box-' . $layout . '">' . "\n";
				echo '<div class="author-box-wrap clearfix">' . "\n";
					echo '<div class="author-box-avatar">' . get_avatar($author_ID, 113) . '</div>' . "\n";
					echo '<h5 class="author-box-name">' . __('About ', 'mh') . esc_attr($name) . '<span class="author-box-postcount"> (<a href="' . get_author_posts_url($author_ID) . '" title="' . __('More articles written by ', 'mh') . esc_attr($name) . '">' . count_user_posts($author_ID) . __(' Articles', 'mh') . '</a>)</span></h5>' . "\n";
					if (get_the_author_meta('description', $author_ID)) {
						echo '<div class="author-box-desc">' . esc_attr(get_the_author_meta('description', $author_ID)) . '</div>' . "\n";
					} else {
						echo '<div class="author-box-desc">' . __('The author has not yet added any personal or biographical info to his author profile.', 'mh') . '</div>' . "\n";
					}
				echo '</div>' . "\n";
				if (isset($options['author_contact']) ? !$options['author_contact'] : true) {
					if ($website || $facebook || $twitter || $googleplus || $youtube) {
						echo '<div class="author-box-contact">';
						echo '<span class="author-box-contact-start">' . __('Contact: ', 'mh') . '</span>';
						if ($website) {
							echo '<a class="author-box-website" href="' . esc_url($website) . '" title="' . __('Visit the website of ', 'mh') . esc_attr($name) . '" target="_blank">' . __('Website', 'mh') . '</a>';
						}
						if ($facebook) {
							echo '<a class="author-box-facebook" href="' . esc_url($facebook) . '" title="' . __('Follow ', 'mh') . esc_attr($name) . __(' on Facebook', 'mh') . '" target="_blank">' . __('Facebook', 'mh') . '</a>';
						}
						if ($twitter) {
							echo '<a class="author-box-twitter" href="' . esc_url($twitter) . '" title="' . __('Follow ', 'mh') . esc_attr($name) . __(' on Twitter', 'mh') . '" target="_blank">' . __('Twitter', 'mh') . '</a>';
						}
						if ($googleplus) {
							echo '<a class="author-box-googleplus" href="' . esc_url($googleplus) . '" title="' . __('Follow ', 'mh') . esc_attr($name) . __(' on Google+', 'mh') . '" target="_blank">' . __('Google+', 'mh') . '</a>';
						}
						if ($youtube) {
							echo '<a class="author-box-youtube" href="' . esc_url($youtube) . '" title="' . __('Follow ', 'mh') . esc_attr($name) . __(' on YouTube', 'mh') . '" target="_blank">' . __('YouTube', 'mh') . '</a>';
						}
						echo '</div>' . "\n";
					}
				}
			echo '</section>' . "\n";
		}
	}
}
add_action('mh_after_post_content', 'mh_author_box');

/***** Post / Image Navigation *****/

if (!function_exists('mh_postnav')) {
	function mh_postnav() {
		global $post, $options;
		if (isset($options['post_nav']) && $options['post_nav']) {
			$parent_post = get_post($post->post_parent);
			$attachment = is_attachment();
			$previous = ($attachment) ? $parent_post : get_adjacent_post(false, '', true);
			$next = get_adjacent_post(false, '', false);

			if (!$next && !$previous)
			return;

			if ($attachment) {
				$attachments = get_children(array('post_type' => 'attachment', 'post_mime_type' => 'image', 'post_parent' => $parent_post->ID));
				$count = count($attachments);
			}
			if ($attachment && $count == 1) {
				$permalink = get_permalink($parent_post);
				echo '<nav class="section-title clearfix" role="navigation">' . "\n";
				echo '<div class="post-nav left">' . "\n";
				echo '<a href="' . $permalink . '">' . __('&larr; Back to article', 'mh') . '</a>';
				echo '</div>' . "\n";
				echo '</nav>' . "\n";
			} elseif (!$attachment || $attachment && $count > 1) {
				echo '<nav class="section-title clearfix" role="navigation">' . "\n";
				echo '<div class="post-nav left">' . "\n";
				if ($attachment) {
					previous_image_link('%link', __('&larr; Previous image', 'mh'));
				} else {
					previous_post_link('%link', __('&larr; Previous article', 'mh'));
				}
				echo '</div>' . "\n";
				echo '<div class="post-nav right">' . "\n";
				if ($attachment) {
					next_image_link('%link', __('Next image &rarr;', 'mh'));
				} else {
					next_post_link('%link', __('Next article &rarr;', 'mh'));
				}
				echo '</div>' . "\n";
				echo '</nav>' . "\n";
			}
		}
	}
}
add_action('mh_after_post_content', 'mh_postnav');

/***** Related Posts *****/

if (!function_exists('mh_related')) {
	function mh_related() {
		global $post, $options;
		if (isset($options['related_layout']) && $options['related_layout'] != 'no_related' || !isset($options['related_layout'])) {
			$tags = wp_get_post_tags($post->ID);
			if ($tags) {
				$layout = isset($options['related_layout']) ? $options['related_layout'] : 'layout1';
				$tag_ids = array();
				foreach($tags as $tag) $tag_ids[] = $tag->term_id;
				$args = array('tag__in' => $tag_ids, 'post__not_in' => array($post->ID), 'posts_per_page' => 5, 'ignore_sticky_posts' => 1, 'orderby' => 'rand');
				$related = new wp_query($args);
				if ($related->have_posts()) {
					echo '<section class="related-posts related-' . $layout . '">' . "\n";
					echo '<h3 class="section-title">' . __('Related Articles', 'mh') . '</h3>' . "\n";
					echo '<ul>' . "\n";
					while ($related->have_posts()) : $related->the_post();
						$permalink = get_permalink($post->ID);
						echo '<li class="related-wrap clearfix">' . "\n";
						echo '<div class="related-thumb">' . "\n";
						echo '<a href="' . $permalink . '" title="' . get_the_title() . '">';
						if (has_post_thumbnail()) {
							the_post_thumbnail('cp_small');
						} else {
							echo '<img src="' . get_template_directory_uri() . '/images/noimage_cp_small.png' . '" alt="No Picture" />';
						}
						echo '</a>' . "\n";
						echo '</div>' . "\n";
						echo '<div class="related-data">' . "\n";
						echo '<a href="' . $permalink . '"><h4 class="related-title">' . get_the_title() . '</h4></a>' . "\n";
						echo '<span class="related-subheading">' . esc_attr(get_post_meta($post->ID, "mh-subheading", true)) . '</span>' . "\n";
						echo '</div>' . "\n";
						echo '</li>' . "\n";
					endwhile;
					echo '</ul>' . "\n";
					echo '</section>' . "\n";
					wp_reset_postdata();
				}
			}
		}
	}
}
add_action('mh_after_post_content', 'mh_related');

/***** Loop Output *****/

if (!function_exists('mh_loop')) {
	function mh_loop() {
		global $post, $paged, $options;
		$do_not_duplicate[] = '';
		$counter = 0;
		$layout = isset($options['loop_layout']) ? $options['loop_layout'] : 'layout1';
		$adcode = empty($options['loop_ad']) ? '' : '<div class="loop-ad loop-ad-' . $layout . '">' . do_shortcode($options['loop_ad']) . '</div>' . "\n";
		$adcount = empty($options['loop_ad_no']) ? '3' : $options['loop_ad_no'];
		if (is_category() && $paged < 2 && isset($options['loop_slider']) && $options['loop_slider'] != 'no_slider') {
			$category = single_cat_title("", false);
			$cat_id = get_cat_ID($category);
			$cat_meta = get_option("category_$cat_id");
			$cat_postcount = isset($cat_meta['slider_postcount']) ? $cat_meta['slider_postcount'] : '5';
			$cat_posts = new WP_Query('showposts=' . intval($cat_postcount) . '&cat=' . $cat_id);
			if ($cat_posts->have_posts()) {
				get_template_part('/templates/loop-slider', get_post_format());
				while($cat_posts->have_posts()) : $cat_posts->the_post(); $do_not_duplicate[] = $post->ID; endwhile;
			}
		}
		if (have_posts()) {
			echo '<div class="loop-content clearfix">' . "\n";
			while (have_posts()) : the_post(); if (in_array($post->ID, $do_not_duplicate)) continue;
				get_template_part('/templates/loop-' . $layout, get_post_format());
				if ($counter % $adcount == 0) {
					echo $adcode;
				}
				$counter++;
			endwhile;
			echo '</div>' . "\n";
			mh_pagination();
		} else {
			get_template_part('content', 'none');
		}
	}
}
add_action('mh_loop_content', 'mh_loop');

/***** Loop Output Meta Data *****/

if (!function_exists('mh_loop_meta')) {
	function mh_loop_meta() {
		global $options;
		$post_date = isset($options['post_meta_date']) ? !$options['post_meta_date'] : true;
		$post_comments = isset($options['post_meta_comments']) ? !$options['post_meta_comments'] : true;
		if ($post_date || $post_comments) {
			echo '<p class="meta">';
			if ($post_date) {
				echo get_the_date();
			}
			if ($post_date && $post_comments) {
				echo ' // ';
			}
			if ($post_comments) {
				comments_number(__('0 Comments', 'mh'), __('1 Comment', 'mh'), __('% Comments', 'mh'));
			}
			echo '</p>' . "\n";
		}
	}
}

?>