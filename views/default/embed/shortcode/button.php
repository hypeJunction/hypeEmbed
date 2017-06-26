<?php

$url = elgg_extract('url', $vars);
$text = elgg_extract('text', $vars);

$params['class'] = ['elgg-button', 'embed-button'];

$type = elgg_extract('type', $vars);
if ($type) {
	$params['class'][] = "elgg-button-$type";
}

$target = elgg_extract('target', $vars);
switch ($target) {
	case 'blank' :
		$params['target'] = '_blank';
		break;

	case 'lightbox' :
		$params['class'][] = 'elgg-lightbox';
		$params['class'][] = 'elgg-lightbox-iframe';
		$params['data-colorbox-opts'] = json_encode([
			'minWidth' => '300px',
			'minHeight' => '300px',
			'maxWidth' => '800px',
			'maxHeight' => '800px',
			'width' => '90%',
			'height' => '90%',
		]);
		$url = elgg_http_add_url_query_elements($url, [
			'embed_lightbox' => true,
		]);
		break;
}

$params['text'] = $text;
$params['href'] = $url;

echo elgg_view('output/url', $params);
