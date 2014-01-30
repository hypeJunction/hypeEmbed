<?php

namespace hypeJunction\Embed;

$body = '<div>';
$body .= '<label>' . elgg_echo('embed:embed_src:address') . '</label>';
$body .= elgg_view('input/embed', array(
	'name' => 'address',
	'required' => true,
		));
$body .= '</div>';

$body .= '<div class="elgg-foot">';
$body .= elgg_view('input/submit', array('value' => elgg_echo('embed:embed')));
$body .= '</div>';

echo $body;