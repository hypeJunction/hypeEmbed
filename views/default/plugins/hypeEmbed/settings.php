<?php

namespace hypeJunction\Embed;

echo '<h3>' . elgg_echo('embed:iframely') . '</h3>';

echo '<div>';
echo '<label>' . elgg_echo('embed:iframely_gateway') . '</label>';
echo '<div class="elgg-text-help">' . elgg_echo('embed:iframely_gateway:help') . '</div>';
echo elgg_view('input/url', array(
	'name' => 'params[iframely_gateway]',
	'value' => $vars['entity']->iframely_gateway,
));
echo '</div>';
