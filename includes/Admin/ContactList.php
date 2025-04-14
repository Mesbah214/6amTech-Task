<?php

namespace _6amTech\Task\Admin;

use WP_List_Table;

if ( ! class_exists( 'WP_List_Table' ) ) {
	require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}

/**
 * Class ContactList
 *
 * This class handles the display of the contact list in a table format.
 *
 * @package _6amTech\Task\Admin
 */
class ContactList extends WP_List_Table {
	public function __construct() {
		parent::__construct( [
			'singular' => 'Contact',
			'plural'   => 'Contacts',
			'ajax'     => false,
		] );
	}

	/**
	 * Get the columns for the table
	 *
	 * @return array
	 */
	public function get_columns() {
		return [
			'cb'         => '<input type="checkbox" />',
			'name'       => __( 'Name', '6amtech_task' ),
			'email'      => __( 'Email', '6amtech_task' ),
			'phone'      => __( 'Phone', '6amtech_task' ),
			'address'    => __( 'Address', '6amtech_task' ),
			'created_at' => __( 'Created At', '6amtech_task' ),
		];
	}

	/**
	 * Render the columns
	 *
	 * @param object $item The current item.
	 * @param string $column_name The name of the column.
	 *
	 * @return string
	 */
	protected function column_default( $item, $column_name ) {
		switch ( $column_name ) {
			case 'value':
				break;

			default:
				return isset(  $item->$column_name ) ? $item->$column_name : '';
		}
	}

	/**
	 * Get sortable columns
	 *
	 * @return array
	 */
	public function get_sortable_columns() {
		return [
			'name'       => [ 'name', true ],
			'created_at' => [ 'created_at', true ],
		];
	}

	/**
	 * Render the name column
	 *
	 * @param object $item The current item.
	 *
	 * @return string
	 */
	public function column_name( $item ) {
		$actions = [];

		$actions['edit']   = sprintf( '<a href="%s" title="%s">%s</a>', admin_url( 'admin.php?page=6amtech_task_add_new_contact&action=edit&id=' . $item->id ), __( 'Edit', '6amtech_task' ), __( 'Edit', '6amtech_task' ) );
		$actions['delete'] = sprintf( '<a href="%s" class="submitdelete" onclick="return confirm(\'Are you sure?\');" title="%s">%s</a>', wp_nonce_url( admin_url( 'admin-post.php?action=6amtech-task-delete-contact&id=' . $item->id ), '6amtech-task-delete-contact' ), $item->id, __( 'Delete', '6amtech_task' ), __( 'Delete', '6amtech_task' ) );

		return sprintf(
			'<a href="%1$s"><strong>%2$s</strong></a> %3$s',
			admin_url( 'admin.php?page=6amtech_task_contact_list&action=view' . $item->id ),
			$item->name,
			$this->row_actions( $actions )
		);
	}

	/**
	 * Render the checkbox column
	 *
	 * @param object $item The current item.
	 *
	 * @return string
	 */
	protected function column_cb( $item ) {
		return sprintf(
			'<input type="checkbox" name="contact_list[]" value="%s" />',
			$item->id
		);
	}

	/**
	 * Display the table
	 *
	 * @return void
	 */
	public function prepare_items() {
		$column   = $this->get_columns();
		$hidden   = [];
		$sortable = $this->get_sortable_columns();

		$this->_column_headers = [ $column, $hidden, $sortable ];
		$per_page              = 5;
		$current_page          = $this->get_pagenum();
		$offset                = ( $current_page - 1 ) * $per_page;

		$args = [
			'number' => $per_page,
			'offset' => $offset,
		];

		if ( isset( $_REQUEST['orderby'], $_REQUEST['order'] )     ) {
			$args['orderby'] = $_REQUEST['orderby'];
			$args['order']   = $_REQUEST['order'];
		}

		// Fetch the items from the database
		$this->items = contact_list_get_details( $args );

		$this->set_pagination_args( [
			'total_items' => contact_list_get_count(),
			'per_page'    => 5,
		] );
	}
}
