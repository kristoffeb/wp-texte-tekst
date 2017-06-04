<?php

namespace TexteTekst\Content\Core\Type;

use TexteTekst\Content\Main;
use Type;

class Book {

	const POST_TYPE = 'book';

	public function __construct() {
		$this->post_type();
	}

	public function post_type() {
		$this->post_type = new Type( [
			'post_type_name' => self::POST_TYPE,
			'singular'       => __( 'Book', Main::TEXT_DOMAIN ),
			'plural'         => __( 'Books', Main::TEXT_DOMAIN ),
			'slug'           => 'book',
		],
		[
			'supports'    => [ 'title', 'thumbnail', 'editor', 'excerpt' ],
			'menu_icon'   => 'dashicons-book-alt',
			'public'      => true,
			'has_archive' => true,
			'rewrite'     => [
				'with_front' => false,
				'slug'       => 'book',
			],
		] );
	}
}
