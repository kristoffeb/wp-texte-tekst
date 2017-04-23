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
		// Main::require_file( 'admin/settings.php' );
	}

	/**
	 * Run core bootstrap hooks.
	 */
	public function init() {
		// $settings = new Settings();
	}
}
