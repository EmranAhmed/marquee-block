<?php
/**
 * Main Plugin Class File.
 *
 * @package    StorePress/MarqueeBlock
 * @since      1.0.0
 * @version    1.0.0
 */

declare( strict_types=1 );

namespace StorePress\MarqueeBlock;

defined( 'ABSPATH' ) || die( 'Keep Silent' );

use Exception;

/**
 * Main Plugin Class.
 */
class Plugin {

	/**
	 * Return singleton instance of Plugin.
	 * The instance will be created if it does not exist yet.
	 *
	 * @return self The main instance.
	 * @since 1.0.0
	 */
	public static function instance(): self {
		static $instance = null;
		if ( is_null( $instance ) ) {
			$instance = new self();
		}

		return $instance;
	}

	/**
	 * Initialise the plugin.
	 *
	 * @since 1.0.0
	 */
	protected function __construct() {
		try {
			$this->includes();
			$this->hooks();
			$this->init();
		} catch ( Exception $e ) {
			$message = sprintf( '<strong>%s:</strong> %s', $this->name(), $e->getMessage() );
			add_action(
				'admin_notices',
				function () use ( $message ) {
					printf( '<div class="notice notice-error"><p>%s</p></div>', wp_kses_data( $message ) );
				},
				50
			);
		}

		/**
		 * Action to signal that Plugin has finished loading.
		 *
		 * @param Plugin $instance Plugin Object.
		 *
		 * @since 1.0.0
		 */
		do_action( 'storepress_marquee_block_plugin_loaded', $this );
	}

	/**
	 * Plugin Absolute File.
	 *
	 * @return string
	 * @since 1.0.0
	 */
	public function get_plugin_file(): string {
		return constant( 'STOREPRESS_MARQUEE_BLOCK_PLUGIN_FILE' );
	}

	/**
	 * Get Plugin Name.
	 *
	 * @return string
	 * @since 1.0.0
	 */
	public function name(): string {
		static $names;

		if ( is_null( $names ) ) {
			$names = get_file_data( $this->get_plugin_file(), array( 'Plugin Name' ) );
		}

		return esc_attr( $names[0] );
	}

	/**
	 * Get Plugin Version.
	 *
	 * @return string
	 * @since 1.0.0
	 */
	public function version(): string {
		static $versions;

		if ( is_null( $versions ) ) {
			$versions = get_file_data( $this->get_plugin_file(), array( 'Version' ) );
		}

		return esc_attr( $versions[0] );
	}

	/**
	 * Includes.
	 *
	 * @return bool
	 * @throws Exception When class files loading fails.
	 * @since 1.0.0
	 */
	public function includes(): bool {
		if ( file_exists( $this->vendor_path() . '/autoload_packages.php' ) ) {
			require_once $this->vendor_path() . '/autoload_packages.php';
			require_once __DIR__ . '/functions.php';

			return true;
		}

		throw new Exception( '"vendor/autoload_packages.php" file missing. Please run `composer install`' );
	}

	/**
	 * Initialize Classes.
	 *
	 * @return void
	 * @since 1.0.0
	 */
	public function init() {
		// Setup BLocks.
		$this->get_blocks();
	}

	/**
	 * Hooks.
	 *
	 * @return void
	 * @since 1.0.0
	 */
	public function hooks() {
		// Register with hook.
		add_action( 'init', array( $this, 'load_translations' ) );
	}

	/**
	 * Load Plugin Translation Files.
	 *
	 * @return void
	 */
	public function load_translations() {
		load_plugin_textdomain( 'marquee-block', false, $this->plugin_dirname() . '/languages' );
	}

	/**
	 * Get Plugin basename directory name
	 *
	 * @return string
	 * @since 1.0.0
	 */
	public function basename(): string {
		return wp_basename( dirname( $this->get_plugin_file() ) );
	}

	/**
	 * Get Plugin basename
	 *
	 * @return string
	 * @since 1.0.0
	 */
	public function plugin_basename(): string {
		return plugin_basename( $this->get_plugin_file() );
	}

	/**
	 * Get Plugin directory name
	 *
	 * @return string
	 * @since 1.0.0
	 */
	public function plugin_dirname(): string {
		return untrailingslashit( dirname( plugin_basename( $this->get_plugin_file() ) ) );
	}

	/**
	 * Get Plugin directory path
	 *
	 * @return string
	 * @since 1.0.0
	 */
	public function plugin_path(): string {
		return untrailingslashit( plugin_dir_path( $this->get_plugin_file() ) );
	}

	/**
	 * Get Plugin directory url
	 *
	 * @return string
	 * @since 1.0.0
	 */
	public function plugin_url(): string {
		return untrailingslashit( plugin_dir_url( $this->get_plugin_file() ) );
	}

	/**
	 * Get Plugin image url
	 *
	 * @return string
	 * @since 1.0.0
	 */
	public function images_url(): string {
		return untrailingslashit( plugin_dir_url( $this->get_plugin_file() ) . 'images' );
	}

	/**
	 * Get Assets URL
	 *
	 * @return string
	 * @since 1.0.0
	 */
	public function assets_url(): string {
		return untrailingslashit( plugin_dir_url( $this->get_plugin_file() ) . 'assets' );
	}

	/**
	 * Get Asset Absolute Path
	 *
	 * @return string
	 * @since 1.0.0
	 */
	public function assets_path(): string {
		return $this->plugin_path() . '/assets';
	}

	/**
	 * Get Vendor path
	 *
	 * @return string
	 * @since 1.0.0
	 */
	public function vendor_path(): string {
		return $this->plugin_path() . '/vendor';
	}

	/**
	 * Get Vendor URL
	 *
	 * @return string
	 * @since 1.0.0
	 */
	public function vendor_url(): string {
		return untrailingslashit( plugin_dir_url( $this->get_plugin_file() ) . 'vendor' );
	}

	/**
	 * Get Node Modules build URL
	 *
	 * @return string
	 * @since 1.0.0
	 */
	public function build_url(): string {
		return untrailingslashit( plugin_dir_url( $this->get_plugin_file() ) . 'build' );
	}

	/**
	 * Get Node Modules build path
	 *
	 * @return string
	 * @since 1.0.0
	 */
	public function build_path(): string {
		return $this->plugin_path() . '/build';
	}

	/**
	 * Get Asset file make time for versioning.
	 *
	 * @param string $file Asset file name.
	 *
	 * @return int asset file make time.
	 * @since 1.0.0
	 */
	public function assets_version( string $file ): int {
		return filemtime( $this->assets_path() . $file );
	}

	/**
	 * Get includes directory absolute path
	 *
	 * @return string
	 * @since 1.0.0
	 */
	public function include_path(): string {
		return untrailingslashit( plugin_dir_path( $this->get_plugin_file() ) . 'includes' );
	}

	/**
	 * Get templates directory absolute path
	 *
	 * @return string
	 * @since 1.0.0
	 */
	public function template_path(): string {
		return untrailingslashit( plugin_dir_path( $this->get_plugin_file() ) . 'templates' );
	}

	// Add feature classes from here...

	/**
	 * Get Block Instance.
	 *
	 * @return Blocks
	 * @since 1.0.0
	 */
	public function get_blocks(): Blocks {
		return Blocks::instance();
	}
}
