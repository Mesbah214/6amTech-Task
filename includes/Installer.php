<?php

namespace _6amTech\Task;

class Installer {
	/**
	 * Run the installer.
	 *
	 * @return void
	 */
	public function run() {
		$this->contact_list_table();
		$this->update_version();
	}

    /**
     * Create the contact list table.
     *
     * @return void
     */
	public function contact_list_table() {
		global $wpdb;

		$table_name      = $wpdb->prefix . 'contact_list';
		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE IF NOT EXISTS {$table_name} (
            id INT NOT NULL AUTO_INCREMENT,
            name varchar(100) NOT NULL,
            email varchar(255) NOT NULL UNIQUE,
            phone varchar(20) DEFAULT NULL,
            address text DEFAULT NULL,
            created_by bigint(20) unsigned NOT NULL,
            created_at datetime NOT NULL,
            PRIMARY KEY (id)
        ) {$charset_collate}";

		if ( ! function_exists( 'dbDelta' ) ) {
			require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		}

		dbDelta( $sql );
	}

	public function update_version() {
		update_option( '6amTech_version', _6amTech_VERSION );
	}

	// public function uninstall() {
	// 	global $wpdb;

	// 	$table_name = $wpdb->prefix . '6amtech_task_contact_list';

	// 	$sql = "DROP TABLE IF EXISTS {$table_name};";
	// 	$wpdb->query( $sql );
	// }
}
