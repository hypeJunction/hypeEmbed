<?php

$id = elgg_extract('id', $vars);

list($user_guid, $token) = explode(':', $id, 2);

$file = new \hypeJunction\Embed\EmbedCode();
$file->owner_guid = $user_guid;
$file->setFilename("embed_code/$token.html");

if (!$file->exists()) {
	return;
}

$code = $file->grabFile();

echo elgg_format_element('div', [
	'class' => 'embed-code-wrapper',
], $code);
