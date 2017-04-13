<?php

$entity = elgg_extract('entity', $vars);

echo elgg_view_entity($entity, [
	'full_view' => false,
	'size' => elgg_extract('size', $vars),
]);