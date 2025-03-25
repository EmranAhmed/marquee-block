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
 * @var   array<string, mixed> $attributes - A clean associative array of block attributes.
 * @var   WP_Block             $block      - The block instance. All the block settings and attributes.
 * @var   string               $content    - The block inner HTML (usually empty unless using inner blocks).
 */

$marquee_block_classes = array(
	'has-overlay-color' => isset( $attributes['overlayColor'] ),
	'orientation-x'     => 'x' === $attributes['orientation'],
	'orientation-y'     => 'y' === $attributes['orientation'],
);

$marquee_block_styles = array(
	'--animation-direction'  => esc_attr( $attributes['animationDirection'] ),
	'--animation-speed'      => esc_attr( $attributes['animationSpeed'] ),
	'--content-gap'          => esc_attr( $attributes['gap'] ),
	'--overlay-color'        => isset( $attributes['overlayColor'] ) ? sanitize_hex_color( $attributes['overlayColor'] ) : 'transparent',
	'--white-space'          => esc_attr( $attributes['whiteSpace'] ),
	'--animation-name'       => sprintf( 'storepress-marquee-animation-%s', esc_attr( $attributes['orientation'] ) ),
	'--animation-play-state' => esc_attr( $attributes['hoverAnimationState'] ),
);

$marquee_block_wrapper_attrs = array(
	'class' => esc_attr( marquee_block_plugin()->get_blocks()->get_css_classes( $marquee_block_classes ) ),
	'style' => esc_attr( marquee_block_plugin()->get_blocks()->get_inline_styles( $marquee_block_styles ) ),
);

$marquee_block_allowed_html = marquee_block_plugin()->get_blocks()->get_kses_allowed_html();
?>
<div <?php echo wp_kses_post( get_block_wrapper_attributes( $marquee_block_wrapper_attrs ) ); ?>>
	<div class="wp-block-storepress-marquee__item"><?php echo wp_kses( $content, $marquee_block_allowed_html ); ?></div>
	<!-- Mirrors the content -->
	<div class="wp-block-storepress-marquee__item mirror" aria-hidden="true"><?php echo wp_kses( $content, $marquee_block_allowed_html ); ?></div>
</div>
