/**
 * External dependencies
 */
import domReady from '@wordpress/dom-ready';

function marqueeHeight() {
	document
		.querySelectorAll(
			'.wp-block-storepress-marquee.orientation-y .wp-block-storepress-marquee__item'
		)
		.forEach( function ( el ) {
			el.parentNode.style.height = false;

			const { height } = el.getBoundingClientRect();

			el.parentNode.style.height = `${ height }px`;
			// el.nextElementSibling.style.visibility = 'visible';
		} );
}

// window.addEventListener( 'load', ( event ) => {} );

domReady( function () {
	const isReduced =
		window.matchMedia( `(prefers-reduced-motion: reduce)` ) === true ||
		window.matchMedia( `(prefers-reduced-motion: reduce)` ).matches ===
			true;

	if ( isReduced ) {
		return false;
	}

	marqueeHeight();

	// let timer;
	//
	// window.addEventListener( 'resize', ( event ) => {
	// 	clearTimeout( timer );
	//
	// 	timer = setTimeout( () => {
	// 		marqueeHeight();
	// 	}, 300 );
	// } );
} );
