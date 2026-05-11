<?php
/**
 * Plugin Service Container.
 *
 * @package StorePress\MarqueeBlock\Containers
 * @since   2.0.0
 * @version 2.0.0
 */

	declare( strict_types=1 );

	namespace StorePress\MarqueeBlock\Containers;

	defined( 'ABSPATH' ) || die( 'Keep Silent' );

	use StorePress\AdminUtils\ServiceContainers\ServiceContainer;
	use StorePress\AdminUtils\Traits\SingletonTrait;

/**
 * Plugin service container.
 *
 * Singleton DI container for the Variation Duplicator plugin.
 *
 * @name    Container
 * @phpstan-use SingletonTrait<Container>
 *
 * @example
 * $container = Container::instance();
 * $service   = $container->get( 'my_service' );
 *
 * @since 2.0.0
 */
class Container extends ServiceContainer {
	use SingletonTrait;
}
