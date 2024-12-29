/**
 * External dependencies
 */
import { __ } from '@wordpress/i18n';
import {
	InspectorControls,
	useBlockProps,
	useInnerBlocksProps,
	// eslint-disable-next-line @wordpress/no-unsafe-wp-apis
	__experimentalColorGradientSettingsDropdown as ColorGradientSettingsDropdown,
	// eslint-disable-next-line @wordpress/no-unsafe-wp-apis
	__experimentalUseMultipleOriginColorsAndGradients as useMultipleOriginColorsAndGradients,
} from '@wordpress/block-editor';
import {
	PanelBody,
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

import { clsx } from 'clsx';

import { UnitRangeControl } from '@storepress/components';

/**
 * Internal dependencies
 */

import './editor.scss';

export default function Edit({ attributes, setAttributes, clientId }) {
	const {
		orientation,
		animationDirection,
		hoverAnimationState,
		animationSpeed,
		gap,
		overlayColor,
		whiteSpace,
	} = attributes;

	const blockProps = useBlockProps({
		className: clsx({
			'has-overlay-color': overlayColor,
			'orientation-x': orientation === 'x',
			'orientation-y': orientation === 'y',
		}),
		style: {
			'--overlay-color': overlayColor ?? 'transparent',
			'--white-space': whiteSpace,
		},
	});

	const colorGradientSettings = useMultipleOriginColorsAndGradients();

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

	const setOverlayColor = (newValue) => {
		setAttributes({ overlayColor: newValue });
	};

	const setOrientation = (newValue) => {
		setAttributes({ orientation: newValue });
	};

	const setAnimationDirection = (newValue) => {
		setAttributes({ animationDirection: newValue });
	};

	const setHoverAnimationState = (newValue) => {
		setAttributes({ hoverAnimationState: newValue });
	};

	const setAnimationSpeed = (newValue) => {
		setAttributes({ animationSpeed: newValue });
	};

	const setWhiteSpace = (newValue) => {
		setAttributes({ whiteSpace: newValue });
	};

	const setGap = (newValue) => {
		setAttributes({ gap: newValue });
	};

	return (
		<>
			<InspectorControls>
				<PanelBody title={__('Settings', 'marquee-block')}>
					<ToggleGroupControl
						label={__('Orientation', 'marquee-block')}
						value={orientation}
						onChange={setOrientation}
						isBlock
					>
						<ToggleGroupControlOption
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
						value={animationDirection}
						onChange={setAnimationDirection}
						isBlock
					>
						<ToggleGroupControlOption
							value="normal"
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
							value="reverse"
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

					<ToggleGroupControl
						label={__('On Hover Animation', 'marquee-block')}
						value={hoverAnimationState}
						onChange={setHoverAnimationState}
						isBlock
					>
						<ToggleGroupControlOption
							value="paused"
							label={__('Pause', 'marquee-block')}
						/>
						<ToggleGroupControlOption
							value="running"
							label={__('Continue', 'marquee-block')}
						/>
					</ToggleGroupControl>

					<UnitRangeControl
						label={__('Animation Speed', 'marquee-block')}
						onChange={setAnimationSpeed}
						value={animationSpeed}
						allowedUnits={['s', 'ms']}
					/>
				</PanelBody>
				<PanelBody title={__('Style', 'marquee-block')}>
					<ToggleGroupControl
						label={__('White Space', 'marquee-block')}
						value={whiteSpace}
						onChange={setWhiteSpace}
						isBlock
					>
						<ToggleGroupControlOption
							value="wrap"
							label={__('Wrap', 'marquee-block')}
						/>
						<ToggleGroupControlOption
							value="nowrap"
							label={__('No Wrap', 'marquee-block')}
						/>
					</ToggleGroupControl>

					<UnitRangeControl
						label={__('Content Gap', 'marquee-block')}
						onChange={setGap}
						value={gap}
						allowedUnits={['%', 'px', 'em', 'rem']}
					/>
				</PanelBody>
			</InspectorControls>

			<InspectorControls group="color">
				<ColorGradientSettingsDropdown
					panelId={clientId}
					settings={[
						{
							label: __('Overlay color', 'marquee-block'),
							colorValue: overlayColor,
							onColorChange: setOverlayColor,
						},
					]}
					{...colorGradientSettings}
				/>
			</InspectorControls>

			<div {...blockProps}>
				<div {...innerBlockProps} />
			</div>
		</>
	);
}
