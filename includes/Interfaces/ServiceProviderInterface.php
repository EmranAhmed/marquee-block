<?php
	/**
	 * Service Provider Interface File.
	 *
	 * Defines the contract every plugin service provider must fulfil so the
	 * service provider runner can treat them uniformly during bootstrap.
	 *
	 * @package    StorePress/MarqueeBlock
	 * @since      2.1.0
	 * @version    1.0.0
	 */

	declare( strict_types=1 );

	namespace StorePress\MarqueeBlock\Interfaces;

	defined( 'ABSPATH' ) || die( 'Keep Silent' );

	/**
	 * Service Provider Interface.
	 *
	 * Describes the two phase lifecycle used by the plugin bootstrap: every
	 * provider first registers its service factories into the DI container,
	 * then boots them once all providers have been registered. Implementations
	 * are expected to be singletons, which the runner resolves through
	 * instance() before invoking register() and boot().
	 *
	 * @name ServiceProviderInterface
	 *
	 * @since 1.0.0
	 *
	 * @example
	 * $provider = MyServiceProvider::instance();
	 * $provider->register();
	 * $provider->boot();
	 *
	 * @see \StorePress\MarqueeBlock\ServiceProviders\ServiceProviders
	 */
interface ServiceProviderInterface {

	// =====================================================================
	// Service Lifecycle Methods
	// =====================================================================

	/**
	 * Returns the singleton instance of the service provider.
	 *
	 * The instance is created on first call and reused afterward, so the
	 * runner can call register() and boot() on the same object.
	 *
	 * @return self The shared service provider instance.
	 *
	 * @since  1.0.0
	 * @see    \StorePress\AdminUtils\Traits\SingletonTrait::instance()
	 */
	public static function instance(): self;

	/**
	 * Registers the provider's service factories into the DI container.
	 *
	 * Runs before boot() and must only bind definitions; services should not
	 * be resolved or hooked into WordPress at this stage.
	 *
	 * @return void
	 *
	 * @since  1.0.0
	 * @see    boot()
	 */
	public function register(): void;

	/**
	 * Resolves and boots the services registered by this provider.
	 *
	 * Runs after register() and is the place to pull services out of the
	 * container and wire them into WordPress.
	 *
	 * @return void
	 *
	 * @since  1.0.0
	 * @see    register()
	 */
	public function boot(): void;
}
