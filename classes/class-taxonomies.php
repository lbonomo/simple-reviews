<?php
/**
 * Metabox class file
 *
 * @package SimpleQuotes
 */

/**
 * Meta box Quote.
 */
class Taxonomies {
	/** Constructor
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'add_taxonomy' ) );
	}

	/**
	 * Register taxonomia.
	 */
	public function add_taxonomy() {

		$labels = array(
			'name'          => 'Source',
			'add_new_item'  => 'Add New source',
			'new_item_name' => 'New source',
		);

		$args = array(
			'hierarchical'      => true,
			'labels'            => $labels,
			'show_ui'           => true, // No se muestra .
			'show_in_menu'      => true,
			'show_admin_column' => false, // No show in admin table.
			'query_var'         => false,
			'meta_box_cb'       => array( $this, 'taxonomy_select_meta_box' ),
			'rewrite'           => array( 'slug' => 'review-source' ),
		);
		// https://developer.wordpress.org/reference/functions/register_taxonomy/.
		// register_taxonomy( Nombre de la taxonomia , CTP al que se aplica , $args ).
		register_taxonomy( 'review-source', array( 'simple-reviews' ), $args );
	}


	/**
	 * Display taxonomy selection as select box
	 *
	 * @param WP_Post $post Currente Post.
	 * @param array   $box Meta box.
	 */
	public function taxonomy_select_meta_box( $post, $box ) {
		$defaults = array( 'taxonomy' => 'review-source' );
		if ( ! isset( $box['args'] ) || ! is_array( $box['args'] ) ) {
			$args = array();
		} else {
			$args = $box['args'];
		}

		$taxonomy     = 'review-source';
		$tax          = get_taxonomy( $taxonomy );
		$selected     = wp_get_object_terms( $post->ID, $taxonomy, array( 'fields' => 'ids' ) );
		$hierarchical = $tax->hierarchical;

		?>

		<div id="taxonomy-<?php echo esc_attr( $taxonomy ); ?>" class="selectdiv">
			<?php
			if ( current_user_can( $tax->cap->edit_terms ) ) {
				// https://developer.wordpress.org/reference/functions/wp_dropdown_categories/.
				wp_dropdown_categories(
					array(
						'taxonomy'        => $taxonomy,
						'class'           => 'widefat',
						'hide_empty'      => false,
						'name'            => "tax_input[$taxonomy][]",
						'selected'        => count( $selected ) >= 1 ? $selected[0] : '',
						'orderby'         => 'name',
						'hierarchical'    => true,
						'show_option_all' => ' ',
					)
				);
			}
			?>
		</div>
		<?php
	}
}
