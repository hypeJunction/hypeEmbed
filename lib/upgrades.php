<?php

use hypeJunction\Embed\File;

if (!elgg_get_plugin_setting('upgrade:ckeditor_conf', 'hypeEmbed')) {

	$subtypes = array(
		'embed_file' => File::class,
		'ckeditor_file' => File::class,
	);

	foreach ($subtypes as $subtype => $class) {
		if (!update_subtype('object', $subtype, $class)) {
			add_subtype('object', $subtype, $class);
		}
	}

	// Move CKEditor assets to embed
	$dataroot = elgg_get_config('dataroot');
	rename($dataroot . 'ckeditor/assets/', $dataroot . 'embed/');

	elgg_set_plugin_setting('upgrade:ckeditor_conf', time(), 'hypeEmbed');
}

// Register upgrade scripts
$path = 'admin/upgrades/embed/ckeditor_file';
$upgrade = new \ElggUpgrade();
if (!$upgrade->getUpgradeFromPath($path)) {
	$upgrade->setPath($path);
	$upgrade->title = elgg_echo('admin:upgrades:embed:ckeditor_file');
	$upgrade->description = elgg_echo('admin:upgrades:embed:ckeditor_file:description');
	$upgrade->save();

	$count = elgg_get_entities([
		'types' => 'object',
		'subtypes' => 'ckeditor_file',
		'count' => true,
	]);
	
	if (!$count) {
		$upgrade->setCompleted();
	}
}