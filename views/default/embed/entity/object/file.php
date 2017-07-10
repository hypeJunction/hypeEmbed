<?php

$entity = elgg_extract('entity', $vars);
if (!$entity instanceof ElggFile) {
	return;
}

$vars['full_view'] = true;

$mime = $entity->getMimeType();
$base_type = substr($mime, 0, strpos($mime, '/'));

if (elgg_view_exists("file/specialcontent/$mime")) {
	echo elgg_view("file/specialcontent/$mime", $vars);
} else if (elgg_view_exists("file/specialcontent/$base_type/default")) {
	echo elgg_view("file/specialcontent/$base_type/default", $vars);
} else {
	echo elgg_view_entity($entity, [
		'full_view' => false,
		'size' => elgg_extract('size', $vars),
	]);
}
