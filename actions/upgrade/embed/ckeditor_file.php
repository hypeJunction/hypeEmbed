<?php

if (get_input('upgrade_completed')) {
	$factory = new ElggUpgrade();
	$upgrade = $factory->getUpgradeFromPath('admin/upgrades/embed/ckeditor_file');
	if ($upgrade instanceof ElggUpgrade) {
		$upgrade->setCompleted();
	}
	return true;
}

$original_time = microtime(true);
$time_limit = 4;

$success_count = 0;
$error_count = 0;

$response = [];

$has_memory_to_resize = function($source) {
	$imginfo = getimagesize($source);
	$requiredMemory1 = ceil($imginfo[0] * $imginfo[1] * 5.35);
	$requiredMemory2 = ceil($imginfo[0] * $imginfo[1] * ($imginfo['bits'] / 8) * $imginfo['channels'] * 2.5);
	$requiredMemory = (int) max($requiredMemory1, $requiredMemory2);

	$mem_avail = elgg_get_ini_setting_in_bytes('memory_limit');
	$mem_used = memory_get_usage();

	$mem_avail = $mem_avail - $mem_used - 20971520; // 20 MB buffer, yeah arbitrary but necessary

	return $mem_avail > $requiredMemory;
};

while (microtime(true) - $original_time < $time_limit) {

	$files = elgg_get_entities([
		'types' => 'object',
		'subtypes' => 'ckeditor_file',
		'limit' => 1,
	]);

	if (!$files) {
		break;
	}

	foreach ($files as $file) {
		$embed_file = new hypeJunction\Embed\File();
		$embed_file->owner_guid = $file->owner_guid;
		$embed_file->container_guid = $file->container_guid;
		$embed_file->title = $file->title;
		$embed_file->description = $file->description;
		$embed_file->access_id = $file->access_id;
		$embed_file->time_created = $file->time_created;
		
		$metadata = elgg_get_metadata([
			'guids' => $file->guid,
			'limit' => 0,
		]);

		foreach ($metadata as $md) {
			$name = $md->name;
			$embed_file->$name = $md->value;
		}

		$embed_file->setFilename($file->getFilename());

		if ($embed_file->save()) {
			rename($file->getFilenameOnFilestore(), $embed_file->getFilenameOnFilestore());

			if ($embed_file->exists() && $has_memory_to_resize($embed_file->getFilenameOnFilestore())) {
				if ($embed_file->saveIconFromElggFile($embed_file)) {
					$embed_file->thumbnail = $embed_file->getIcon('small')->getFilename();
					$embed_file->smallthumb = $embed_file->getIcon('medium')->getFilename();
					$embed_file->largethumb = $embed_file->getIcon('large')->getFilename();
				}
			}

			$file->delete();
			$success_count++;
		} else {
			$error_count++;
		}
	}
}

if (elgg_is_xhr()) {
	$response['numSuccess'] = $success_count;
	$response['numErrors'] = $error_count;
	echo json_encode($response);
}
