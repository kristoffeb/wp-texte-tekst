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
		if ( is_singular( 'post' ) ) {
			add_action( THEMEDOMAIN . '-before_article', [ $this, 'open_wrap' ] );
			add_action( THEMEDOMAIN . '-after_article',  [ $this, 'close_wrap' ] );
		}
	}

	public function open_wrap() {
		echo '<div class="content-wrap">';
	}

	public function close_wrap() {
		echo '</div>';
	}
}
