<?php

$count = elgg_get_entities([
	'types' => 'object',
	'subtypes' => 'ckeditor_file',
	'count' => true,
		]);

echo elgg_view('output/longtext', [
	'value' => elgg_echo('admin:upgrades:embed:ckeditor_file:description')
]);

echo elgg_view('admin/upgrades/view', [
	'count' => $count,
	'action' => 'action/upgrade/embed/ckeditor_file',
]);
