<?php
?>
<div class="embed-toolbar">
	<?php
    if (!elgg_extract('embed', $vars)) {
		echo elgg_view_menu('embed', [
			'sort_by' => 'priority',
			'textarea_id' => elgg_extract('id', $vars),
		]);
	}

	echo elgg_view_menu('longtext', [
		'sort_by' => 'priority',
		'class' => 'elgg-menu-embed',
		'id' => elgg_extract('id', $vars),
	]);
	?>
</div>

<div class="hidden">
    <div id="embed-toolbar-popup" class="elgg-module-popup"></div>
</div>
