<?php

namespace hypeJunction\Embed;

$query = get_input('query', false);
$simpletype = get_input('simpletype', '');
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
$action = elgg_http_remove_url_query_element($action, 'simpletype');
$action = elgg_http_remove_url_query_element($action, 'limit');
$action = elgg_http_remove_url_query_element($action, 'offset');

echo elgg_view_form('embed/search_files', array(
	'method' => 'get',
	'disable_security' => true,
	'action' => $action,
	'class' => 'elgg-form-embed-search',
		), array(
	'query' => $display_query,
	'simpletype' => $simpletype
));

$container_guids = array(elgg_get_logged_in_user_guid());
$page_owner = elgg_get_page_owner_entity();
if (elgg_instanceof($page_owner) && $page_owner->canWriteToContainer('object', 'file')) {
	$container_guids[] = $page_owner->guid;
}

$dbprefix = elgg_get_config('dbprefix');

$options = array(
	'types' => 'object',
	'subtypes' => 'file',
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

if ($simpletype) {
	$simpletype_id = add_metastring($simpletype);
	$md_name_id = add_metastring('simpletype');
	$options['joins'][] = "JOIN {$dbprefix}metadata md ON e.guid = md.entity_guid AND md.name_id = $md_name_id AND md.value_id = $simpletype_id";
}

$count = elgg_get_entities($options);

if (!$count) {
	echo elgg_autop(elgg_echo('embed:tab:file:empty'));
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
