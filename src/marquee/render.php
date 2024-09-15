<?php
/**
 * Marquee Block Render Template File.
 *
 * @package    StorePress/MarqueeBlock
 * @since      1.0.0
 * @version    1.0.0
 */

namespace StorePress\MarqueeBlock;

use WP_Block;

/**
 * Dynamic Block Template.
 *
 * @global   array $attributes -  A clean associative array of block attributes.
 * @global   WP_Block $block - The block instance. All the block settings and attributes.
 * @global   string $content - The block inner HTML (usually empty unless using inner blocks).
 */

$marquee_block_classes = array(
	'pause-on-hover'       => marquee_block_plugin()->get_blocks()->string_to_boolean( $attributes['pause'] ),
	'has-overlay'          => marquee_block_plugin()->get_blocks()->string_to_boolean( $attributes['overlay'] ),
	'orientation-x'        => 'x' === $attributes['orientation'],
	'orientation-y'        => 'y' === $attributes['orientation'],
	'white-space--no-wrap' => marquee_block_plugin()->get_blocks()->string_to_boolean( $attributes['whiteSpaceNoWrap'] ),
);

$marquee_block_styles = array(
	'--direction'       => 'left' === $attributes['direction'] ? 'normal' : 'reverse',
	'--animation-speed' => sprintf( '%ds', absint( $attributes['animationSpeed'] ) ),
	'--content-gap'     => sprintf( '%dpx', absint( $attributes['gap'] ) ),
	'--overlay-color'   => sanitize_hex_color( $attributes['overlayColor'] ),
);

$marquee_block_wrapper_attrs = array(
	'class' => esc_attr( marquee_block_plugin()->get_blocks()->get_css_classes( $marquee_block_classes ) ),
	'style' => esc_attr( marquee_block_plugin()->get_blocks()->get_inline_styles( $marquee_block_styles ) ),
);

$marquee_block_allowed_html = marquee_block_plugin()->get_blocks()->get_kses_allowed_html();
?>

<div <?php echo wp_kses_post( get_block_wrapper_attributes( $marquee_block_wrapper_attrs ) ); ?>>
	<div class="wp-block-storepress-marquee__item">
		<?php echo wp_kses( $content, $marquee_block_allowed_html ); ?>
	</div>
	<!-- Mirrors the content above -->
	<div class="wp-block-storepress-marquee__item mirror" aria-hidden="true">
		<?php echo wp_kses( $content, $marquee_block_allowed_html ); ?>
	</div>
</div>
