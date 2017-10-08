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
			if ( is_singular() ) {
				add_action( THEMEDOMAIN . '-loop',                  [ $this, 'background' ], 5 );
				add_action( THEMEDOMAIN . '-before_article',        [ $this, 'metas' ] );
				add_action( THEMEDOMAIN . '-before_article',        [ $this, 'open_wrap' ] );
				add_action( THEMEDOMAIN . '-after_article',         [ $this, 'close_wrap' ] );
				add_action( THEMEDOMAIN . '-after_article_header',  [ $this, 'writer' ] );
				add_action( THEMEDOMAIN . '-after_article_content', [ $this, 'sidebar' ] );
				add_action( THEMEDOMAIN . '-after_main_content',    [ $this, 'about' ] );
				add_action( THEMEDOMAIN . '-after_main_content',    [ $this, 'related' ] );
			}
		}
	}

	public function background() {
		echo Utility::get_bg_lines();
	}

	public function open_wrap() {
		echo '<div class="content-wrap">';
	}

	public function close_wrap() {
		echo '</div>';
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
		$image = ! empty( $source ) ? sprintf( '<img src="%s" alt="" />', $source[0] ) : '';

		Main::get_template_part( 'partials/block.html', [
			'class'    => 'cover',
			'content'  => $image,
		] );
	}

	public function get_infos() {
		$meta_ids = [
			[
				'id'    => 'original_title',
				'label' => __( 'Original title', Main::TEXT_DOMAIN ),
			],
			[
				'id'    => 'pages',
				'label' => __( 'Pages', Main::TEXT_DOMAIN ),
			],
			[
				'id'    => 'year',
				'label' => __( 'Year', Main::TEXT_DOMAIN ),
			],
			[
				'id'    => 'publisher',
				'label' => __( 'Publisher', Main::TEXT_DOMAIN ),
			],
			[
				'id'    => 'isbn',
				'label' => __( 'ISBN', Main::TEXT_DOMAIN ),
			],
		];

		$content = $this->get_metas( $meta_ids );

		$title = sprintf(
			'<li><strong>%s</strong>, %s</li>',
			$this->get_writer()->post_title,
			get_the_title()
		);

		Main::get_template_part( 'partials/block-list.html', [
			'class' => 'infos',
			'list'  => $title . $content,
		] );
	}

	public function get_metas( $meta_ids ) {
		$content = '';
		foreach ( $meta_ids as $meta ) {
			$value = get_post_meta( get_the_ID(), Type\Meta\Book::PREFIX . 'book_' . $meta['id'], TRUE );

			if ( $meta['id'] === 'link' ) {
				$value = sprintf( '<a href="%s">%s</a>', $value, __( 'Link', Main::TEXT_DOMAIN ) );
			}

			if ( $meta['id'] === 'publisher' ) {
				$link = get_post_meta( get_the_ID(), Type\Meta\Book::PREFIX . 'book_publisher_link', TRUE );

				if ( ! empty( $link ) ) {
					$value = sprintf( '<a href="%s">%s</a>', $link, $value );
				}
			}

			if ( $meta['id'] === 'foreign_rights' ) {
				$contact = get_post_meta( get_the_ID(), Type\Meta\Book::PREFIX . 'book_foreign_rights_contact', TRUE );
				$email = get_post_meta( get_the_ID(), Type\Meta\Book::PREFIX . 'book_foreign_rights_email', TRUE );

				if ( ! empty( $contact ) && ! empty( $email ) ) {
					$value .= sprintf( ' (<a href="mailto:%s">%s</a>)', $email, $contact );
				}
			}

			if ( ! empty( $value ) ) {
				$content .= sprintf(
					'<li>%s: %s</li>',
					$meta['label'],
					$value
				);
			}
		}

		return $content;
	}

	public function writer() {
		$post = $this->get_writer();

		$writer = sprintf( '<a href="%s">%s</a>', get_permalink( $post->ID ), $post->post_title );

		echo $writer;
	}

	public static function get_writer( $connection = 'book_to_writer' ) {
		$args = [
			'connected_type'  => $connection,
			'connected_items' => get_the_ID(),
			'posts_per_page'  => 1,
		];

		$writer = new WP_Query( $args );

		return $writer->post;
	}

	public function sidebar() {
		ob_start();

			$this->get_pdf();
			$this->get_categories();
			$this->get_share_button();

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

			if ( ! empty( $pdf['file'] ) ) {
				$items .= sprintf(
					'<li class="item"><div class="item-wrap"><a href="%s">%s (%s)</a></div></li>',
					$pdf['file'],
					__( 'Read', Main::TEXT_DOMAIN ),
					$language->name
				);
			}
		}

		if ( ! empty( $items ) ) {
			Main::get_template_part( 'partials/block-list.html', [
				'class'      => 'pdf',
				'title'      => __( 'First pages', Main::TEXT_DOMAIN ),
				'list'       => $items,
				'list_class' => 'styled'
			] );
		}
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

		if ( ! empty( $items ) ) {
			Main::get_template_part( 'partials/block-list.html', [
				'class' => 'items-list',
				'title' => __( 'Categories', Main::TEXT_DOMAIN ),
				'list'  => $items,
			] );
		}
	}

	public function get_share_button() {
		$button = sprintf(
			'<div class="fb-share-button" data-href=%s" data-layout="button_count" data-size="small" data-mobile-iframe="true"><a class="fb-xfbml-parse-ignore" target="_blank" href="%s">%s</a></div>',
			get_permalink(),
			get_permalink(),
			__( 'Share', Main::TEXT_DOMAIN )
		);

		Main::get_template_part( 'partials/block.html', [
			'class'   => 'share',
			'content' => $button,
		] );
	}

	public function about() {
		ob_start();
			$this->get_press();
		$press = ob_get_clean();

		ob_start();
			$this->get_writer_bio( 'book_to_writer', __( 'Writer', Main::TEXT_DOMAIN ) );
			$this->get_writer_bio( 'book_to_translator', __( 'Translator', Main::TEXT_DOMAIN ) );
		$writers = ob_get_clean();

		ob_start();
			Main::get_template_part( 'partials/block.html', [
				'class'   => 'writers',
				'content' => $writers,
			] );
		$writers_block = ob_get_clean();

		Main::get_template_part( 'partials/section.html', [
			'class'    => 'about',
			'content'  => $press . $writers_block,
			'bg_lines' => Utility::get_bg_lines(),
		] );
	}

	public function get_press() {
		$reviews = get_post_meta( get_the_ID(), Type\Meta\Book::PREFIX . 'reviews_group', TRUE );

		ob_start();
			if ( ! empty( $reviews ) ) {
				foreach ( $reviews as $review ) {
					Main::get_template_part( 'partials/quote.html', [
						'quote'  => $review['quote'],
						'source' => $review['source'],
						'url'    => $review['url'],
					] );
				}
			} else {
				echo __( 'No press reviews yet.', Main::TEXT_DOMAIN );
			}
		$quotes = ob_get_clean();

		$metas = $this->get_press_meta();

		Main::get_template_part( 'partials/block.html', [
			'class'   => 'reviews',
			'title'   => __( 'Press', Main::TEXT_DOMAIN ),
			'content' => $quotes . $metas,
		] );
	}

	public function get_press_meta() {
		$meta_ids = [
			[
				'id'    => 'link',
				'label' => __( 'More information', Main::TEXT_DOMAIN ),
			],
			[
				'id'    => 'foreign_rights',
				'label' => __( 'Foreign rights', Main::TEXT_DOMAIN ),
			],
			[
				'id'    => 'foreign_rights_countries',
				'label' => __( 'Foreign rights sold to following countries', Main::TEXT_DOMAIN ),
			],
		];

		$metas = $this->get_metas( $meta_ids );

		ob_start();
			$title = sprintf( '<h2>%s</h2>', __( 'Foreign Rights', Main::TEXT_DOMAIN ) );

			Main::get_template_part( 'partials/block-list.html', [
				'class' => 'infos',
				'list'  => $title . $metas,
			] );
		$metas = ob_get_clean();

		return $metas;
	}

	public function get_writer_bio( $connection, $label ) {
		$writer = $this->get_writer( $connection );

		$excerpt = wpautop( wp_trim_words( $writer->post_content, 30 ) );
		$writer_link = sprintf( '<a href="%s" class="writer-link">%s</a>', get_permalink( $writer->ID ), $writer->post_title );

		Main::get_template_part( 'partials/block.html', [
			'class'   => 'writer-bio',
			'title'   => $label,
			'content' => $writer_link . $excerpt,
			'more'    => '',
		] );
	}

	public function related() {
		ob_start();

			$this->get_books();

		$content = ob_get_clean();

		Main::get_template_part( 'partials/section.html', [
			'class'    => 'related',
			'content'  => $content,
		] );
	}

	public function get_books() {
		$args = [
			'connected_type'  => 'book_to_book',
			'connected_items' => get_the_ID(),
			'posts_per_page'  => 5,
		];

		$books = new WP_Query( $args );

		$list = '';
		if ( $books->have_posts() ) {
			foreach ( $books->posts as $book ) {
				ob_start();
					$source = wp_get_attachment_image_src( get_post_thumbnail_id( $book->ID ), 'medium' );

					Main::get_template_part( 'partials/book-loop.html', [
						'title'     => $book->post_title,
						'size'      => 'small',
						'permalink' => get_permalink( $book->ID ),
						'cover'     => isset( $source ) ? $source[0] : '',
					] );
				$block = ob_get_clean();

				$list .= sprintf( '<li class="item">%s</li>', $block );
			}
		}

		Main::get_template_part( 'partials/block-list.html', [
			'class' => 'related',
			'title' => __( 'Related books', Main::TEXT_DOMAIN ),
			'list'  => $list,
		] );
	}
}
