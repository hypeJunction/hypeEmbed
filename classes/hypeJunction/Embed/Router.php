<?php

namespace hypeJunction\Embed;

class Router {

	/**
	 * Handles legacy ckeditor pages
	 *
	 * @param array $segments An array of URL segments
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
				array_unshift($segments, 'embed');
				$view = implode('/', $segments);
				forward(elgg_get_simplecache_url($view));
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
	 * Rewrite URLs added by the old ckeditor_addons plugin
	 *
	 * @param string $hook   "view_vars"
	 * @param string $type   Input names
	 * @param array  $return View vars
	 * @param array  $params Hook params
	 * @return array
	 */
	public static function rewriteLegacyURLs($hook, $type, $return, $params) {

		$value = elgg_extract('value', $return);

		if (!$value) {
			return;
		}

		$image_callback = function($matches) {
			$hash = $matches[1];
			$ext = $matches[2];
			if (!$hash || !$ext) {
				return $matches[0];
			}

			$files = elgg_get_entities_from_metadata([
				'types' => 'object',
				'subtypes' => 'embed_file',
				'limit' => 1,
				'metadata_name_value_pairs' => [
					'hash' => $hash,
				],
			]);

			if (!$files) {
				return $matches[0];
			}

			$file = array_shift($files);

			$url = elgg_get_embed_url($file, 'large');
			if (!$url) {
				return $matches[0];
			}

			return str_replace(elgg_get_site_url(), '', $url);
		};

		$asset_callback = function($matches) {
			if ($matches[1]) {
				return "embed/asset/{$matches[1]}";
			}
			return $matches[0];
		};

		$value = preg_replace_callback('/ckeditor\/image\/\d+\/(.*?)\/(\w+)/i', $image_callback, $value);
		$value = preg_replace_callback('/ckeditor\/assets\/((\w+\/?)*)/i', $asset_callback, $value);

		$return['value'] = $value;
		return $return;
	}

}
