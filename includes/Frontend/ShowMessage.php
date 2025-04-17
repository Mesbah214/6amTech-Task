<?php

namespace _6amTech\Task\Frontend;

/**
 * ShowMessage class
 *
 * Show custom welcome message on single post pages.
 *
 * @param string $content The original post content.
 * @return string Modified content with the welcome message.
 *
 * @package _6amTech\Task
 * @since 1.0.0
 */
class ShowMessage {
	public function __construct() {
		add_filter( 'the_content', [ $this, 'show_message' ] );
	}

	public function show_message( $content ) {
		if ( is_single() && in_the_loop() && is_main_query() ) {
			$welcome_message = get_option( 'welcome_message' );
			$message         = '<div class="custom-message">' . esc_html( $welcome_message ) . '</div>';
			$content         = $message . $content;
		}

		return $content;
	}
}
