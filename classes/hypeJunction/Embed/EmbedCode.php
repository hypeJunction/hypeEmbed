<?php

namespace hypeJunction\Embed;

class EmbedCode extends \ElggFile {

	const SUBTYPE = 'embed_code';

	/**
	 * {@inheritdoc}
	 */
	protected function initializeAttributes() {
		parent::initializeAttributes();
		$this->attributes['subtype'] = self::SUBTYPE;
	}
}
