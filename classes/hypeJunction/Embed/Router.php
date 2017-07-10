<?php

namespace hypeJunction\Embed;

class Router {

	/**
	 * Handles legacy ckeditor pages
	 *
	 * @param array $segments An array of URL segments
	 *
	 * @return boolean
	 */
	public static function handleCKEditor($segments) {

		switch ($segments[0]) {

			case 'image' :
				$hash = $segments[2];
				$files = elgg_get_entities_from_metadata([
					'types' => 'object',
					'subtypes' => 'embed_file',
					'limit' => 1,
					'metadata_name_value_pairs' => [
						'hash' => $hash,
					],
				]);
				if (!$files) {
					return;
				}
				$file = array_shift($files);
				forward(elgg_get_embed_url($file, 'large'));
				break;

			case 'assets' :
				array_shift($segments);
				$view = implode('/', $segments);
				forward(elgg_get_simplecache_url("embed/$view"));
				break;
		}

		return false;
	}

	/**
	 * Route /embed
	 *
	 * @param string $hook   "route"
	 * @param string $type   "embed"
	 * @param array  $return Route
	 * @param array  $params Hook params
	 *
	 * @return mixed
	 */
	public static function routeEmbed($hook, $type, $return, $params) {

		if (!is_array($return)) {
			return;
		}

		$identifier = elgg_extract('identifier', $return);
		$segments = elgg_extract('segments', $return);
		$page = array_shift($segments);

		switch ($page) {
			case 'asset' :
				$view = implode('/', $segments);
				forward(elgg_get_simplecache_url("embed/$view"));
				break;
		}
	}

	/**
	 * Set public pages
	 *
	 * @param string $hook   "public_pages"
	 * @param string $type   "walled_garden"
	 * @param array  $return Public pages
	 *
	 * @return array
	 */
	public static function setPublicPages($hook, $type, $return) {

		$return[] = 'ckeditor/.*';
		$return[] = 'embed/.*';

		return $return;
	}
}
