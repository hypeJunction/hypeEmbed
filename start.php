<?php

/**
 * Improved embedding experience
 * 
 * @author Ismayil Khayredinov <info@hypejunction.com>
 */
require __DIR__ . '/autoloader.php';

use hypeJunction\Embed\Lists;
use hypeJunction\Embed\Menus;
use hypeJunction\Embed\Shortcodes;

elgg_register_event_handler('init', 'system', function() {

	elgg_register_plugin_hook_handler('register', 'menu:embed', [Menus::class, 'setupEmbedMenu']);
	elgg_register_plugin_hook_handler('filter_options', 'object', [Lists::class, 'addFileSimpletypeOptions']);

	elgg_register_ajax_view('embed/safe/entity');
	elgg_register_ajax_view('embed/safe/player');

	elgg_register_action('embed/player', __DIR__ . '/actions/embed/player.php');

	elgg_register_plugin_hook_handler('view_vars', 'output/longtext', [Shortcodes::class, 'filterLongtextOutputVars'], 9999);
	elgg_register_plugin_hook_handler('view_vars', 'output/excerpt', [Shortcodes::class, 'filterExcerptVars'], 9999);
});

/**
 * Expand shortcodes
 * 
 * @param string $value Text
 * @return string
 */
function hypeapps_expand_embed_shortcodes($value) {
	return Shortcodes::expandShortcodes($value);
}

/**
 * Strip shortcodes
 *
 * @param string $value Text
 * @return string
 */
function hypeapps_strip_embed_shortcodes($value) {
	return Shortcodes::stripShortcodes($value);
}

/**
 * Prepares a shortcode tag
 *
 * @param string $shortcode Shortcode name
 * @param array  $attrs     Attributes
 * @return string
 */
function hypeapps_get_shortcode_embed_tag($shortcode, array $attrs = []) {
	return Shortcodes::getShortcodeTag($shortcode, $attrs);
}
