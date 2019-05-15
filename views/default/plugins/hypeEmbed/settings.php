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

$tabs = array_filter([
	'posts',
	elgg_is_active_plugin('hypeScraper') ? 'player' : null,
	'buttons',
	'code',
	'assets',
]);

foreach ($tabs as $tab) {
	echo elgg_view_field([
		'#type' => 'select',
		'#label' => elgg_echo('embed:settings:tabs', [elgg_echo("embed:$tab")]),
		'name' => "params[tabs:$tab]",
		'value' => $entity->{"tabs:$tab"},
		'options_values' => [
			0 => elgg_echo('option:no'),
			1 => elgg_echo('option:yes'),
		],
	]);
}

