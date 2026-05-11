<?php
	/**
	 * Service Providers Runner File.
	 *
	 * Iterates and bootstraps all registered service providers.
	 *
	 * @package    StorePress/MarqueeBlock
	 * @since      1.0.0
	 * @version    1.0.0
	 */

	declare( strict_types=1 );

	namespace StorePress\MarqueeBlock\ServiceProviders;

	use StorePress\AdminUtils\Traits\SingletonTrait;

	defined( 'ABSPATH' ) || die( 'Keep Silent' );

	/**
	 * Bootstraps all registered service providers.
	 *
	 * Accepts an array of service provider class names and calls
	 * register() then boot() on each in sequence.
	 *
	 * @name    ServiceProviders
	 * @package StorePress/Variation_Duplicator_For_WooCommerce
	 * @since   1.0.0
	 *
	 * @phpstan-use SingletonTrait<ServiceProviders>
	 *
	 * @example new ServiceProviders( [ BlocksServiceProvider::class, BlockSupportServiceProvider::class ] );
	 * @example ServiceProviders::get_instance()->get_providers();
	 */
class ServiceProviders {

	use SingletonTrait;

	/**
	 * Registered service provider class names.
	 *
	 * @var array<int, class-string>
	 */
	protected array $service_providers = array();

	// =====================================================================
	// Service Lifecycle Methods
	// =====================================================================

	/**
	 * Stores the provider list and immediately boots all providers via init().
	 *
	 * @param  array<int, class-string> $service_providers List of service provider class names.
	 *
	 * @since  1.0.0
	 * @see    init()
	 */
	public function __construct( array $service_providers ) {
		$this->service_providers = $service_providers;
		$this->init();
	}

	/**
	 * Returns all registered service provider class names.
	 *
	 * @since   1.0.0
	 * @return  array<int, class-string>
	 * @see     init()
	 * @example ServiceProviders::instance()->get_providers(); // [ BlocksServiceProvider::class, ... ]
	 */
	public function get_providers(): array {
		return $this->service_providers;
	}

	// =====================================================================
	// Service Provider Registration Methods
	// =====================================================================

	/**
	 * Instantiates, registers, and boots each service provider in order.
	 *
	 * @since  1.0.0
	 * @return void
	 * @see    get_providers()
	 */
	private function init(): void {
		$providers = $this->get_providers();

		foreach ( $providers as $provider ) {
			$provider::instance();
			$provider::instance()->register();
			$provider::instance()->boot();
		}
	}
}
