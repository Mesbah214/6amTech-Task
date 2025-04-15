<?php

namespace _6amTech\Task;

class Frontend {
    public function __construct() {
        new Frontend\ContactListShortcode();
        new Frontend\AddNewContactShortcode();
    }
}