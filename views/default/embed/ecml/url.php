<?php

namespace hypeJunction\Embed;

use hypeJunction\Util\Embedder;

$url = elgg_extract('src', $vars);

$content = Embedder::getEmbedView($url, $vars);

?>

<div class="embed-ecml-placeholder">
	<?php echo $content ?>
</div>