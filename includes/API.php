<?php

namespace _6amTech\Task;

use WP_REST_Response;

class API {
	public function __construct() {
		add_action( 'rest_api_init', [ $this, 'register_routes' ] );
	}

	/**
	 * Register the REST API routes
	 *
	 * @return void
	 */
	public function register_routes() {
		register_rest_route( '6amtech/v1', '/contact-list', [
			'methods'  => 'POST',
			'callback' => [ $this, 'insert_contact_list' ],
			'args'     => [
				'name' => [
					'description' => __( 'Name of the contact.' ),
					'type'        => 'string',
					'context'     => [ 'view', 'edit' ],
					'required'    => true,
					'arg_options' => [
						'sanitize_callback' => 'sanitize_text_field',
					],
				],
				'email' => [
					'description' => __( 'Email of the contact.' ),
					'type'        => 'string',
					'context'     => [ 'view', 'edit' ],
					'required'    => true,
					'arg_options' => [
						'sanitize_callback' => 'sanitize_text_field',
					],
				],
				'phone' => [
					'description' => __( 'Phone of the contact.' ),
					'type'        => 'string',
					'context'     => [ 'view', 'edit' ],
					'required'    => true,
					'arg_options' => [
						'sanitize_callback' => 'sanitize_text_field',
					],
				],
				'address' => [
					'description' => __( 'Address of the contact.' ),
					'type'        => 'string',
					'context'     => [ 'view', 'edit' ],
					'required'    => false,
					'arg_options' => [
						'sanitize_callback' => 'sanitize_text_field',
					],
				],
			],
		] );
	}

	/**
	 * Insert contact list
	 *
	 * @param WP_REST_Request $request
	 * @return WP_REST_Response
	 */
	public function insert_contact_list( $request ) {
		$params = $request->get_params();

		$result = contact_list_insert_details( $params );

		if ( is_wp_error( $result ) ) {
			return new WP_REST_Response( [
				'success' => false,
				'message' => $result->get_error_message(),
			], 400 );
		}


		$contact = contact_list_get_details( $result );

		return new WP_REST_Response( [
			'success' => true,
			'message' => __( 'Contact added successfully.', '6amtech_task' ),
			'data'    => $contact,
		], 201 );
	}
}
