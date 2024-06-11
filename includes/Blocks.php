<?php
	/**
	 * Blocks Class file.
	 *
	 * @package    StorePress/MarqueeBlock
	 * @since      1.0.0
	 * @version    1.0.0
	 */

	namespace StorePress\MarqueeBlock;

	defined( 'ABSPATH' ) || die( 'Keep Silent' );

	/**
	 *  Blocks Class.
	 *
	 * @since 1.0.0
	 */
class Blocks {

	use Common;

	/**
	 * Initialise class.
	 *
	 * @since      1.0.0
	 */
	protected function __construct() {
		$this->hooks();
		$this->init();

		/**
		 * Action to signal that Plugin has finished loading.
		 *
		 * @param Blocks $this Plugin Object.
		 *
		 * @since 1.0.0
		 */
		do_action( 'storepress_marquee_block_blocks_loaded', $this );
	}

	/**
	 * Blocks Hooks
	 *
	 * @since      1.0.0
	 */
	public function hooks() {
		add_action( 'init', array( $this, 'register_blocks' ) );
		add_action( 'enqueue_block_editor_assets', array( $this, 'block_editor_scripts' ) );
		add_filter( 'block_categories_all', array( $this, 'add_block_category' ) );
	}

	/**
	 * Initialize Blocks Included Classes
	 *
	 * @since      1.0.0
	 */
	public function init() {
	}

	/**
	 *  Add custom block category
	 *
	 * @param array $block_categories Available block category.
	 *
	 * @return array New category.
	 * @since      1.0.0
	 */
	public function add_block_category( array $block_categories ): array {

		$available_slugs = wp_list_pluck( $block_categories, 'slug' );

		$category = array(
			'slug'  => 'storepress',
			'title' => esc_html__( 'StorePress', 'marquee-block' ),
			'icon'  => null,
		);

		if ( ! in_array( 'storepress', $available_slugs, true ) ) {
			array_unshift( $block_categories, $category );
		}

		return $block_categories;
	}


	/**
	 * Block Editor Script
	 *
	 * @since      1.0.0
	 * @see https://developer.wordpress.org/reference/functions/wp_set_script_translations/
	 * @see https://developer.wordpress.org/block-editor/how-to-guides/internationalization/#load-translation-file
	 */
	public function block_editor_scripts() {
		// Editor Scripts.
		$editor_script_src_url    = marquee_block_plugin()->build_url() . '/editor-scripts.js';
		$editor_script_asset_file = marquee_block_plugin()->build_path() . '/editor-scripts.asset.php';
		$editor_script_asset      = require $editor_script_asset_file;

		wp_enqueue_script( 'marquee-block-editor-scripts', $editor_script_src_url, $editor_script_asset['dependencies'], $editor_script_asset['version'], array( 'strategy' => 'defer' ) );

		wp_set_script_translations( 'marquee-block-editor-scripts', 'marquee-block', marquee_block_plugin()->plugin_path() . '/languages' );
	}

	/**
	 * Block Register
	 *
	 * @since      1.0.0
	 */
	public function register_blocks() {
		if ( ! file_exists( marquee_block_plugin()->build_path() ) ) {
			return;
		}

		// Scanning block.json directory.
		$block_json_files = glob( marquee_block_plugin()->build_path() . '/**/block.json' );

		// Auto register all blocks that were found.
		foreach ( $block_json_files as $filename ) {
			$block_type = dirname( $filename );
			register_block_type( $block_type );
		}
	}

	/**
	 * Returns an array of allowed HTML tags and attributes for a given context.
	 *
	 * @param array $args extra argument.
	 *
	 * @return array
	 */
	public function get_kses_allowed_html( array $args = array() ): array {
		$defaults = wp_kses_allowed_html( 'post' );

		$tags = array(
			'svg'   => array( 'class', 'aria-hidden', 'aria-labelledby', 'role', 'xmlns', 'width', 'height', 'viewbox', 'height' ),
			'g'     => array( 'fill' ),
			'title' => array( 'title' ),
			'path'  => array( 'd', 'fill' ),
		);

		$allowed_args = array_reduce(
			array_keys( $tags ),
			function ( $carry, $tag ) use ( $tags ) {
				$carry[ $tag ] = array_fill_keys( $tags[ $tag ], true );
				return $carry;
			},
			array()
		);

		return array_merge( $defaults, $allowed_args, $args );
	}
}
