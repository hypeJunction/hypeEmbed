<?php

$entity = elgg_extract('entity', $params);

echo elgg_view('output/embed', array(
	'value' => $entity->address
));