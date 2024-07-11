<?php

/**
 * @see https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/block-api/block-metadata.md#render
 */


// Get SVG 
$svg_path = plugin_dir_path(dirname(__FILE__)) . 'assets/logo.svg';
$svg_content = file_get_contents($svg_path);

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