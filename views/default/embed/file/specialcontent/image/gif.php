<?php

$download_url = elgg_get_download_url($file);

if ($vars['full_view']) {
	echo <<<HTML
		<div class="file-photo">
			<a href="$download_url" class="elgg-lightbox-photo"><img class="elgg-photo" src="$download_url" /></a>
		</div>
HTML;
}