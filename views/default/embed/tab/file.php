<?php

$page_owner = elgg_get_page_owner_entity();
if (!$page_owner) {
	$page_owner = elgg_get_logged_in_user_entity();
}

$options = [
	'types' => 'object',
	'subtypes' => ['file', 'embed_file'],
	'limit' => 5,
	'no_results' => elgg_echo('embed:tab:file:empty'),
	'base_url' => elgg_http_add_url_query_elements('embed/tab/file', [
		'container_guid' => $page_owner->guid,
	]),
	'item_view' => 'embed/lists/item',
];

if ($page_owner instanceof ElggGroup) {
	$options['container_guids'][] = $page_owner->guid;
} else {
	$options['owner_guids'][] = elgg_get_logged_in_user_guid();
}

elgg_register_tag_metadata_name('simpletype');
$types = elgg_get_tags(array(
	'type' => 'object',
	'subtype' => 'file',
	'threshold' => 1,
	'limit' => 20,
	'tag_names' => array('simpletype')
		));

$type_options = ['simpletype:all'];
foreach ($types as $type) {
	$type_options[] = "simpletype:$type->tag";
}

echo elgg_view('lists/objects', [
	'list_id' => 'embed-file',
	'options' => $options,
	'show_filter' => true,
	'show_sort' => true,
	'show_search' => true,
	'expand_form' => true,
	'filter_options' => $type_options,
	'sort_options' => [
		'time_created::desc',
		'time_created::asc',
	],
	'sort' => get_input('sort', 'time_created::desc'),
	'filter' => get_input('filter', 'simpletype:image'),
]);