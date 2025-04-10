<?php

/**
 * @wordpress-plugin
 * Plugin Name:       6amTech - Task
 * Plugin URI:        https://6amTech-Task.xyz
 * Description:       Print welcome message to the front page
 * Version:           1.0.0
 * Author:            Mesbah
 * Author URI:        https://https://mesbah214.github.io/portfolio/
 * License:           MIT License
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       6amtech_task
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

require_once __DIR__ . '/vendor/autoload.php';

final class _6amTechTask {
	/**
	 * Plugin version
	 *
	 * @var string
	 */
	public const VERSION = '1.0.0';

	private function __construct() {
		$this->defined_constants();
		register_activation_hook( __FILE__, [ $this, 'activate' ] );
		add_action( 'plugins_loaded', [ $this, 'init_plugin' ] );
	}

	/**
	 * Defines the constants for the plugin
	 *
	 * @return void
	 */
	public function defined_constants() {
		define( '_6amTech_VERSION', self::VERSION );
		define( '_6amTech_FILE', __FILE__ );
		define( '_6amTech_PATH', __DIR__ );
		define( '_6amTech_URL', plugins_url( '', _6amTech_FILE ) );
		define( '_6amTech_ASSETS', _6amTech_URL . '/assets' );
	}

	/**
	 * Do stuff on plugin activation
	 *
	 * @return void
	 */
	public function activate() {
		update_option( '6amTech_version', _6amTech_VERSION );
	}

	public function init_plugin() {
	}

	/**
	 * Intializes singleton instance
	 *
	 * @return \_6amTechTask
	 */
	public static function init() {
		static $instance = false;

		if ( ! $instance ) {
			$instance = new self();
		}

		return $instance;
	}
}

/**
 * Returns the main instance of _6amTechTask
 *
 * @return \_6amTechTask
 */
function _6amTechTask() {
	return _6amTechTask::init();
}

/**
 * Start the plugin
 */
_6amTechTask();
