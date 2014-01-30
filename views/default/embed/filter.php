<?php

namespace hypeJunction\Embed;

$filter_context = elgg_extract('filter_context', $vars);
elgg_set_config('embed_tab', $filter_context);

echo elgg_view_menu('embed', array(
	'sort_by' => 'priority',
));