<?php

namespace hypeJunction\Embed;

$options = elgg_extract('options', $vars);

$count = elgg_get_entities($options);

if (!$count) {
	echo elgg_autop(elgg_echo('embed:tab:content_items:empty'));
	return;
}

$options['count'] = false;
$files = elgg_get_entities($options);

echo elgg_view('embed/list', array(
	'items' => $files,
	'count' => $count,
	'limit' => $limit,
	'offset' => $offset,
));
