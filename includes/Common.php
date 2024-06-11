<?php
	/**
	 * Common Methods for Classes.
	 *
	 * @package    StorePress/MarqueeBlock
	 * @since      1.0.0
	 * @version    1.0.0
	 */

	namespace StorePress\MarqueeBlock;

	defined( 'ABSPATH' ) || die( 'Keep Silent' );

trait Common {
	/**
	 * Return singleton instance of Class.
	 * The instance will be created if it does not exist yet.
	 *
	 * @return self The main instance.
	 * @since 1.0.0
	 */
	public static function instance(): self {
		static $instance = null;
		if ( is_null( $instance ) ) {
			$instance = new self();
		}

		return $instance;
	}

	/**
	 * Create HTML Attributes from given array
	 *
	 * @param array $attributes Attribute array.
	 * @param array $exclude    Exclude attribute. Default array.
	 *
	 * @return string
	 */
	public function get_html_attributes( array $attributes, array $exclude = array() ): string {

		$attrs = array_map(
			function ( $key ) use ( $attributes, $exclude ) {

				// Exclude attribute.
				if ( in_array( $key, $exclude, true ) ) {
					return '';
				}

				$value = $attributes[ $key ];

				// If attribute value is null.
				if ( is_null( $value ) ) {
					return '';
				}

				// If attribute value is boolean.
				if ( is_bool( $value ) ) {
					return $value ? $key : '';
				}

				// If attribute value is array.
				if ( is_array( $value ) ) {
					$value = $this->get_css_classes( $value );
				}

				return sprintf( '%s="%s"', esc_attr( $key ), esc_attr( $value ) );
			},
			array_keys( $attributes )
		);

		return implode( ' ', $attrs );
	}


	/**
	 * Generate Inline Style from array
	 *
	 * @param array $inline_styles_array Inline style as array.
	 *
	 * @return string
	 * @since      1.0.0
	 */
	public function get_inline_styles( array $inline_styles_array = array() ): string {

		$styles = array();

		foreach ( $inline_styles_array as $property => $value ) {
			if ( is_null( $value ) ) {
				continue;
			}
			$styles[] = sprintf( '%s: %s;', esc_attr( $property ), esc_attr( $value ) );
		}

		return implode( ' ', $styles );
	}

	/**
	 * Array to css class.
	 *
	 * @param array $classes_array css classes array.
	 *
	 * @return string
	 * @since      1.0.0
	 */
	public function get_css_classes( array $classes_array = array() ): string {

		$classes = array();

		foreach ( $classes_array as $class_name => $should_include ) {

			// Is class assign by numeric array. Like: ['class-a', 'class-b'].
			if ( is_numeric( $class_name ) && ! is_string( $class_name ) ) {
				$classes[] = esc_attr( $should_include );
				continue;
			}

			// Is class assign by associative array.
			// Like: ['class-a'=>true, 'class-b'=>false, class-c'=>'', 'class-d'=>'hello'].
			if ( ! empty( $should_include ) ) {
				$classes[] = esc_attr( $class_name );
			}
		}

		return implode( ' ', array_unique( $classes ) );
	}

	/**
	 * Converts a string (e.g. 'yes' or 'no') to a bool.
	 *
	 * @param string|bool $value String to convert. If a bool is passed it will be returned as-is.
	 *
	 * @return boolean
	 * @since      1.0.0
	 */
	public function string_to_boolean( $value ): bool {
		$value = $value ?? '';

		return is_bool( $value ) ? $value : ( 'yes' === strtolower( $value ) || 1 === $value || 'true' === strtolower( $value ) || '1' === $value );
	}

	/**
	 * Converts a bool to a 'yes' or 'no'.
	 *
	 * @param bool|string $value Bool to convert. If a string is passed it will first be converted to a bool.
	 *
	 * @return string
	 * @since 1.0.0
	 */
	public function boolean_to_string( $value ): string {
		if ( ! is_bool( $value ) ) {
			$value = $this->string_to_boolean( $value );
		}

		return true === $value ? 'yes' : 'no';
	}
}
