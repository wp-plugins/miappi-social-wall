<?php
/*
Plugin Name: Miappi Social Wall
Plugin URI: http://business.miappi.com/
Description: Show all your Social feeds and hashtag content in one widget
Version: 0.1
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
