<?php
$meta = elgg_extract('meta', $vars);

if ($meta->thumbnail_url) {
	$icon = elgg_view('output/img', array(
		'src' => $meta->thumbnail_url,
		'width' => 100,
	));
}

$title = elgg_view('output/url', array(
	'text' => $meta->title,
	'href' => ($meta->canonical) ? $meta->canonical : $meta->url,
	'target' => '_blank'
		));

$description = elgg_view('output/longtext', array(
	'value' => $meta->description
		));

$description .= elgg_view('output/url', array(
	'href' => ($meta->canonical) ? $meta->canonical : $meta->url,
	'class' => 'embed-ecml-resource',
	'target' => '_blank',
		));

$body = elgg_view('object/elements/summary', array(
	'title' => $title,
	'tags' => false,
	'content' => $description
		));

$content = elgg_view_image_block($icon, $body);
?>

<div class="embed-ecml-oembed-link">
	<?php echo $content; ?>
</div>