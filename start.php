<?php

/**
 * Improved embedding experience
 * 
 * @author Ismayil Khayredinov <info@hypejunction.com>
 */
require __DIR__ . '/autoloader.php';

use hypeJunction\Embed\Lists;
use hypeJunction\Embed\Menus;
use hypeJunction\Embed\Router;
use hypeJunction\Embed\Shortcodes;
use hypeJunction\Embed\Uploads;

elgg_register_event_handler('init', 'system', function() {

	elgg_register_plugin_hook_handler('register', 'menu:embed', [Menus::class, 'setupEmbedMenu']);
	elgg_register_plugin_hook_handler('filter_options', 'object', [Lists::class, 'addFileSimpletypeOptions']);

	elgg_register_ajax_view('embed/safe/entity');
	elgg_register_ajax_view('embed/safe/player');

	elgg_register_action('embed/player', __DIR__ . '/actions/embed/player.php');

	elgg_register_plugin_hook_handler('view_vars', 'output/plaintext', [Shortcodes::class, 'filterLongtextOutputVars'], 9999);
	elgg_register_plugin_hook_handler('view_vars', 'output/longtext', [Shortcodes::class, 'filterLongtextOutputVars'], 9999);
	elgg_register_plugin_hook_handler('view_vars', 'output/excerpt', [Shortcodes::class, 'filterExcerptVars'], 9999);

	elgg_extend_view('forms/file/upload', 'embed/forms/upload', 100);
	elgg_register_plugin_hook_handler('action', 'file/upload', [Uploads::class, 'handleUpload'], 100);
	elgg_register_plugin_hook_handler('entity:icon:sizes', 'object', [Uploads::class, 'setIconSizes']);
	elgg_register_plugin_hook_handler('entity:icon:file', 'object', [Uploads::class, 'setIconFile']);

	elgg_register_plugin_hook_handler('route', 'embed', [Router::class, 'routeEmbed']);

	// Legacy ckeditor_addons
	elgg_register_page_handler('ckeditor', [Router::class, 'handleCKEditor']);
	elgg_register_action('upgrade/embed/ckeditor_file', __DIR__ . '/actions/upgrade/embed/ckeditor_file.php');
	elgg_register_plugin_hook_handler('view_vars', 'input/plaintext', [Router::class, 'rewriteLegacyURLs']);
	elgg_register_plugin_hook_handler('view_vars', 'input/longtext', [Router::class, 'rewriteLegacyURLs']);

	elgg_extend_view('elgg.css', 'embed/tab/assets.css');
	elgg_extend_view('admin.css', 'embed/tab/assets.css');
	
});

elgg_register_event_handler('upgrade', 'system', function() {
	if (!elgg_is_admin_logged_in()) {
		return;
	}

	require_once __DIR__ . '/lib/upgrades.php';
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
