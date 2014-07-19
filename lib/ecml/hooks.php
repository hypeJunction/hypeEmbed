<?php

namespace hypeJunction\Embed\ECML;

use ElggFile;
use hypeJunction\Util\Embedder;
use WideImage\Exception\Exception;

/**
 * Add views in which ECML should be rendered
 *
 * @param string $hook		Equals 'get_views'
 * @param string $type		Equals 'ecml'
 * @param array $views		Current list of views
 * @param array $params		Additional params
 * @return array			Updated lsit of views
 */
function get_views($hook, $type, $views, $params) {
	$views['output/embed'] = elgg_echo('embed:embed_src:output');
	return $views;
}

/**
 * Replace default Embed content with an ECML tag
 *
 * @param string $hook		Equals 'prepare:entity'
 * @param string $type		Equals 'embed'
 * @param string $content	HTML markup to inject into the longtext input
 * @param array $params		Additional params
 * @uses ElggEntity $params['entity']
 * @return type
 */
function prepare_entity_embed($hook, $type, $content, $params) {

	$entity = elgg_extract('entity', $params);

	// Where appropriate just use the <img>
	if ($entity instanceof ElggFile && $entity->simpletype == 'image') {
		return $content;
	}

	$default_allowed_attributes = array(
		'full_view', // Full view or not
		'list_type', // List type, e.g. gallery
		'size', // Icon size
		'context', // Elgg context or comma separated list of contexts to push
	);

	$allowed_attributes = elgg_trigger_plugin_hook('ecml:attributes:entity', 'embed', $params, $default_allowed_attributes);

	// GUID attribute is required
	$allowed_attributes[] = 'guid';

	// strip attributes that are not allowed
	$attributes = array();
	foreach ($allowed_attributes as $key) {
		$attributes[$key] = $params[$key];
	}

	if (!$attributes['guid']) {
		if ($entity->guid) {
			$attributes['guid'] = $entity->guid;
		} else {
			return $content;
		}
	}

	$attrs = elgg_format_attributes($attributes);
	$content = "[embed $attrs]";

	return $content;
}

/**
 * Replace default src Embed content with an ECML tag
 *
 * @param string $hook		Equals 'prepare:src'
 * @param string $type		Equals 'embed'
 * @param string $content	HTML markup to inject into the longtext input
 * @param array $params		Additional params
 * @uses ElggEntity $params['entity']
 * @return type
 */
function prepare_src_embed($hook, $type, $content, $params) {

	$allowed_attributes = elgg_trigger_plugin_hook('ecml:attributes:src', 'embed', $params, array());

	// src attribute is required
	$allowed_attributes[] = 'src';

	// strip attributes that are not allowed
	$attributes = array();
	foreach ($allowed_attributes as $key) {
		$attributes[$key] = $params[$key];
	}

	if (!$attributes['src']) {
		return $content;
	}

	$attrs = elgg_format_attributes($attributes);
	$content = "[embed $attrs]";

	return $content;
}

/**
 * Rendering an ECML embed
 *
 * @param string $hook		Equals 'render:embed'
 * @param string $type		Equals 'ecml;
 * @param string $content	ECML string that needs to be converted
 * @param array $params		ECML tokenizaton results
 * @uses string $params['keyword'] ECML keyword, i.e. embed in [embed guid="XXX"]
 * @uses array $params['attributes'] ECML attributes, i.e. array('guid' => XXX) in [embed guid="XXX"]
 *
 * @return string	Rendered ECML replacement
 */
function render_embed($hook, $type, $content, $params) {

	if ($hook != 'render:embed' || $params['keyword'] != 'embed') {
		return $content;
	}

	$attributes = elgg_extract('attributes', $params);

	// Return empty strings for embeds within embeds
	if (elgg_in_context('embed')) {
		return '';
	}

	elgg_push_context('embed');

	if (isset($attributes['context'])) {
		$contexts = string_to_tag_array($attributes['context']);
		foreach ($contexts as $context) {
			elgg_push_context($context);
		}
	}

	if (isset($attributes['guid'])) {
		$guid = $attributes['guid'];
		unset($attributes['guid']);

		$entity = get_entity($guid);
		$attributes['entity'] = $entity;

		if (elgg_instanceof($entity)) {
			$type = $entity->getType();
			$subtype = $entity->getSubtype();

			if (elgg_view_exists("embed/ecml/$type/$subtype")) {
				$ecml = elgg_view("embed/ecml/$type/$subtype", $attributes);
			} else if ($type == 'object' && in_array($subtype, get_registered_entity_types('object'))) {
				if (elgg_view_exists("embed/ecml/object")) {
					$ecml = elgg_view("embed/ecml/object", $attributes);
				} else {
					$ecml = elgg_view("embed/ecml/default", $attributes);
				}
			}
		}
		if (empty($ecml)) {
			$content = elgg_view('embed/ecml/error');
		} else {
			$content = $ecml;
		}
	} elseif (isset($attributes['src'])) {
		$content = elgg_view("embed/ecml/url", $attributes);
	}

	elgg_pop_context();
	if (!empty($contexts)) {
		foreach ($contexts as $context) {
			elgg_pop_context();
		}
	}

	return $content;
}

/**
 * Render oEmbed html using iFramely
 * 
 * @param string $hook		Equals 'output:src'
 * @param string $type		Equals 'embed'
 * @param string $return	HTML markup
 * @param string $params	Additional params
 * @uses string $params['url'] URL to embed
 * @return string
 * @deprecated since 1.1
 */
function render_oembed_html($hook, $type, $return, $params) {
	return $return;
}
