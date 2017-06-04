<?php

namespace TexteTekst\Content\Core\Type\P2P;

use TexteTekst\Content\Main;
use TexteTekst\Content\Core\Type;

class Book {

	public function __construct() {
		add_action( 'p2p_init', [ $this, 'connection' ] );
	}

	public function connection() {
		p2p_register_connection_type( [
			'title'    =>  [
				'from' => __( 'Book Writer', Main::TEXT_DOMAIN ),
				'to'   => __( 'Written Books', Main::TEXT_DOMAIN ),
			],
			'name'     => 'book_to_writer',
			'from'     => Type\Book::POST_TYPE,
			'to'       => Type\Writer::POST_TYPE,
			'sortable' => 'any',
			/*'admin_box' => array(
				'show' => 'from',
			),*/
		] );

		p2p_register_connection_type( [
			'title'      => __( 'Related Books', Main::TEXT_DOMAIN ),
			'name'       => 'book_to_book',
			'from'       => Type\Book::POST_TYPE,
			'to'         => Type\Book::POST_TYPE,
			'reciprocal' => TRUE,
			'sortable'   => 'any',
			/*'admin_box' => array(
				'show' => 'from',
			),*/
		] );
	}
}
