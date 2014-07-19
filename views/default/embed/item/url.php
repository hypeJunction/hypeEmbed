<?php

namespace hypeJunction\Embed;

if (!isset($vars['url'])) {
	return;
}

$url = elgg_extract('url', $vars);
unset($vars['url']);

$output = elgg_view('output/url', array(
	'href' => $url,
	'text' => $url,
	'title' => 'oembed',
	'target' => '_blank'
));

$vars['src'] = $url;
echo elgg_trigger_plugin_hook('prepare:src', 'embed', $vars, $output);
