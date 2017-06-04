<?php

namespace TexteTekst\Content\Core\Type;

use TexteTekst\Content\Main;
use Type;

class Writer {

	const POST_TYPE = 'writer';

	public function __construct() {
		$this->post_type();
	}

	public function post_type() {
		$this->post_type = new Type( [
			'post_type_name' => self::POST_TYPE,
			'singular'       => __( 'Writer', Main::TEXT_DOMAIN ),
			'plural'         => __( 'Writers', Main::TEXT_DOMAIN ),
			'slug'           => 'writer',
		],
		[
			'supports'    => [ 'title', 'thumbnail', 'editor', 'excerpt' ],
			'menu_icon'   => 'dashicons-edit',
			'public'      => true,
			'has_archive' => true,
			'rewrite'     => [
				'with_front' => false,
				'slug'       => 'writer',
			],
		] );
	}
}
