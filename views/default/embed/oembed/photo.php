<?php

namespace hypeJunction\Embed;

$meta = elgg_extract('meta', $vars);

$content = elgg_view('output/url', array(
	'text' => elgg_view('output/img', array(
		'src' => $meta->url,
		'alt' => $meta->title,
	)),
	'href' => $meta->canonical,
	'target' => '_blank',
		));
?>

<div class="embed-ecml-oembed-photo">
	<?php echo $content; ?>
</div>