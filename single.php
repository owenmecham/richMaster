<?php $options = get_option('mh_options'); ?>
<?php get_header(); ?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<div class="wrapper clearfix">
	<div class="main">
		<div class="content <?php mh_content_class(); ?>"><?php 
			mh_before_post_content();
			if (is_attachment()) {
				get_template_part('content', 'attachment');	
			} else {
				get_template_part('content', get_post_format());
			}
			mh_after_post_content();
			endwhile;
			comments_template();
			endif; ?>
		</div>
		<?php get_sidebar(); ?> 
	</div>   
    <?php mh_second_sb(); ?>
</div> 
<?php get_footer(); ?>