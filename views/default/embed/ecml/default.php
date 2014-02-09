<?php
/**
 * Default rendered entity view
 */

namespace hypeJunction\Embed;

$entity = elgg_extract('entity', $vars);

if (!isset($vars['full_view'])) {
	$vars['full_view'] = false;
}

elgg_push_context('widgets');
$view = elgg_view_entity($entity, $vars);
elgg_pop_context();

if (!$view) {
	echo elgg_view('embed/ecml/error');
	return;
}

$view .= elgg_view('output/url', array(
	'href' => $entity->getURL(),
	'class' => 'embed-ecml-resource'
		));

?>

<div class="embed-ecml-placeholder">
	<?php echo $view ?>
</div>