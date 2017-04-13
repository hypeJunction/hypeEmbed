<?php
$entity = elgg_extract('entity', $vars);

if (!$entity instanceof ElggEntity) {
	return;
}

$title = $entity->getDisplayName();

if ($entity->hasIcon('small') || $entity instanceof ElggFile) {
	$icon = elgg_view('output/img', [
		'src' => $entity->getIconURL('small'),
		'alt' => $title,
	]);
} else {
	$owner = $entity->getOwnerEntity();
	$icon = elgg_view('output/img', [
		'src' => $owner->getIconURL('small'),
		'alt' => $title,
	]);
}

$subtitle = elgg_format_element('span', [
	'class' => 'embed-type-badge elgg-badge mrs',
		], elgg_echo("item:object:{$entity->getSubtype()}"));

$subtitle .= elgg_view('page/elements/by_line', $vars);

$items[] = [
	'name' => 'embed',
	'class' => 'embed-insert-async',
	'text' => elgg_echo('embed:embed'),
	'href' => 'javascript:',
	'data-guid' => $entity->guid,
	'data-view' => 'embed/safe/entity',
];

$menu = elgg_view_menu('embed:entity', [
	'items' => $items,
	'entity' => $entity,
	'sort_by' => 'priority',
	'class' => 'elgg-menu-hz',
		]);

echo elgg_view('object/elements/summary', array(
	'entity' => $entity,
	'title' => $title,
	'subtitle' => $subtitle,
	'content' => elgg_get_excerpt($entity->description) . $menu,
	'metadata' => false,
	'tags' => $tags,
	'icon' => $icon,
));
?>
<script>
	require(['embed/lists/item']);
</script>

