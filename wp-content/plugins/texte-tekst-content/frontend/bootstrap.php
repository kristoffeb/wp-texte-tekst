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
		Main::require_file( 'frontend/types/frontpage.php' );
		Main::require_file( 'frontend/types/search.php' );
	}

	/**
	 * Run core bootstrap hooks.
	 */
	public function init() {
		// $load_template = new Load_Template();
		$frontpage = new Type\Frontpage();
		$search    = new Type\Search();
	}
}
