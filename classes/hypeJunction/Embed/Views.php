<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 26-Jun-17
 * Time: 17:22
 */

namespace hypeJunction\Embed;


class Views {

	/**
	 * Replace layout for embedded lightbox pages
	 * @return string
	 */
	public static function filterLightboxLayout() {
		if (get_input('embed_lightbox')) {
			return 'embed_lightbox';
		}
	}

	/**
	 * Replace shell for embedded lightbox pages
	 * @return string
	 */
	public static function filterLightboxShell() {
		if (get_input('embed_lightbox')) {
			return 'embed_lightbox';
		}
	}
}