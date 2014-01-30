<?php

namespace hypeJunction\Embed;

use ElggMenuItem;

$tabs = array();

foreach ($vars['menu']['default'] as $item) {
	if (!$item instanceof ElggMenuItem) {
		continue;
	}

	$name = $item->getName();
	$title = $item->getText();
	$url = ($item->getHref()) ? $item->getHref() : "embed/tab/{$name}";
	$class = ($item->getLinkClass()) ? $item->getLinkClass() : "embed-section embed-section-{$name}";
	$selected = $item->getSelected();

	$tabs[] = array(
		'title' => $title,
		'url' => $url,
		'link_class' => $class,
		'selected' => $selected,
	);
}

if (empty($tabs)) {
	return;
}

echo elgg_view('navigation/tabs', array('tabs' => $tabs));
