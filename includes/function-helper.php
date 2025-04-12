<?php

/**
 * Inset data to the database
 *
 * @param array $args
 * @return int|\WP_Error
 */
function contact_list_insert_details( $args = [] ) {
	global $wpdb;

	if ( empty( $args['name'] ) ) {
		return new \WP_Error( 'missing_name', __( 'Name is required.', '6amtech_task' ) );
	}

	$defaults = [
		'name'       => '',
		'email'      => '',
		'phone'      => '',
		'address'    => '',
		'created_by' => get_current_user_id(),
		'created_at' => current_time( 'mysql' ),
	];

	$data       = wp_parse_args( $args, $defaults );
	$table_name = $wpdb->prefix . 'contact_list';

	$inserted = $wpdb->insert(
		$table_name,
		$data,
		[
			'%s',
			'%s',
			'%s',
			'%s',
			'%d',
			'%s',
		]
	);

	if ( ! $inserted ) {
		return new \WP_Error( 'db_insert_error', __( 'Failed to insert data into the database.', '6amtech_task' ) );
	}

	return $wpdb->insert_id;
}
