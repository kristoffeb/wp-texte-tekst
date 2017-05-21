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
		Main::require_file( 'frontend/types/page.php' );
	}

	/**
	 * Run core bootstrap hooks.
	 */
	public function init() {
		// $load_template = new Load_Template();
		$page = new Type\Page();
	}
}
