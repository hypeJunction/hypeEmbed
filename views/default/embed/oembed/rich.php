<?php

namespace hypeJunction\Embed;

$meta = elgg_extract('meta', $vars);
if ($meta->provider_name) {
	$class = ' ' . preg_replace('/[^a-z0-9\-]/i', '-', strtolower($meta->provider_name));
}

$content = $meta->html;
$content .= elgg_view('output/url', array(
	'href' => ($meta->canonical) ? $meta->canonical : $meta->url,
	'class' => 'embed-ecml-resource',
	'target' => '_blank',
		));
?>

<div class="embed-ecml-oembed-rich<?php echo $class ?>">
	<?php echo $content; ?>
</div>