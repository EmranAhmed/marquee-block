<?php
/**
 * Utility Functions.
 *
 * @package    StorePress/MarqueeBlock
 * @since      1.0.0
 * @version    1.0.0
 */

declare( strict_types=1 );

namespace StorePress\MarqueeBlock;

defined( 'ABSPATH' ) || die( 'Keep Silent' );

use StorePress\MarqueeBlock\Containers\Container;
use StorePress\MarqueeBlock\Features\Blocks;
use StorePress\MarqueeBlock\Services\BlockSupports;

// =====================================================================
// Container & Service Access Functions
// =====================================================================

/**
 * Returns the plugin DI container singleton.
 *
 * @return Container
 * @since  1.0.0
 * @see    get_blocks()
 * @see    get_block_support()
 */
function get_container(): Container {
	return Container::instance();
}

/**
 * Returns the Blocks service from the DI container.
 *
 * @since  1.0.0
 * @return Blocks
 * @see    get_container()
 */
function get_blocks(): Blocks {
	return get_container()->get( Blocks::class );
}

/**
 * Returns a new BlockSupports instance for the given block attributes.
 *
 * @since  1.0.0
 * @param  array<string, mixed> $attributes Block attributes array.
 * @return BlockSupports
 * @see    get_container()
 */
function get_block_support( array $attributes ): BlockSupports {
	return get_container()->get( BlockSupports::class )( $attributes );
}

/**
 * Returns the absolute path to the main plugin file.
 *
 * @return string
 * @since  1.0.0
 */
function get_plugin_file(): string {
	return constant( 'STOREPRESS_MARQUEE_BLOCK_PLUGIN_FILE' );
}
