<?php

namespace hypeJunction\Embed;

/**
 * Sniff the URL to see if it references a local entity
 *
 * @param string $url
 * @return mixed int|false
 * @deprecated 1.1
 */
function get_guid_from_url($url) {
	return false;
}

/**
 * Get metatags from iframely
 *
 * @param string $url
 * @return array
 * @deprecated 1.1
 */
function get_iframely_metatags_from_url($url, $endpoint = 'iframely') {
	return false;
}
