<?php
	/**
	 * Plugin Deactivation Service Provider Class File.
	 *
	 * Manages service registration and bootstrapping for the plugin's dependency
	 * injection container. Handles the lifecycle of plugin services including
	 * registration and initialization.
	 *
	 * @package    StorePress/MarqueeBlock
	 * @since      1.0.0
	 * @version    1.0.0
	 */

	declare( strict_types=1 );

	namespace StorePress\MarqueeBlock\ServiceProviders;

	defined( 'ABSPATH' ) || die( 'Keep Silent' );

	use StorePress\AdminUtils\Abstracts\AbstractServiceProvider;
	use StorePress\AdminUtils\Traits\SingletonTrait;
	use StorePress\MarqueeBlock\Integrations\DeactivationFeedback;
	use StorePress\MarqueeBlock\Traits\UtilityHelperTrait;

	/**
	 * Plugin Service Provider Class.
	 *
	 * Extends AbstractServiceProvider to manage plugin-specific service registration
	 * and bootstrapping. Uses the singleton pattern to ensure a single provider
	 * instance manages all service lifecycle operations. Registers the Updater
	 * service and handles its initialization during the boot phase.
	 *
	 * @name DeactivationServiceProvider
	 */
class DeactivationServiceProvider extends AbstractServiceProvider {

	use SingletonTrait;
	use UtilityHelperTrait;

	/**
	 * Register services with the container.
	 *
	 * Registers the Updater service as a factory closure that instantiates
	 * the Updater with the caller (Init) instance. Called during the service
	 * provider initialization phase before boot().
	 *
	 * @return void
	 * @since 1.0.0
	 */
	public function register(): void {

		$this->get_container()->register(
			DeactivationFeedback::class,
			function () {
				return DeactivationFeedback::instance();
			}
		);
	}

	/**
	 * Bootstrap services after all providers are registered.
	 *
	 * Initializes registered services by resolving the Updater service
	 * from the container. Called after all services are registered to
	 * perform any necessary setup or initialization logic.
	 *
	 * @return void
	 * @since 1.0.0
	 */
	public function boot(): void {
		$this->get_container()->get( DeactivationFeedback::class );
	}
}
