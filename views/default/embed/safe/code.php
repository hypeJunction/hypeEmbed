<?php

use hypeJunction\Embed\Shortcodes;

$user_guid = elgg_extract('user_guid', $vars);
$token = elgg_extract('token', $vars);

$attrs = [
	'id' => "$user_guid:$token",
];

$output = Shortcodes::getShortcodeTag('code', $attrs);

echo elgg_trigger_plugin_hook('prepare:code', 'embed', $vars, $output);
