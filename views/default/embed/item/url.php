<?php

namespace hypeJunction\Embed;

if (!isset($vars['url'])) {
	return;
}

$url = elgg_extract('url', $vars);
unset($vars['url']);

// If the URL qualifies an existing entity, just use the entity view
$guid = get_guid_from_url($url);
echo $guid;

if ($guid && ($entity = get_entity($guid))) {
	echo elgg_view('embed/item/entity', array(
		'entity' => $entity
	));
	return;
}

$output = elgg_view('output/url', array(
	'href' => $url,
	'text' => $url,
	'title' => 'oembed',
	'target' => '_blank'
));

$vars['src'] = $url;
echo elgg_trigger_plugin_hook('prepare:src', 'embed', $vars, $output);
