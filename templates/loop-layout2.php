<?php /* Loop Template Layout 2 used for index/archive/search */
$options = get_option('mh_options'); 
$excerpt_length = empty($options['excerpt_length']) ? '175' : $options['excerpt_length'];
?>
<article <?php post_class(); ?>>	
	<div class="loop-wrap loop-layout2">
		<div class="clearfix">
			<div class="loop-thumb">
				<a href="<?php the_permalink(); ?>">
					<?php if (has_post_thumbnail()) { the_post_thumbnail('cp_large'); } else { echo '<img src="' . get_template_directory_uri() . '/images/noimage_300x225.png' . '" alt="No Picture" />'; } ?>
				</a>
			</div>
			<div class="loop-content">
				<header>
					<h3 class="loop-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h3>
				</header>		
				<?php mh_excerpt($excerpt_length); ?>
			</div>
		</div>
		<?php mh_loop_meta(); ?>
	</div>
</article>