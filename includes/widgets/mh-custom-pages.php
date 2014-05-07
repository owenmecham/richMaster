<?php

/***** Custom Pages Widget *****/

class mh_custom_pages_widget extends WP_Widget {
    function mh_custom_pages_widget() {
        $widget_ops = array('classname' => 'mh_custom_pages', 'description' => __('Custom Pages Widget to display pages based on page IDs.', 'mh'));
        $this->WP_Widget('mh_custom_pages', __('MH Custom Pages', 'mh'), $widget_ops);
    }
    function widget($args, $instance) {
        extract($args);
        $title = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base);
		$link = empty($instance['link']) ? '' : $instance['link'];
        $pages = empty($instance['pages']) ? '' : $instance['pages'];
        $excerpt = isset($instance['excerpt']) ? $instance['excerpt'] : 'none';
        $excerpt_length = empty($instance['excerpt_length']) ? '175' : $instance['excerpt_length'];
        $thumbnails = isset($instance['thumbnails']) ? $instance['thumbnails'] : 'show_thumbs';

        if ($link) {
	        $before_title = $before_title . '<a href="' . esc_url($link) . '" class="widget-title-link">';
	        $after_title = '</a>' . $after_title;
        }

        echo $before_widget;
        if (!empty( $title)) { echo $before_title . $title . $after_title;} ?>
        <ul class="cp-widget clearfix"> <?php
        $include_ids = explode(',', $pages);
		$args = array('post_type' => 'page', 'post__in' => $include_ids, 'orderby' => 'post__in');
		$counter = 1;
		$widget_loop = new WP_Query($args);
		while ($widget_loop->have_posts()) : $widget_loop->the_post();
			if ($counter == 1 && $excerpt == 'first' || $excerpt == 'all') : ?>
			<li class="cp-wrap cp-large clearfix">
				<?php if ($thumbnails == 'show_thumbs' || $thumbnails == 'hide_small') : ?>
					<div class="cp-thumb-xl"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php if (has_post_thumbnail()) { the_post_thumbnail('cp_large'); } else { echo '<img src="' . get_template_directory_uri() . '/images/noimage_300x225.png' . '" alt="No Picture" />'; } ?></a></div>
				<?php endif; ?>
				<div class="cp-data">
					<h3 class="cp-xl-title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>
				</div>
				<?php mh_excerpt($excerpt_length); ?>
			</li><?php
			else : ?>
			<?php $thumbnails == 'show_thumbs' || $thumbnails == 'hide_large' ? $cp_no_image = '' : $cp_no_image = ' cp-no-image'; ?>
			<li class="cp-wrap cp-small<?php echo $cp_no_image; ?> clearfix">
				<?php if ($thumbnails == 'show_thumbs' || $thumbnails == 'hide_large') : ?>
					<div class="cp-thumb"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php if (has_post_thumbnail()) { the_post_thumbnail('cp_small'); } else { echo '<img src="' . get_template_directory_uri() . '/images/noimage_cp_small.png' . '" alt="No Picture" />'; } ?></a></div>
				<?php endif; ?>
				<div class="cp-data">
					<p class="cp-widget-title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></p>
				</div>
			</li><?php
			endif;
			$counter++;
		endwhile;
		wp_reset_postdata(); ?>
        </ul><?php
        echo $after_widget;
    }
    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['link'] = strip_tags($new_instance['link']);
        $instance['pages'] = strip_tags($new_instance['pages']);
        $instance['excerpt'] = $new_instance['excerpt'];
        $instance['excerpt_length'] = strip_tags($new_instance['excerpt_length']);
        $instance['thumbnails'] = $new_instance['thumbnails'];

        return $instance;
    }
    function form($instance) {
        $defaults = array('title' => '', 'link' => '', 'pages' => '', 'excerpt' => 'none', 'excerpt_length' => '175', 'thumbnails' => 'show_thumbs');
        $instance = wp_parse_args((array) $instance, $defaults); ?>

        <p>
        	<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title (optional):', 'mh'); ?></label>
			<input class="widefat" type="text" value="<?php echo esc_attr($instance['title']); ?>" name="<?php echo $this->get_field_name('title'); ?>" id="<?php echo $this->get_field_id('title'); ?>" />
        </p>
        <p>
        	<label for="<?php echo $this->get_field_id('link'); ?>"><?php _e('Link Title to URL (optional):', 'mh'); ?></label>
			<input class="widefat" type="text" value="<?php echo esc_url($instance['link']); ?>" name="<?php echo $this->get_field_name('link'); ?>" id="<?php echo $this->get_field_id('link'); ?>" />
        </p>
		<p>
        	<label for="<?php echo $this->get_field_id('pages'); ?>"><?php _e('Filter Pages by ID (comma separated):', 'mh'); ?></label>
			<input class="widefat" type="text" value="<?php echo esc_attr($instance['pages']); ?>" name="<?php echo $this->get_field_name('pages'); ?>" id="<?php echo $this->get_field_id('pages'); ?>" />
	    </p>
        <p>
	    	<label for="<?php echo $this->get_field_id('excerpt'); ?>"><?php _e('Display Excerpts:', 'mh'); ?></label>
			<select id="<?php echo $this->get_field_id('excerpt'); ?>" class="widefat" name="<?php echo $this->get_field_name('excerpt'); ?>">
				<option value="first" <?php if ($instance['excerpt'] == "first") { echo "selected='selected'"; } ?>><?php _e('Excerpt for first Page', 'mh') ?></option>
				<option value="all" <?php if ($instance['excerpt'] == "all") { echo "selected='selected'"; } ?>><?php _e('Excerpt for all Pages', 'mh') ?></option>
				<option value="none" <?php if ($instance['excerpt'] == "none") { echo "selected='selected'"; } ?>><?php _e('No Excerpts', 'mh') ?></option>
			</select>
        </p>
        <p>
        	<label for="<?php echo $this->get_field_id('excerpt_length'); ?>"><?php _e('Excerpt Character Limit:', 'mh'); ?></label>
			<input class="widefat" type="text" value="<?php echo esc_attr($instance['excerpt_length']); ?>" name="<?php echo $this->get_field_name('excerpt_length'); ?>" id="<?php echo $this->get_field_id('excerpt_length'); ?>" />
	    </p>
    	<p>
	    	<label for="<?php echo $this->get_field_id('thumbnails'); ?>"><?php _e('Thumbnails:', 'mh'); ?></label>
			<select id="<?php echo $this->get_field_id('thumbnails'); ?>" class="widefat" name="<?php echo $this->get_field_name('thumbnails'); ?>">
				<option value="show_thumbs" <?php if ($instance['thumbnails'] == "show_thumbs") { echo "selected='selected'"; } ?>><?php _e('Show all Thumbnails', 'mh') ?></option>
				<option value="hide_thumbs" <?php if ($instance['thumbnails'] == "hide_thumbs") { echo "selected='selected'"; } ?>><?php _e('Hide all Thumbnails', 'mh') ?></option>
				<option value="hide_large" <?php if ($instance['thumbnails'] == "hide_large") { echo "selected='selected'"; } ?>><?php _e('Hide only large Thumbnails', 'mh') ?></option>
				<option value="hide_small" <?php if ($instance['thumbnails'] == "hide_small") { echo "selected='selected'"; } ?>><?php _e('Hide only small Thumbnails', 'mh') ?></option>
			</select>
        </p><?php
    }
}

?>