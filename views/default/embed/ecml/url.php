<?php

namespace hypeJunction\Embed;

$url = elgg_extract('src', $vars);
$content = elgg_trigger_plugin_hook('format:src', 'embed', $vars, $url);

?>

<div class="embed-ecml-placeholder">
	<?php
		echo $content;
	?>
</div>