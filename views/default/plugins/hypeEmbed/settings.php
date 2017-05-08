<?php

$entity = elgg_extract('entity', $vars);

echo elgg_view_field([
	'#type' => 'select',
	'#label' => elgg_echo('embed:settings:river_preview'),
	'name' => 'params[river_preview]',
	'value' => $entity->river_preview,
	'options_values' => [
		0 => elgg_echo('option:no'),
		1 => elgg_echo('option:yes'),
	],
]);

echo elgg_view_field([
	'#type' => 'select',
	'#label' => elgg_echo('embed:settings:summary_preview'),
	'name' => 'params[summary_preview]',
	'value' => $entity->summary_preview,
	'options_values' => [
		0 => elgg_echo('option:no'),
		1 => elgg_echo('option:yes'),
	],
]);