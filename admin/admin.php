<?php

/***** Custom Dashboard Widget *****/

function mh_info_widget() {
	echo '<div class="admin-theme-thumb"><img src="' . get_template_directory_uri() . '/images/MH_Magazine_Thumb.png" /></div><p>Thank you very much for purchasing <strong>MH Magazine WordPress Theme</strong>! If you need help with the theme setup or have any questions, please register at the <a href="http://www.mhthemes.com/support/" target="_blank"><strong>support forum</strong></a> where you can find <a href="http://www.mhthemes.com/support/resources/" target="_blank"><strong>several tutorials</strong></a> and get excellent theme support. We usually answer within 24 hours!</p>';
}

function mh_dashboard_widgets() {
	global $wp_meta_boxes;
	add_meta_box('mh_info_widget', 'Theme Support', 'mh_info_widget', 'dashboard', 'normal', 'high');
}
add_action('wp_dashboard_setup', 'mh_dashboard_widgets');

/***** Custom Meta Boxes *****/

if (!function_exists('mh_add_meta_boxes')) {
	function mh_add_meta_boxes() {
		global $options;
		add_meta_box('mh_post_details', __('Post Options', 'mh'), 'mh_post_options', 'post', 'normal', 'high');
	}
}
add_action('add_meta_boxes', 'mh_add_meta_boxes');

if (!function_exists('mh_post_options')) {
	function mh_post_options() {
		global $post;
		wp_nonce_field('mh_meta_box_nonce', 'meta_box_nonce');
		echo '<p>';
		echo '<label for="mh-subheading">' . __("Subheading (will be displayed below post title)", 'mh') . '</label>';
		echo '<br />';
		echo '<input class="widefat" type="text" name="mh-subheading" id="mh-subheading" placeholder="Enter subheading" value="' . esc_attr(get_post_meta($post->ID, 'mh-subheading', true)) . '" size="30" />';
		echo '</p>';
		echo '<p>';
		echo '<label for="mh-alt-ad">' . __("Alternative ad code (this will overwrite the global content ad code)", 'mh') . '</label>';
		echo '<br />';
		echo '<textarea name="mh-alt-ad" id="mh-alt-ad" cols="60" rows="3" placeholder="Enter alternative ad code for this post">' . get_post_meta($post->ID, 'mh-alt-ad', true) . '</textarea>';
		echo '<br />';
		echo '</p>';
		echo '<p>';
		echo '<input type="checkbox" id="mh-no-ad" name="mh-no-ad"'; echo checked(get_post_meta($post->ID, 'mh-no-ad', true), 'on'); echo '/>';
		echo '<label for="mh-no-ad">' . __(' Disable content ad for this post', 'mh') . '</label>';
		echo '</p>';
		echo '<p>';
		echo '<input type="checkbox" id="mh-no-image" name="mh-no-image"'; echo checked(get_post_meta($post->ID, 'mh-no-image', true), 'on'); echo '/>';
		echo '<label for="mh-no-image">' . __(' Disable featured image for this post', 'mh') . '</label>';
		echo '</p>';
	}
}

if (!function_exists('mh_save_meta_boxes')) {
	function mh_save_meta_boxes($post_id, $post) {
		if (!isset($_POST['meta_box_nonce']) || !wp_verify_nonce($_POST['meta_box_nonce'], 'mh_meta_box_nonce')) {
			return $post->ID;
		}
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        	return $post->ID;
		}
		if ('page' == $_POST['post_type']) {
			if (!current_user_can('edit_page', $post_id)) {
				return $post->ID;
			}
		}
		elseif (!current_user_can('edit_post', $post_id)) {
			return $post->ID;
		}
		if ('post' == $_POST['post_type']) {
			$meta_data['mh-subheading'] = esc_attr($_POST['mh-subheading']);
			$meta_data['mh-alt-ad'] = $_POST['mh-alt-ad'];
			$meta_data['mh-no-ad'] = isset($_POST['mh-no-ad']) ? esc_attr($_POST['mh-no-ad']) : '';
			$meta_data['mh-no-image'] = isset($_POST['mh-no-image']) ? esc_attr($_POST['mh-no-image']) : '';
		}
		foreach ($meta_data as $key => $value) {
			if ($post->post_type == 'revision') return;
			$value = implode(',', (array)$value);
			if (get_post_meta($post->ID, $key, FALSE)) {
				update_post_meta($post->ID, $key, $value);
			} else {
				add_post_meta($post->ID, $key, $value);
			}
			if (!$value) delete_post_meta($post->ID, $key);
		}
	}
}
add_action('save_post', 'mh_save_meta_boxes', 10, 2 );

/***** Custom Category Meta Fields *****/

function mh_category_add_meta_field() { ?>

	<?php
}
add_action('category_add_form_fields', 'mh_category_add_meta_field', 10, 2);

function mh_category_edit_meta_field($term) {
	$t_id = $term->term_id;
	$cat_meta = get_option("category_$t_id"); ?>
	<tr class="form-field">
		<th scope="row" valign="top"><label for="cat_meta[slider_postcount]"><?php _e('Posts in Slider', 'mh'); ?></label></th>
		<td>
			<input type="text" name="cat_meta[slider_postcount]" id="cat_meta[slider_postcount]" value="<?php echo isset($cat_meta['slider_postcount']) ? intval($cat_meta['slider_postcount']) : '5'; ?>">
			<p class="description"><?php _e('Enter how many posts you want to show in the category slider', 'mh'); ?></p>
		</td>
	</tr> <?php
}
add_action('category_edit_form_fields', 'mh_category_edit_meta_field', 10, 2 );

function mh_save_category_custom_meta($term_id) {
	if (isset($_POST['cat_meta'])) {
		$t_id = $term_id;
		$cat_meta = get_option("category_$t_id");
		$cat_keys = array_keys($_POST['cat_meta']);
		foreach ($cat_keys as $key) {
			if (isset($_POST['cat_meta'][$key])) {
				$cat_meta[$key] = $_POST['cat_meta'][$key];
			}
		}
		update_option("category_$t_id", $cat_meta);
	}
}
add_action('edited_category', 'mh_save_category_custom_meta', 10, 2);
add_action('create_category', 'mh_save_category_custom_meta', 10, 2);

/***** Additional fields user profile *****/

if (!function_exists('mh_user_profile')) {
    function mh_user_profile($mh_usercontact) {
        $array_mh_usercontact = array('facebook' => 'Facebook', 'twitter' => 'Twitter', 'googleplus' => 'Google+', 'youtube' => 'YouTube');
        $array_mh_usercontact = array_merge($mh_usercontact, $array_mh_usercontact);
        return $array_mh_usercontact;
    }
    add_filter('user_contactmethods', 'mh_user_profile');
}

?>