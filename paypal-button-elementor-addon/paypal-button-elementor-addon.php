<?php
/**
 * Plugin Name: Elementor Button Addon for Paypal 
 * Description: Elementor Button Addon for Paypal.
 * Plugin URI:  https://devabdurrahman.com
 * Version:     1.0.0
 * Author:      Abdur Rahman
 * Author URI:  https://devabdurrahman.com
 * Text Domain: paypal-button-elementor-addon
 * License:	GPL2
 * Requires Plugins: elementor
 * Elementor tested up to: 3.28.3
 * Elementor Pro tested up to: 3.28.2 
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Register Widget.
 */
function pbea_register_widget( $widgets_manager ) {

	require_once( __DIR__ . '/widgets/paypal-button.php' );

	$widgets_manager->register( new \Pbea_Elementor_PayPal_Button_Widget() );

}
add_action( 'elementor/widgets/register', 'pbea_register_widget' );

/*
* Enqueue Necessery Script and style 
*/
function pbea_enqueue_scripts() {
    wp_enqueue_style('pbea-css', plugin_dir_url(__FILE__) . 'assets/css/style.css', '', '1.0');
    // Force Elementor's FA to load
    \Elementor\Icons_Manager::enqueue_shim();
}
add_action('wp_enqueue_scripts', 'pbea_enqueue_scripts');

