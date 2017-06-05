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
		Main::require_file( 'frontend/types/archive.php' );
		Main::require_file( 'frontend/types/book.php' );
		Main::require_file( 'frontend/types/frontpage.php' );
		Main::require_file( 'frontend/types/menu.php' );
		Main::require_file( 'frontend/types/search.php' );
		Main::require_file( 'frontend/types/single.php' );
		Main::require_file( 'frontend/types/writer.php' );
	}

	/**
	 * Run core bootstrap hooks.
	 */
	public function init() {
		$archive   = new Type\Archive();
		$book      = new Type\Book();
		$frontpage = new Type\Frontpage();
		$menu      = new Type\Menu();
		$search    = new Type\Search();
		$single    = new Type\Single();
		$writer    = new Type\Writer();
	}
}
