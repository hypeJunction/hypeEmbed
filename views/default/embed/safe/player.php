<?php

use hypeJunction\Embed\Shortcodes;

$url = elgg_extract('url', $vars);

$attrs = [
	'url' => $url,
];

$data = [];
if (elgg_is_active_plugin('hypeScraper')) {
	$data = hypeapps_scrape($url);
	if ($data) {
		$attrs['title'] = elgg_get_excerpt($data['title']);
		$attrs['summary'] = elgg_get_excerpt($data['description']);
	}
}

$output = '<p>' . Shortcodes::getShortcodeTag('player', $attrs) . '</p>';

echo elgg_trigger_plugin_hook('prepare:player', 'embed', $vars, $output);
