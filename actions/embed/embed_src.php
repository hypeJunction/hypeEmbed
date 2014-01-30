<?php

namespace hypeJunction\Embed;

$url = get_input('address');

if (!$url) {
	register_error(elgg_echo('embed:embed_src:error:empty_url'));
	forward();
}

if (!$fp = curl_init($url)) {
	register_error(elgg_echo('embed:embed_src:error:invalid_url'));
	forward(REFERER);
}

echo elgg_view('embed/item/url', array(
	'url' => $url
));
forward(REFERRER);