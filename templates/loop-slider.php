<?php /* Loop Slider Template used for category archives */
$options = get_option('mh_options');
$category = single_cat_title("", false);
$cat_id = get_cat_ID($category);
$cat_meta = get_option("category_$cat_id");
$cat_postcount = isset($cat_meta['slider_postcount']) ? $cat_meta['slider_postcount'] : '5';
$cat_posts = new WP_Query('showposts=' . intval($cat_postcount) . '&cat=' . $cat_id);
$layout = isset($options['loop_slider']) ? $options['loop_slider'] : 'layout1'; ?>
<div class="sb-widget">
	<div id="slider-loop" class="flexslider loop-slider slider-<?php echo esc_attr($layout); ?>">
		<ul class="slides">
		<?php while($cat_posts->have_posts()) : $cat_posts->the_post(); $do_not_duplicate[] = $post->ID; ?>
			<li>
				<article class="slide-wrap">
					<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"> <?php
						if (has_post_thumbnail()) {
							if (isset($options['site_width']) && $options['site_width'] == 'large' && isset($options['sidebars']) && $options['sidebars'] != 'two' || isset($options['sidebars']) && $options['sidebars'] == 'no') {
								the_post_thumbnail('slider');
							} else {
								the_post_thumbnail('content');
							}
						} else {
							if (isset($options['site_width']) && $options['site_width'] == 'large' && isset($options['sidebars']) && $options['sidebars'] != 'two' || isset($options['sidebars']) && $options['sidebars'] == 'no') {
								echo '<img src="' . get_template_directory_uri() . '/images/noimage_940x400.png' . '" alt="No Picture" />';
							} else {
								echo '<img src="' . get_template_directory_uri() . '/images/noimage_620x264.png' . '" alt="No Picture" />';
							}
						} ?>
					</a>
					<div class="slide-caption">
						<div class="slide-data">
							<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><h2 class="slide-title"><?php the_title(); ?></h2></a>
							<?php mh_excerpt(); ?>
						</div>
					</div>
				</article>
			</li>
		<?php endwhile; ?>
		</ul>
	</div>
</div>