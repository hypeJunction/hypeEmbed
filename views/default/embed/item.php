<?php

namespace hypeJunction\Embed;

$entity = $vars['entity'];
if (!elgg_instanceof($entity)) {
	return;
}

$title = (isset($entity->name)) ? $entity->name : $entity->title;
$title = elgg_get_excerpt(strip_tags($title));

if (empty($title)) {
	$title = elgg_get_excerpt(strip_tags($entity->briefdescription . $entity->description));
}

$icon_url = $entity->getIconURL('small');

$owner = $entity->getOwnerEntity();
if (elgg_instanceof($owner)) {
	$author_text = elgg_echo('byline', array($owner->name));
	$date = elgg_view_friendly_time($entity->time_created);
	$subtitle = "$author_text $date";
	if (strpos($icon_url, '_graphics/icons/default/')) {
		$icon_url = $owner->getIconURL('small');
	}
} else {
	$subtitle = '';
}

if ($icon_url) {
	$icon_sizes = elgg_get_config('icon_sizes');
	$icon = elgg_view('output/img', array(
		'src' => $icon_url,
		'alt' => $title,
		'width' => $icon_sizes['small']['w'],
	));
}

$body = elgg_view('object/elements/summary', array(
	'entity' => $entity,
	'title' => $title,
	'subtitle' => $subtitle,
	'metadata' => false,
	'tags' => false
		));

$insert = elgg_view('output/url', array(
	'class' => 'elgg-button elgg-button-action small embed-insert',
	'text' => elgg_echo('embed:embed'),
	'href' => 'ajax/view/embed/item/entity?guid=' . $entity->guid
		));

echo elgg_view_image_block($icon, $body, array(
	'image_alt' => $insert
));


