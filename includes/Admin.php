<?php

namespace _6amTech\Task;

class Admin {
	public function __construct() {
		$add_new_contact = new Admin\AddNewContact();
		$this->dispatch_action( $add_new_contact );

		new Admin\Menu( $add_new_contact );
		new Admin\Message();
	}

	public function dispatch_action( $add_new_contact ) {
		add_action( 'admin_init', [ $add_new_contact, 'submit_form' ] );
		add_action( 'admin_post_6amtech-task-delete-contact', [ $add_new_contact, 'delete_contact' ] );
	}
}
