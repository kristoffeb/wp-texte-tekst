<?php

namespace TexteTekst\Content\Frontend\Type;

use TexteTekst\Content\Main;
use TexteTekst\Content\Core\Type;
use TexteTekst\Content\Core\Utility;
use WP_Query;

class Single {

	public function __construct() {
		add_action( 'wp', [ $this, 'init' ], 10 );
	}

	public function init() {
		if ( is_page() && ! is_front_page() ) {
			add_action( THEMEDOMAIN . '-after_article_content',  [ $this, 'sidebar' ] );
		}
	}

	public function sidebar() {
		ob_start();

			$this->get_breadcrumbs();

		$content = ob_get_clean();

		Main::get_template_part( 'partials/block.html', [
			'class'   => 'sidebar breadcrumbs items-list',
			'content' => $content,
		] );
	}

	public function get_breadcrumbs() {
		\TexteTekst\main_menu();
	}
}
