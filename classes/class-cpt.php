<?php
/**
 * Main class file.
 *
 * @package SimpleQuotes
 */

/** CTP definitions
 */
class CPT {

	/** Constructor
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'ctp_review' ) );
	}

	/** CTR Function.
	 */
	public function ctp_review() {
		$labels = array(
			'name'          => 'Reviews',
			'singular_name' => 'Review',
			'edit_item'     => 'Edit review',
			'add_new'       => 'Add new review',
			'archives'      => 'Reviews', // The title to show in de menu.
		);

		// Creamos un array para $args.
		$args = array(
			'labels'             => $labels,
			'public'             => false,
			'has_archive'        => false,
			'publicly_queryable' => false,
			'show_ui'            => true,
			'show_in_rest'       => false,
			'query_var'          => true,
			'rewrite'            => true,
			'taxonomies'         => array( 'review-source' ),
			'capability_type'    => 'page',
			'hierarchical'       => false,
			'menu_position'      => 6,
			'menu_icon'          => null, // See in style.css.
			'supports'           => array(
				'editor',
			),
		);

		register_post_type( 'simple-reviews', $args );

	}
}
