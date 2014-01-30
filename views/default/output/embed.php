<?php

namespace hypeJunction\Embed;

$url = elgg_extract('value', $vars);

// If the URL qualifies an existing entity, just use the entity view
$guid = get_guid_from_url($url);
if ($guid && ($entity = get_entity($guid))) {
	echo elgg_view('embed/item/entity', array(
		'entity' => $entity
	));
	return;
}

echo elgg_view('embed/item/url', array(
	'url' => $url
));
