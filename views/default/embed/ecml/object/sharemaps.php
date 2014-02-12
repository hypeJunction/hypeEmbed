<?php

$sharemaps = $vars['entity'];

$filename = $shareamps->originalfilename;

if (empty($filename)) {  // gmap link
	echo elgg_view('output/embed', array(
		'value' => $shareamps->gmaplink
	));
	return;
}

//Read map width and height from settings
$mapwidth = trim(elgg_get_plugin_setting('map_width', 'sharemaps'));
if (strripos($mapwidth, '%') === false) {
	if (is_numeric($mapwidth))
		$mapwidth = $mapwidth . 'px';
	else
		$mapwidth = '100%';
}

$mapheight = trim(elgg_get_plugin_setting('map_height', 'sharemaps'));
if (strripos($mapheight, '%') === false) {
	if (is_numeric($mapheight))
		$mapheight = $mapheight . 'px';
	else
		$mapheight = '500px';
}


$mapfile = $sharemaps->getFilenameOnFilestore();

// check if kml file
$pos = strripos($mapfile, '.kml');

// check if kmz file
if ($pos === false) {
	$pos = strripos($mapfile, '.kmz');
}

if ($pos != false) {
	elgg_load_css('kmlcss');
	elgg_load_js('gkml');
	elgg_load_js('kml');

	//add time parameter to load kml map
	date_default_timezone_set('UTC');

	// assign maps folder location elgg_get_plugins_path()
	$mapspath = elgg_get_plugins_path() . 'sharemaps/maps/';
	// remove files older than 15 minutes
	$files = glob($mapspath . '*'); // get all file names
	foreach ($files as $file) { // iterate files
		if (is_file($file)) {
			$ttt = (time() - filemtime($file));
			if ($ttt > 900) {
				unlink($file);
			}
		}
	}

	// create new kml file with random filename
	$randomString = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyz"), 0, 10);
	$my_file = $randomString . '.kml';
	$handle = fopen($mapspath . $my_file, 'w') or die('Cannot open kml file. Make sure that folder mod/sharemaps/maps is writable from web server');

	// write entity kml content to file
	fwrite($handle, file_get_contents($mapfile));
	fclose($handle);
	$kmlurl = elgg_get_site_url() . 'mod/sharemaps/maps/' . $my_file . '?t=' . time();
	$content .= '<script language="javascript" type="text/javascript">';
	$content .= 'window.onload = function () {';
	$content .= 'initialize(encodeURI("' . $kmlurl . '"));';
	$content .= '}';
	$content .= '</script>';
	$content .= '<br />';
	$content .= '<div id="map_canvas" style="width:' . $mapwidth . '; height:' . $mapheight . '; border:1px solid #eee; "></div>';
}

echo $content;
