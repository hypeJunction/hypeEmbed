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
	'class' => 'embed-type-badge',
], elgg_echo("item:object:{$entity->getSubtype()}"));

$subtitle .= elgg_view('page/elements/by_line', $vars);

$items[] = [
	'name' => 'embed',
	'text' => elgg_echo('embed:embed'),
	'href' => 'javascript:',
	'data-guid' => $entity->guid,
	'data-view' => 'embed/safe/entity',
	'link_class' => 'elgg-button embed-insert-async',
];

$menu = elgg_view_menu('embed:entity', [
	'items' => $items,
	'entity' => $entity,
	'sort_by' => 'priority',
	'class' => 'elgg-menu-hz',
]);
?>

<div class="embed-list-item">
    <div class="embed-list-item__icon">
		<?= $icon ?>
    </div>
    <div class="embed-list-item__body">
        <div class="embed-list-item__title">
			<?= $title ?>
        </div>
        <div class="embed-list-item__subtitle">
			<?= $subtitle ?>
        </div>
    </div>
    <div class="embed-list-item__menu">
		<?= $menu ?>
    </div>
</div>
