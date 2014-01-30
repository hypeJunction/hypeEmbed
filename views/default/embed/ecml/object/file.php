<?php
/**
 * Rendered ECML view of the file
 * Use specialcontent if available
 */

namespace hypeJunction\Embed;

$full = $vars['full_view'];
$vars['full_view'] = true;

$file = elgg_extract('entity', $vars);

$mime = $file->mimetype;
$base_type = substr($mime, 0, strpos($mime, '/'));

if (elgg_view_exists("file/specialcontent/$mime")) {
	$content = elgg_view("file/specialcontent/$mime", $vars);
} else if (elgg_view_exists("file/specialcontent/$base_type/default")) {
	$content = elgg_view("file/specialcontent/$base_type/default", $vars);
}

if (!$content) {
	$vars['full_view'] = $full;
	echo elgg_view('embed/ecml/default', $vars);
	return;
}
?>

<div class="embed-ecml-placeholder">
	<?php echo $content ?>
</div>