<?php
/**
 * Singleton instance for Classes.
 *
 * @package    StorePress/MarqueeBlock
 * @since      1.1.1
 * @version    1.1.1
 */

declare( strict_types=1 );

namespace StorePress\MarqueeBlock;

defined( 'ABSPATH' ) || die( 'Keep Silent' );

trait Singleton {
	/**
	 * Return singleton instance of Class.
	 * The instance will be created if it does not exist yet.
	 *
	 * @return self The main instance.
	 * @since 1.1.1
	 */
	public static function instance(): self {
		static $instance = null;
		if ( is_null( $instance ) ) {
			$instance = new self();
		}

		return $instance;
	}
}
