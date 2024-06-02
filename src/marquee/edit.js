/**
 * External dependencies
 */
import { __ } from '@wordpress/i18n';
import {
	InspectorControls,
	useBlockProps,
	useInnerBlocksProps,
} from '@wordpress/block-editor';
import { PanelBody, ToggleControl, RangeControl } from '@wordpress/components';

/**
 * Internal dependencies
 */

export default function Edit( { attributes, setAttributes } ) {
	const { pause, animationSpeed } = attributes;

	const blockProps = useBlockProps();
	const innerBlockProps = useInnerBlocksProps( blockProps, {
		template: [
			[
				'core/paragraph',
				{
					className: 'wp-block-storepress-marquee__item',
					align: 'center',
					metadata: { name: 'Text' },
					content:
						'Marquee block adds a touch of movement and interactivity to your site and help to capture attention and engage your site visitors in a unique way.',
				},
			],
		],
	} );

	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Settings', 'marquee-block' ) }>
					<ToggleControl
						label={ __( 'Pause on hover', 'marquee-block' ) }
						checked={ pause }
						onChange={ ( value ) =>
							setAttributes( { pause: value } )
						}
					/>

					<RangeControl
						initialPosition={ 9 }
						value={ animationSpeed }
						label={ __( 'Animation Speed', 'marquee-block' ) }
						help={ __(
							'Animation speed in seconds',
							'marquee-block'
						) }
						max={ 100 }
						min={ 1 }
						onChange={ ( value ) =>
							setAttributes( { animationSpeed: value } )
						}
					/>
				</PanelBody>
			</InspectorControls>

			<div { ...blockProps }>
				<div { ...innerBlockProps } />
			</div>
		</>
	);
}
