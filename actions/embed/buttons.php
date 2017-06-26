<?php

$text = get_input('text');
$type = get_input('type', 'action');
$url = get_input('url');
$target = get_input('target', 'self');

$output = elgg_view('embed/safe/button', array(
	'text' => $text,
	'url' => $url,
	'type' => $type,
	'target' => $target,
));

return elgg_ok_response($output);