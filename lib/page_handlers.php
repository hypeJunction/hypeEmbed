<?php

namespace hypeJunction\Embed;

/**
 * Page handler for embeds
 * 
 * @param array $page
 */
function embed_page_handler($page) {

	$params = array(
		'output' => '',
		'status' => 0,
		'system_messages' => array(
			'error' => array(),
			'success' => array()
		)
	);

	$container_guid = get_input('container_guid');
	if ($container_guid && get_entity($container_guid)) {
		elgg_set_page_owner_guid($container_guid);
	}

	switch ($page[0]) {

		default :
		case 'tab' :

			// We do not want to serve this page via non-xhr requests
			if (!elgg_is_xhr()) {
				register_error(elgg_echo('embed:error:non_xhr_request'));
				forward(REFERER);
			}

			$default_tab = (elgg_is_active_plugin('file')) ? 'file' : 'content_items';
			$embed_tab = elgg_extract(1, $page, $default_tab);

			$title = elgg_echo("embed:embed");

			$filter = elgg_view('embed/filter', array(
				'filter_context' => $embed_tab
			));

			$view = "embed/tab/$embed_tab";
			if (elgg_view_exists($view)) {
				$content = elgg_view($view);
			}

			if (empty($content)) {
				$content = elgg_autop(elgg_echo('embed:section:invalid'));
			}

			$params['output'] = elgg_view_layout('one_column', array(
				'title' => $title,
				'content' => $filter . $content,
				'class' => 'embed-wrapper'
			));
			break;
	}

	$system_messages = system_messages(NULL, "");
	if (isset($system_messages['success'])) {
		$params['system_messages']['success'] = $system_messages['success'];
	}
	if (isset($system_messages['error'])) {
		$params['system_messages']['error'] = $system_messages['error'];
		$params['status'] = -1;
	}

	echo json_encode($params);
	exit;
}
