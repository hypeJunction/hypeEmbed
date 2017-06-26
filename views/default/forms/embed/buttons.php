<?php

echo elgg_view_field([
	'#type' => 'text',
	'#label' => elgg_echo('embed:buttons:text'),
	'name' => 'text',
	'required' => true,
]);

echo elgg_view_field([
	'#type' => 'select',
	'#label' => elgg_echo('embed:buttons:type'),
	'name' => 'type',
	'options_values' => [
		'action' => elgg_echo('embed:buttons:type:action'),
		'submit' => elgg_echo('embed:buttons:type:submit'),
		'delete' => elgg_echo('embed:buttons:type:delete'),
		'cancel' => elgg_echo('embed:buttons:type:cancel'),
	],
	'required' => true,
]);

echo elgg_view_field([
	'#type' => 'url',
	'#label' => elgg_echo('embed:buttons:address'),
	'name' => 'url',
	'required' => true,
]);

echo elgg_view_field([
	'#type' => 'select',
	'#label' => elgg_echo('embed:buttons:target'),
	'name' => 'target',
	'options_values' => [
		'self' => elgg_echo('embed:buttons:target:self'),
		'blank' => elgg_echo('embed:buttons:target:blank'),
		'lightbox' => elgg_echo('embed:buttons:target:lightbox'),
	],
	'required' => true,
]);

$footer = elgg_view_field([
	'#type' => 'submit',
	'value' => elgg_echo('embed:embed'),
]);

elgg_set_form_footer($footer);
