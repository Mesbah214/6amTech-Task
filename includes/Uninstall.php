<?php

namespace _6amTech\Task;

class Uninstall {
	public function run() {
		$this->uninstall();
	}

	public function uninstall() {
		global $wpdb;

		$table_name = $wpdb->prefix . 'contact_list';

		$sql = "DROP TABLE IF EXISTS {$table_name};";
		$wpdb->query( $sql );

		delete_option( 'welcome_message' );
	}
}
