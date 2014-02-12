<?php

namespace hypeJunction\Embed;

/**
 * Add a menu item to toggle embed interface
 * (or overwrite the default one if embed plugin is enabled)
 *
 * @param string $hook	Equals 'register'
 * @param string $type	Equals 'menu:longtext'
 * @param array $menu	Current menu items
 * @param array $params	Additional params
 * @return array Updated menu
 */
function longtext_menu_setup($hook, $type, $menu, $params) {

	if (!elgg_is_logged_in() || elgg_get_context() == 'embed') {
		return $menu;
	}

	$id = elgg_extract('id', $params);

	$menu[] = \ElggMenuItem::factory(array(
				'name' => 'embed',
				'href' => 'embed',
				'text' => elgg_echo('embed:media'),
				'data-textarea-id' => $id,
				'link_class' => "elgg-longtext-control embed-control",
				'priority' => 10,
	));

	elgg_load_js('elgg.embed');
	elgg_load_js('oembed.js');

	return $menu;
}

/**
 * Embed filter tabs
 *
 * @param string $hook  Equals 'register'
 * @param string $type	Equals 'menu:embed'
 * @param array $menu	Current menu
 * @param array $params	Additional params
 * @return array		Updated menu
 */
function embed_filter_menu_setup($hook, $type, $menu, $params) {

	$selected_tab = elgg_get_config('embed_tab');

	if (elgg_is_active_plugin('file')) {

		$menu[] = \ElggMenuItem::factory(array(
					'name' => 'file',
					'text' => elgg_echo('embed:file'),
					'href' => 'embed/tab/file',
					'class' => 'embed-section embed-section-file',
					'selected' => ($selected_tab == 'file'),
					'priority' => 1,
		));

		$menu[] = \ElggMenuItem::factory(array(
					'name' => 'file_upload',
					'text' => elgg_echo('embed:file:upload'),
					'href' => 'embed/tab/file_upload',
					'class' => 'embed-section embed-section-file-upload',
					'selected' => ($selected_tab == 'file_upload'),
					'priority' => 200,
		));
	}

	$menu[] = \ElggMenuItem::factory(array(
				'name' => 'content_items',
				'text' => elgg_echo('embed:content_items'),
				'href' => 'embed/tab/content_items',
				'class' => 'embed-section embed-section-content-items',
				'selected' => ($selected_tab == 'content_items'),
				'priority' => 300,
	));

	$menu[] = \ElggMenuItem::factory(array(
				'name' => 'embed_src',
				'text' => elgg_echo('embed:embed_src'),
				'href' => 'embed/tab/embed_src',
				'class' => 'embed-section embed-section-embed-src',
				'selected' => ($selected_tab == 'embed_src'),
				'priority' => 400,
	));

	return $menu;
}