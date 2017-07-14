<?php

$english = array(

	'embed:posts' => 'Posts',
	'embed:player' => 'Player',
	'embed:assets' => 'Assets',
	'embed:buttons' => 'Buttons',

	'embed:assets:help' => 'For improved performance, site administrator can use static asset for recurring embedding. Upload your image files to %s and flush the caches for the files to appear under this tab.',

	'embed:code:help' => 'This operation is insecure. Do not paste code from untrusted sources.',
	
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

	'embed:buttons:text' => 'Button text',
	'embed:buttons:type' => 'Button style',
	'embed:buttons:type:action' => 'Action',
	'embed:buttons:type:submit' => 'Submit',
	'embed:buttons:type:delete' => 'Delete',
	'embed:buttons:type:cancel' => 'Cancel',
	'embed:buttons:address' => 'URL',
	'embed:buttons:target' => 'Target',
	'embed:buttons:target:self' => 'Same window',
	'embed:buttons:target:blank' => 'New window',
	'embed:buttons:target:lightbox' => 'Lightbox',

	'embed:code' => 'HTML',
	'embed:code:html' => 'Insecure HTML',
	'embed:code:html:empty' => 'HTML code should not be empty',

);

add_translation("en", $english);