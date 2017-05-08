<?php
if (!elgg_is_admin_logged_in()) {
	return;
}

$embed_asset_path = elgg_get_config('dataroot') . 'embed/';
echo elgg_format_element('div', [
	'class' => 'elgg-text-help',
		], elgg_echo('embed:assets:help', [$embed_asset_path]));

$views = elgg_list_views();
$images = array_filter($views, function($view) {
	$extension = pathinfo($view, PATHINFO_EXTENSION);
	return 0 === strpos($view, 'embed/') && in_array($extension, ['jpg', 'gif', 'png', 'svg']);
});

if (empty($images)) {
	return;
}
?>

<ul class="elgg-gallery embed-asset-gallery">
	<?php
	foreach ($images as $image) {
		?>
		<li class="elgg-item embed-item">
			<div>
				<?php
				$segments = explode('/', $image);
				array_shift($segments);
				$view = implode('/', $segments);
				echo elgg_format_element('img', array(
					'src' => elgg_normalize_url("embed/asset/$view"),
					'class' => 'embed-insert',
				));
				?>
			</div>
		</li>
		<?php
	}
	?>
</ul>
