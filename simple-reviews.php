<?php
/**
 * Custon post tyep to manages reviews.
 *
 * @link              https://lucasbonomo.com
 * @since             1.0.0
 * @package           Simple_Reviews
 *
 * @wordpress-plugin
 * Plugin Name:       Simple reviews
 * Plugin URI:        https://lucasbonomo.com/wordpress
 * Description:       CTP to manage reviews
 * Version:           1.0.0
 * Stable tag:        1.0.0
 * Requires at least: 5.0
 * Requires PHP:      7.0
 * Tested up to:      5.5
 * Author:            Lucas Bonomo
 * Author URI:        https://lucasbonomo.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       show-remote-ip
 * Domain Path:       /languages
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
	$version = get_plugin_data( __FILE__ )['Version'];
	wp_enqueue_style( 'reviews-style', $version, 1, 'all' );
}

simple_reviews_run();
