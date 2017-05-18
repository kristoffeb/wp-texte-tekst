<?php

namespace TexteTekst\Content\Core\Type;

use TexteTekst\Content\Main;
use Type;

class Author {

	const POST_TYPE = 'author';

	public function __construct() {
		$this->post_type();

		add_filter( 'pco_prd_post_types', [ $this, 'redirect' ] );
	}

	public function post_type() {
		$this->post_type = new Type( [
			'post_type_name' => self::POST_TYPE,
			'singular'       => __( 'Author', Main::TEXT_DOMAIN ),
			'plural'         => __( 'Authors', Main::TEXT_DOMAIN ),
			'slug'           => __( 'author', Main::TEXT_DOMAIN ),
		],
		[
			'supports'    => [ 'title', 'thumbnail', 'editor', 'excerpt' ],
			'menu_icon'   => 'dashicons-edit',
			'public'      => true,
			'has_archive' => true,
			'rewrite'     => [
				'with_front' => false,
				'slug'       => __( 'author', Main::TEXT_DOMAIN ),
			],
		] );
	}

	public function redirect( $post_types ) {
		$post_types[] = self::POST_TYPE;
		return $post_types;
	}
}
