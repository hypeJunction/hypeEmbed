<?php

namespace hypeJunction\Embed;

use hypeJunction\Lists\ElggList;

$options = elgg_extract('options', $vars);

$list = new ElggList($options);
$count = $list->getCount();

if (!$count) {
	echo elgg_autop(elgg_echo('embed:tab:content_items:empty'));
	return;
}

$options['count'] = false;
$files = $list->getItems();

echo elgg_view('embed/list', array(
	'items' => $files,
	'count' => $count,
	'limit' => $limit,
	'offset' => $offset,
));
