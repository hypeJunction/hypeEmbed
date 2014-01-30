<?php

namespace hypeJunction\Embed;

$body_vars = array('container_guid' => elgg_get_page_owner_guid());
echo elgg_view_form('file/upload', array(
	'enctype' => 'multipart/form-data',
	'class' => 'elgg-form-embed-upload',
		), array(
	'container_guid' => elgg_get_page_owner_guid()
));