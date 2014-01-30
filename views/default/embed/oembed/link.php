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
$description = elgg_view('output/description', array(
	'value' => $meta->description
		));
$author = (isset($meta->author)) ?
		elgg_echo('byline', array(elgg_view('output/url', array(
				'text' => $meta->author,
				'href' => $meta->author_url,
				'target' => '_blank'))
		)) :
		'';

$body = elgg_view('object/elements/summary', array(
	'title' => $title,
	'subtitle' => $author,
	'tags' => false,
	'content' => $meta->description
		));

$content = elgg_view_image_block($icon, $body);
?>

<div class="embed-ecml-oembed-link">
<?php echo $content; ?>
</div>