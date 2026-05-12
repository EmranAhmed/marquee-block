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

	use StorePress\MarqueeBlock\ServiceProviders\BlocksServiceProvider;
	use StorePress\MarqueeBlock\ServiceProviders\DeactivationServiceProvider;
	use StorePress\MarqueeBlock\ServiceProviders\ServiceProviders;

	defined( 'ABSPATH' ) || die( 'Keep Silent' );

	/**
	 * Main Plugin Class.
	 */
class Plugin {

	/**
	 * Absolute path to the main plugin file.
	 *
	 * @since 1.0.0
	 * @var   string
	 */
	protected string $plugin_file;

	/**
	 * Returns the singleton Plugin instance, creating it on first call.
	 *
	 * @return static
	 * @since  1.0.0
	 */
	public static function instance(): self {
		static $instance = null;

		return $instance ??= new self();
	}

	/**
	 * Initialize the plugin.
	 *
	 * @since 1.0.0
	 */
	protected function __construct() {
		$this->includes();
		$this->hooks();
		$this->init();

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
	 * Loads the Composer autoloader and plugin utility functions.
	 *
	 * @return void
	 * @since  1.0.0
	 * @see    init()
	 */
	public function includes(): void {

		require_once __DIR__ . '/functions.php';

		$vendor_path = untrailingslashit( plugin_dir_path( $this->get_plugin_file() ) ) . '/vendor';

		if ( file_exists( $vendor_path . '/autoload_packages.php' ) ) {
			require_once $vendor_path . '/autoload_packages.php';
		}
	}

	/**
	 * Hooks.
	 *
	 * @return void
	 * @since 1.0.0
	 */
	public function hooks(): void {
	}

	/**
	 * Boots all service providers.
	 *
	 * @return void
	 * @since  1.0.0
	 * @see    service_providers()
	 */
	public function init(): void {
		$this->service_providers();
	}

	// =====================================================================
	// Plugin Identity Methods
	// =====================================================================

	/**
	 * Returns the absolute path to the main plugin file.
	 *
	 * @return  string
	 * @since   1.0.0
	 * @example Plugin::instance()->get_plugin_file(); // '/path/to/variation-duplicator-for-woocommerce.php'
	 */
	public function get_plugin_file(): string {
		return get_plugin_file();
	}

	// =====================================================================
	// Service Provider Registration Methods
	// =====================================================================

	/**
	 * Returns all service provider class names to register and boot.
	 *
	 * @return  array<int, class-string>
	 * @since   1.0.0
	 * @see     service_providers()
	 * @example Plugin::instance()->get_service_providers();
	 */
	public function get_service_providers(): array {
		$service_providers = array(
			BlocksServiceProvider::class,
			DeactivationServiceProvider::class,
		);

		/**
		 * Filters the list of service provider class names to register and boot.
		 *
		 * @param array<int, class-string> $service_providers Service provider class names.
		 * @param Plugin                   $plugin            Plugin instance.
		 *
		 * @since 2.0.0
		 */
		return apply_filters( 'storepress_marquee_block_service_providers', $service_providers, $this );
	}

	/**
	 * Instantiates and returns the ServiceProviders runner.
	 *
	 * @return  ServiceProviders
	 * @since   1.0.0
	 * @see     get_service_providers()
	 * @example Plugin::instance()->service_providers();
	 */
	public function service_providers(): ServiceProviders {
		return ServiceProviders::instance( $this->get_service_providers() );
	}
}
