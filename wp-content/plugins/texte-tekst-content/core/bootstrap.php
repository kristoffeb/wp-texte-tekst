<?php

namespace TexteTekst\Content\Core;

use TexteTekst\Content\Main;
use TexteTekst\Content\Core\Menu\Walker_Nav_Mega_Menu;

class Bootstrap {

	public function __construct() {
		$this->includes();
		$this->init();
	}

	/**
	 * Include files.
	 */
	private function includes() {
		Main::require_file( 'core/utility.php' );

		// @TODO Get this from composer
		// https://github.com/jjgrainger/wp-custom-post-type-class/blob/master/composer.json
		if ( ! class_exists( 'Type' ) ) {
			Main::require_file( 'includes/class-custom-post-type.php' );
		}

		// Type
		Main::require_file( 'core/types/writer.php' );
		Main::require_file( 'core/types/book.php' );

		// Meta
		Main::require_file( 'core/types/meta/writer.php' );
		Main::require_file( 'core/types/meta/book.php' );
		Main::require_file( 'core/types/meta/page.php' );

		// P2P
		Main::require_file( 'core/types/p2p/book.php' );

		// Taxonomy
		Main::require_file( 'core/types/taxonomy/book-category.php' );
		Main::require_file( 'core/types/taxonomy/page-category.php' );

	}

	/**
	 * Run core bootstrap hooks.
	 */
	public function init() {
		$utility       = new Utility();

		// Book
		$book          = new Type\Book();
		$book_meta     = new Type\Meta\Book();
		$book_category = new Type\Taxonomy\Book_Category();
		$book_p2p      = new Type\P2P\Book();

		// Writer
		$writer        = new Type\Writer();
		$writer_meta   = new Type\Meta\Writer();

		// Page
		$page_meta     = new Type\Meta\Page();
		$page_category = new Type\Taxonomy\Page_Category();

		add_action( 'widgets_init', [ $this, 'register_widgets' ] );
		add_action( 'widgets_init', [ $this, 'unregister_default_widgets' ] );
	}

	public function register_widgets() {
		// register_widget( __NAMESPACE__ . '\Widget\Calendar' );
	}

	public function unregister_default_widgets() {
		unregister_widget( 'WP_Widget_Pages' );
		unregister_widget( 'WP_Widget_Calendar' );
		unregister_widget( 'WP_Widget_Archives' );
		unregister_widget( 'WP_Widget_Links' );
		unregister_widget( 'WP_Widget_Meta' );
		unregister_widget( 'WP_Widget_Search' );
		unregister_widget( 'WP_Widget_Categories' );
		unregister_widget( 'WP_Widget_Recent_Posts' );
		unregister_widget( 'WP_Widget_Recent_Comments' );
		unregister_widget( 'WP_Widget_RSS' );
		unregister_widget( 'WP_Widget_Tag_Cloud' );
	}
}
