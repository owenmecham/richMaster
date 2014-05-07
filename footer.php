<?php $options = get_option('mh_options'); ?>
<?php if (is_active_sidebar('footer-1') || is_active_sidebar('footer-2') || is_active_sidebar('footer-3') || is_active_sidebar('footer-4')) { ?>
<footer class="row clearfix">
	<?php if (is_active_sidebar('footer-1')) { ?>
	<div class="col-1-4 mq-footer">
		<?php dynamic_sidebar('footer-1'); ?>
	</div>
	<?php } ?>
	<?php if (is_active_sidebar('footer-2')) { ?>
	<div class="col-1-4 mq-footer">
		<?php dynamic_sidebar('footer-2'); ?>
	</div>
	<?php } ?>
	<?php if (is_active_sidebar('footer-3')) { ?>
	<div class="col-1-4 mq-footer">
		<?php dynamic_sidebar('footer-3'); ?>
	</div>
	<?php } ?>
	<?php if (is_active_sidebar('footer-4')) { ?>
	<div class="col-1-4 mq-footer">
		<?php dynamic_sidebar('footer-4'); ?>
	</div>
	<?php } ?>
</footer>
<?php } ?>
<?php if (has_nav_menu('footer_nav')) { ?>
	<nav class="footer-nav clearfix">
		<?php wp_nav_menu(array('theme_location' => 'footer_nav', 'fallback_cb' => '')); ?>
	</nav>
<?php } ?>
</div>
<div class="copyright-wrap">
	<p class="copyright"><?php echo empty($options['copyright']) ? 'Copyright &copy; ' . date("Y") . ' | Theme by <a href="http://www.mhthemes.com/" title="Premium WordPress Themes">MH Themes</a>' : $options['copyright']; ?></p>
</div>
<?php if ($options['tracking_code']) { ?>
<?php echo $options['tracking_code']; ?>
<?php } ?>
<?php wp_footer(); ?>
</body>  
</html>