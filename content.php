<?php /* Default template for displaying content. */ ?>
<?php $options = get_option('mh_options'); ?>
<article <?php post_class(); ?>>
	<header class="post-header">			
		<h1 class="entry-title"><?php the_title(); ?></h1>
		<?php mh_post_header(); ?>
	</header>
	<?php dynamic_sidebar('posts-1'); ?>
	<div class="entry clearfix">
		<?php mh_post_content(); ?>
	</div>
	<?php if (has_tag()) : ?>
		<div class="post-tags clearfix">
        	<?php the_tags('<ul><li>','</li><li>','</li></ul>'); ?>
        </div>
	<?php endif; ?>
	<?php dynamic_sidebar('posts-2'); ?>	
</article>