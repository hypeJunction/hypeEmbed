<?php

namespace hypeJunction\Embed;

class File extends \ElggFile {

	const SUBTYPE = 'embed_file';

	/**
	 * {@inheritdoc}
	 */
	protected function initializeAttributes() {
		parent::initializeAttributes();
		$this->attributes['subtype'] = self::SUBTYPE;
	}
}
