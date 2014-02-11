<?php

/**
 * Generate HTML markup to be added to the longtext as embed
 * Do not overwrite this view, use 'prepare:entity','embed' plugin hook instead
 */

namespace hypeJunction\Embed;

use ElggFile;

$entity = elgg_extract('entity', $vars);
if (!elgg_instanceof($entity)) {
	return;
}

if ($entity instanceof ElggFile) {
	$size = ($entity->simpletype == 'image') ? 'large' : 'small';
	$output = elgg_view_entity_icon($entity, $size);
} else {

	$title = (isset($entity->name)) ? $entity->name : $entity->title;
	$title = elgg_get_excerpt(strip_tags($title));

	if (empty($title)) {
		$title = elgg_get_excerpt(strip_tags($entity->briefdescription . $entity->description));
	}

	$icon_url = $entity->getIconURL('tiny');
	if (strpos($icon_url, '_graphics/icons/default/')) {
		$owner = $entity->getOwnerEntity();
		if (elgg_instanceof($owner)) {
			$icon_url = $owner->getIconURL('tiny');
		} else {
			$icon_url = false;
		}
	}

	if ($icon_url) {
		$icon = elgg_view('output/img', array(
			'src' => $icon_url,
			'alt' => $title,
		));
		$title = "$icon <span>$title</span>";
	}

	$output = elgg_view('output/url', array(
		'text' => $title,
		'href' => $entity->getURL()
	));
}

echo elgg_trigger_plugin_hook('prepare:entity', 'embed', $vars, $output);
