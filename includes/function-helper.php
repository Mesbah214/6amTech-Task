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

	// Update if ID is set
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

	// Insert new record
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
 * @return array
 */
function contact_list_get_details( $args = [] ) {
	global $wpdb;

	$defaults = [
		'number'  => -1,
		'offset'  => 0,
		'order'   => 'ASC',
		'orderby' => 'id',
	];

	$args = wp_parse_args( $args, $defaults );

	$table_name = $wpdb->prefix . 'contact_list';

	$allowed_orderby = ['id', 'name', 'email', 'created_at'];
	$allowed_order   = ['ASC', 'DESC'];

	$orderby = in_array( $args['orderby'], $allowed_orderby, true ) ? $args['orderby'] : 'id';
	$order   = in_array( strtoupper( $args['order'] ), $allowed_order, true ) ? strtoupper( $args['order'] ) : 'ASC';

	$query = "SELECT * FROM `{$table_name}` ORDER BY {$orderby} {$order}";

	if ( -1 !== intval( $args['number'] ) ) {
		$query = $wpdb->prepare(
			'%1$s LIMIT %2$d OFFSET %3$d',
			$query,
			$args['number'],
			$args['offset']
		);
	}

	if ( -1 === intval( $args['number'] ) ) {
		// phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
		$items = $wpdb->get_results( $query );
	} else {
		// phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
		$items = $wpdb->get_results( $query );
	}

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

	// phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
	$query = "SELECT COUNT(id) FROM `{$table_name}`";

	$count = $wpdb->get_var( $query );

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
