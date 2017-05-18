<?php

namespace TexteTekst\Content\Core\Type\P2P;

use TexteTekst\Content\Main;
use TexteTekst\Content\Core\Type;

class Book {

	public function __construct() {
		add_action( 'p2p_init', [ $this, 'connection' ] );
	}

	public function connection() {
		p2p_register_connection_type( array(
			'name'      => 'book_to_author',
			'from'      => Type\Book::POST_TYPE,
			'to'        => Type\Author::POST_TYPE,
			'sortable'  => 'any',
			/*'admin_box' => array(
				'show' => 'from',
			),
			'title' => array(
				'from' => __( 'Process', Main::TEXT_DOMAIN ),
			)*/
		) );
	}
}
