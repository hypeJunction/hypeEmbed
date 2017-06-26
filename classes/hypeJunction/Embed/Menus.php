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
	 * @return ElggMenuItem[]
	 */
	public static function setupEmbedMenu($hook, $type, $return, $params) {

		$return[] = ElggMenuItem::factory(array(
					'name' => 'posts',
					'text' => elgg_echo('embed:posts'),
					'priority' => 300,
					'data' => array(
						'view' => 'embed/tab/posts',
					),
		));

		if (elgg_is_active_plugin('hypeScraper')) {
			$return[] = ElggMenuItem::factory(array(
						'name' => 'player',
						'text' => elgg_echo('embed:player'),
						'priority' => 500,
						'data' => array(
							'view' => 'embed/tab/player',
						),
			));
		}

		$page_owner = elgg_get_page_owner_entity();

		foreach ($return as &$item) {
			if (!$item instanceof \ElggMenuItem) {
				continue;
			}
			if ($item->getName() == 'file') {
				$item->setData('type', null);
				$item->setData('subtype', null);
				$item->setData('view', 'embed/tab/file');
			}

			$href = elgg_http_add_url_query_elements($item->getHref(), [
				'container_guid' => $page_owner->guid,
			]);

			$item->setHref($href);
		}

		if (elgg_is_admin_logged_in()) {
			$return[] = ElggMenuItem::factory(array(
						'name' => 'assets',
						'text' => elgg_echo('embed:assets'),
						'priority' => 900,
						'data' => array(
							'view' => 'embed/tab/assets',
						),
			));

			$return[] = ElggMenuItem::factory(array(
				'name' => 'buttons',
				'text' => elgg_echo('embed:buttons'),
				'priority' => 950,
				'data' => array(
					'view' => 'embed/tab/buttons',
				),
			));
		}

		return $return;
	}

}
