<?php

namespace hypeJunction\Embed;

$query = get_input('query', false);
$subtype = get_input('subtype', '');
$limit = get_input('limit', 5);
$offset = get_input('offset', 0);

if ($query) {
	$query = stripslashes($query);
	if (function_exists('mb_convert_encoding')) {
		$display_query = mb_convert_encoding($query, 'HTML-ENTITIES', 'UTF-8');
	} else {
		$display_query = preg_replace("/[^\x01-\x7F]/", "", $query);
	}
	$display_query = htmlspecialchars($display_query, ENT_QUOTES, 'UTF-8', false);
}

$action = current_page_url();
$action = elgg_http_remove_url_query_element($action, 'query');
$action = elgg_http_remove_url_query_element($action, 'subtype');
$action = elgg_http_remove_url_query_element($action, 'limit');
$action = elgg_http_remove_url_query_element($action, 'offset');

echo elgg_view_form('embed/search_content_items', array(
	'method' => 'get',
	'disable_security' => true,
	'action' => $action,
	'class' => 'elgg-form-embed-search',
		), array(
	'query' => $display_query,
	'subtype' => $subtype
));


$container_guids = array(elgg_get_logged_in_user_guid());
$page_owner = elgg_get_page_owner_entity();
if (elgg_instanceof($page_owner) && $page_owner->canWriteToContainer('object', 'file')) {
	$container_guids[] = $page_owner->guid;
}

$subtypes = elgg_get_config('registered_entities');
$object_subtypes = elgg_extract('object', $subtypes, array());
if (!in_array($subtype, $object_subtypes)) {
	$subtype = $object_subtypes;
}

$dbprefix = elgg_get_config('dbprefix');

$options = array(
	'types' => 'object',
	'subtypes' => $subtype,
	'limit' => $limit,
	'offset' => $offset,
	'container_guids' => $container_guids,
	'joins' => array(),
	'wheres' => array(),
	'count' => true
);

if ($query) {
	$string = sanitize_string($display_query);
	$options['joins'][] = "JOIN {$dbprefix}objects_entity oe ON e.guid = oe.guid";
	$options['wheres'][] = "oe.title LIKE '%$string%'";
}

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
