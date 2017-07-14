<?php

$html = get_input('html', '', false);

if (!$html) {
	return elgg_error_response(elgg_echo('embed:code:html:empty'));
}

$user = elgg_get_logged_in_user_entity();

$token = elgg_build_hmac([$user->guid, $html])->getToken();

$file = new \hypeJunction\Embed\EmbedCode();
$file->owner_guid = $user->guid;
$file->setFilename("embed_code/$token.html");
$file->setMimeType('text/html');

$file->open('write');
$file->write($html);
$file->close();

$file->access_id = ACCESS_PRIVATE;
$file->token = $token;
$file->save();

$output = elgg_view('embed/safe/code', array(
	'user_guid' => $user->guid,
	'token' => $token,
));

return elgg_ok_response($output);