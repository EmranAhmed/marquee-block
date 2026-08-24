<?php
/**
 * Blocks Class file.
 *
 * @package    StorePress/MarqueeBlock
 * @since      1.0.0
 * @version    1.0.0
 */

declare( strict_types=1 );

namespace StorePress\MarqueeBlock\Features;

defined( 'ABSPATH' ) || die( 'Keep Silent' );

use StorePress\AdminUtils\Traits\HelperMethodsTrait;
use StorePress\AdminUtils\Traits\SingletonTrait;
use StorePress\MarqueeBlock\Traits\UtilityHelperTrait;

/**
 *  Blocks Class.
 *
 * @since 1.0.0
 */
class Blocks {

	use SingletonTrait;
	use HelperMethodsTrait;
	use UtilityHelperTrait;

	/**
	 * Initialise class.
	 *
	 * @since      1.0.0
	 */
	protected function __construct() {
		$this->hooks();

		/**
		 * Fires after the Blocks service has finished loading.
		 *
		 * Allows other plugins or themes to hook in after blocks
		 * are registered and ready.
		 *
		 * @param Blocks $instance The Blocks service instance.
		 *
		 * @since 1.0.0
		 */
		do_action( 'storepress_marquee_block_blocks_loaded', $this );
	}

	/**
	 * Blocks Hooks
	 *
	 * @return void
	 * @since      1.0.0
	 */
	public function hooks(): void {
		add_action( 'init', array( $this, 'register_blocks' ) );
		add_action( 'enqueue_block_editor_assets', array( $this, 'block_editor_scripts' ) );
		add_filter( 'block_categories_all', array( $this, 'add_block_category' ) );
	}

	/**
	 *  Add custom block category
	 *
	 * @param array<int, mixed> $block_categories Available block category.
	 *
	 * @return array<int, mixed>
	 * @since      1.0.0
	 */
	public function add_block_category( array $block_categories ): array {

		/**
		 * Slugs.
		 *
		 * @var list<string> $available_slugs
		 */
		$available_slugs = wp_list_pluck( $block_categories, 'slug' );

		$category = array(
			'slug'  => 'storepress',
			'title' => esc_html__( 'StorePress', 'marquee-block' ),
			'icon'  => null,
		);

		if ( ! in_array( 'storepress', $available_slugs, true ) ) {
			$block_categories[] = $category;
		}

		return $block_categories;
	}

	/**
	 * Block Editor Script
	 *
	 * @return void
	 * @since      1.0.0
	 * @see        https://developer.wordpress.org/reference/functions/wp_set_script_translations/
	 * @see        https://developer.wordpress.org/block-editor/how-to-guides/internationalization/#load-translation-file
	 */
	public function block_editor_scripts(): void {
		// Editor Scripts.
		$url        = $this->build_url() . '/editor-scripts.js';
		$asset_file = $this->build_path() . '/editor-scripts.asset.php';

		/**
		 * Asset File data.
		 *
		 * @var array{dependencies: list<string>, version: string} $asset
		 */
		$asset = include $asset_file;

		wp_enqueue_script( 'marquee-block-editor-scripts', $url, $asset['dependencies'], $asset['version'], array( 'strategy' => 'defer' ) );

		wp_set_script_translations( 'marquee-block-editor-scripts', 'marquee-block', $this->languages_path() );
	}

	/**
	 * Register all Gutenberg blocks.
	 *
	 * Scans the build directory for block.json files and auto-registers
	 * each block found. Blocks are registered using WordPress's native
	 * register_block_type() function.
	 *
	 * @return void
	 *
	 * @since 1.0.0
	 *
	 * @see   Plugin::build_path()       Returns the build directory path.
	 * @see   register_block_type()      WordPress function to register blocks.
	 *
	 * @example
	 * // Blocks are automatically registered via init hook
	 * // Build directory structure expected:
	 * // build/
	 * //   popup/block.json
	 * //   slider/block.json
	 * //   pointer/block.json
	 *
	 * @example
	 * // Each block.json defines block metadata:
	 * // {
	 * //   "apiVersion": 3,
	 * //   "name": "storepress/hotspot-popup",
	 * //   "title": "Image Hotspot Popup",
	 * //   "category": "storepress"
	 * // }
	 *
	 * @example
	 * // Registered blocks can be used in templates:
	 * // <!-- wp:storepress/hotspot-popup -->...<!-- /wp:storepress/hotspot-popup -->
	 *
	 * @example
	 * // Check if blocks are registered:
	 * // $registry = WP_Block_Type_Registry::get_instance();
	 * // $is_registered = $registry->is_registered( 'storepress/hotspot-popup' );
	 */
	public function register_blocks(): void {
		if ( ! file_exists( $this->build_path() ) ) {
			return;
		}

		// Scanning block.json directory for all block definitions.
		$block_json_files = glob( $this->build_path() . '/**/block.json' );

		if ( false === $block_json_files ) {
			return;
		}

		// Auto register all blocks that were found.
		foreach ( $block_json_files as $filename ) {
			$block_type = dirname( $filename );
			register_block_type( $block_type );
		}
	}

	/**
	 * Returns an array of allowed HTML tags and attributes for a given context.
	 *
	 * @param array<string, mixed> $args extra argument.
	 *
	 * @return array<string, mixed>
	 * @since 1.0.0
	 */
	public function get_kses_allowed_html( array $args = array() ): array {

		/**
		 * Allowed HTML tags and attributes for the 'post' context.
		 *
		 * @var array<string, mixed> $defaults
		 */
		$defaults = wp_kses_allowed_html( 'post' );

		$tags = array(
			'svg'   => array(
				'class',
				'aria-hidden',
				'aria-labelledby',
				'role',
				'xmlns',
				'width',
				'height',
				'viewbox',
				'height',
			),
			'g'     => array( 'fill' ),
			'title' => array( 'title' ),
			'path'  => array( 'd', 'fill' ),
		);

		/**
		 * Allowed attributes keyed by tag name.
		 *
		 * @var array<string, array<string, true>> $allowed_args
		 */

		$allowed_args = array_reduce(
			array_keys( $tags ),
			static function ( array $carry, string $tag ) use ( $tags ) {
				$carry[ $tag ] = array_fill_keys( $tags[ $tag ], true );

				return $carry;
			},
			array()
		);

		return array_merge( $defaults, $allowed_args, $args );
	}
}
