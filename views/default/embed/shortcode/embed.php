<?php

$src = elgg_extract('src', $vars); // BC
if ($src) {
	echo elgg_view('output/player', [
		'href' => $src,
	]);
	return;
}

$guid = elgg_extract('guid', $vars);
$entity = get_entity($guid);

if (!$entity) {
	return;
}

$type = $entity->getType();
$subtype = $entity->getSubtype() ?: 'default';

$views = [
	"embed/entity/$type/$subtype",
	"embed/entity/$type/default",
	"embed/entity/$type",
	"embed/entity/default",
];

$params = $vars;
$params['entity'] = $entity;

foreach ($views as $view) {
	if (elgg_view_exists($view)) {
		$output = elgg_view($view, $params);
		echo elgg_format_element('div', [
			'class' => 'embed-shortcode-expanded',
		], $output);
		return;
	}
}