<?php

function mh_customize_register($wp_customize) {

	/***** Register Custom Controls *****/

	class MH_Customize_Textarea_Control extends WP_Customize_Control {
    	public $type = 'textarea';
    	public function render_content() { ?>
            <label>
                <span class="customize-textarea"><?php echo esc_html($this->label); ?></span>
                <textarea rows="5" style="width: 100%;" <?php $this->link(); ?>><?php echo esc_textarea($this->value()); ?></textarea>
            </label> <?php
	    }
	}

	class MH_Customize_Image_Control extends WP_Customize_Image_Control {
    	public $extensions = array('jpg', 'jpeg', 'gif', 'png', 'ico');
	}

	/***** Add Sections *****/

	$wp_customize->add_section('mh_general', array('title' => __('General Options', 'mh'), 'priority' => 1));
	$wp_customize->add_section('mh_layout', array('title' => __('Layout Options', 'mh'), 'priority' => 2));
	$wp_customize->add_section('mh_typo', array('title' => __('Typography Options', 'mh'), 'priority' => 3));
	$wp_customize->add_section('mh_ticker', array('title' => __('News Ticker Options', 'mh'), 'priority' => 4));
	$wp_customize->add_section('mh_content', array('title' => __('Posts/Pages Options', 'mh'), 'priority' => 5));
	$wp_customize->add_section('mh_ads', array('title' => __('Advertising', 'mh'), 'priority' => 6));
    $wp_customize->add_section('mh_css', array('title' => __('Custom CSS', 'mh'), 'priority' => 8));
    $wp_customize->add_section('mh_tracking', array('title' => __('Tracking Code', 'mh'), 'priority' => 9));

    /***** Add Settings *****/

    $wp_customize->add_setting('mh_options[mh_favicon]', array('default' => '', 'type' => 'option'));
    $wp_customize->add_setting('mh_options[excerpt_length]', array('default' => '175', 'type' => 'option', 'sanitize_callback' => 'mh_sanitize_integer'));
    $wp_customize->add_setting('mh_options[excerpt_more]', array('default' => '[...]', 'type' => 'option', 'sanitize_callback' => 'mh_sanitize_text'));
    $wp_customize->add_setting('mh_options[copyright]', array('default' => '', 'type' => 'option', 'sanitize_callback' => 'mh_sanitize_text'));

    $wp_customize->add_setting('mh_options[layout]', array('default' => 'responsive', 'type' => 'option', 'sanitize_callback' => 'mh_sanitize_select'));
    $wp_customize->add_setting('mh_options[site_width]', array('default' => 'normal', 'type' => 'option', 'sanitize_callback' => 'mh_sanitize_select'));
    $wp_customize->add_setting('mh_options[wt_layout]', array('default' => 'layout1', 'type' => 'option', 'sanitize_callback' => 'mh_sanitize_select'));
    $wp_customize->add_setting('mh_options[page_title_layout]', array('default' => 'layout1', 'type' => 'option', 'sanitize_callback' => 'mh_sanitize_select'));
    $wp_customize->add_setting('mh_options[authorbox_layout]', array('default' => 'layout1', 'type' => 'option', 'sanitize_callback' => 'mh_sanitize_select'));
    $wp_customize->add_setting('mh_options[related_layout]', array('default' => 'layout1', 'type' => 'option', 'sanitize_callback' => 'mh_sanitize_select'));
    $wp_customize->add_setting('mh_options[loop_slider]', array('default' => 'no_slider', 'type' => 'option', 'sanitize_callback' => 'mh_sanitize_select'));
    $wp_customize->add_setting('mh_options[loop_layout]', array('default' => 'layout1', 'type' => 'option', 'sanitize_callback' => 'mh_sanitize_select'));
    $wp_customize->add_setting('mh_options[sidebars]', array('default' => 'one', 'type' => 'option', 'sanitize_callback' => 'mh_sanitize_select'));
    $wp_customize->add_setting('mh_options[sb_position]', array('default' => 'right', 'type' => 'option', 'sanitize_callback' => 'mh_sanitize_select'));

    $wp_customize->add_setting('mh_options[font_size]', array('default' => '14', 'type' => 'option', 'sanitize_callback' => 'mh_sanitize_integer'));
    $wp_customize->add_setting('mh_options[font_heading]', array('default' => 'open_sans', 'type' => 'option'));
    $wp_customize->add_setting('mh_options[font_body]', array('default' => 'open_sans', 'type' => 'option'));

    $wp_customize->add_setting('mh_options[show_ticker]', array('default' => '', 'type' => 'option', 'sanitize_callback' => 'mh_sanitize_checkbox'));
    $wp_customize->add_setting('mh_options[ticker_title]', array('default' => '', 'type' => 'option', 'sanitize_callback' => 'mh_sanitize_text'));
    $wp_customize->add_setting('mh_options[ticker_posts]', array('default' => '5', 'type' => 'option', 'sanitize_callback' => 'mh_sanitize_integer'));
    $wp_customize->add_setting('mh_options[ticker_cats]', array('default' => '', 'type' => 'option', 'sanitize_callback' => 'mh_sanitize_integer'));
    $wp_customize->add_setting('mh_options[ticker_tags]', array('default' => '', 'type' => 'option', 'sanitize_callback' => 'mh_sanitize_text'));
    $wp_customize->add_setting('mh_options[ticker_offset]', array('default' => '', 'type' => 'option', 'sanitize_callback' => 'mh_sanitize_integer'));
    $wp_customize->add_setting('mh_options[ticker_sticky]', array('default' => '', 'type' => 'option', 'sanitize_callback' => 'mh_sanitize_checkbox'));

	$wp_customize->add_setting('mh_options[breadcrumbs]', array('default' => '', 'type' => 'option', 'sanitize_callback' => 'mh_sanitize_checkbox'));
    $wp_customize->add_setting('mh_options[teaser_text]', array('default' => '', 'type' => 'option', 'sanitize_callback' => 'mh_sanitize_checkbox'));
    $wp_customize->add_setting('mh_options[featured_image]', array('default' => '', 'type' => 'option', 'sanitize_callback' => 'mh_sanitize_checkbox'));
    $wp_customize->add_setting('mh_options[no_prettyphoto]', array('default' => '', 'type' => 'option', 'sanitize_callback' => 'mh_sanitize_checkbox'));
    $wp_customize->add_setting('mh_options[post_meta_date]', array('default' => '', 'type' => 'option', 'sanitize_callback' => 'mh_sanitize_checkbox'));
    $wp_customize->add_setting('mh_options[post_meta_author]', array('default' => '', 'type' => 'option', 'sanitize_callback' => 'mh_sanitize_checkbox'));
    $wp_customize->add_setting('mh_options[post_meta_cat]', array('default' => '', 'type' => 'option', 'sanitize_callback' => 'mh_sanitize_checkbox'));
    $wp_customize->add_setting('mh_options[post_meta_comments]', array('default' => '', 'type' => 'option', 'sanitize_callback' => 'mh_sanitize_checkbox'));
    $wp_customize->add_setting('mh_options[author_contact]', array('default' => '', 'type' => 'option', 'sanitize_callback' => 'mh_sanitize_checkbox'));
    $wp_customize->add_setting('mh_options[comments_pages]', array('default' => '', 'type' => 'option', 'sanitize_callback' => 'mh_sanitize_checkbox'));
    $wp_customize->add_setting('mh_options[post_nav]', array('default' => '', 'type' => 'option', 'sanitize_callback' => 'mh_sanitize_checkbox'));
    $wp_customize->add_setting('mh_options[social_buttons]', array('default' => 'both_social', 'type' => 'option', 'sanitize_callback' => 'mh_sanitize_select'));

    $wp_customize->add_setting('mh_options[content_ad]', array('default' => '', 'type' => 'option'));
    $wp_customize->add_setting('mh_options[loop_ad]', array('default' => '', 'type' => 'option'));
    $wp_customize->add_setting('mh_options[loop_ad_no]', array('default' => '3', 'type' => 'option', 'sanitize_callback' => 'mh_sanitize_integer'));

    $wp_customize->add_setting('mh_options[custom_css]', array('default' => '', 'type' => 'option'));
    $wp_customize->add_setting('mh_options[tracking_code]', array('default' => '', 'type' => 'option'));

    $wp_customize->add_setting('mh_options[color_bg_header]', array('default' => '', 'type' => 'option'));
    $wp_customize->add_setting('mh_options[color_bg_inner]', array('default' => '', 'type' => 'option'));
    $wp_customize->add_setting('mh_options[color_1]', array('default' => '', 'type' => 'option'));
    $wp_customize->add_setting('mh_options[color_2]', array('default' => '', 'type' => 'option'));
    $wp_customize->add_setting('mh_options[color_3]', array('default' => '', 'type' => 'option'));
    $wp_customize->add_setting('mh_options[color_text_general]', array('default' => '', 'type' => 'option'));
    $wp_customize->add_setting('mh_options[color_text_second]', array('default' => '', 'type' => 'option'));
    $wp_customize->add_setting('mh_options[color_text_meta]', array('default' => '', 'type' => 'option'));
    $wp_customize->add_setting('mh_options[color_links', array('default' => '', 'type' => 'option'));

    $wp_customize->add_setting('mh_options[full_bg]', array('default' => '', 'type' => 'option', 'sanitize_callback' => 'mh_sanitize_checkbox'));

    /***** Add Controls *****/

    $wp_customize->add_control(new MH_Customize_Image_Control($wp_customize, 'mh_favicon', array('label' => __('Favicon Upload', 'mh'), 'section' => 'mh_general', 'settings' => 'mh_options[mh_favicon]', 'priority' => 1)));
    $wp_customize->add_control('excerpt_length', array('label' => __('Custom Excerpt Length in Characters', 'mh'), 'section' => 'mh_general', 'settings' => 'mh_options[excerpt_length]', 'priority' => 2, 'type' => 'text'));
    $wp_customize->add_control('excerpt_more', array('label' => __('Custom Excerpt More-Text', 'mh'), 'section' => 'mh_general', 'settings' => 'mh_options[excerpt_more]', 'priority' => 3, 'type' => 'text'));
    $wp_customize->add_control('copyright', array('label' => __('Copyright Text', 'mh'), 'section' => 'mh_general', 'settings' => 'mh_options[copyright]', 'priority' => 4, 'type' => 'text'));

	$wp_customize->add_control('layout', array('label' => __('Select Layout', 'mh'), 'section' => 'mh_layout', 'settings' => 'mh_options[layout]', 'priority' => 1, 'type' => 'select', 'choices' => array('responsive' => 'Responsive', 'fixed' => 'Fixed')));
	$wp_customize->add_control('site_width', array('label' => __('Set Site Width', 'mh'), 'section' => 'mh_layout', 'settings' => 'mh_options[site_width]', 'priority' => 2, 'type' => 'select', 'choices' => array('normal' => '980px', 'large' => '1300px')));
    $wp_customize->add_control('wt_layout', array('label' => __('Layout of Widget Titles', 'mh'), 'section' => 'mh_layout', 'settings' => 'mh_options[wt_layout]', 'priority' => 3, 'type' => 'select', 'choices' => array('layout1' => 'Layout 1', 'layout2' => 'Layout 2', 'layout3' => 'Layout 3')));
    $wp_customize->add_control('page_title_layout', array('label' => __('Layout of Page Titles', 'mh'), 'section' => 'mh_layout', 'settings' => 'mh_options[page_title_layout]', 'priority' => 4, 'type' => 'select', 'choices' => array('layout1' => 'Layout 1', 'layout2' => 'Layout 2')));
    $wp_customize->add_control('authorbox_layout', array('label' => __('Layout of Author Box', 'mh'), 'section' => 'mh_layout', 'settings' => 'mh_options[authorbox_layout]', 'priority' => 5, 'type' => 'select', 'choices' => array('layout1' => 'Layout 1', 'layout2' => 'Layout 2', 'no_authorbox' => __('No Author Box', 'mh'))));
    $wp_customize->add_control('related_layout', array('label' => __('Layout of Related Articles', 'mh'), 'section' => 'mh_layout', 'settings' => 'mh_options[related_layout]', 'priority' => 6, 'type' => 'select', 'choices' => array('layout1' => 'Layout 1', 'layout2' => 'Layout 2', 'no_related' => __('No Related Articles', 'mh'))));
	$wp_customize->add_control('loop_slider', array('label' => __('Layout of Category Slider', 'mh'), 'section' => 'mh_layout', 'settings' => 'mh_options[loop_slider]', 'priority' => 7, 'type' => 'select', 'choices' => array('layout1' => 'Layout 1', 'layout2' => 'Layout 2', 'no_slider' => 'No Slider')));
    $wp_customize->add_control('loop_layout', array('label' => __('Layout of Archives', 'mh'), 'section' => 'mh_layout', 'settings' => 'mh_options[loop_layout]', 'priority' => 8, 'type' => 'select', 'choices' => array('layout1' => 'Layout 1', 'layout2' => 'Layout 2', 'layout3' => 'Layout 3')));
    $wp_customize->add_control('sidebars', array('label' => __('Sidebars', 'mh'), 'section' => 'mh_layout', 'settings' => 'mh_options[sidebars]', 'priority' => 9, 'type' => 'select', 'choices' => array('one' => __('One Sidebar', 'mh'), 'two' => __('Two Sidebars', 'mh'), 'no' => __('No Sidebars', 'mh'))));
    $wp_customize->add_control('sb_position', array('label' => __('Position of default Sidebar', 'mh'), 'section' => 'mh_layout', 'settings' => 'mh_options[sb_position]', 'priority' => 10, 'type' => 'select', 'choices' => array('left' => __('Left', 'mh'), 'right' => __('Right', 'mh'))));

	$wp_customize->add_control('font_size', array('label' => __('Change default Font Size (px)', 'mh'), 'section' => 'mh_typo', 'settings' => 'mh_options[font_size]', 'priority' => 1, 'type' => 'text'));
	$google_fonts = array('armata' => 'Armata', 'arvo' => 'Arvo', 'asap' => 'Asap', 'bree_serif' => 'Bree Serif', 'droid_sans' => 'Droid Sans', 'droid_sans_mono' => 'Droid Sans Mono', 'droid_serif' => 'Droid Serif', 'lato' => 'Lato', 'lora' => 'Lora', 'merriweather' => 'Merriweather', 'merriweather_sans' => 'Merriweather Sans', 'monda' => 'Monda', 'nobile' => 'Nobile', 'noto_sans' => 'Noto Sans', 'noto_serif' => 'Noto Serif', 'open_sans' => 'Open Sans', 'oswald' => 'Oswald', 'pt_sans' => 'PT Sans', 'pt_serif' => 'PT Serif', 'raleway' => 'Raleway', 'roboto_condensed' => 'Roboto Condensed', 'ubuntu' => 'Ubuntu', 'yanone_kaffeesatz' => 'Yanone Kaffeesatz');
	$wp_customize->add_control('font_heading', array('label' => __('Select Font for Headings', 'mh'), 'section' => 'mh_typo', 'settings' => 'mh_options[font_heading]', 'priority' => 2, 'type' => 'select', 'choices' => $google_fonts));
	$wp_customize->add_control('font_body', array('label' => __('Select Font for Body Text', 'mh'), 'section' => 'mh_typo', 'settings' => 'mh_options[font_body]', 'priority' => 3, 'type' => 'select', 'choices' => $google_fonts));

	$wp_customize->add_control('show_ticker', array('label' => __('Enable Ticker', 'mh'), 'section' => 'mh_ticker', 'settings' => 'mh_options[show_ticker]', 'priority' => 1, 'type' => 'checkbox'));
    $wp_customize->add_control('ticker_title', array('label' => __('Ticker Title', 'mh'), 'section' => 'mh_ticker', 'settings' => 'mh_options[ticker_title]', 'priority' => 2, 'type' => 'text'));
    $wp_customize->add_control('ticker_posts', array('label' => __('Limit Post Number', 'mh'), 'section' => 'mh_ticker', 'settings' => 'mh_options[ticker_posts]', 'priority' => 3, 'type' => 'text'));
    $wp_customize->add_control('ticker_cats', array('label'=> __('Custom Categories (use ID - e.g. 3,5,9):', 'mh'), 'section' => 'mh_ticker', 'settings' => 'mh_options[ticker_cats]', 'priority' => 4, 'type' => 'text'));
    $wp_customize->add_control('ticker_tags', array('label' => __('Custom Tags (use slug - e.g. lifestyle):', 'mh'), 'section' => 'mh_ticker', 'settings' => 'mh_options[ticker_tags]', 'priority' => 5, 'type' => 'text'));
    $wp_customize->add_control('ticker_offset', array('label' => __('Offset', 'mh'), 'section' => 'mh_ticker', 'settings' => 'mh_options[ticker_offset]', 'priority' => 6, 'type' => 'text'));
	$wp_customize->add_control('ticker_sticky', array('label' => __('Ignore Sticky Posts', 'mh'), 'section' => 'mh_ticker', 'settings' => 'mh_options[ticker_sticky]', 'priority' => 7, 'type' => 'checkbox'));

	$wp_customize->add_control('breadcrumbs', array('label' => __('Enable Breadcrumbs', 'mh'), 'section' => 'mh_content', 'settings' => 'mh_options[breadcrumbs]', 'priority' => 1, 'type' => 'checkbox'));
    $wp_customize->add_control('teaser_text', array('label' => __('Disable Teaser Text on Posts', 'mh'), 'section' => 'mh_content', 'settings' => 'mh_options[teaser_text]', 'priority' => 2, 'type' => 'checkbox'));
    $wp_customize->add_control('featured_image', array('label' => __('Disable Featured Image on Posts', 'mh'), 'section' => 'mh_content', 'settings' => 'mh_options[featured_image]', 'priority' => 3, 'type' => 'checkbox'));
    $wp_customize->add_control('no_prettyphoto', array('label' => __('Disable prettyPhoto Lightbox', 'mh'), 'section' => 'mh_content', 'settings' => 'mh_options[no_prettyphoto]', 'priority' => 4, 'type' => 'checkbox'));
    $wp_customize->add_control('post_meta_date', array('label' => __('Disable Date in Post Meta', 'mh'), 'section' => 'mh_content', 'settings' => 'mh_options[post_meta_date]', 'priority' => 5, 'type' => 'checkbox'));
    $wp_customize->add_control('post_meta_author', array('label' => __('Disable Author in Post Meta', 'mh'), 'section' => 'mh_content', 'settings' => 'mh_options[post_meta_author]', 'priority' => 6, 'type' => 'checkbox'));
    $wp_customize->add_control('post_meta_cat', array('label' => __('Disable Categories in Post Meta', 'mh'), 'section' => 'mh_content', 'settings' => 'mh_options[post_meta_cat]', 'priority' => 7, 'type' => 'checkbox'));
    $wp_customize->add_control('post_meta_comments', array('label' => __('Disable Comments in Post Meta', 'mh'), 'section' => 'mh_content', 'settings' => 'mh_options[post_meta_comments]', 'priority' => 8, 'type' => 'checkbox'));
    $wp_customize->add_control('author_contact', array('label' => __('Hide Contact Details in Author Box', 'mh'), 'section' => 'mh_content', 'settings' => 'mh_options[author_contact]', 'priority' => 9, 'type' => 'checkbox'));
    $wp_customize->add_control('comments_pages', array('label' => __('Enable Comments on Pages', 'mh'), 'section' => 'mh_content', 'settings' => 'mh_options[comments_pages]', 'priority' => 10, 'type' => 'checkbox'));
    $wp_customize->add_control('post_nav', array('label' => __('Enable Post/Attachment Navigation', 'mh'), 'section' => 'mh_content', 'settings' => 'mh_options[post_nav]', 'priority' => 11, 'type' => 'checkbox'));
    $wp_customize->add_control('social_buttons', array('label' => __('Display Social Buttons', 'mh'), 'section' => 'mh_content', 'settings' => 'mh_options[social_buttons]', 'priority' => 12, 'type' => 'select', 'choices' => array('both_social' => __('Top and bottom', 'mh'), 'top_social' => __('Top of posts', 'mh'), 'bottom_social' => __('Bottom of posts', 'mh'), 'no_social' => __('No Social Buttons', 'mh'))));

    $wp_customize->add_control(new MH_Customize_Textarea_Control($wp_customize, 'content_ad', array('label' => __('Ad Code for Content Ad on Posts', 'mh'), 'section' => 'mh_ads', 'settings' => 'mh_options[content_ad]', 'priority' => 1)));
    $wp_customize->add_control(new MH_Customize_Textarea_Control($wp_customize, 'loop_ad', array('label' => __('Ad Code for Ads on Archives', 'mh'), 'section' => 'mh_ads', 'settings' => 'mh_options[loop_ad]', 'priority' => 2)));
    $wp_customize->add_control('loop_ad_no', array('label'=> __('Display Ad every x Posts on Archives:', 'mh'), 'section' => 'mh_ads', 'settings' => 'mh_options[loop_ad_no]', 'priority' => 3, 'type' => 'text'));

    $wp_customize->add_control(new MH_Customize_Textarea_Control($wp_customize, 'custom_css', array('label' => __('Custom CSS', 'mh'), 'section' => 'mh_css', 'settings' => 'mh_options[custom_css]', 'priority' => 1)));
    $wp_customize->add_control(new MH_Customize_Textarea_Control($wp_customize, 'tracking_code', array('label' => __('Tracking Code (e.g. Google Analytics)', 'mh'), 'section' => 'mh_tracking', 'settings' => 'mh_options[tracking_code]', 'priority' => 1)));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'color_bg_header', array('label' => __('Background Header', 'mh'), 'section' => 'colors', 'settings' => 'mh_options[color_bg_header]', 'priority' => 50)));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'color_bg_inner', array('label' => __('Background Inner', 'mh'), 'section' => 'colors', 'settings' => 'mh_options[color_bg_inner]', 'priority' => 51)));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'color_1', array('label' => __('Color 1', 'mh'), 'section' => 'colors', 'settings' => 'mh_options[color_1]', 'priority' => 52)));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'color_2', array('label' => __('Color 2', 'mh'), 'section' => 'colors', 'settings' => 'mh_options[color_2]', 'priority' => 53)));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'color_3', array('label' => __('Color 3', 'mh'), 'section' => 'colors', 'settings' => 'mh_options[color_3]', 'priority' => 54)));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'color_text_general', array('label' => __('Text: General', 'mh'), 'section' => 'colors', 'settings' => 'mh_options[color_text_general]', 'priority' => 55)));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'color_text_second', array('label' => __('Text: 2nd Color', 'mh'), 'section' => 'colors', 'settings' => 'mh_options[color_text_second]', 'priority' => 56)));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'color_text_meta', array('label' => __('Text: Post Meta', 'mh'), 'section' => 'colors', 'settings' => 'mh_options[color_text_meta]', 'priority' => 57)));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'color_links', array('label' => __('Link Color on Posts / Pages', 'mh'), 'section' => 'colors', 'settings' => 'mh_options[color_links]', 'priority' => 58)));

	$wp_customize->add_control('full_bg', array('label' => __('Scale Background Image to Full Size', 'mh'), 'section' => 'background_image', 'settings' => 'mh_options[full_bg]', 'priority' => 99, 'type' => 'checkbox'));
}
add_action('customize_register', 'mh_customize_register');

