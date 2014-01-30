<?php

namespace hypeJunction\Embed;

/**
 * Sniff the URL to see if it references a local entity
 *
 * @param string $url
 * @return mixed int|false
 */
function get_guid_from_url($url) {

	if (!class_exists('UFCOE\\Elgg\\Url')) {
		require_once dirname(dirname(__FILE__)) . '/classes/UFCOE/Elgg/Url.php';
	}

	$sniffer = new \UFCOE\Elgg\Url();
	return $sniffer->getGuid($url);
}

/**
 * Get metatags from iframely
 *
 * @param string $url
 * @return array
 */
function get_iframely_metatags_from_url($url, $endpoint = 'iframely') {

	switch($endpoint) {
		case 'oembed' :
			$gateway = IFRAMELY_GATEWAY . "oembed?url=$url";
			break;

		default :
		case 'iframely' :
			$gateway = IFRAMELY_GATEWAY . "iframely?uri=$url";
			break;
	}
	$ch = curl_init($gateway);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_POST, false);
	$json = curl_exec($ch);
	curl_close($ch);

	return json_decode($json);
}
