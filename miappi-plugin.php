<?php
/*
Plugin Name: Miappi Social Wall
Plugin URI: http://business.miappi.com/
Description: Show all your Social feeds and hashtag content in one widget
Version: 0.3
Author: Miappi Ltd
Author URI: http://business.miappi.com/
*/

include_once( plugin_dir_path( __FILE__ ) . 'classes/miappi_embed_view.php' );
include_once( plugin_dir_path( __FILE__ ) . 'classes/miappi_widget.php' );

// Widget
function register_wp_miappi_widget() {
	register_widget( 'Miappi_Widget' );
}
add_action( 'widgets_init', 'register_wp_miappi_widget' );

// Theme Embed Code
function miappi_embed( $attributes ) {
    $view = new Miappi_Embed_View();
    return $view->generate( $attributes, false );
}

// Shortcode
function register_miappi_shortcode( $attributes ) {
    return miappi_embed( $attributes );
}
add_shortcode( 'miappi', 'register_miappi_shortcode' );

// Show a message when the plugin is activated 
function miappi_plugin_activation_notice() {
	// used to detect page
	global $pagenow;

	// check we're on plugins page and we have not shown this before
	if ( $pagenow === 'plugins.php' && ! get_option( 'miappi_plugin_activation_notice_shown' ) ) {
		// show the message
		echo 
			'<div class="updated" style="border: 2px solid #7ad03a; border-left: 8px solid #7ad03a;">
				<p style="font-size: 1.1em;">' 
					. sprintf( __( 'You\'ll need to sign up at %s before using this plugin.' ), '<a href="http://dashboard.miappi.com/register?source=business" target="_blank">Miappi</a>' ) . 
				'</p>
			</div>';

		// we're only showing this once
		update_option( 'miappi_plugin_activation_notice_shown', 'y' );
	}
}
add_action( 'admin_notices', 'miappi_plugin_activation_notice' );

// remove any settings when the plugin is de-activated
function miappi_plugin_deactivation_handler() {
	// status of deactivation
	$status = true;

	// remove post activation notice
	if ( ! delete_option( 'miappi_plugin_activation_notice_shown' ) ) {
		$status = false;
	}

	// show an error message if we failed to delete any setting
	if ( false === $status ) {
		echo 
			'<div class="error">
				<p>' 
					. __( 'There was a problem deactivating the Miappi Social Wall plugin. Please try again.' ) . 
				'</p>
			</div>';
	}
}
register_deactivation_hook( __FILE__, 'miappi_plugin_deactivation_handler' );