/***** Data Sanitization *****/

function mh_sanitize_text($input) {
    return wp_kses_post(force_balance_tags($input));
}
function mh_sanitize_integer($input) {
    return strip_tags($input);
}
function mh_sanitize_checkbox($input) {
    if ($input == 1) {
        return 1;
    } else {
        return '';
    }
}
function mh_sanitize_select($input) {
    $valid = array(
    	'responsive' => __('Responsive', 'mh'),
        'fixed' => __('Fixed', 'mh'),
        'one' => __('One Sidebar', 'mh'),
        'two' => __('Two Sidebars', 'mh'),
        'no' => __('No Sidebars', 'mh'),
        'left' => __('Left', 'mh'),
        'right' => __('Right', 'mh'),
        'normal' => '980px',
        'large' => '1300px',
        'no_slider' => 'No Slider',
        'layout1' => 'Layout 1',
        'layout2' => 'Layout 2',
        'layout3' => 'Layout 3',
        'both_social' => __('Top and bottom', 'mh'),
        'top_social' => __('Top of Posts', 'mh'),
        'bottom_social' => __('Bottom of Posts', 'mh'),
        'no_social' => __('No Social Buttons', 'mh'),
        'no_authorbox' => __('No Author Box', 'mh'),
        'no_related' => __('No Related Articles', 'mh')
    );
    if (array_key_exists($input, $valid)) {
        return $input;
    } else {
        return '';
    }
}

