<?php

namespace hypeJunction\Embed;

$query = elgg_extract('query', $vars);
$subtype = elgg_extract('subtype', $vars, '');

$body .= '<div class="pam">';
$body .= '<label>' . elgg_echo('embed:tab:content_items:search:query') . '</label>';
$body .= elgg_view('input/text', array(
	'value' => $query,
	'name' => 'query'
		));
$body .= '</div>';

elgg_register_tag_metadata_name('simpletype');
$subtypes = elgg_get_config('registered_entities');
$object_subtypes = elgg_extract('object', $subtypes, array());
if (!in_array($subtype, $object_subtypes)) {
	$subtype = '';
}

$subtype_options = array('' => elgg_echo('embed:content_items:all'));
foreach ($object_subtypes as $sub) {
	$subtype_options[$sub] = elgg_echo("item:object:$sub");
}

$body .= '<div class="pam">';
$body .= '<label>' . elgg_echo('embed:tab:content_items:search:subtype') . '</label>';
$body .= elgg_view('input/dropdown', array(
	'value' => $subtype,
	'name' => 'subtype',
	'options_values' => $subtype_options
		));
$body .= '</div>';

$body = '<fieldset>' . $body . '</fieldset>';


$button .= elgg_view('input/submit', array(
	'value' => elgg_echo('search'),
	'class' => 'elgg-button elgg-button-submit mam'
		));

$body = elgg_view_image_block('', $body, array(
	'image_alt' => $button
		));

echo $body;