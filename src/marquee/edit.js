/**
 * External dependencies
 */
import { __ } from '@wordpress/i18n';
import {
	InspectorControls,
	useBlockProps,
	useInnerBlocksProps,
} from '@wordpress/block-editor';
import {
	PanelBody,
	ToggleControl,
	RangeControl,
	ColorPicker,
	__experimentalToggleGroupControl as ToggleGroupControl, // eslint-disable-line @wordpress/no-unsafe-wp-apis
	__experimentalToggleGroupControlOption as ToggleGroupControlOption, // eslint-disable-line @wordpress/no-unsafe-wp-apis
} from '@wordpress/components';
import {
	Icon,
	arrowLeft,
	arrowRight,
	arrowUp,
	arrowDown,
} from '@wordpress/icons';

export default function Edit({ attributes, setAttributes }) {
	const {
		orientation,
		direction,
		pause,
		animationSpeed,
		gap,
		overlay,
		overlayColor,
		whiteSpaceNoWrap
	} = attributes;

	const blockProps = useBlockProps();

	const innerBlockProps = useInnerBlocksProps(
		{
			className: 'wp-block-storepress-marquee__item',
		},
		{
			template: [
				[
					'core/paragraph',
					{
						align: 'center',
						content:
							'Marquee block adds a touch of movement and interactivity to your site and help to capture attention and engage your site visitors in a unique way.',
					},
				],
			],
		}
	);

	return (
		<>
			<InspectorControls>
				<PanelBody title={__('Settings', 'marquee-block')}>
					<ToggleGroupControl
						label={__('Orientation', 'marquee-block')}
						value={orientation}
						onChange={(value) =>
							setAttributes({ orientation: value })
						}
						isBlock
					>
						<ToggleGroupControlOption
							key="x"
							value="x"
							label={
								<Icon
									icon={
										<svg>
											<path
												transform="rotate(45 12 12)"
												d="M7 18h4.5v1.5h-7v-7H6V17L17 6h-4.5V4.5h7v7H18V7L7 18Z"
											></path>
										</svg>
									}
								/>
							}
						/>
						<ToggleGroupControlOption
							key="y"
							value="y"
							label={
								<Icon
									icon={
										<svg>
											<path
												transform="rotate(135 12 12)"
												d="M7 18h4.5v1.5h-7v-7H6V17L17 6h-4.5V4.5h7v7H18V7L7 18Z"
											></path>
										</svg>
									}
								/>
							}
						/>
					</ToggleGroupControl>

					<ToggleGroupControl
						label={__('Animation Direction', 'marquee-block')}
						value={direction}
						onChange={(value) =>
							setAttributes({ direction: value })
						}
						isBlock
					>
						<ToggleGroupControlOption
							key="left"
							value="left"
							label={
								<Icon
									icon={
										orientation === 'x'
											? arrowLeft
											: arrowUp
									}
									size="30"
								/>
							}
						/>
						<ToggleGroupControlOption
							key="right"
							value="right"
							label={
								<Icon
									icon={
										orientation === 'x'
											? arrowRight
											: arrowDown
									}
									size="30"
								/>
							}
						/>
					</ToggleGroupControl>

					<RangeControl
						initialPosition={10}
						value={animationSpeed}
						label={__('Animation Speed', 'marquee-block')}
						help={__('Animation speed in seconds', 'marquee-block')}
						max={100}
						min={1}
						onChange={(value) =>
							setAttributes({ animationSpeed: value })
						}
					/>

					<RangeControl
						initialPosition={40}
						value={gap}
						label={__('Content Gap', 'marquee-block')}
						help={__('Content gap in PX', 'marquee-block')}
						max={200}
						min={0}
						step={5}
						onChange={(value) => setAttributes({ gap: value })}
					/>

					<ToggleControl
						label={__('Pause on hover', 'marquee-block')}
						checked={pause}
						onChange={(value) => setAttributes({ pause: value })}
					/>
				</PanelBody>
			</InspectorControls>

			<InspectorControls group="styles">
				<PanelBody title={__('Styles', 'marquee-block')}>
					<ToggleControl
						label={__('Enable Overlay', 'marquee-block')}
						checked={overlay}
						onChange={(value) => setAttributes({ overlay: value })}
					/>

					{overlay && (
						<ColorPicker
							defaultValue={overlayColor}
							onChange={(value) => {
								setAttributes({ overlayColor: value });
							}}
						/>
					)}

					<ToggleControl
						label={__('White Space - No Wrap', 'marquee-block')}
						checked={whiteSpaceNoWrap}
						onChange={(value) => setAttributes({ whiteSpaceNoWrap: value })}
					/>
				</PanelBody>
			</InspectorControls>

			<div {...blockProps}>
				<div {...innerBlockProps} />
			</div>
		</>
	);
}
