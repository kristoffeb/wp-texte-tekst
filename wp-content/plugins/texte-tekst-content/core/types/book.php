<?php

namespace TexteTekst\Content\Core\Type;

use TexteTekst\Content\Main;
use Type;

class Book {

	const POST_TYPE = 'book';

	public function __construct() {
		$this->post_type();

		add_filter( 'pco_prd_post_types', [ $this, 'redirect' ] );
	}

	public function post_type() {
		$this->post_type = new Type( [
			'post_type_name' => self::POST_TYPE,
			'singular'       => __( 'Book', Main::TEXT_DOMAIN ),
			'plural'         => __( 'Books', Main::TEXT_DOMAIN ),
			'slug'           => __( 'book', Main::TEXT_DOMAIN ),
		],
		[
			'supports'    => [ 'title', 'thumbnail' ],
			'menu_icon'   => 'dashicons-book-alt',
			'public'      => true,
			'has_archive' => true,
			'rewrite'     => [
				'with_front' => false,
				'slug'       => __( 'book', Main::TEXT_DOMAIN ),
			],
		] );
	}

	public function redirect( $post_types ) {
		$post_types[] = self::POST_TYPE;
		return $post_types;
	}
}
