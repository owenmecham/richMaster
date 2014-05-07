<?php /* Template Name: Authors */ ?>
<?php $options = get_option('mh_options'); ?>
<?php get_header(); ?>
<div class="wrapper clearfix">
	<div class="main">
    	<div class="content <?php mh_content_class(); ?>">
    		<?php mh_before_page_content(); ?>
    		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    		<div <?php post_class(); ?>>
	        	<div class="entry clearfix">
		        	<?php the_content(); ?>
		        </div>
		    </div>
    		<?php endwhile; endif;
            $users = get_users('orderby=post_count&order=DESC');
			foreach ($users as $current) {
				if(!in_array('subscriber', $current->roles)) {
					$authors[] = $current;
				}
			}
			foreach($authors as $author) {
				mh_author_box($author->ID);
			} ?>
        </div>
		<?php get_sidebar(); ?>
    </div>
    <?php mh_second_sb(); ?>        
</div>
<?php get_footer(); ?>