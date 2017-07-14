<?php

echo elgg_view_field([
	'#type' => 'plaintext',
	'#label' => elgg_echo('embed:code:html'),
	'name' => 'html',
	'required' => true,
]);

$footer = elgg_view_field([
	'#type' => 'submit',
	'value' => elgg_echo('embed:embed'),
]);

elgg_set_form_footer($footer);
