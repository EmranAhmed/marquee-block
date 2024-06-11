/**
 * External dependencies
 */
import domReady from '@wordpress/dom-ready';

/**
 * Internal dependencies
 *
 * @see https://github.com/WordPress/gutenberg/pull/55492
 */
import './view.scss';

function storepressMarqueeBlockHeight() {
	document
		.querySelectorAll(
			'.wp-block-storepress-marquee.orientation-y .wp-block-storepress-marquee__item'
		)
		.forEach(function (el) {
			el.parentNode.style.height = false;

			const { height } = el.getBoundingClientRect();

			el.parentNode.style.height = `${height}px`;
		});
}

domReady(function () {
	const isReduced =
		window.matchMedia(`(prefers-reduced-motion: reduce)`) === true ||
		window.matchMedia(`(prefers-reduced-motion: reduce)`).matches === true;

	if (isReduced) {
		return false;
	}

	storepressMarqueeBlockHeight();
});
