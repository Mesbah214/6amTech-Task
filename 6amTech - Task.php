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

// phpcs:ignore WordPress.NamingConventions.ValidFunctionName.FunctionNameInvalid
// phpcs:ignore PEAR.NamingConventions.ValidClassName.StartWithCapital
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
		register_deactivation_hook( __FILE__, [ $this, 'deactivate' ] );
		add_action( 'plugins_loaded', [ $this, 'init_plugin' ] );
	}

	/**
	 * Defines the constants for the plugin
	 *
	 * @return void
	 */
	public function defined_constants() {
		define( '_6AMTECH_VERSION', self::VERSION );
		define( '_6AMTECH_FILE', __FILE__ );
		define( '_6AMTECH_PATH', __DIR__ );
		define( '_6AMTECH_URL', plugins_url( '', _6AMTECH_FILE ) );
		define( '_6AMTECH_ASSETS', _6AMTECH_URL . '/assets' );
	}

	/**
	 * Do stuff on plugin activation
	 *
	 * @return void
	 */
	public function activate() {
		$installer = new _6amTech\Task\Installer();
		$installer->run();
	}

	/**
	 * Do stuff on plugin activation
	 *
	 * @return void
	 */
	public function deactivate() {
		$installer = new _6amTech\Task\Uninstall();
		$installer->run();
	}

	public function init_plugin() {
		new _6amTech\Task\Assets();
		load_plugin_textdomain( '6amtech_task', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

		if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
			new _6amTech\Task\Ajax();
		}

		if ( is_admin() ) {
			new _6amTech\Task\Admin();
		} else {
			new _6amTech\Task\Frontend();
		}

		new _6amTech\Task\API();
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
// phpcs:ignore WordPress.NamingConventions.ValidFunctionName.FunctionNameInvalid
function _6amTechTask() {
	return _6amTechTask::init();
}

/**
 * Start the plugin
 */
_6amTechTask();
