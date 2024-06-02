<?php
/**
 *  Marquee Block
 *
 * @package    StorePress/MarqueeBlock
 *
 * @wordpress-plugin
 * Plugin Name:       Marquee Block
 * Plugin URI:        https://storepress.com/marquee-block/
 * Description:       A starter WordPress plugin scaffold which comes pre-configured for block development, admin dashboard with settings and standard plugin code.
 * Version:           1.0.0
 * Requires at least: 6.3
 * Requires PHP:      7.4
 * Author:            Emran Ahmed.
 * Author URI:        https://storepress.com/
 * Text Domain:       marquee-block
 * License:           GPL v3 or later
 * License URI:       https://www.gnu.org/licenses/gpl-3.0.html
 * Domain Path:       /languages
 */

/**
 * Bootstrap the plugin.
 */

defined( 'ABSPATH' ) || die( 'Keep Silent' );

use StorePress\MarqueeBlock\Plugin;

if ( ! defined( 'MARQUEE_BLOCK_PLUGIN_FILE' ) ) {
	define( 'MARQUEE_BLOCK_PLUGIN_FILE', __FILE__ );
}

// Include the Plugin class.
if ( ! class_exists( 'StorePress\MarqueeBlock\Plugin' ) ) {
	require_once plugin_dir_path( __FILE__ ) . '/includes/Plugin.php';
}

/**
 * The main function that returns the Plugin class
 *
 * @return Plugin
 * @since 1.0.0
 */
function marquee_block_plugin(): Plugin {
	// Include the main class.
	return Plugin::instance();
}

// Get the plugin running.
add_action( 'plugins_loaded', 'marquee_block_plugin' );
