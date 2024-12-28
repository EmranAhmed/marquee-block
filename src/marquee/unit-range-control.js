/**
 * WordPress dependencies
 */
import { useMemo } from '@wordpress/element';
import {
	BaseControl,
	RangeControl,
	Flex,
	FlexItem,
	// eslint-disable-next-line @wordpress/no-unsafe-wp-apis
	__experimentalSpacer as Spacer,
	// eslint-disable-next-line @wordpress/no-unsafe-wp-apis
	__experimentalUseCustomUnits as useCustomUnits,
	// eslint-disable-next-line @wordpress/no-unsafe-wp-apis
	__experimentalUnitControl as UnitControl,
	// eslint-disable-next-line @wordpress/no-unsafe-wp-apis
	__experimentalParseQuantityAndUnitFromRawValue as parseQuantityAndUnitFromRawValue,
} from '@wordpress/components';

// @see: https://github.com/WordPress/gutenberg/blob/trunk/packages/components/src/unit-control/utils.ts
// @see: https://github.com/WordPress/gutenberg/blob/trunk/packages/block-editor/src/components/height-control/index.js

/**
 * @typedef {Object} availableUnit - Type 'availableUnit'
 * @property {string} value   - Unit Key.
 * @property {string} label   - Unit Label.
 * @property {number} default - Unit Default Value
 * @property {number} min     - Unit Minimum Value
 * @property {number} max     - Unit Maximum Value
 * @property {number} step    - Unit Step
 */

/** @type {availableUnit[]} */
const availableUnits = [
	{ value: 'px', label: 'px', default: 0, min: 0, max: 1000, step: 1 },
	{ value: '%', label: '%', default: 0, min: 0, max: 100, step: 0.1 },
	{ value: 'em', label: 'em', default: 0, min: 0, max: 50, step: 0.01 },
	{ value: 'rem', label: 'rem', default: 0, min: 0, max: 50, step: 0.01 },
	{ value: 's', label: 's', default: 0, min: 0, max: 120, step: 0.1 },
	{ value: 'ms', label: 'ms', default: 0, min: 0, max: 120000, step: 100 },
	{ value: 'fr', label: 'fr', default: 1, min: 1, max: 100, step: 1 },
];

/**
 * @typedef {Object} unitOperation - Type 'unitOperation'
 * @property {string[]} fromUnits - Convert from unit array.
 * @property {string[]} toUnits   - Convert to unit array
 * @property {string}   operator  - Conversion operator
 * @property {number}   digit     - Conversion digit
 */

/** @type {unitOperation[]} */
const unitOperations = [
	{ fromUnits: ['em', 'rem'], toUnits: ['px'], operator: '*', digit: 16 },
	{ fromUnits: ['px'], toUnits: ['em', 'rem'], operator: '/', digit: 16 },
	{ fromUnits: ['s'], toUnits: ['ms'], operator: '*', digit: 1000 },
	{ fromUnits: ['ms'], toUnits: ['s'], operator: '/', digit: 1000 },
];

function unitConverter(newUnit, oldUnit, currentValue, operationLogics) {
	if (newUnit === oldUnit) {
		return {
			unitName: newUnit,
			unitValue: currentValue,
			unitString: `${currentValue}${newUnit}`,
		};
	}

	for (const operation of operationLogics) {
		const { fromUnits, toUnits, operator, digit } = operation;

		if (toUnits.includes(newUnit) && fromUnits.includes(oldUnit)) {
			if (operator === '/') {
				const newValue = (currentValue / digit).toFixed(2);
				return {
					unitName: newUnit,
					unitValue: newValue,
					unitString: `${newValue}${newUnit}`,
				};
			}

			if (operator === '*') {
				const newValue = Math.round(currentValue * digit);
				return {
					unitName: newUnit,
					unitValue: newValue,
					unitString: `${newValue}${newUnit}`,
				};
			}
		}
	}

	return {
		unitName: newUnit,
		unitValue: currentValue,
		unitString: `${currentValue}${newUnit}`,
	};
}

