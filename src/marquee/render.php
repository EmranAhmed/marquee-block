<?php

namespace StorePress\MarqueeBlock;
use WP_Block;

/**
 * Dynamic Block Template.
 * @global   array $attributes -  A clean associative array of block attributes.
 * @global   WP_Block $block - The block instance. All the block settings and attributes.
 * @global   string $content - The block inner HTML (usually empty unless using inner blocks).
 */

$classes = [
	'pause-on-hover' => $attributes['pause'],
	'orientation-x'  => 'x' === $attributes['orientation'],
	'orientation-y'  => 'y' === $attributes['orientation'],
];

$styles = [
	'--direction'       => "left" === $attributes['direction'] ? 'normal' : 'reverse',
	'--animation-speed' => sprintf( '%ds', $attributes['animationSpeed'] ),
	'--content-gap' => sprintf( '%dpx', $attributes['gap'] ),
];

$wrapper_attrs = array(
	'class' => esc_attr( marquee_block_plugin()->get_blocks()->get_css_classes( $classes ) ),
	'style' => esc_attr( marquee_block_plugin()->get_blocks()->get_inline_styles( $styles ) )
);
?>

<div <?php echo wp_kses_post( get_block_wrapper_attributes( $wrapper_attrs ) ); ?>>
	<div class="wp-block-storepress-marquee__item">
		<?php echo wp_kses_post( $content ); ?>
	</div>

	<!-- Mirrors the content above -->
	<div class="wp-block-storepress-marquee__item mirror" aria-hidden="true">
		<?php echo wp_kses_post( $content ); ?>
	</div>
</div>
