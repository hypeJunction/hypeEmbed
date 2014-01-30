<?php

namespace hypeJunction\Embed;

$meta = elgg_extract('meta', $vars);
if ($meta->provider_name) {
	$class = ' ' . preg_replace('/[^a-z0-9\-]/i', '-', strtolower($meta->provider_name));
}
?>

<div class="embed-ecml-oembed-rich<?php echo $class ?>">
	<?php echo $meta->html; ?>
</div>