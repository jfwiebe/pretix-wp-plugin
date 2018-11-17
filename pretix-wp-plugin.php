<?php
/*
Plugin Name:  Wordpress Pretix Integration
Plugin URI:   https://github.com/jfwiebe/pretix-wp-plugin/
Description:  Provides integration of a pretix shop into Wordpress
Version:      0.1
Author:       jfwiebe
Author URI:   https://jfwie.be
License:      Apache License 2.0
License URI:  https://www.apache.org/licenses/LICENSE-2.0
*/



// Add stylesheet and javascript files to the <head>-area

function pretix_css() {
	echo '<link rel="stylesheet" type="text/css" href="' . esc_attr( get_option( 'css-file-link' ) ) . '">
<script type="text/javascript" src="' . esc_attr( get_option( 'js-file-link' ) ) . '" async></script>';
}

add_action('wp_head', 'pretix_css');

// Add Settings to hold URLs

add_action( 'admin_init', 'pretix_admin_init' );

function pretix_admin_init() {
    register_setting( 'pretix-settings-group', 'css-file-link' );
	register_setting( 'pretix-settings-group', 'js-file-link' );
    add_settings_section( 'url-section', 'General Config', 'general_config_callback', 'pretix-plugin' );
    add_settings_field( 'css-file-link', 'CSS File Link', 'css_file_callback', 'pretix-plugin', 'url-section' );
	add_settings_field( 'js-file-link', 'JS File Link', 'js_file_callback', 'pretix-plugin', 'url-section' );
}

function general_config_callback() {
    echo 'Please set your event settings.';
}
function css_file_callback() {
    $setting = esc_attr( get_option( 'css-file-link' ) );
    echo "<input type='text' name='css-file-link' value='$setting' />";
}
function js_file_callback() {
    $setting = esc_attr( get_option( 'js-file-link' ) );
    echo "<input type='text' name='js-file-link' value='$setting' />";
}

// Add Admin Interface

add_action( 'admin_menu', 'pretix_menu' );

function pretix_menu() {
    add_options_page( 'Pretix Shop Integration Settings', 'Pretix Settings', 'manage_options', 'pretix-plugin', 'pretix_options_page' );
}

function pretix_options_page() {
    ?>
    <div class="wrap">
        <h2>Pretix Shop Integration Settings</h2>
        <form action="options.php" method="POST">
            <?php settings_fields( 'pretix-settings-group' ); ?>
            <?php do_settings_sections( 'pretix-plugin' ); ?>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

// Use "pretix-widget" shortcode to be replaced by the widget code

function pretix_widget($atts = [], $content = null, $tag = '') {
	// handle tags
	$atts = array_change_key_case((array)$atts, CASE_LOWER);
	$pretix_atts = shortcode_atts(['eventurl' => 'https://pretix.eu/demo/democon/', 'subevent' => 1, 'voucher' => ''], $atts, $tag);

	$subevent_tag = "";
	if (isset($atts['subevent'])) {
		$subevent_tag = ' subevent="' . $pretix_atts['subevent'] . '"';
	}

	$voucher_tag = "";
	if (isset($atts['voucher'])) {
		$voucher_tag = ' voucher="' . $pretix_atts['voucher'] . '"';
	}

	return '<pretix-widget event="' . $pretix_atts['eventurl'] . '"' . $subevent_tag . $voucher_tag . '></pretix-widget>
<noscript>
   <div class="pretix-widget">
        <div class="pretix-widget-info-message">
            JavaScript is disabled. Please head over to our ticketing system <a target="_blank" href="'. $pretix_atts['eventurl'] .'">to buy a ticket</a>.
        </div>
    </div>
</noscript>';
}

function register_shortcodes(){
   add_shortcode('pretix-widget', 'pretix_widget');
}

add_action( 'init', 'register_shortcodes');
