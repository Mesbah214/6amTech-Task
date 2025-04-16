<?php

namespace _6amTech\Task;

/**
 * Ajax class
 *
 * @package 6amTech\Task
 */
class Ajax {
	public function __construct() {
		add_action( 'wp_ajax_delete_contact', [ $this, 'delete_contact' ] );
	}

	public function delete_contact() {
		$id    = isset( $_POST['id'] ) ? intval( $_POST['id'] ) : 0;
		$nonce = isset( $_POST['_wpnonce'] ) ? sanitize_text_field( $_POST['_wpnonce'] ) : '';

		if ( ! wp_verify_nonce( $nonce, '6amtech_delete_contact' ) ) {
			wp_send_json_error( [
				'message' => __( 'Invalid nonce', '6amtech_task' ),
			] );
		}

		$deleted = contact_list_delete_contact( $id );

		if (  true == $deleted ) {
			wp_send_json_success( [
				'message' => __( 'Contact deleted successfully', '6amtech_task' ),
			] );
		} else {
			wp_send_json_error( [
				'message' => __( 'Failed to delete contact', '6amtech_task' ),
			] );
		}
	}
}
