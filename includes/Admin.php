<?php

namespace _6amTech\Task;

class Admin {
	public function __construct() {
		new Admin\Menu();
		new Admin\Message();
		new Admin\ShowMessage();
	}
}
