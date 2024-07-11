/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/
 */
import { __ } from "@wordpress/i18n";

/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */
import { InspectorControls, useBlockProps } from "@wordpress/block-editor";
import {
	PanelBody,
	ColorPalette,
	RangeControl,
	Flex,
	FlexItem,
} from "@wordpress/components";
import { useSelect } from "@wordpress/data";

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import "./editor.scss";

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {Element} Element to render.
 */

// Import SVG
import { useEffect, useState } from "@wordpress/element";
import logoSVG from "../assets/logo.svg";

export default function Edit({ attributes, setAttributes }) {
	// Atrributes
	const { fill, width } = attributes;

	// Select & save the fill colour
	const onChangeFill = (newColor) => {
		setAttributes({ fill: newColor });
	};

	// Fetch the colors from theme.json
	const paletteColors = useSelect((select) => {
		return select("core/editor").getEditorSettings().colors;
	}, []);

	// Convert to HTML
	const [svgContent, setSvgContent] = useState("");
	useEffect(() => {
		fetch(logoSVG)
			.then((response) => response.text())
			.then((data) => {
				const dataStyled = data.replace("<svg", `<svg style="fill: ${fill}"`);
				setSvgContent(dataStyled);
			});
	}, [fill]);

	// Conditional Style
	const defaultWidth = 250;
	let blockStyle;
	if (width) {
		blockStyle = {
			maxWidth: `${width}px`,
		};
	} else {
		blockStyle = {
			maxWidth: `${defaultWidth}px`,
		};
	}

	return (
		<>
			<InspectorControls>
				<PanelBody title={__("Logo Settings")}>
					<Flex direction="column">
						<FlexItem>
							<ColorPalette
								label={__("Logo Colour")}
								colors={paletteColors.map((color) => ({
									name: color.name,
									color: color.color,
								}))}
								value={fill}
								onChange={onChangeFill}
							/>
						</FlexItem>
						<FlexItem>
							<RangeControl
								label={__("Logo Width")}
								value={width}
								onChange={(value) => setAttributes({ width: value })}
								min={100}
								max={500}
								initialPosition={defaultWidth}
								allowReset={true}
								step={50}
								withInputField={true}
							/>
						</FlexItem>
					</Flex>
				</PanelBody>
			</InspectorControls>
			<div {...useBlockProps()} style={blockStyle}>
				<div
					className={`svg-container${fill ? ` fill-${fill}` : ""}`}
					dangerouslySetInnerHTML={{ __html: svgContent }}
				/>
			</div>
		</>
	);
}
