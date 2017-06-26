<?php

$content = elgg_view('page/elements/body', $vars);

$body = <<<__BODY
<div class="elgg-page elgg-page-lightbox">
	<div class="elgg-page-body">
		<div class="elgg-inner">
			$content
		</div>
	</div>
</div>
__BODY;

$body .= elgg_view('page/elements/foot');

$head = elgg_view('page/elements/head', $vars['head']);

$params = array(
	'head' => $head,
	'body' => $body,
);

if (isset($vars['body_attrs'])) {
	$params['body_attrs'] = $vars['body_attrs'];
}

echo elgg_view("page/elements/html", $params);
