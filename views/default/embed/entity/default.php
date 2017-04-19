<?php

$entity = elgg_extract('entity', $vars);

$type = $entity->getType();
$subtype = $entity->getSubtype();

$subtypes = get_registered_entity_types($type);
if ($subtype && !in_array($subtype, $subtypes)) {
	return;
}

echo elgg_view_entity($entity, [
	'full_view' => false,
	'size' => elgg_extract('size', $vars),
]);