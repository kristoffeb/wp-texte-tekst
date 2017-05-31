<?php

namespace TexteTekst\Content\Frontend;

use TexteTekst\Content\Main;

class Bootstrap {

	public function __construct() {
		$this->includes();
		$this->init();
	}

	/**
	 * Include files.
	 */
	private function includes() {
		// Main::require_file( 'frontend/includes/load-template.php' );
		Main::require_file( 'frontend/types/book.php' );
		Main::require_file( 'frontend/types/frontpage.php' );
		Main::require_file( 'frontend/types/menu.php' );
		Main::require_file( 'frontend/types/search.php' );
	}

	/**
	 * Run core bootstrap hooks.
	 */
	public function init() {
		// $load_template = new Load_Template();
		$book      = new Type\Book();
		$frontpage = new Type\Frontpage();
		$menu      = new Type\Menu();
		$search    = new Type\Search();
	}
}
