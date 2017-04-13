<?php

namespace hypeJunction\Embed;

echo elgg_view_form('embed/player', array(
	'class' => 'elgg-form-embed-player',
		), $vars);
?>
<script>
	require(['embed/tab/player']);
</script>