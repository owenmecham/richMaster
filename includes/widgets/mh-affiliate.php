<?php

/***** Affiliate Widget *****/

class mh_affiliate_widget extends WP_Widget {
    function mh_affiliate_widget() {
        $widget_ops = array('classname' => 'mh_affiliate', 'description' => __('MH Affiliate Widget to earn money by promoting WordPress themes by MH Themes.', 'mh'));
        $this->WP_Widget('mh_affiliate', __('MH Affiliate Widget', 'mh'), $widget_ops);
    }
    function widget($args, $instance) {
        extract($args);
        $title = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base);
        $mh_username = empty($instance['mh_username']) ? 'MHthemes' : $instance['mh_username'];
        $mh_ads = isset($instance['mh_ads']) ? $instance['mh_ads'] : '300x250';

        echo $before_widget;

        if (!empty($title)) { echo $before_title . $title . $after_title; } ?>
       	<a href="https://creativemarket.com/MHthemes/?u=<?php echo esc_attr($mh_username); ?>" target="_blank" title="Premium Magazine WordPress Themes by MH Themes" rel="nofollow"><img src="<?php echo get_template_directory_uri() . '/images/ads/mh_magazine_' . $mh_ads . '.png' ?>" alt="MH Magazine WordPress Theme" /></a> <?php

        echo $after_widget;
    }
    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['mh_username'] = strip_tags($new_instance['mh_username']);
        $instance['mh_ads'] = $new_instance['mh_ads'];
        return $instance;
    }
    function form($instance) {
        $defaults = array('title' => 'WordPress Magazine Theme', 'mh_username' => '', 'mh_ads' => '300x250');
        $instance = wp_parse_args((array) $instance, $defaults); ?>

        <p>
        	<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'mh'); ?></label>
			<input class="widefat" type="text" value="<?php echo esc_attr($instance['title']); ?>" name="<?php echo $this->get_field_name('title'); ?>" id="<?php echo $this->get_field_id('title'); ?>" />
        </p>
        <p>
	    	<label for="<?php echo $this->get_field_id('mh_username'); ?>">Creative Market Username:</label>
			<input class="widefat" type="text" value="<?php echo esc_attr($instance['mh_username']); ?>" name="<?php echo $this->get_field_name('mh_username'); ?>" id="<?php echo $this->get_field_id('mh_username'); ?>" />
	    </p>
        <p>
	    	<label for="<?php echo $this->get_field_id('mh_ads'); ?>"><?php _e('Banner Size:', 'mh'); ?></label>
			<select id="<?php echo $this->get_field_id('mh_ads'); ?>" name="<?php echo $this->get_field_name('mh_ads'); ?>" type="text">
				<option value="125x125" <?php if ($instance['mh_ads'] == "125x125") { echo "selected='selected'"; } ?>>125x125</option>
				<option value="250x250" <?php if ($instance['mh_ads'] == "250x250") { echo "selected='selected'"; } ?>>250x250</option>
				<option value="300x250" <?php if ($instance['mh_ads'] == "300x250") { echo "selected='selected'"; } ?>>300x250</option>
				<option value="468x60" <?php if ($instance['mh_ads'] == "468x60") { echo "selected='selected'"; } ?>>468x60</option>
				<option value="728x90" <?php if ($instance['mh_ads'] == "728x90") { echo "selected='selected'"; } ?>>728x90</option>
			</select>
        </p>
        <p><?php echo __('With this widget you can earn money by promoting WordPress themes by MH Themes. If you do not have a Creative Market Username yet, please visit our', 'mh') . ' <a href="http://www.mhthemes.com/affiliates/" target="_blank">' . __('infopage for affiliates', 'mh'). '</a>'; ?>.</p> <?php
    }
}

?>