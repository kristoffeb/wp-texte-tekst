<?php

namespace TexteTekst\Content\Admin;

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
		Main::require_file( 'admin/includes/featured-book.php' );
		Main::require_file( 'admin/includes/partners.php' );
	}

	/**
	 * Run core bootstrap hooks.
	 */
	public function init() {
		$featured_book = new Featured_Book();
		$partners      = new Partners();
	}
}
