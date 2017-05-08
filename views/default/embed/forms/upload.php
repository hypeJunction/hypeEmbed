<?php

if (!elgg_in_context('embed')) {
	return;
}

$options = [
	'file' => elgg_echo('embed:upload_type:file'),
	'embed_file' => elgg_echo('embed:upload_type:embed_file'),
];

echo elgg_view_field([
	'#type' => 'radio',
	'#label' => elgg_echo('embed:upload_type'),
	'name' => 'embed_upload_type',
	'value' => 'file',
	'options' => array_flip($options),
]);
