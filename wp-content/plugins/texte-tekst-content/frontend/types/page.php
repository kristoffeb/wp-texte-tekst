<?php

namespace TexteTekst\Content\Frontend\Type;

use TexteTekst\Content\Main;
use TexteTekst\Content\Core\Type;
use WP_Query;

class Page {

	public function __construct() {
		add_action( 'wp', [ $this, 'init' ], 10 );
	}

	public function init() {
		if ( is_front_page() ) {
			add_action( THEMEDOMAIN . '-main_front_page', [ $this, 'frontpage' ] );
		}
	}

	public function frontpage() {
		$page_id = get_option( 'page_on_front' );

		$frontpage = new WP_Query( [ 'page_id' => $page_id ] );

		if ( $frontpage->have_posts() ) :
			while ( $frontpage->have_posts() ) : $frontpage->the_post();
				get_template_part( 'template-part/content', 'page' );
			endwhile;
		endif;
	}
}
