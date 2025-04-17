<?php

namespace _6amTech\Task\Traits;

trait FormError {
	/**
	 * Holds the error messages.
	 *
	 * @var array
	 */
	public $errors = [];

	/**
	 * Check if the form has errors.
	 *
	 * @param string $key The key for the error message.
	 * @return bool True if the form has errors, false otherwise.
	 */
	public function has_error( $key ) {
		return ( isset( $this->errors[ $key ] ) ? true : false );
	}

	/**
	 * Get the error message for a specific key.
	 *
	 * @param string $key The key for the error message.
	 * @return string|null The error message or null if not set.
	 */
	public function get_error( $key ) {
		if ( isset( $this->errors[ $key ] ) ) {
			return $this->errors[ $key ];
		}
	}
}
