<?php
	/**
	 * Uninstall Plugin
	 *
	 * Deletes all plugin settings.
	 *
	 * @package    StorePress/MarqueeBlock
	 * @since      1.0.0
	 */

	namespace StorePress\MarqueeBlock;

	// Exit if accessed directly.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

	// Load main plugin file.
	require_once 'marquee-block.php';

	global $wpdb;

	$storepress_settings = get_option( 'plugin_settings' );

	// Delete all settings.
if ( $storepress_settings['plugin_settings']['remove_on_uninstall'] ) {
	delete_option( 'plugin_settings' );
}
