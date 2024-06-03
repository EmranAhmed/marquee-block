<?php
	/**
	 * Main Plugin Class.
	 *
	 * @package    StorePress/MarqueeBlock
	 * @since      1.0.0
	 */

	namespace StorePress\MarqueeBlock;

	defined( 'ABSPATH' ) || die( 'Keep Silent' );

	use Exception;

	/**
	 * Class Plugin.
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
			$this->trigger_error( __METHOD__, $e->getMessage() );
		}

		/**
		 * Action to signal that Plugin has finished loading.
		 *
		 * @param Plugin $this Plugin Object.
		 *
		 * @since 1.0.0
		 */
		do_action( 'marquee_block_plugin_loaded', $this );
	}

	/**
	 * Plugin Absolute File.
	 *
	 * @return string
	 * @since 1.0.0
	 */
	public function get_plugin_file(): string {
		return constant( 'MARQUEE_BLOCK_PLUGIN_FILE' );
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
	 * Set constant if not defined and prevent reassign
	 *
	 * @param string $name  Constant name.
	 * @param mixed  $value Constant value.
	 *
	 * @return void.
	 * @since 1.0.0
	 */
	public function define( string $name, $value ) {
		if ( ! defined( $name ) ) {
			// phpcs:ignore
			define( $name, $value );
		}
	}

	/**
	 * Includes.
	 *
	 * @return bool
	 * @throws Exception When class files loading fails.
	 * @since 1.0.0
	 */
	public function includes(): bool {

		if ( file_exists( $this->vendor_path() . '/autoload.php' ) ) {
			require_once $this->vendor_path() . '/autoload.php';
			require_once __DIR__ . '/functions.php';

			return true;
		}

		throw new Exception( '"vendor/autoload.php" file missing. Please run `composer install`' );
	}

	/**
	 * Initialize Classes.
	 *
	 * @since 1.0.0
	 */
	public function init() {

		// Setup BLocks.
		$this->get_blocks();

		// Set up cache management.
		// new Extension_Cache();.

		// Initialize REST API.
		// new Extension_REST_API();.

		// Set up email management.
		// new Extension_Email_Manager();.
	}

	/**
	 * Hooks.
	 *
	 * @return void
	 * @since 1.0.0
	 */
	public function hooks() {
		// Register with hook.
		add_action( 'init', array( $this, 'language' ), 1 );
	}

	/**
	 * Language
	 *
	 * @return void
	 * @since 1.0.0
	 */
	public function language() {
		load_plugin_textdomain( 'marquee-block', false, $this->plugin_path() . '/languages' );
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
		return dirname( plugin_basename( $this->get_plugin_file() ) );
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

	/**
	 * Generates a user-level error/warning/notice/deprecation message.
	 *
	 * Generates the message when `WP_DEBUG` is true.
	 *
	 * @param string $function_name The function that triggered the error.
	 * @param string $message       The message explaining the error.
	 *                              The message can contain allowed HTML 'a' (with href), 'code',
	 *                              'br', 'em', and 'strong' tags and http or https protocols.
	 *                              If it contains other HTML tags or protocols, the message should be escaped
	 *                              before passing to this function to avoid being stripped {@see wp_kses()}.
	 *
	 * @since 1.0.0
	 */
	public function trigger_error( string $function_name, string $message ) {

		// Bail out if WP_DEBUG is not turned on.
		if ( ! WP_DEBUG ) {
			return;
		}

		if ( function_exists( 'wp_trigger_error' ) ) {
			wp_trigger_error( $function_name, $message );
		} else {

			if ( ! empty( $function_name ) ) {
				$message = sprintf( '%s(): %s', $function_name, $message );
			}

			// phpcs:ignore
			trigger_error( wp_kses_post( $message ) );
		}
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
