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
 * Version:           1.0.2
 * Requires at least: 6.4
 * Requires PHP:      7.4
 * Author:            Emran Ahmed
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

if ( ! defined( 'STOREPRESS_MARQUEE_BLOCK_PLUGIN_FILE' ) ) {
	define( 'STOREPRESS_MARQUEE_BLOCK_PLUGIN_FILE', __FILE__ );
}

// Include the Plugin class.
if ( ! class_exists( 'StorePress\MarqueeBlock\Plugin' ) ) {
	require_once plugin_dir_path( __FILE__ ) . '/includes/Plugin.php';
}

/**
 * The function that always returns the same instance to ensure only one instance exists in the global scope at any time.
 *
 * @return Plugin
 * @since 1.0.0
 */
function marquee_block_plugin(): Plugin {
	return Plugin::instance();
}

/**
 * Plugin Init.
 *
 * @return void
 * @since 1.0.0
 */
function marquee_block_plugin_init() {
	// Load Plugin TextDomain.
	load_plugin_textdomain( 'marquee-block', false, plugin_dir_path( __FILE__ ) . 'languages' );

	// Init Plugin.
	marquee_block_plugin();
}

// Get the plugin running.
add_action( 'plugins_loaded', 'marquee_block_plugin_init' );
