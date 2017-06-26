<?php

echo elgg_view_field([
	'#type' => 'url',
	'#label' => elgg_echo('embed:player:address'),
	'name' => 'url',
	'required' => true,
]);

$footer = elgg_view_field([
	'#type' => 'submit',
	'value' => elgg_echo('embed:embed'),
]);

elgg_set_form_footer($footer);
