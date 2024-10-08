<?php

/**
 * Plugin Name:       WCRH Custom Logo
 * Description:       Add a custom svg logo to your website
 * Requires at least: 6.1
 * Requires PHP:      7.0
 * Version:           0.1.0
 * Author:            Gavin McGregor
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       wcrh-custom-logo
 *
 * @package Wcrh
 */

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

/**
 * Registers the block using the metadata loaded from the `block.json` file.
 * Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://developer.wordpress.org/reference/functions/register_block_type/
 */
function wcrh_custom_logo_block_init()
{
	register_block_type(__DIR__ . '/build');
}
add_action('init', 'wcrh_custom_logo_block_init');


// Add SVG to allowed upload types
function custom_logo_allow_svg_uploads($mime_types)
{
	$mime_types['svg'] = 'image/svg+xml';
	return $mime_types;
}
add_filter('upload_mimes', 'custom_logo_allow_svg_uploads');
