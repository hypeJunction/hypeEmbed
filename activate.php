<?php

require_once __DIR__ . '/autoloader.php';

use hypeJunction\Embed\File;

$subtypes = array(
	'ckeditor_file' => File::class, // legacy support for files uploaded with ckeditor_addons
	'embed_file' => File::class,
	'embed_code' => \hypeJunction\Embed\EmbedCode::class,
);

foreach ($subtypes as $subtype => $class) {
	if (!update_subtype('object', $subtype, $class)) {
		add_subtype('object', $subtype, $class);
	}
}