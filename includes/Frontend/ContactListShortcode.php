<?php

namespace _6amTech\Task\Frontend;

class ContactListShortcode {
	public function __construct() {
		add_shortcode( 'contact_list', [ $this, 'render_shortcode' ] );
        add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_assets' ] );
	}

    public function enqueue_assets() {
        wp_enqueue_style( 'bootstrap-css' );
        wp_enqueue_script( 'bootstrap-js' );
    }

	public function render_shortcode( $atts, $content = '' ) {
        wp_enqueue_style( 'table-css' );
		ob_start();

		include _6AMTECH_PATH . '/templates/frontend/contact_list_table.php';

		return ob_get_clean();
	}
}
