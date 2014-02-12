<?php

namespace hypeJunction\Embed;

$query = elgg_extract('query', $vars);
$simpletype = elgg_extract('simpletype', $vars);

$body .= '<div class="elgg-col elgg-col-1of2">';
$body .= '<div class="elgg-inner">';
$body .= '<label>' . elgg_echo('embed:tab:file:search:query') . '</label>';
$body .= elgg_view('input/text', array(
	'value' => $query,
	'name' => 'query'
		));
$body .= '</div>';
$body .= '</div>';

elgg_register_tag_metadata_name('simpletype');
$types = elgg_get_tags(array(
	'type' => 'object',
	'subtype' => 'file',
	'threshold' => 1,
	'limit' => 20,
	'tag_names' => array('simpletype')
		));

$type_options = array('' => elgg_echo('file:type:all'));
foreach ($types as $type) {
	$type_options[$type->tag] = elgg_echo("file:type:$type->tag");
}

$body .= '<div class="elgg-col elgg-col-1of2">';
$body .= '<div class="elgg-inner">';
$body .= '<label>' . elgg_echo('embed:tab:file:search:type') . '</label>';
$body .= elgg_view('input/dropdown', array(
	'value' => $simpletype,
	'name' => 'simpletype',
	'options_values' => $type_options
		));
$body .= '</div>';
$body .= '</div>';

$body = '<fieldset>' . $body . '</fieldset>';

$body .= '<fieldset class="elgg-foot">';
$body .= elgg_view('input/submit', array(
	'value' => elgg_echo('search'),
	'class' => 'elgg-button-submit'
		));
$body .= '</fieldset>';

echo $body;