<?php

/**
 * Generate an embeddable view from a URL
 */

namespace hypeJunction\Util;

use DOMDocument;
use ElggEntity;
use ElggFile;
use Exception;
use stdClass;
use UFCOE\Elgg\Url;

class Embedder {

	protected $url;
	protected $guid;
	protected $entity;
	protected $view;
	protected $meta;
	static $cache;

	function __construct($url = '') {

		if (!self::isValidURL($url)) {
			throw new Exception("Embedder class expects a valid URL");
		}

		$this->url = $url;

		$sniffer = new Url();
		$guid = $sniffer->getGuid($this->url);
		if ($guid) {
			$this->guid = $guid;
			$this->entity = get_entity($guid);
		}
	}

	/**
	 * Validate URL format and accessibility
	 * @param string $url
	 * @return boolean
	 */
	public static function isValidURL($url = '') {
		if (!$url || !is_string($url) || !filter_var($url, FILTER_VALIDATE_URL) || !($fp = curl_init($url))) {
			return false;
		}
		return true;
	}

	/**
	 * Checks URL headers to determine whether the content type is image
	 * @param string $url
	 */
	public static function isImage($url = '') {
		if (!self::isValidURL($url)) {
			return false;
		}

		$headers = get_headers($url, 1);
		if (is_string($headers['Content-Type']) && substr($headers['Content-Type'], 0, 6) == 'image/') {
			return true;
		}
	}

	/**
	 * Get an embeddable representation of a URL
	 * @param string $url	URL to embed
	 * @param array $params	Additional params
	 * @return string		HTML
	 */
	public static function getEmbedView($url = '', $params = array()) {

		try {
			if ($url instanceof ElggEntity) {
				$url = $url->getURL();
			}
			$embedder = new Embedder($url);
			return $embedder->getView($params);
		} catch (Exception $ex) {
			return elgg_view('output/longtext', array(
				'value' => $url,
				'class' => 'embedder-invalid-url',
			));
		}
	}

	/**
	 * Determine what view to return
	 * @return string
	 */
	private function getView($params = array()) {

		if (elgg_instanceof($this->entity)) {
			return $this->getEntityView($params = array());
		} else if (self::isImage($this->url)) {
			return $this->getImageView($params = array());
		}

		return $this->getSrcView($params = array());
	}

	/**
	 * Render a uniform view for embedded entities
	 * Use 'output:entity', 'embed' hook to override the output
	 * @return string
	 */
	private function getEntityView($params = array()) {

		$entity = $this->entity;

		if ($entity instanceof ElggFile) {

			$size = ($entity->simpletype == 'image') ? 'large' : 'small';
			$output = elgg_view_entity_icon($entity, $size);
		} else {

			elgg_push_context('widgets');
			if (!isset($params['full_view'])) {
				$params['full_view'] = false;
			}
			$output = elgg_view_entity($entity, $params);
			elgg_pop_context();
		}

		$params['entity'] = $this->entity;
		$params['src'] = $this->url;

		return elgg_trigger_plugin_hook('output:entity', 'embed', $params, $output);
	}

	/**
	 * Render a uniform view for embedded links
	 * Use 'output:src', 'embed' hook to override the output
	 * @param array $params		Additional params to pass to the hook
	 * @uses boolean $params['module']	Wrap the output into an elgg-module-embed
	 * @return string
	 */
	private function getSrcView($params = array()) {

		$meta = $this->extractMeta();

		if ($meta->provider_name) {
			$class = 'embed-' . preg_replace('/[^a-z0-9\-]/i', '-', strtolower($meta->provider_name));
		}

		if ($meta->html) {
			$body = str_replace('http://', '//', $meta->html);
		} else {
			if ($meta->oembed_url && $meta->type == 'photo') {
				$icon = elgg_view('output/url', array(
					'text' => elgg_view('output/img', array(
						'src' => str_replace('http://', '//', $meta->oembed_url),
						'alt' => $meta->title,
					)),
					'href' => $meta->canonical,
					'class' => 'embedder-photo',
					'target' => '_blank',
				));
			}
			if ($meta->thumbnail_url) {
				$icon = elgg_view('output/img', array(
					'src' => $meta->thumbnail_url,
					'width' => 100,
					'class' => 'embedder-thumbnail',
				));
			}
		}

		if (!$body && $meta->description) {
			$body .= elgg_view('output/longtext', array(
				'value' => elgg_get_excerpt($meta->description),
				'class' => 'embedder-description'
			));
		}

		$footer = elgg_view('output/url', array(
			'href' => ($meta->canonical) ? $meta->canonical : $meta->url,
			'target' => '_blank',
		));

		if (!$body) {
			$body = $footer;
			$footer = false;
		}

		if ($icon) {
			$body = elgg_view_image_block($icon, $body, array(
				'class' => 'embedder-image-block',
			));
		}

		if (elgg_extract('module', $params, true)) {
			$output = elgg_view_module('embed', $meta->title, $body, array(
				'class' => $class,
				'footer' => $footer,
			));
		} else {
			$output = $body;
		}

		$params['src'] = $this->url;
		$params['meta'] = $meta;

		return elgg_trigger_plugin_hook('output:src', 'embed', $params, $output);
	}

