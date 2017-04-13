<?php

$url = get_input('url');

$output = elgg_view('embed/safe/player', array(
	'url' => $url,
));

return elgg_ok_response($output);