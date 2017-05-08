<?php

if (!elgg_extract('full_view', $vars)) {
	return;
}

$entity = elgg_extract('entity', $vars);
if (!$entity instanceof ElggFile) {
	return;
}

$download_url = elgg_get_download_url($entity);

$img = elgg_view('output/img', [
	'src' => $download_url,
	'alt' => $entity->getDisplayName(),
]);

echo elgg_view('output/url', [
	'href' => $entity->getURL(),
	'text' => $img,
]);
