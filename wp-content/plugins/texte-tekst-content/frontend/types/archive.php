<?php

namespace TexteTekst\Content\Frontend\Type;

use TexteTekst\Content\Main;
use TexteTekst\Content\Core\Type;
use TexteTekst\Content\Core\Utility;
use WP_Query;

class Archive {

	public function __construct() {
		add_action( 'wp', [ $this, 'init' ], 10 );
		add_action( 'pre_get_posts', [ $this, 'query' ], 9999 );
	}

	public function init() {
		if ( is_archive() ) {
			add_filter( THEMEDOMAIN . '-post_featured_class', [ $this, 'thumbnail_classes' ] );
			add_action( THEMEDOMAIN . '-archive_footer', [ $this, 'sidebar' ] );

			if ( get_post_type() === Type\Book::POST_TYPE ) {
				add_action( THEMEDOMAIN . '-after_article_header', [ $this, 'writer' ] );
				add_action( THEMEDOMAIN . '-after_main_content', [ $this, 'pagination' ] );
			}

			if ( ! is_tax( Type\Taxonomy\Page_Category::TERM ) ) {
				add_action( THEMEDOMAIN . '-after_main_content', [ $this, 'pagination' ] );
			}
		}

		if ( is_home() || is_tax() ) {
			add_filter( THEMEDOMAIN . '-post_featured_class', [ $this, 'thumbnail_classes' ] );
			add_filter( 'template_include', [ $this, 'page_template' ], 99 );
		}

		if ( is_search() ) {
			add_filter( THEMEDOMAIN . '-post_featured_class', [ $this, 'thumbnail_classes' ] );
			//add_action( THEMEDOMAIN . '-after_article_header', [ $this, 'writer' ] );
			add_action( THEMEDOMAIN . '-after_main_content', [ $this, 'pagination' ] );
			add_action( THEMEDOMAIN . '-archive_footer', [ $this, 'sidebar' ] );
		}
	}

	public function writer() {
		$post = $this->get_writer();
		$nationality = get_post_meta( $post->ID, Type\Meta\Writer::PREFIX . 'writer_nationality', TRUE );

		$writer = sprintf(
			'<a href="%s" class="writer">%s (%s)</a>',
			get_permalink( $post->ID ),
			$post->post_title,
			strtoupper( $nationality )
		);

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

	public function query( $query ) {
		$year = intval( $_GET['publication'] );
		$language = htmlspecialchars( $_GET['languages'] );
		$categories = htmlspecialchars( $_GET['categories'] );

		if ( ! is_admin() && is_search() ) {
			$meta_query = [];
			$tax_query = [];

			if ( ! empty( $year ) ) {
				$meta_query[] = [
					'key'     => Type\Meta\Book::PREFIX . 'book_year',
					'value'   => $year,
					'compare' => '=',
				];
			}

			if ( ! empty( $language ) ) {
				$meta_query[] = [
					'key'     => Type\Meta\Book::PREFIX . 'book_original_language',
					'value'   => $language,
					'compare' => '=',
				];
			}

			if ( ! empty( $categories ) ) {
				$tax_query[] = [
					'taxonomy' => Type\Taxonomy\Book_Category::TERM,
					'field'    => 'term_id',
					'terms'    => $categories,
				];
			}

			$query->set( 'post_type', Type\Book::POST_TYPE );
			$query->set( 'meta_query', $meta_query );
			$query->set( 'tax_query', $tax_query );
			$query->set( 's', '' );
		}
	}
}
