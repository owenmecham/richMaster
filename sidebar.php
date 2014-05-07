<?php /* Template for default sidebar */ ?>
<?php $options = get_option('mh_options'); ?>
<?php if (isset($options['sidebars']) ? $options['sidebars'] != 'no' : true) : ?>
	<aside class="sidebar <?php mh_sb_class(); ?>">
		<?php dynamic_sidebar('sidebar'); ?>
	</aside>
<?php endif; ?>