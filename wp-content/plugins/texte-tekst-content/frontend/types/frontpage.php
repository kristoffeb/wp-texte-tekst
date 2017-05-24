<?php

namespace TexteTekst\Content\Frontend\Type;

use TexteTekst\Content\Main;
use TexteTekst\Content\Core\Type;
use TexteTekst\Content\Core\Utility;
use WP_Query;

class Frontpage {

	public function __construct() {
		add_action( 'wp', [ $this, 'init' ], 10 );
	}

	public function init() {
		if ( is_front_page() ) {
			add_action( THEMEDOMAIN . '-main_front_page', [ $this, 'intro' ] );
			add_action( THEMEDOMAIN . '-article_footer', [ $this, 'cta' ] );
			add_action( THEMEDOMAIN . '-main_front_page', [ $this, 'partners' ] );
			add_action( THEMEDOMAIN . '-main_front_page', [ $this, 'columns' ] );
		}
	}

	public function intro() {
		ob_start();

			$this->get_frontpage();
			$this->get_featured();

		$content = ob_get_clean();

		$intro = sprintf( '<section class="intro"><div class="inner-grid">%s</div></section>', $content );

		echo $intro;
	}

	public function get_frontpage() {
		$page_id = get_option( 'page_on_front' );

		$frontpage = new WP_Query( [ 'page_id' => $page_id ] );

		if ( $frontpage->have_posts() ) :
			while ( $frontpage->have_posts() ) : $frontpage->the_post();
				get_template_part( 'template-part/content', 'page' );
			endwhile;
		endif;
	}

	public function cta() {
		$page_id = get_post_meta( get_the_ID(), Type\Meta\Page::PREFIX . 'frontpage_cta_page', true );
		$text = get_post_meta( get_the_ID(), Type\Meta\Page::PREFIX . 'frontpage_cta_text', true );

		$link = sprintf( '<a href="%s" class="button">%s</a>', get_permalink( $page_id ), $text );

		echo $link;
	}

	public function get_featured() {
		$featured_id = $this->get_featured_id();
		$image = wp_get_attachment_image_src( get_post_thumbnail_id( $featured_id ), 'large' );

		$title = sprintf(
			'<strong>%s</strong> <em>%s</em>, %s',
			__( 'Featured book', Main::TEXT_DOMAIN ),
			get_the_title( $featured_id ),
			$this->get_author( $featured_id )->post_title
		);

		Main::get_template_part( 'partials/book-loop.html', [
			'cover'      => isset( $image ) ? $image[0] : '',
			'title'      => $title,
			'permalink'  => get_permalink( $featured_id ),
			'author'     => '',
			'author_url' => '',
			'excerpt'    => '',
		] );
	}

	public function get_featured_id() {
		$post_id = cmb2_get_option( 'texttekst_featured_book_options', 'texttekst_featured_book_' . pll_current_language( 'slug' ) );

		return $post_id;
	}

	public function get_author( $post_id ) {
		$args = [
			'connected_type'  => 'book_to_author',
			'connected_items' => $post_id,
			'posts_per_page'  => 1,
		];

		$author = new WP_Query( $args );

		return $author->post;
	}

	public function partners() {
		ob_start();

			echo sprintf( '<h2>%s</h2>', __( 'Partners', Main::TEXT_DOMAIN ) );
			$this->get_partners_loop();

		$content = ob_get_clean();

		$partners = sprintf( '<section class="partners">%s<div class="inner-grid">%s</div></section>', Utility::get_bg_lines(), $content );

		echo $partners;
	}

	public function get_partners_loop() {
		$partners = cmb2_get_option( 'texttekst_partners_options', 'texttekst_partners_partner' );

		foreach ( $partners as $partner ) {
			Main::get_template_part( 'partials/partner-loop.html', [
				'title' => $partner['title'],
				'url'   => $partner['url'],
				'logo'  => $partner['logo'],
			] );
		}
	}

	public function columns() {
		ob_start();

			$this->get_books();

		$content = ob_get_clean();

		$columns = sprintf( '<section class="columns"><div class="inner-grid">%s</div></section>', $content );

		echo $columns;
	}

	public function get_books() {
		$args = [
			'post_type'      => Type\Book::POST_TYPE,
			'posts_per_page' => 4,
			'lang'           => pll_current_language( 'slug' ),
			'post__not_in'   => [ $this->get_featured_id() ],
		];

		$books = new WP_Query( $args );

		$archive_link =

		ob_start();

			echo sprintf( '<h2>%s</h2>', __( 'Books', Main::TEXT_DOMAIN ) );

			foreach ( $books->posts as $post ) {
				$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'medium' );

				Main::get_template_part( 'partials/book-loop.html', [
					'cover'      => isset( $image ) ? $image[0] : '',
					'title'      => $post->post_title,
					'permalink'  => get_permalink( $post->ID ),
					'author'     => $this->get_author( $post->ID )->post_title,
					'author_url' => get_permalink( $this->get_author( $post->ID )->ID ),
					'excerpt'    => get_the_excerpt( $post->ID ),
				] );
			}

			echo sprintf(
				'<a href="%s" class="button">%s</a>',
				get_post_type_archive_link( Type\Book::POST_TYPE ),
				__( 'See all books', Main::TEXT_DOMAIN )
			);

		$content = ob_get_clean();

		$book_list = sprintf( '<div class="book-list">%s</div>', $content );

		echo $book_list;
	}
}
