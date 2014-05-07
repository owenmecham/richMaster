<?php /* Loop Template Layout 3 used for index/archive/search */
$options = get_option('mh_options');
$excerpt_length = empty($options['excerpt_length']) ? '175' : $options['excerpt_length'];
?>
<article <?php post_class(); ?>>
	<div class="loop-wrap loop-layout3 clearfix">
		<div class="loop-thumb">
			<?php if (isset($options['site_width']) && $options['site_width'] == 'large' && isset($options['sidebars']) && $options['sidebars'] != 'two' || isset($options['sidebars']) && $options['sidebars'] == 'no') { ?>
				<a href="<?php the_permalink()?>"><?php if (has_post_thumbnail()) { the_post_thumbnail('slider'); } else { echo '<img src="' . get_template_directory_uri() . '/images/noimage_940x400.png' . '" alt="No Picture" />'; } ?></a>
			<?php } else { ?>
				<a href="<?php the_permalink()?>"><?php if (has_post_thumbnail()) { the_post_thumbnail('content'); } else { echo '<img src="' . get_template_directory_uri() . '/images/noimage_620x264.png' . '" alt="No Picture" />'; } ?></a>
			<?php } ?>
		</div>
		<div class="loop-content">
			<header>
				<h3 class="loop-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h3>
			</header>
			<?php mh_excerpt($excerpt_length); ?>
		</div>
		<?php mh_loop_meta(); ?>
	</div>
</article>