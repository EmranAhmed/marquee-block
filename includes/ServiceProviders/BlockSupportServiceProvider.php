<?php
	/**
	 * Block Support Service Provider Class File.
	 *
	 * Registers the BlockSupports factory into the DI container for on-demand
	 * instantiation with per-block attribute sets.
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
	use StorePress\MarqueeBlock\Services\BlockSupports;
	use StorePress\MarqueeBlock\Traits\UtilityHelperTrait;

	/**
	 * Service provider for the BlockSupports factory.
	 *
	 * Binds a factory closure for {@see BlockSupports} so callers can resolve
	 * a new instance per block by passing an attributes array.
	 *
	 * @name    BlockSupportServiceProvider
	 * @package StorePress/MarqueeBlock
	 * @since   1.0.0
	 *
	 * @phpstan-use SingletonTrait<BlockSupportServiceProvider>
	 *
	 * @example BlockSupportServiceProvider::instance()->register();
	 * @example $factory = $container->get( BlockSupports::class ); $supports = $factory( $attributes );
	 */
class BlockSupportServiceProvider extends AbstractServiceProvider {

	use SingletonTrait;
	use UtilityHelperTrait;

	// =====================================================================
	// Service Lifecycle Methods
	// =====================================================================

	/**
	 * Registers the BlockSupports factory closure into the DI container.
	 *
	 * The resolved value is a callable: `fn( array $attributes ): BlockSupports`.
	 *
	 * @since  1.0.0
	 * @return void
	 * @see    boot()
	 */
	public function register(): void {

		$this->get_container()->register(
			BlockSupports::class,
			function () {
				return static function ( array $attributes ): BlockSupports {
					return new BlockSupports( $attributes );
				};
			}
		);
	}

	/**
	 * Boots the BlockSupports service — no eager initialisation required.
	 *
	 * @since  1.0.0
	 * @return void
	 * @see    register()
	 */
	public function boot(): void {
	}
}
