<?php
	/**
	 * Utility Helper Trait File.
	 *
	 * Provides shared helper methods for accessing the plugin file path and DI container.
	 *
	 * @package    StorePress/MarqueeBlock
	 * @since      1.0.0
	 * @version    1.0.0
	 */

	namespace StorePress\MarqueeBlock\Traits;

	defined( 'ABSPATH' ) || die( 'Keep Silent' );

	use StorePress\AdminUtils\Traits\PluginCommonTrait;
	use StorePress\MarqueeBlock\Containers\Container;
	use function StorePress\MarqueeBlock\get_container;
	use function StorePress\MarqueeBlock\get_plugin_file;

	/**
	 * Shared helpers for plugin file path and DI container access.
	 *
	 * Mix into any class that needs the plugin entry-file path or the
	 * global {@see Container} instance without direct function imports.
	 *
	 * @name UtilityHelperTrait
	 * @since 1.0.0
	 *
	 * @example use UtilityHelperTrait; // in any plugin class
	 * @example $container = $this->get_container();
	 */
trait UtilityHelperTrait {

	use PluginCommonTrait;

	// =====================================================================
	// Plugin Identity Methods
	// =====================================================================

	/**
	 * Returns the absolute path to the plugin entry file.
	 *
	 * @since   1.0.0
	 * @return  string
	 * @see     get_container()
	 * @example $this->plugin_file(); // '/path/to/marquee-block.php'
	 */
	public function plugin_file(): string {
		return get_plugin_file();
	}

	// =====================================================================
	// Container Access Methods
	// =====================================================================

	/**
	 * Returns the plugin's DI container instance.
	 *
	 * @since   1.0.0
	 * @return  Container
	 * @see     plugin_file()
	 * @example $this->get_container()->get( Settings::class );
	 */
	public function get_container(): Container {
		return get_container();
	}
}
