<?php

$entity = elgg_extract('entity', $vars);
if (!$entity instanceof ElggFile) {
	return;
}

$mime = $file->getMimeType();
$base_type = substr($mime, 0, strpos($mime, '/'));

$extra = '';
if (elgg_view_exists("file/specialcontent/$mime")) {
	$extra = elgg_view("file/specialcontent/$mime", $vars);
} else if (elgg_view_exists("file/specialcontent/$base_type/default")) {
	$extra = elgg_view("file/specialcontent/$base_type/default", $vars);
}

echo $extra;
