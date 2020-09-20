<?php
/**
 * Main class file.
 *
 * @package SimpleQuotes
 */

/**
 * Main class file
 */

require_once 'class-cpt.php';
require_once 'class-admincolumns.php';
require_once 'class-taxonomies.php';
require_once 'class-metabox.php';

/**
 * Main class
 */
class Reviews {
	/** Constructor
	 */
	public function __construct() {
		$cpt             = new CPT();
		$cpt->taxonomies = new Taxonomies();
		$cpt->columns    = new AdminColumns();
		$cpt->metabox    = new Metabox();
	}

	/** On activation actions
	 */
	public static function simple_reviews_activate() {
		flush_rewrite_rules();
	}

	/** On desactivation actions
	 */
	public static function simple_reviews_deactivation() {
		// On desactivation.
	}

	/** On uninstall actions
	 */
	public static function simple_reviews_uninstall() {
		// On uninstall actions.
	}

}
