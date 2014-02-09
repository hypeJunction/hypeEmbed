<?php

namespace hypeJunction\Embed;

$url = elgg_extract('src', $vars);

$default = elgg_view('output/url', array(
	'href' => $url,
	'text' => $url,
	'title' => 'oembed'
));

$content = elgg_trigger_plugin_hook('output:src', 'embed', array(
	'url' => $url,
		), $default);

$content .= elgg_view('output/url', array(
	'href' => $url,
	'class' => 'embed-ecml-resource',
	'target' => '_blank',
		));
?>

<div class="embed-ecml-placeholder">
	<?php echo $content ?>
</div>