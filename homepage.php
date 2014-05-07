<?php /* Template Name: Homepage */ ?>
<?php $options = get_option('mh_options'); ?>
<?php get_header(); ?>
<div class="wrapper hp clearfix">
	<div class="main">
		<?php dynamic_sidebar('home-1'); ?>
		<?php if (is_active_sidebar('home-2') || is_active_sidebar('home-3') || is_active_sidebar('home-4') || is_active_sidebar('home-5') || is_active_sidebar('home-6')) : ?>
		<div class="clearfix">
			<div class="hp-content left">
		    	<?php dynamic_sidebar('home-2'); ?>
				<?php if (is_active_sidebar('home-3') || is_active_sidebar('home-4')) : ?>
				<div class="clearfix">
				<?php if (is_active_sidebar('home-3')) { ?>
		    		<div class="hp-sidebar hp-sidebar-left">
			    		<?php dynamic_sidebar('home-3'); ?>
					</div>
				<?php } ?>
				<?php if (is_active_sidebar('home-4')) { ?>
		    		<div class="hp-sidebar sb-right hp-sidebar-right">
			    		<?php dynamic_sidebar('home-4'); ?>
					</div>
				<?php } ?>
				</div>
				<?php endif; ?>
				<?php dynamic_sidebar('home-5'); ?>
			</div>
			<?php if (is_active_sidebar('home-6')) { ?>
			<div class="hp-sidebar sb-right hp-home-6">
        		<?php dynamic_sidebar('home-6'); ?>
			</div>
			<?php } ?>
		</div>
		<?php endif; ?>
		<?php dynamic_sidebar('home-7'); ?>
		<?php if (is_active_sidebar('home-8') || is_active_sidebar('home-9') || is_active_sidebar('home-10')) : ?>
		<div class="clearfix">
	    	<?php if (is_active_sidebar('home-8')) { ?>
			<div class="hp-sidebar hp-sidebar-left">
				<?php dynamic_sidebar('home-8'); ?>
			</div>
			<?php } ?>
			<?php if (is_active_sidebar('home-9')) { ?>
			<div class="hp-sidebar sb-right hp-sidebar-right">
				<?php dynamic_sidebar('home-9'); ?>
			</div>
			<?php } ?>
			<?php if (is_active_sidebar('home-10')) { ?>
			<div class="hp-sidebar sb-right">
				<?php dynamic_sidebar('home-10'); ?>
			</div>
			<?php } ?>
		</div>
		<?php endif; ?>
		<?php dynamic_sidebar('home-11'); ?>
	</div>
	<?php if (isset($options['site_width']) && $options['site_width'] == 'large' && is_active_sidebar('home-12') || isset($options['sidebars']) && $options['sidebars'] == 'two' && is_active_sidebar('home-12')) { ?>
	<div class="hp-sidebar-2 sb-right">
    	<?php dynamic_sidebar('home-12'); ?>
    </div>
	<?php } ?>
</div>
<?php get_footer(); ?>