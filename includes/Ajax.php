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
		add_action( 'wp_ajax_add_contact', [ $this, 'add_contact' ] );
	}

	/**
	 * Delete contact
	 *
	 * @return void
	 *
	 * @since 1.0.0
	 */
	public function delete_contact() {
		$id    = isset( $_POST['id'] ) ? intval( $_POST['id'] ) : 0;
		$nonce = isset( $_POST['_wpnonce'] ) ? sanitize_text_field( wp_unslash( $_POST['_wpnonce'] ) ) : '';

		if ( ! wp_verify_nonce( $nonce, '6amtech_delete_contact' ) ) {
			wp_send_json_error(
				[
					'message' => __( 'Invalid nonce', '6amtech_task' ),
				]
			);
		}

		$deleted = contact_list_delete_contact( $id );

		if ( true == $deleted ) {
			wp_send_json_success(
				[
					'message' => __( 'Contact deleted successfully', '6amtech_task' ),
				]
			);
		} else {
			wp_send_json_error(
				[
					'message' => __( 'Failed to delete contact', '6amtech_task' ),
				]
			);
		}
	}

	/**
	 * Add or update contact
	 *
	 * @return void
	 *
	 * @since 1.0.0
	 */
	public function add_contact() {
		global $wpdb;
		parse_str( $_POST['data'], $parsed_data );

		$nonce = isset( $parsed_data['_wpnonce'] ) ? sanitize_text_field( $parsed_data['_wpnonce'] ) : '';

		if ( ! wp_verify_nonce( $nonce, 'add_contact' ) ) {
			wp_send_json_error( [ 'message' => __( 'Invalid nonce', '6amtech_task' ) ] );
		}

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( [ 'message' => __( 'You do not have sufficient permissions to access this page.', '6amtech_task' ) ] );
		}

		$id      = isset( $parsed_data['id'] ) ? intval( $parsed_data['id'] ) : 0;
		$name    = sanitize_text_field( $parsed_data['name'] );
		$email   = sanitize_email( $parsed_data['email'] );
		$phone   = sanitize_text_field( $parsed_data['phone'] );
		$address = sanitize_text_field( $parsed_data['address'] );

		if ( empty( $name ) ) {
			wp_send_json_error(
				[
					'message' => __( 'Name is required.', '6amtech_task' ),
				]
			);
		}

		if ( empty( $email ) ) {
			wp_send_json_error(
				[
					'message' => __( 'Email is required.', '6amtech_task' ),
				]
			);
		}

		$args = [
			'name'    => $name,
			'email'   => $email,
			'phone'   => $phone,
			'address' => $address,
		];

		// add new contact
		if ( empty( $id ) ) {
			// check if the email is unique
			$table = $wpdb->prefix . 'contact_list';

			$exists = $wpdb->get_var( $wpdb->prepare( 'SELECT COUNT(*) FROM ' . esc_sql( $table ) . ' WHERE email = %s', $email ) );

			if ( $exists ) {
				wp_send_json_error( [ 'message' => __( 'The email already exists', 'wpappsdev-core' ) ] );
			}

			$result = contact_list_insert_details( $args );

			if ( true == $result ) {
				wp_send_json_success(
					[
						'message' => __( 'Contact added successfully', '6amtech_task' ),
					]
				);
			} else {
				wp_send_json_error(
					[
						'message' => __( 'Failed to add contact', '6amtech_task' ),
					]
				);
			}
		}
		// update contact
		$args['id'] = $id;
		$inserted   = contact_list_insert_details( $args );

		if ( true == $inserted ) {
			wp_send_json_success(
				[
					'message' => __( 'Contact updated successfully', '6amtech_task' ),
				]
			);
		} else {
			wp_send_json_error(
				[
					'message' => __( 'Failed to update contact', '6amtech_task' ),
				]
			);
		}
	}
}
