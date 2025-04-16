<?php

namespace _6amTech\Task;

/**
 * Handles the enqueueing of styles and scripts for the plugin.
 *
 * @package _6amTech\Task
 */
class Assets {
	public function __construct() {
		add_action( 'wp_enqueue_scripts', [ $this, 'register_assets' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'register_assets' ] );
	}

	public function get_scripts() {
		return [
			'frontend.js' => [
				'src'       => _6amTech_ASSETS . '/js/script.js',
				'deps'      => [],
				'ver'       => filemtime( _6amTech_PATH . '/assets/js/script.js' ),
				'in_footer' => true,
			],
			'bootstrap-js' => [
				'src'       => _6amTech_ASSETS . '/js/bootstrap.min.js',
				'deps'      => [],
				'ver'       => filemtime( _6amTech_PATH . '/assets/js/bootstrap.min.js' ),
				'in_footer' => true,
			],
			'toastr-js' => [
				'src'       => _6amTech_ASSETS . '/js/toastr.min.js',
				'deps'      => ['jquery'],
				'ver'       => filemtime( _6amTech_PATH . '/assets/js/toastr.min.js' ),
				'in_footer' => true,
			],
			'contact' => [
				'src'       => _6amTech_ASSETS . '/js/contactPage.js',
				'deps'      => ['jquery', 'wp-util'],
				'ver'       => filemtime( _6amTech_PATH . '/assets/js/contactPage.js' ),
				'in_footer' => true,
			],
		];
	}

	public function get_styles() {
		return [
			'style.css' => [
				'src'  => _6amTech_ASSETS . '/css/styles.css',
				'deps' => [],
				'ver'  => filemtime( _6amTech_PATH . '/assets/css/styles.css' ),
			],
			'bootstrap-css' => [
				'src'  => _6amTech_ASSETS . '/css/bootstrap.min.css',
				'deps' => [],
				'ver'  => filemtime( _6amTech_PATH . '/assets/css/bootstrap.min.css' ),
			],
			'table-css' => [
				'src'  => _6amTech_ASSETS . '/css/table-style.css',
				'deps' => [],
				'ver'  => filemtime( _6amTech_PATH . '/assets/css/table-style.css' ),
			],
			'toastr-css' => [
				'src'  => _6amTech_ASSETS . '/css/toastr.min.css',
				'deps' => [],
				'ver'  => filemtime( _6amTech_PATH . '/assets/css/toastr.min.css' ),
			],
		];
	}

	/**
	 * Enqueues the styles and scripts for the plugin.
	 *
	 * @return void
	 */
	public function register_assets() {
		$scripts = $this->get_scripts();
		$styles  = $this->get_styles();

		foreach ( $scripts as $handle => $script ) {
			wp_register_script( $handle, $script['src'], $script['deps'], $script['ver'], $script['in_footer'] );
		}

		foreach ( $styles as $handle => $style ) {
			wp_register_style( $handle, $style['src'], $style['deps'], $style['ver'] );
		}

		wp_localize_script( 'contact', '_6amtech_contact', [
			'nonce' => wp_create_nonce( '6amtech_delete_contact' ),
			'ajax_url' => admin_url( 'admin-ajax.php' ),
			'confirm' => __( 'Are you sure?', '6amtech_task' ),
			'error'    => __( 'Something went wrong. Please try again.', '6amtech_task' ),
		] );
	}
}
