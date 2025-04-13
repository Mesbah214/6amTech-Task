<?php

namespace _6amTech\Task\Admin;

class Menu {
	public $add_new_contact;

	// Crete a top level menu
	public function __construct( $add_new_contact ) {
		$this->add_new_contact = $add_new_contact;
		add_action( 'admin_menu', [ $this, 'add_admin_menu' ] );
	}

	/**
	 * Add admin menu page
	 *
	 * @return void
	 */
	public function add_admin_menu() {
		$capability  = 'manage_options';
		$parent_slug = '6amtech_task_contact_list';

		add_menu_page( __( '6amTech - Task', '6amtech_task' ), __( '6amTech - Task', '6amtech_task' ), $capability, $parent_slug, [ $this, 'contact_list_page' ], 'dashicons-book', 25 );
		add_submenu_page( $parent_slug, __( 'Contact List', '6amtech_task' ), __( 'Contact List', '6amtech_task' ), $capability, $parent_slug, [ $this, 'contact_list_page' ] );
		add_submenu_page( $parent_slug, __( 'Add New Contact', '6amtech_task' ), __( 'Add New Contact', '6amtech_task' ), $capability, '6amtech_task_add_new_contact', [ $this->add_new_contact, 'page' ] );
	}

	public function contact_list_page() {
		// Check if the user has the required capability
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( __( 'You do not have sufficient permissions to access this page.', '6amtech_task' ) );
		}

		$template_path = _6amTech_PATH . '/templates/admin/contact_list.php';

		if ( file_exists( $template_path ) ) {
			include $template_path;
		} else {
			echo '<div class="wrap"><h1>' . esc_html__( 'File not found!', '6amtech_task' ) . '</h1>';
		}
	}
}
