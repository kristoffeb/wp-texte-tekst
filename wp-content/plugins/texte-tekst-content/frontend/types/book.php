<?php

namespace TexteTekst\Content\Frontend\Type;

use TexteTekst\Content\Main;
use TexteTekst\Content\Core\Type;
use TexteTekst\Content\Core\Utility;
use WP_Query;

class Book {

	public function __construct() {
		add_action( 'wp', [ $this, 'init' ], 10 );
	}

	public function init() {
		if ( get_post_type() === Type\Book::POST_TYPE ) {
			add_action( THEMEDOMAIN . '-before_article', [ $this, 'metas' ] );
			add_action( THEMEDOMAIN . '-after_article_header', [ $this, 'author' ] );
			add_action( THEMEDOMAIN . '-after_article', [ $this, 'sidebar' ] );
		}
	}

	public function metas() {
		ob_start();

			$this->get_cover();
			$this->get_infos();

		$content = ob_get_clean();

		Main::get_template_part( 'partials/block.html', [
			'class'    => 'meta',
			'content'  => $content,
		] );
	}

	public function get_cover() {
		$source = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large' );
		$image = sprintf( '<img src="%s" alt="" />', $source[0] );

		Main::get_template_part( 'partials/block.html', [
			'class'    => 'cover',
			'content'  => $image,
		] );
	}

	public function get_infos() {
		$meta_ids = [
			[
				'id'    => 'publisher',
				'label' => __( 'Publisher', Main::TEXT_DOMAIN ),
			],
			[
				'id'    => 'year',
				'label' => __( 'Year', Main::TEXT_DOMAIN ),
			],
			[
				'id'    => 'isbn',
				'label' => __( 'ISBN', Main::TEXT_DOMAIN ),
			],
		];

		$content = '';
		foreach ( $meta_ids as $meta ) {
			$content .= sprintf(
				'<li>%s: %s</li>',
				$meta['label'],
				get_post_meta( get_the_ID(), Type\Meta\Book::PREFIX . 'book_' . $meta['id'], TRUE )
			);
		}

		$title = sprintf(
			'<li><strong>%s</strong>, %s</li>',
			get_the_title(),
			$this->get_author()->post_title
		);

		Main::get_template_part( 'partials/block-list.html', [
			'class' => 'infos',
			'list'  => $title . $content,
		] );
	}

	public function author() {
		$post = $this->get_author();

		$author = sprintf( '<a href="%s">%s</a>', get_permalink( $post->ID ), $post->post_title );

		echo $author;
	}

	public function get_author() {
		$args = [
			'connected_type'  => 'book_to_author',
			'connected_items' => get_the_ID(),
			'posts_per_page'  => 1,
		];

		$author = new WP_Query( $args );

		return $author->post;
	}

	public function sidebar() {
		ob_start();

			$this->get_pdf();
			$this->get_categories();

		$content = ob_get_clean();

		Main::get_template_part( 'partials/block.html', [
			'class'   => 'sidebar',
			'content' => $content,
		] );
	}

	public function get_pdf() {
		$pdfs = get_post_meta( get_the_ID(), Type\Meta\Book::PREFIX . 'book_pdf', TRUE );

		$items = '';
		foreach ( $pdfs as $pdf ) {
			$language = get_term_by( 'slug', $pdf['language'], 'language' );

			$items .= sprintf(
				'<li class="item"><a href="%s">%s (%s)</a></li>',
				$pdf['file'],
				__( 'Read', Main::TEXT_DOMAIN ),
				$language->name
			);
		}

		Main::get_template_part( 'partials/block-list.html', [
			'class' => 'pdf',
			'title' => __( 'First pages', Main::TEXT_DOMAIN ),
			'list'  => $items,
		] );
	}

	public function get_categories() {
		$categories = get_categories( [ 'taxonomy' => Type\Taxonomy\Book_Category::TERM ] );

		$items = '';
		foreach ( $categories as $category ) {
			$items .= sprintf(
				'<li class="item"><a href="%s">%s</a></li>',
				get_term_link( $category->term_id, Type\Taxonomy\Book_Category::TERM ),
				$category->name
			);
		}

		Main::get_template_part( 'partials/block-list.html', [
			'class' => 'categories',
			'title' => __( 'Categories', Main::TEXT_DOMAIN ),
			'list'  => $items,
		] );
	}
}
