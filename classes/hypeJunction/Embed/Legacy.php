<?php

namespace hypeJunction\Embed;

class Legacy {

	public static function update($value) {

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

		$linkembed_callback = function($matches) {
			if ($matches[1]) {
				return Shortcodes::getShortcodeTag('player', [
							'url' => $matches[1],
				]);
			}
			return $matches[0];
		};

		$value = preg_replace_callback('/ckeditor\/image\/\d+\/(.*?)\/(\w+)/i', $image_callback, $value);
		$value = preg_replace_callback('/ckeditor\/assets\/((\w+\/?)*)/i', $asset_callback, $value);
		$value = preg_replace_callback('/<a.*?href=\"(.*?)\".*?><img.*?alt=\"linkembed\".*?><\/a>/i', $linkembed_callback, $value);

		return $value;
	}

}