/***** CSS Output *****/

function mh_custom_css() {
	$options = get_option('mh_options');
	$font_css = array('armata' => '"Armata", sans-serif', 'arvo' => '"Arvo", serif', 'asap' => '"Asap", sans-serif', 'bree_serif' => '"Bree Serif", serif', 'droid_sans' => '"Droid Sans", sans-serif', 'droid_sans_mono' => '"Droid Sans Mono", sans-serif', 'droid_serif' => '"Droid Serif", serif', 'lato' => '"Lato", sans-serif', 'lora' => '"Lora", serif', 'merriweather' => '"Merriweather", serif', 'merriweather_sans' => '"Merriweather Sans", sans-serif', 'monda' => '"Monda", sans-serif', 'nobile' => '"Nobile", sans-serif', 'noto_sans' => '"Noto Sans", sans-serif', 'noto_serif' => '"Noto Serif", serif', 'open_sans' => '"Open Sans", sans-serif', 'oswald' => '"Oswald", sans-serif', 'pt_sans' => '"PT Sans", sans-serif', 'pt_serif' => '"PT Serif", serif', 'raleway' => '"Raleway", sans-serif', 'roboto_condensed' => '"Roboto Condensed", sans-serif', 'ubuntu' => '"Ubuntu", sans-serif', 'yanone_kaffeesatz' => '"Yanone Kaffeesatz", sans-serif');
	if (isset($options['font_size']) && $options['font_size'] != '14' || isset($options['font_heading']) && $options['font_heading'] != 'open_sans' || isset($options['font_body']) && $options['font_body'] != 'open_sans' || $options['color_bg_header'] || $options['color_bg_inner'] || $options['color_1'] || $options['color_2'] || $options['color_3'] || $options['color_text_general'] || $options['color_text_second'] || $options['color_text_meta'] || $options['color_links'] || $options['custom_css']) : ?>
    <style type="text/css">
    	<?php if ($options['font_size'] && $options['font_size'] != '14') { ?>
    		.entry { font-size: <?php echo $options['font_size']; ?>px; font-size: <?php echo $options['font_size'] / 16; ?>rem; }
    	<?php } ?>
    	<?php if (isset($options['font_heading']) && $options['font_heading'] != 'open_sans') { ?>
			h1, h2, h3, h4, h5, h6 { font-family: <?php echo $font_css[$options['font_heading']]; ?>; }
		<?php } ?>
		<?php if (isset($options['font_body']) && $options['font_body'] != 'open_sans') { ?>
			body { font-family: <?php echo $font_css[$options['font_body']]; ?>; }
		<?php } ?>
    	<?php if ($options['color_bg_header']) { ?>
    		.header-wrap { background: <?php echo $options['color_bg_header']; ?> }
    	<?php } ?>
    	<?php if ($options['color_bg_inner']) { ?>
    		.wrapper { background: <?php echo $options['color_bg_inner']; ?> }
    	<?php } ?>
    	<?php if ($options['color_1']) { ?>
    		.main-nav,
    		.header-nav .menu .menu-item:hover > .sub-menu,
    		.main-nav .menu .menu-item:hover > .sub-menu,
    		.footer-nav .menu-item:hover,
    		.slide-caption,
    		.spotlight,
    		.carousel-layout1,
    		footer,
    		.loop-layout2 .meta, .loop-layout3 .meta, .loop-layout4 .meta,
			input[type=submit]:hover,
    		#cancel-comment-reply-link:hover { background: <?php echo $options['color_1']; ?> }
    	<?php } ?>
    	<?php if ($options['color_2']) { ?>
    		.ticker-title,
    		.header-nav .menu-item:hover,
    		.main-nav li:hover,
    		.footer-nav,
    		.footer-nav .menu .menu-item:hover > .sub-menu,
    		.slider-layout2 .flex-control-paging li a.flex-active,
    		.sl-caption,
    		.subheading,
    		.page-title-layout1,
    		.wt-layout2 .widget-title,
    		.wt-layout2 .footer-widget-title,
    		.carousel-layout1 .caption,
    		.loop-layout3 .loop-title,
    		.page-numbers:hover,
    		.current,
    		.pagelink,
    		a:hover .pagelink,
    		input[type=submit],
    		#cancel-comment-reply-link,
    		.post-tags li:hover,
    		.tagcloud a:hover,
    		.sb-widget .tagcloud a:hover,
    		.footer-widget .tagcloud a:hover { background: <?php echo $options['color_2']; ?>; }
    		.slide-caption,
    		.mh-mobile .slide-caption,
    		[id*='carousel-'],
    		.wt-layout1 .widget-title,
    		.wt-layout1 .footer-widget-title,
    		.wt-layout3 .widget-title,
    		.wt-layout3 .footer-widget-title,
    		.author-box-layout1,
    		.cat-desc,
			input[type=text]:hover,
			textarea:hover,
			.wpcf7-form input[type=email]:hover,
    		blockquote { border-color: <?php echo $options['color_2']; ?>; }
    		a:hover,
    		.entry a:hover,
    		.slide-title:hover,
    		.sl-title:hover,
    		.carousel-layout2 .caption,
    		.carousel-layout2 .carousel-item-title:hover,
    		.related-title:hover,
    		.dropcap { color: <?php echo $options['color_2']; ?>; }
    	<?php } ?>
    	<?php if ($options['color_3']) { ?>
    		.news-ticker,
    		#searchform,
    		.author-box,
    		.cat-desc,
    		.post-nav-wrap,
    		#wp-calendar caption,
    		.no-comments,
    		#respond,
    		.wpcf7-form { background: <?php echo $options['color_3']; ?>; }
    	<?php } ?>
    	<?php if ($options['color_text_general']) { ?>
    		body { color: <?php echo $options['color_text_general']; ?>; }
    	<?php } ?>
    	<?php if ($options['color_text_second']) { ?>
    		.logo-desc,
    		.header-nav .menu-item:hover a,
    		.header-nav .sub-menu a,
    		.main-nav li a,
    		.footer-nav .menu-item:hover a,
    		.footer-nav .sub-menu a,
    		.ticker-title,
    		.subheading,
    		.page-title,
    		footer,
    		.sl-title,
    		.sl-caption,
    		.slide-caption,
    		.caption { color: <?php echo $options['color_text_second']; ?>; }
    	<?php } ?>
    	<?php if ($options['color_text_meta']) { ?>
    		.meta, .breadcrumb { color: <?php echo $options['color_text_meta']; ?>; }
    	<?php } ?>
    	<?php if ($options['color_links']) { ?>
    		.entry a { color: <?php echo $options['color_links']; ?>; }
    	<?php } ?>
    	<?php if ($options['custom_css']) {	echo $options['custom_css']; } ?>
	</style>
    <?php
	endif;
}
add_action('wp_head', 'mh_custom_css');

?>