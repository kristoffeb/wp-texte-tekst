<?php

namespace TexteTekst\Content\Core\Type\P2P;

use TexteTekst\Content\Main;
use TexteTekst\Content\Core\Type;

class Artist {

	public function __construct() {
		add_action( 'p2p_init', [ $this, 'connection' ] );
	}

	public function connection() {
		p2p_register_connection_type( array(
			'name'      => 'work_to_artist',
			'from'      => Type\Work::POST_TYPE,
			'to'        => Type\Artist::POST_TYPE,
			'sortable'  => 'any',
			/*'admin_box' => array(
				'show' => 'from',
			),
			'title' => array(
				'from' => __( 'Process', Main::TEXT_DOMAIN ),
			)*/
		) );

		p2p_register_connection_type( array(
			'name'      => 'event_to_artist',
			'from'      => Type\Event::POST_TYPE,
			'to'        => Type\Artist::POST_TYPE,
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
