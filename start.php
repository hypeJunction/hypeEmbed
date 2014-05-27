<?php

/**
 * Embeds
 *
 * @package hypeJunction
 * @subpackage Embed
 *
 * @author Ismayil Khayredinov <ismayil.khayredinov@gmail.com>
 */

namespace hypeJunction\Embed;

const PLUGIN_ID = 'hypeEmbed';

require_once __DIR__ . '/vendors/autoload.php';

require_once __DIR__ . '/lib/functions.php';
require_once __DIR__ . '/lib/hooks.php';
require_once __DIR__ . '/lib/page_handlers.php';

require_once __DIR__ . '/lib/ecml/hooks.php';

elgg_register_event_handler('init', 'system', __NAMESPACE__ . '\\init');

function init() {

	elgg_extend_view('css/elgg', 'embed/css');
	elgg_extend_view('css/admin', 'embed/css');

	// Load fonts
	elgg_register_css('fonts.font-awesome', '/mod/' . PLUGIN_ID . '/vendors/fonts/font-awesome.css');
	elgg_load_css('fonts.font-awesome');
	elgg_register_css('fonts.open-sans', '/mod/' . PLUGIN_ID . '/vendors/fonts/open-sans.css');
	elgg_load_css('fonts.open-sans');

	elgg_register_page_handler('embed', __NAMESPACE__ . '\\embed_page_handler');

	elgg_register_simplecache_view('js/embed/embed');
	elgg_register_js('elgg.embed', elgg_get_simplecache_url('js', 'embed/embed'), 'footer');

	elgg_register_plugin_hook_handler('register', 'menu:longtext', __NAMESPACE__ . '\\longtext_menu_setup');
	elgg_register_plugin_hook_handler('register', 'menu:embed', __NAMESPACE__ . '\\embed_filter_menu_setup', 1000);

	elgg_register_ajax_view('embed/item/entity');

	elgg_register_action('embed/embed_src', __DIR__ . '/actions/embed/embed_src.php');

	if (elgg_is_active_plugin('ecml')) {
		elgg_register_plugin_hook_handler('render:embed', 'ecml', __NAMESPACE__ . '\\ECML\\render_embed');
		elgg_register_plugin_hook_handler('get_views', 'ecml', __NAMESPACE__ . '\\ECML\\get_views');
		elgg_register_plugin_hook_handler('prepare:entity', 'embed', __NAMESPACE__ . '\\ECML\\prepare_entity_embed');
		elgg_register_plugin_hook_handler('prepare:src', 'embed', __NAMESPACE__ . '\\ECML\\prepare_src_embed');
		elgg_register_plugin_hook_handler('output:src', 'embed', __NAMESPACE__ . '\\ECML\\render_oembed_html');
	}
}
