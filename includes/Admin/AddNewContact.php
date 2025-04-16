<?php

namespace _6amTech\Task\Admin;

use _6amTech\Task\Traits\FormError;

/**
 * Class AddNewContact
 *
 * This class handles the display and submission of the "Add New Contact" form.
 *
 * @package _6amTech\Task\Admin
 */
TODO: 'add custom validation for email and phone number';

class AddNewContact {
	use FormError;

	/**
	 * Render the "Add New Contact" page.
	 *
	 * @return void
	 */
	public function page() {
		$action = isset( $_GET['action'] ) ? $_GET['action'] : 'list';
		$id     = isset( $_GET['id'] ) ? intval( $_GET['id'] ) : 0;

		switch ( $action ) {
			case 'edit':
				$contact       = contact_list_get_details_by_id( $id );
				$template_path = _6amTech_PATH . '/templates/admin/edit_contact.php';

				break;

			default:
				$template_path = _6amTech_PATH . '/templates/admin/add_new_contact.php';

				break;
		}

		// Check if the user has the required capability
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( __( 'You do not have sufficient permissions to access this page.', '6amtech_task' ) );
		}

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
		error_log( print_r( $_POST, true ) );

		if ( ! isset( $_POST['add_contact'] ) ) {
			return;
		}

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( __( 'You do not have sufficient permissions to access this page.', '6amtech_task' ) );
		}

		if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'add_contact' ) ) {
			wp_die( __( 'Nonce verification failed', '6amtech_task' ) );
		}

		$id      = isset( $_POST['id'] ) ? intval( $_POST['id'] ) : 0;
		error_log( $id );
		$name    = isset( $_POST['name'] ) ? sanitize_text_field( $_POST['name'] ) : '';
		$email   = isset( $_POST['email'] ) ? sanitize_text_field( $_POST['email'] ) : '';
		$phone   = isset( $_POST['phone'] ) ? sanitize_text_field( $_POST['phone'] ) : '';
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

		$args = [
			'name'    => $name,
			'email'   => $email,
			'phone'   => $phone,
			'address' => $address,
		];

		if ( $id ) {
			$args['id'] = $id;
		}

		$insert_id = contact_list_insert_details( $args );

		if ( is_wp_error( $insert_id ) ) {
			wp_die( $insert_id->get_error_message() );
		}

		if ( $id ) {
			$redirected_url = admin_url( 'admin.php?page=6amtech_task_add_new_contact&action=edit&contact-updated=true&id=' . $id );
		} else {
			$redirected_url = admin_url( 'admin.php?page=6amtech_task_contact_list&inserted=true' );
		}
		wp_redirect( $redirected_url );

		exit;
	}

	public function delete_contact() {
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( __( 'You do not have sufficient permissions to access this page.', '6amtech_task' ) );
		}

		if ( ! wp_verify_nonce( $_REQUEST['_wpnonce'], '6amtech-task-delete-contact' ) ) {
			wp_die( __( 'Nonce verification failed', '6amtech_task' ) );
		}

		$id = isset( $_REQUEST['id'] ) ? intval( $_REQUEST['id'] ) : 0;

		if ( contact_list_delete_contact( $id ) ) {
			$redirected_to = admin_url( 'admin.php?page=6amtech_task_contact_list&contact-deleted=true' );
		} else {
			$redirected_to = admin_url( 'admin.php?page=6amtech_task_contact_list&contact-deleted=false' );
		}

		wp_redirect( $redirected_to );

		exit;
	}
}
