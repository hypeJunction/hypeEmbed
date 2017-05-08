<?php

$english = array(

	'embed:posts' => 'Posts',
	'embed:player' => 'Player',
	'embed:assets' => 'Assets',

	'embed:assets:help' => 'For improved performance, site administrator can use static asset for recurring embedding. Upload your image files to %s and flush the caches for the files to appear under this tab.',
	
	'embed:ecml:error' => 'Embedded content could not be loaded because it was removed or you do not have sufficient access permissions to view it',

	'embed:player:address' => 'URL address of the content',

	'sort:object:filter:simpletype:all' => 'All types',
	'sort:object:filter:simpletype:image' => 'Images',
	'sort:object:filter:simpletype:general' => 'Other',
	'sort:object:filter:simpletype:document' => 'Documents',
	'sort:object:filter:simpletype:video' => 'Videos',
	'sort:object:filter:simpletype:audio' => 'Audio',

	'item:object:embed_file' => 'Embedded Files',
	
	'embed:upload_type' => 'Upload type',
	'embed:upload_type:file' => 'List this file under My Files and make it searchable',
	'embed:upload_type:embed_file' => 'Only use this file for embedding in documents',

	'admin:upgrades:embed:ckeditor_file' => 'Migrate CKEditor files',
	'admin:upgrades:embed:ckeditor_file:description' => 'Migrate files uploaded with CKEditor to embed-compatible storage',

	'embed:settings:river_preview' => 'Add player view to river item view',
	'embed:settings:summary_preview' => 'Add player view to item\'s summary view',

	'embed:tab:file:empty' => 'No files have been uploaded yet',
	'embed:tab:posts:empty' => 'No items have been posted yet',
);

add_translation("en", $english);