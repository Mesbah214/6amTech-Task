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
		return new \WP_Error( 'missing_name', __( 'Name has no value.', '6amtech_task' ) );
	}

	if ( empty( $args['email'] ) ) {
		return new \WP_Error( 'missing_email', __( 'Email has no value.', '6amtech_task' ) );
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

	if ( isset( $data['id'] ) ) {
		$id = $data['id'];
		unset( $data['id'] );

		$updated = $wpdb->update(
			$table_name,
			$data,
			[ 'id' => $id ],
			[
				'%s',
				'%s',
				'%s',
				'%s',
				'%d',
				'%s',
			],
			[ '%d' ]
		);

		return $updated;
	}

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

/**
 * Get contact list details
 *
 * @param array $args
 * @return $items
 */
function contact_list_get_details( $args = [] ) {
	global $wpdb;

	$defaults = [
		'number'  => 5,
		'offset'  => 0,
		'order'   => 'ASC',
		'orderby' => 'id',
	];

	$args = wp_parse_args( $args, $defaults );

	$table_name = $wpdb->prefix . 'contact_list';

	$sql = $wpdb->prepare(
		"SELECT * FROM {$table_name}
            ORDER BY {$args['orderby']} {$args['order']}
            LIMIT %d, %d",
		$args['offset'],
		$args['number']
	);

	$items = $wpdb->get_results( $sql );

	return $items;
}

/**
 * Get contact list count
 *
 * @return int
 */
function contact_list_get_count() {
	global $wpdb;

	$table_name = $wpdb->prefix . 'contact_list';

	$count = $wpdb->get_var( "SELECT COUNT(id) FROM {$table_name}" );

	return $count;
}

/**
 * Get a single contact from DB
 *
 * @param int $id
 * @return object|false
 */
function contact_list_get_details_by_id( $id ) {
	global $wpdb;

	return $wpdb->get_row(
		$wpdb->prepare( "SELECT * FROM {$wpdb->prefix}contact_list WHERE id = %d", $id )
	);
}

/**
 * Update contact list details
 *
 * @param int $id
 * @param array $args
 * @return int|bool
 */
function contact_list_delete_contact( $id ) {
	global $wpdb;

	return $wpdb->delete(
		$wpdb->prefix . 'contact_list',
		[ 'id' => $id ],
		[ '%d' ]
	);
}