/**
 * @callback onChange
 * @param {string} value
 * @return {void}
 */

/**
 * UnitRangeControl renders a linked unit control and range control.
 *
 *
 * @param {Object}          props
 * @param {string}          props.label                                              - A label for the control.
 * @param {onChange}        props.onChange                                           - Called when the value changes.
 * @param {string}          props.value                                              - The current value with unit.
 * @param {string[]}        [props.allowedUnits=['%', 'px', 'em', 'rem', 's', 'ms']] - Available values.
 * @param {availableUnit[]} [props.defaultUnits]                                     - Default units.
 * @param {unitOperation[]} [props.convertUnits]                                     - Unit value conversion logic.
 *
 * @return {UnitRangeControl} The component to be rendered.
 */
export default function UnitRangeControl({
	label,
	onChange,
	value,
	allowedUnits = ['%', 'px', 'em', 'rem', 's', 'ms'],
	defaultUnits = availableUnits,
	convertUnits = unitOperations,
}) {
	const customRangeValue = parseFloat(value);

	const defaultValues = useMemo(() => {
		return defaultUnits.reduce((accumulator, unit) => {
			accumulator[unit.label] = unit.default;
			return accumulator;
		}, {});
	}, [defaultUnits]);

	const unitSettings = useMemo(() => {
		return defaultUnits.reduce((accumulator, unit) => {
			accumulator[unit.label] = unit;
			return accumulator;
		}, {});
	}, [defaultUnits]);

	const units = useCustomUnits({
		units: defaultUnits,
		availableUnits: allowedUnits,
		defaultValues,
	});

	const selectedUnit =
		useMemo(
			() => parseQuantityAndUnitFromRawValue(value, defaultUnits),
			[value, defaultUnits]
		)[1] ||
		units[0]?.value ||
		'px';

	const handleSliderChange = (next) => {
		onChange([next, selectedUnit].join(''));
	};

	const handleUnitChange = (newUnit) => {
		// Attempt to smooth over differences between currentUnit and newUnit.
		// This should slightly improve the experience of switching between unit types.
		const [currentValue, currentUnit] = parseQuantityAndUnitFromRawValue(
			value,
			defaultUnits
		);

		const { unitValue, unitString } = unitConverter(
			newUnit,
			currentUnit,
			currentValue,
			convertUnits
		);

		if (unitValue > unitSettings[newUnit]?.max) {
			onChange(unitSettings[newUnit]?.max + newUnit);
		} else {
			onChange(unitString);
		}
	};

	return (
		<fieldset
			className="components-unit-range-control"
			style={{ marginBottom: '16px' }}
		>
			<BaseControl.VisualLabel as="legend">
				{label}
			</BaseControl.VisualLabel>
			<Flex>
				<FlexItem isBlock>
					<UnitControl
						value={value}
						units={units}
						onChange={onChange}
						onUnitChange={handleUnitChange}
						min={unitSettings[selectedUnit]?.min ?? 0}
						max={unitSettings[selectedUnit]?.max ?? 100}
						step={unitSettings[selectedUnit]?.step ?? 0.1}
						size="__unstable-large"
						label={label}
						hideLabelFromVision
					/>
				</FlexItem>
				<FlexItem isBlock>
					<Spacer marginX={2} marginBottom={0}>
						<RangeControl
							__next40pxDefaultSize
							value={customRangeValue}
							min={unitSettings[selectedUnit]?.min ?? 0}
							max={unitSettings[selectedUnit]?.max ?? 100}
							step={unitSettings[selectedUnit]?.step ?? 0.1}
							withInputField={false}
							onChange={handleSliderChange}
							label={label}
							hideLabelFromVision
							__nextHasNoMarginBottom
							renderTooltipContent={(contentValue) =>
								`${contentValue}${selectedUnit}`
							}
						/>
					</Spacer>
				</FlexItem>
			</Flex>
		</fieldset>
	);
}
