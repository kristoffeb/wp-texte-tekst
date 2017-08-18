<?php

namespace TexteTekst\Content\Frontend\Type;

use TexteTekst\Content\Main;
use TexteTekst\Content\Core\Type;
use TexteTekst\Content\Core\Utility;
use WP_Query;

class Archive {

	public function __construct() {
		add_action( 'wp', [ $this, 'init' ], 10 );
	}

	public function init() {
		if ( is_archive() ) {
			add_filter( THEMEDOMAIN . '-post_featured_class', [ $this, 'thumbnail_classes' ] );
			add_action( THEMEDOMAIN . '-archive_footer', [ $this, 'sidebar' ] );
			add_action( THEMEDOMAIN . '-after_main_content', [ $this, 'pagination' ] );

			if ( get_post_type() === Type\Book::POST_TYPE ) {
				add_action( THEMEDOMAIN . '-after_article_header',  [ $this, 'writer' ] );
			}
		}

		if ( is_home() || is_tax() ) {
			add_filter( THEMEDOMAIN . '-post_featured_class', [ $this, 'thumbnail_classes' ] );
			add_action( THEMEDOMAIN . '-after_main_content', [ $this, 'pagination' ] );
			add_filter( 'template_include', [ $this, 'page_template' ], 99 );
		}
	}

	public function writer() {
		$post = $this->get_writer();

		$writer = sprintf( '<a href="%s" class="writer">%s</a>', get_permalink( $post->ID ), $post->post_title );

		echo $writer;
	}

	public static function get_writer() {
		$args = [
			'connected_type'  => 'book_to_writer',
			'connected_items' => get_the_ID(),
			'posts_per_page'  => 1,
		];

		$writer = new WP_Query( $args );

		return $writer->post;
	}

	public function thumbnail_classes( $classes ) {
		$new_classes = [ $classes, 'small' ];

		return implode( ' ', $new_classes );
	}

	public function sidebar() {
		ob_start();

			if ( get_post_type() === Type\Book::POST_TYPE ) {
				$this->get_search();
			}

		$content = ob_get_clean();

		Main::get_template_part( 'partials/block.html', [
			'class'   => 'sidebar',
			'content' => $content,
		] );
	}

	public function get_search() {
		get_template_part( 'partial/search', 'form' );
	}

	public function pagination() {
		$pagination = sprintf( '<span class="label">%s:</span> %s', __( 'Pages', Main::TEXT_DOMAIN ), paginate_links() );

		Main::get_template_part( 'partials/block.html', [
			'class'   => 'pagination inner-grid',
			'content' => $pagination,
		] );
	}

	public function page_template() {
		get_template_part( 'archive' );
	}
}
