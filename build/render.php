<?php

/**
 * @see https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/block-api/block-metadata.md#render
 */

// Get the user-uploaded logo from block attributes
$custom_logo = !empty($attributes['logo']) ? esc_url($attributes['logo']) : '';

// Get the default logo if no custom logo is provided
if (empty($custom_logo)) {
	$svg_path = plugin_dir_path(dirname(__FILE__)) . 'assets/logo.svg';
	$svg_content = file_get_contents($svg_path);
} else {
	$svg_content = file_get_contents($custom_logo);
}

if (!empty($attributes['fill'])) {
	// Load SVG content into DOMDocument
	$dom = new DOMDocument();
	$dom->loadXML($svg_content, LIBXML_NOERROR);

	// Add style attribute to <svg> element
	$svg_elements = $dom->getElementsByTagName('svg');
	foreach ($svg_elements as $svg_element) {
		$svg_element->setAttribute('style', 'fill: ' . esc_attr($attributes['fill']));
	}

	$svg = $dom->saveXML();
} else {
	$svg = $svg_content;
}

// Get Width
if (!empty($attributes['width'])) {
	$width = $attributes['width'];
} else {
	$width = 250;
}

?>
<div <?php echo get_block_wrapper_attributes(); ?> style="max-width: <?php echo $width; ?>px">
	<a href="/">
		<?php echo $svg; ?>
	</a>
</div>