	/**
	 * Wrap an image url into a params tag
	 * @param type $params
	 */
	public function getImageView($params = array()) {

		$body = elgg_view('output/img', array(
			'src' => $this->url,
		));

		$output = elgg_view_module('embed', false, $body, array(
			'footer' => elgg_view('output/url', array(
				'href' => $this->url,
			))
		));
		return elgg_trigger_plugin_hook('output:image', 'embed', $params, $output);
	}

	/**
	 * Extract page meta tags
	 * @return array
	 */
	public function extractMeta() {

		if (isset(self::$cache[$this->url])) {
			return self::$cache[$this->url];
		}

		$this->prepareMeta();

		self::$cache[$this->url] = $this->meta;
		return $this->meta;
	}

	/**
	 * Get contents of a remote page
	 * @param string $url
	 * @return string
	 */
	private function getContents($url = '') {

		if (!$url) {
			$url = $this->url;
		}

		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:27.0) Gecko/20100101 Firefox/27.0');
		curl_setopt($ch, CURLOPT_POST, false);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

//		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
//		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

		$response = curl_exec($ch);
		curl_close($ch);

		return $response;
	}

	/**
	 * Extract meta tags and oEmbed embed code from the remote URL
	 * @return void
	 */
	private function prepareMeta() {

		if (!$this->meta) {
			$this->meta = new stdClass();
		}

		$this->meta->url = $this->url;
		$this->meta->title = parse_url($this->url, PHP_URL_HOST);
		$this->meta->description = '';
		$this->meta->thumbnails = array();
		$this->meta->icons = array();

		$html = $this->getContents();

		$doc = new DOMDocument();
		@$doc->loadHTML($html);

		// Get document title
		$node = $doc->getElementsByTagName('title');
		$title = $node->item(0)->nodeValue;
		if ($title) {
			$this->meta->title = $title;
		}

		// Get oEmbed content and canonical URLs
		$nodes = $doc->getElementsByTagName('link');
		foreach ($nodes as $node) {
			$rel = $node->getAttribute('rel');
			$href = $node->getAttribute('href');

			switch ($rel) {

				case 'icon' :
					$this->meta->icons[] = $href;
					break;

				case 'canonical' :
					$this->meta->canonical = $href;
					break;

				case 'alternate' :
					$type = $node->getAttribute('type');
					if ($type == 'application/json+oembed' || $type == 'text/json+oembed') {
						$oembed_endpoint = $href;
					}
					break;
			}
		}

		if ($oembed_endpoint) {
			$json = $this->getContents($oembed_endpoint);
			if ($json) {
				$oembed_params = json_decode($json, true);
				if ($oembed_params) {
					foreach ($oembed_params as $key => $value) {
						if (!$this->meta->$key) {
							$this->meta->$key = $value;
						}
						if ($key == 'url') {
							$this->meta->oembed_url = $value;
						}
						if ($key == 'thumbnail_url' && !$this->meta->oembed_url) {
							$this->meta->oembed_url = $value;
						}
					}
				}
			}
		}

		if ($title) {
			$this->meta->title = $title;
		}

		$nodes = $doc->getElementsByTagName('meta');
		if (!empty($nodes)) {
			foreach ($nodes as $node) {
				$name = $node->getAttribute('name');
				if (!$name) {
					$name = $node->getAttribute('property');
				}
				$content = $node->getAttribute('content');

				switch ($name) {

					default :
						if ($name && !$this->meta->$name) {
							$name = str_replace(':', '_', $name);
							$this->meta->$name = $content;
						}
						break;

					case 'title' :
					case 'og:title' :
					case 'twitter:title' :
						if (!$this->meta->title) {
							$this->meta->title = $content;
						}
						break;

					case 'description' :
					case 'og:description' :
					case 'twitter:description' :
						if (!$this->meta->description) {
							$this->meta->description = $content;
						}
						break;

					case 'keywords' :
						$this->meta->keywords = $content;
						break;

					case 'og:site_name' :
					case 'twitter:site' :
						if (!$this->meta->provider_name) {
							$this->meta->provider_name = $content;
						}
						break;

					case 'og:type' :
						$this->meta->og_type = $content;
						break;

					case 'og:image' :
					case 'twitter:image' :
						$this->meta->thumbnails[] = $content;
						break;
				}
			}
		}

		if (count($this->meta->thumbnails)) {
			// Display a thumbnail parsed from <meta> tags
			$this->meta->thumbnail_url = $this->meta->thumbnails[0];
		} else if (count($this->meta->icons)) {
			// Display an icon parsed from <link> tags
			$this->meta->thumbnail_url = $this->meta->icons[0];
		} else {
			// Display a favicon
			$this->meta->thumbnail_url = $favicon = "http://g.etfv.co/{$this->url}";
		}

	}

}
