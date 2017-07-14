<?php

$warning = elgg_echo('embed:code:help');
echo elgg_format_element('p', [
        'class' => 'elgg-text-help message is-warning',
], $warning);

echo elgg_view_form('embed/code', array(
	'class' => 'elgg-form-embed-code',
		), $vars);
?>

<script>
	require(['embed/tab/code']);
</script>