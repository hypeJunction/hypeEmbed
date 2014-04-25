<?php

namespace hypeJunciton\Embed;

global $HYPEJUNCTION_FONTS;
if (isset($HYPEJUNCTION_FONTS['open-sans'])) {
	return;
}
$HYPEJUNCTION_FONTS['open-sans'] = true;
?>
<link href='//fonts.googleapis.com/css?family=Open+Sans:400,700' rel='stylesheet' type='text/css'>