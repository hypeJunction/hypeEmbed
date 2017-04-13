<?php

use hypeJunction\Embed\Shortcodes;

$entity = elgg_extract('entity', $vars);
if (!elgg_instanceof($entity)) {
	return;
}

if ($entity instanceof ElggFile && $entity->simpletype == 'image') {
	$output = elgg_view('output/img', [
		'src' => elgg_get_embed_url($entity, 'large'),
		'alt' => $entity->getDisplayName(),
	]);
} else {
	$attrs = [
		'title' => elgg_get_excerpt($entity->getDisplayName()),
		'url' => $entity->getURL(),
		'summary' => elgg_get_excerpt($entiy->description),
		'guid' => $entity->guid,
	];

	$output = '<p>' . Shortcodes::getShortcodeTag('embed', $attrs) . '</p>';
}

echo elgg_trigger_plugin_hook('prepare:entity', 'embed', $vars, $output);
