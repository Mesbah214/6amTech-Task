<?php

namespace _6amTech\Task\Admin;

/**
 * Class AddNewContact
 *
 * This class handles the display and submission of the "Add New Contact" form.
 *
 * @package _6amTech\Task\Admin
 */
class AddNewContact {
	public $errors = [];

	/**
	 * Render the "Add New Contact" page.
	 *
	 * @return void
	 */
	public function page() {
		// Check if the user has the required capability
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( __( 'You do not have sufficient permissions to access this page.', '6amtech_task' ) );
		}

		$template_path = _6amTech_PATH . '/templates/admin/add_new_contact.php';

		if ( file_exists( $template_path ) ) {
			include $template_path;
		} else {
			echo '<div class="wrap"><h1>' . esc_html__( 'File not found!', '6amtech_task' ) . '</h1>';
		}
	}

	/**
	 * Handle the form submission.
	 *
	 * @return void
	 */
	public function submit_form() {
		if ( ! isset( $_POST['add_contact'] ) ) {
			return;
		}

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( __( 'You do not have sufficient permissions to access this page.', '6amtech_task' ) );
		}

		if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'add_contact' ) ) {
			wp_die( __( 'Nonce verification failed', '6amtech_task' ) );
		}

		$name    = isset( $_POST['name'] ) ? sanitize_text_field( $_POST['name'] ) : '';
		$email   = isset( $_POST['email'] ) ? sanitize_text_field( $_POST['email'] ) : '';
		$phone   = isset( $_POST['phone'] ) ? sanitize_text_field( $_POST['name'] ) : '';
		$address = isset( $_POST['address'] ) ? sanitize_textarea_field( $_POST['address'] ) : '';

		if ( empty( $name ) ) {
			$this->errors['name'] = __( 'Name is required.', '6amtech_task' );
		}

		if ( empty( $email ) ) {
			$this->errors['email'] = __( 'Email is required.', '6amtech_task' );
		}

		if ( ! empty( $this->errors ) ) {
			return;
		}

		// var_dump( $_POST );
		$insert_id = contact_list_insert_details(
			[
				'name'    => $name,
				'email'   => $email,
				'phone'   => $phone,
				'address' => $address,
			]
		);

		if ( is_wp_error( $insert_id ) ) {
			wp_die( $insert_id->get_error_message() );
		}

		$redirected_url = admin_url( 'admin.php?page=6amtech_task_contact_list&inserted=true' );
		wp_redirect( $redirected_url );

		exit;
	}
}
