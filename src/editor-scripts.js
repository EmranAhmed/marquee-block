/**
 * External dependencies
 */
import { Icon } from '@wordpress/icons';
import { updateCategory } from '@wordpress/blocks';
import { storepress } from '@storepress/icons';

( function () {
	updateCategory( 'storepress', { icon: <Icon icon={ storepress } /> } );
} )();
