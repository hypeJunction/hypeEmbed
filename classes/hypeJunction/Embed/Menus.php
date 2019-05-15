<?php

namespace hypeJunction\Embed;

use ElggMenuItem;

/**
 * @access private
 */
class Menus {

	/**
	 * Setup embed menu
	 *
	 * @param string         $hook   "register"
	 * @param string         $type   "menu:embed"
	 * @param ElggMenuItem[] $return Menu
	 * @param array          $params Hook params
	 *
	 * @return ElggMenuItem[]
	 */
	public static function setupEmbedMenu($hook, $type, $return, $params) {

		if (self::isTabEnabled('posts')) {
			$return[] = ElggMenuItem::factory([
				'name' => 'posts',
				'text' => elgg_echo('embed:posts'),
				'priority' => 300,
				'data' => [
					'view' => 'embed/tab/posts',
				],
			]);
		}

		if (elgg_is_active_plugin('hypeScraper') && self::isTabEnabled('player')) {
			$return[] = ElggMenuItem::factory([
				'name' => 'player',
				'text' => elgg_echo('embed:player'),
				'priority' => 500,
				'data' => [
					'view' => 'embed/tab/player',
				],
			]);
		}

		if (elgg_is_admin_logged_in()) {
			if (self::isTabEnabled('assets')) {
				$return[] = ElggMenuItem::factory([
					'name' => 'assets',
					'text' => elgg_echo('embed:assets'),
					'priority' => 900,
					'data' => [
						'view' => 'embed/tab/assets',
					],
				]);
			}

			if (self::isTabEnabled('buttons')) {
				$return[] = ElggMenuItem::factory([
					'name' => 'buttons',
					'text' => elgg_echo('embed:buttons'),
					'priority' => 950,
					'data' => [
						'view' => 'embed/tab/buttons',
					],
				]);
			}

			if (self::isTabEnabled('code')) {
				$return[] = ElggMenuItem::factory([
					'name' => 'code',
					'text' => elgg_echo('embed:code'),
					'priority' => 950,
					'data' => [
						'view' => 'embed/tab/code',
					],
				]);
			}
		}

		$id = elgg_extract('textarea_id', $params);

		foreach ($return as &$item) {
			if (!$item instanceof \ElggMenuItem) {
				continue;
			}

			if ($item->getName() == 'file') {
				$item->setData('type', null);
				$item->setData('subtype', null);
				$item->setData('view', 'embed/tab/file');
			}

			if ($id) {
				$item->rel = "embed-lightbox-{$id}";
				$item->setLinkClass("embed-control embed-control-{$id}");
			}

			$item->addDeps(['elgg/embed', 'embed/toolbar']);

			$url = "embed/tab/{$item->getName()}";

			$page_owner = elgg_get_page_owner_entity();

			if ($page_owner instanceof \ElggGroup && $page_owner->isMember()) {
				$url = elgg_http_add_url_query_elements($url, [
					'container_guid' => $page_owner->guid,
				]);
			}

			$item->setHref('javascript:');
			$item->{'data-href'} = elgg_normalize_url($url);
		}

		return $return;
	}

	protected static function isTabEnabled($name) {
		return elgg_get_plugin_setting("tabs:$name", 'hypeEmbed', true);
	}

}
