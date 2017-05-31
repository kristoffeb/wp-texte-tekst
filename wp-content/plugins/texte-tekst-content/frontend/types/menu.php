<?php

namespace TexteTekst\Content\Frontend\Type;

use TexteTekst\Content\Main;
use TexteTekst\Content\Core\Utility;

class Menu {

	public function __construct() {
		add_action( 'wp', [ $this, 'init' ], 10 );
	}

	public function init() {
		add_action( THEMEDOMAIN . '-before_header', [ $this, 'megamenu' ] );
		// add_filter( 'body_class', [ $this, 'body' ] );
	}

	public function body( $classes ) {
		$classes[] = 'menu-open';
		return $classes;
	}

	public function megamenu() {
		Main::get_template_part( 'partials/megamenu.html', [
			'bg_lines' => Utility::get_bg_lines(),
			'search'   => $this->get_search(),
			//'items'  => $this->get_items(),
		] );
	}

	public function get_search() {
		ob_start();
			get_template_part( 'partial/search', 'form' );
		$search = ob_get_clean();

		return $search;
	}
}
