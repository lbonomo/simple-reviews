<?php
/**
 * @package SimpleQuote
 * @version 1.0.0
 *
 * Version: 1.0.0
 * Plugin Name: Simple Quote
 * Plugin URI: https://lucasbonomo.com/wordpress
 * Description: List of Review
 * Author: Lucas Bonomo
 * Author URI: https://lucasbonomo.com/
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once 'classes/class-reviews.php';

/* Activator */
register_activation_hook(
	__FILE__,
	array( 'Review', 'simple_reviews_activate' )
);

/* Deactivator */
register_deactivation_hook(
	__FILE__,
	array( 'Review', 'simple_reviews_deactivation' )
);

/* Uninstall */
register_uninstall_hook(
	__FILE__,
	array( 'Review', 'simple_reviews_uninstall' )
);

/** Init plugin.
 */
function simple_reviews_run() {
	$plugin = new Reviews();
	/* Add CSS */
	add_action( 'admin_init', 'wpdocs_theme_name_scripts' );
}

/** Init plugin.
 */
function wpdocs_theme_name_scripts() {
	$css_url = plugins_url( 'style.css', __FILE__ );
	wp_enqueue_style( 'reviews-style', $css_url );
}

simple_reviews_run();
