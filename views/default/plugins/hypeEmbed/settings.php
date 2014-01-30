<?php

namespace hypeJunction\Embed;

echo '<div>';
echo '<label>' . elgg_echo('embed:iframely_gateway') . '</label>';
echo '<div class="elgg-text-help">' . elgg_echo('embed:iframely_gateway:help') . '</div>';
echo elgg_view('input/url', array(
	'name' => 'params[iframely_gateway]',
	'value' => $vars['entity']->iframely_gateway,
));
echo '</div>';
?>






