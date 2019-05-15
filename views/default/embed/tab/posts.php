<?php

$page_owner = elgg_get_page_owner_entity();
if (!$page_owner) {
	$page_owner = elgg_get_logged_in_user_entity();
}

elgg_unregister_entity_type('object', 'comment');
elgg_unregister_entity_type('object', 'discussion_reply');
elgg_unregister_entity_type('object', 'file');

$options = [
	'types' => 'object',
	'subtypes' => get_registered_entity_types('object'),
	'limit' => 5,
	'no_results' => elgg_echo('embed:tab:posts:empty'),
	'base_url' => elgg_http_add_url_query_elements('embed/tab/posts', [
		'container_guid' => $page_owner->guid,
	]),
	'item_view' => 'embed/lists/item',
];

if ($page_owner instanceof ElggGroup) {
	$options['container_guids'][] = $page_owner->guid;
} else {
	$options['owner_guids'][] = elgg_get_logged_in_user_guid();
}

echo elgg_view('lists/objects', [
	'list_id' => 'embed-content-items',
	'list_class' => 'embed-list is-borderless',
	'options' => $options,
	'show_filter' => false,
	'show_sort' => true,
	'show_search' => true,
	'show_subtype' => true,
	'expand_form' => true,
	'filter_options' => $type_options,
	'sort_options' => [
		'time_created::desc',
		'time_created::asc',
	],
	'sort' => get_input('sort', 'time_created::desc'),
]);