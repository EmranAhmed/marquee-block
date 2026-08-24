<?php
	/**
	 *  Marquee Block
	 *
	 * @package    StorePress/MarqueeBlock
	 *
	 * @wordpress-plugin
	 * Plugin Name:       Marquee Block
	 * Plugin URI:        https://wordpress.org/plugins/marquee-block
	 * Description:       Marquee block adds a touch of movement and interactivity to your site and help to capture attention and engage your site visitors in a unique way.
	 * Version:           2.1.0
	 * Requires at least: 6.4
	 * Requires PHP:      7.4
	 * Author:            Emran Ahmed
	 * Author URI:        https://storepress.com/
	 * Text Domain:       marquee-block
	 * License:           GPL-2.0-or-later
	 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
	 * Domain Path:       /languages
	 */

	/**
	 * Bootstrap the plugin.
	 */

	declare( strict_types=1 );

	defined( 'ABSPATH' ) || die( 'Keep Silent' );

	use StorePress\MarqueeBlock\Plugin;

	define( 'STOREPRESS_MARQUEE_BLOCK_PLUGIN_FILE', __FILE__ );

	// Include the Plugin class.
if ( ! class_exists( Plugin::class, false ) ) {
	require_once plugin_dir_path( __FILE__ ) . 'includes/Plugin.php';
}

	/**
	 * Plugin Instance.
	 *
	 * @return Plugin
	 */
function marquee_block_plugin(): Plugin {

	// Include the main class.
	return Plugin::instance();
}

	/**
	 * Plugin Init.
	 *
	 * @return void
	 */
function marquee_block_plugin_init() {
	marquee_block_plugin();
}

	// Get the plugin running.
	add_action( 'plugins_loaded', 'marquee_block_plugin_init' );
