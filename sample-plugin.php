<?php
/**
 * Plugin Name: Sample Plugin
 * Plugin URI: https://github.com/pluggableio/sample-plugin
 * Author: Pluggable, Inc
 * Author URI: https://pluggable.io/
 * Version: 0.1
 * Text Domain: sample-plugin
 * Domain Path: languages
 */

use Pluggable\Plugin\License;

require_once 'vendor/autoload.php';

/**
 * Initialize the license
 */
add_action( 'plugins_loaded', 'sample_plugin_initialize_license' );
function sample_plugin_initialize_license() {
    global $sample_plugin_license;

    $sample_plugin_license = new License( __FILE__, 352, [
    	'hide_notice'	=> true
    ] );
}

/**
 * Register an admin menu
 */
add_action( 'admin_menu', 'sample_plugin_register_menu' );
function sample_plugin_register_menu() {
	add_menu_page(
		__( 'Sample Plugin', 'sample-plugin' ),
		__( 'Sample Plugin', 'sample-plugin' ),
		'manage_options',
		'sample-plugin',
		'callback_sample_menu'
	);
}
function callback_sample_menu() {
	global $sample_plugin_license;

	printf( '<div class="wrap">' );
	printf( '<h2>%s</h2>', __( 'Sample Plugin', 'sample-plugin' ) );

	// if the license is already activated, show a success message (or the premium features)
	if( $sample_plugin_license->_is_activated() ) {
	    printf( __( '<p>Your license is activated. Enjoy premium features.</p>', 'sample-plugin' ) );
	    printf( __( '<p><a href="%s">Click here</a> if you want to deactivate your license.</p>', 'sample-plugin' ), $sample_plugin_license->get_deactivation_url() );
	}

	// if the license is not activated, show the activation link
	else {
	    printf( __( '<p><a href="%s">Click here</a> to activate your license</p>', 'sample-plugin' ), $sample_plugin_license->get_activation_url() );
	}

	printf( '</div>' );
}