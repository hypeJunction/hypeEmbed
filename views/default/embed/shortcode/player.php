<?php

$url = elgg_extract('url', $vars);

echo elgg_view('output/player', [
	'href' => $url,
]);
