<?php

namespace _6amTech\Task\Admin;

class Message {
	public function __construct() {
		add_action( 'admin_menu', [ $this, 'add_message_settings_page' ] );
		add_action( 'admin_init', [ $this, 'register_settings' ] );
	}

	/**
	 * Register the settings section for the settings page
	 *
	 * @return void
	 */
	public function register_settings() {
		// Register the setting
		register_setting( 'welcome_message_options_group', 'welcome_message' );

		// Add the settings section
		// phpcs:ignore WordPress.WP.I18n.NoEmptyStrings
		add_settings_section( 'welcome_message_settings_section', __( '', '6amtech_task' ), null, 'welcome_message' );

		// Add the settings field
		add_settings_field( 'welcome_message_field', __( 'Welcome Message', '6amtech_task' ), [ $this, 'render_welcome_message_field' ], 'welcome_message', 'welcome_message_settings_section' );
	}

	/**
	 * Add the settings page to the admin menu
	 *
	 * @return void
	 */
	public function add_message_settings_page() {
		add_options_page( 'Welcome Message', 'Welcome Message', 'manage_options', 'welcome_message', [ $this, 'welcome_message_options_page' ] );
	}

	/**
	 * Render the settings page
	 *
	 * @return void
	 */
	public function welcome_message_options_page() {
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html__( 'You do not have sufficient permissions to access this page.', '6amtech_task' ) );
		}

		$template_path = _6AMTECH_PATH . '/templates/admin/welcome_message.php';

		if ( file_exists( $template_path ) ) {
			include $template_path;
		} else {
			echo '<div class="wrap"><h1>' . esc_html__( 'File not found!', '6amtech_task' ) . '</h1>';
		}
	}

	public function render_welcome_message_field() {
		$value = get_option( 'welcome_message', '' );
		echo '<textarea id="welcome_message" name="welcome_message" rows="5" cols="50">' . esc_textarea( $value ) . '</textarea>';
	}
}
