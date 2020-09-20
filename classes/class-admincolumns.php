<?php
/**
 * Admin columns class file
 *
 * @package SimpleQuotes
 */

/**
 * Class Admin columns.
 */
class AdminColumns {
	/** Constructor.
	 */
	public function __construct() {
		// https://codex.wordpress.org/Plugin_API/Action_Reference/manage_posts_custom_column.

		// Devuelve el array con las columnas.
		// IMPORTANTE: 'manage_{post-type}_posts_columns'.
		add_filter( 'manage_simple-reviews_posts_columns', array( $this, 'set_columns' ) );

		// Columnas ordenables.
		// IMPORTANTE: 'manage_edit-{post-type}_sortable_columns'.
		add_filter( 'manage_edit-simple-reviews_sortable_columns', array( $this, 'sort_columns' ), 10, 2 );

		// Asigna el valor a cada celda.
		// IMPORTANTE: 'manage_{post-type}_posts_custom_column'.
		add_action( 'manage_simple-reviews_posts_custom_column', array( $this, 'admin_reviews_columns' ), 10, 2 );

		// Aplico el ordenamiento.
		add_action( 'pre_get_posts', array( $this, 'review_orderby' ), 5, 2 );

	}

	/** Lista de columnas a mostar
	 *
	 * @param array $columns List of columns to filter.
	 */
	public function set_columns( $columns ) {
		unset( $columns['date'] );
		unset( $columns['title'] );
		$columns['review'] = 'Review';
		$columns['source'] = 'Source';
		$columns['name']   = 'Name';
		$columns['order']  = 'Order';
		return $columns;
	}

	/** Sorteable columns.
	 *
	 * @param array $columns Columns.
	 */
	public function sort_columns( $columns ) {
			// $columns['nombre de la coumna'] = 'valor que aparece en el Get &orderby=???&'.
			$columns['source'] = 'source';
			$columns['order']  = 'order';
			return $columns;
	}

	/** Rellena la tabla.
	 *
	 * @param array $column Column.
	 * @param array $post_id ID de post.
	 */
	public function admin_reviews_columns( $column, $post_id ) {

		switch ( $column ) {
			case 'source':
				foreach ( get_the_terms( $post_id, 'review-source' ) as $tax ) {
					echo esc_attr( $tax->name );
				}
				break;
			case 'review':
				echo esc_attr( get_the_content( $post_id ) );
				break;
			case 'name':
				echo esc_attr( get_post_meta( $post_id, 'review_name', true ) );
				break;
			case 'order':
				echo esc_attr( get_post_meta( $post_id, 'review_order', true ) );
				break;
		}
	}

	/** Aplico el orden.
	 *
	 * @param array $query The Query.
	 */
	public function review_orderby( $query ) {

		if ( ! is_admin() ) {
			return;
		}

		// Objento el valor &orderby=???& de la URL.
		$orderby = $query->get( 'orderby' );

		switch ( $orderby ) {

			case 'order': // Valor asignado en sort_columns().
				$query->set( 'meta_key', 'review_order' );
				$query->set( 'meta_key', 'review_order' );
				// $query->set( 'orderby', 'meta_value_num' );
				break;

			case 'source': // Valor asignado en sort_columns().
				$query->set( 'orderby', 'meta_value' );
				break;

			default:
				break;
		}

		return $query;
	}
}
