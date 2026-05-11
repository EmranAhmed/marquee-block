<?php
	/**
	 * Blocks Service Provider Class File.
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
	use StorePress\MarqueeBlock\Features\Blocks;
	use StorePress\MarqueeBlock\Traits\UtilityHelperTrait;

	/**
	 * Plugin Service Provider Class.
	 *
	 * Extends AbstractServiceProvider to manage plugin-specific service registration
	 * and bootstrapping. Uses the singleton pattern to ensure a single provider
	 * instance manages all service lifecycle operations. Registers the Updater
	 * service and handles its initialization during the boot phase.
	 *
	 * @name BlocksServiceProvider
	 */
class BlocksServiceProvider extends AbstractServiceProvider {

	use SingletonTrait;
	use UtilityHelperTrait;

	// =====================================================================
	// Service Lifecycle Methods
	// =====================================================================

	/**
	 * Registers the Blocks service factory into the DI container.
	 *
	 * @since  1.0.0
	 * @return void
	 * @see    boot()
	 */
	public function register(): void {

		$this->get_container()->register(
			Blocks::class,
			function () {
				return Blocks::instance();
			}
		);
	}

	/**
	 * Resolves and boots the Blocks service from the DI container.
	 *
	 * @since  2.0.0
	 * @return void
	 * @see    register()
	 */
	public function boot(): void {
		$this->get_container()->get( Blocks::class );
	}
}
