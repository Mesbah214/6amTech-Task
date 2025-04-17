<?php

namespace _6amTech\Task\Frontend;

class AddNewContactShortcode {
	public function __construct() {
		add_shortcode( 'add_new_contact', [ $this, 'render_shortcode' ] );
	}

	public function render_shortcode( $atts, $content = '' ) {
		ob_start();

		include _6AMTECH_PATH . '/templates/frontend/add_new_contact_form.php';

		return ob_get_clean();
	}
}
