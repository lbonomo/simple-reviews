<?php
/**
 * Metabox class file
 *
 * @package SimpleQuotes
 */

/**
 * Meta box Quote.
 */
class Metabox {
	/** Constructor
	 */
	public function __construct() {
		add_action( 'add_meta_boxes', array( $this, 'register_metabox' ) );
		add_action( 'save_post', array( $this, 'save' ) );
	}

	/**
	 * Register meta box(es).
	 */
	public function register_metabox() {
		// https://developer.wordpress.org/reference/functions/add_meta_box/.
		add_meta_box(
			'review-meta-box-id', // ID.
			'Review data', // Title.
			// callback.
			array( $this, 'render_metabox_content' ),
			'simple-reviews', // screen - CTP Name.
			'normal', // dónde queremos que se muestre nuestro metabox [side/advanced/normal].
			'low', // priority [default/high/low].
			null, // callback_args.
		);
	}

		/**
		 * Render Meta Box content.
		 *
		 * @param WP_Post $post The post object.
		 */
	public function render_metabox_content( $post ) {
		// Add an nonce field so we can check for it later.
		wp_nonce_field( 'review_custom_box', 'review_custom_box_nonce' );
		// Use get_post_meta to retrieve an existing value from the database.

		$review_name  = get_post_meta( $post->ID, 'review_name', true );
		$review_link  = get_post_meta( $post->ID, 'review_link', true );
		$review_order = get_post_meta( $post->ID, 'review_order', true );
		?>

	<div class="review_box">

		<!-- Name -->
		<div class="meta-options review_field">
			<label for="review_name">Person name</label>
			<input type="text" id="review_name" name="review_name" value="<?php echo esc_attr( $review_name ); ?>" />
		</div>
		<!-- Name -->

		<!-- Link -->
		<div class="meta-options review_field">
			<label for="review_link">Link to review</label>
			<input type="url" id="review_link" name="review_link" value="<?php echo esc_attr( $review_link ); ?>" size="7" />
		</div>
		<!-- Link -->

		<!-- Order -->
		<div class="meta-options review_field">
			<label for="review_order">Order</label>
			<input type="number" id="review_order" name="review_order" value="<?php echo esc_attr( $review_order ); ?>" size="35" />
		</div>
		<!-- Order -->



	</div>
		<?php
	}




	/**
	 * Save the meta when the post is saved.
	 *
	 * @param int $post_id The ID of the post being saved.
	 */
	public function save( $post_id ) {

		// Check if our nonce is set.
		if ( ! isset( $_POST['review_custom_box_nonce'] ) ) {
			return $post_id;
		}
		$nonce = $_POST['review_custom_box_nonce'];

		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce( $nonce, 'review_custom_box' ) ) {
			return $post_id;
		}

		/*
		* If this is an autosave, our form has not been submitted,
		* so we don't want to do anything.
		*/
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return $post_id;
		}

		// Check the user's permissions.
		if ( 'page' == $_POST['post_type'] ) {
			if ( ! current_user_can( 'edit_page', $post_id ) ) {
				return $post_id;
			}
		} else {
			if ( ! current_user_can( 'edit_post', $post_id ) ) {
				return $post_id;
			}
		}

		/* OK, it's safe for us to save the data now. */

		// Sanitize the user input.
		// $mydata = ;
		// $mydata = ;
		// $mydata = ;.

		// Update the meta field.
		// update_post_meta( $post_id, 'review_source', sanitize_text_field( $_POST['review_source'] ) );
		update_post_meta( $post_id, 'review_name', sanitize_text_field( $_POST['review_name'] ) );
		update_post_meta( $post_id, 'review_link', sanitize_text_field( $_POST['review_link'] ));
		update_post_meta( $post_id, 'review_order', sanitize_text_field( $_POST['review_order'] ));
	}
}
