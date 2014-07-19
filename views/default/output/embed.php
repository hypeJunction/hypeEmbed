<?php

namespace hypeJunction\Embed;

$url = elgg_extract('value', $vars);

echo elgg_view('embed/item/url', array(
	'url' => $url
));
