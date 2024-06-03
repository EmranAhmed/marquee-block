<?php
/**
 * Dynamic Block Template.
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
	'pause-on-hover' => $attributes['pause'],
	'orientation-x'  => 'x' === $attributes['orientation'],
	'orientation-y'  => 'y' === $attributes['orientation'],
);

$marquee_block_styles = array(
	'--direction'       => 'left' === $attributes['direction'] ? 'normal' : 'reverse',
	'--animation-speed' => sprintf( '%ds', $attributes['animationSpeed'] ),
	'--content-gap'     => sprintf( '%dpx', $attributes['gap'] ),
);

$marquee_block_wrapper_attrs = array(
	'class' => esc_attr( marquee_block_plugin()->get_blocks()->get_css_classes( $marquee_block_classes ) ),
	'style' => esc_attr( marquee_block_plugin()->get_blocks()->get_inline_styles( $marquee_block_styles ) ),
);
?>

<div <?php echo wp_kses_post( get_block_wrapper_attributes( $marquee_block_wrapper_attrs ) ); ?>>
	<div class="wp-block-storepress-marquee__item">
		<?php echo wp_kses_post( $content ); ?>
	</div>

	<!-- Mirrors the content above -->
	<div class="wp-block-storepress-marquee__item mirror" aria-hidden="true">
		<?php echo wp_kses_post( $content ); ?>
	</div>
</div>
