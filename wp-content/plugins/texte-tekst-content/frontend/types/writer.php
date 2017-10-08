<?php

namespace TexteTekst\Content\Frontend\Type;

use TexteTekst\Content\Main;
use TexteTekst\Content\Core\Type;
use TexteTekst\Content\Core\Utility;
use WP_Query;

class Writer {

	public function __construct() {
		add_action( 'wp', [ $this, 'init' ], 10 );
	}

	public function init() {
		if ( get_post_type() === Type\Writer::POST_TYPE ) {
			add_action( THEMEDOMAIN . '-loop',                  [ $this, 'background' ], 5 );
			add_action( THEMEDOMAIN . '-before_article',        [ $this, 'metas' ] );
			add_action( THEMEDOMAIN . '-before_article',        [ $this, 'open_wrap' ] );
			add_action( THEMEDOMAIN . '-after_article',         [ $this, 'close_wrap' ] );
			add_action( THEMEDOMAIN . '-after_article_content', [ $this, 'sidebar' ] );
			add_action( THEMEDOMAIN . '-after_main_content',    [ $this, 'related' ] );
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

	public function sidebar() {
		ob_start();

			$this->get_bibliography();

		$content = ob_get_clean();

		Main::get_template_part( 'partials/block.html', [
			'class'   => 'sidebar',
			'content' => $content,
		] );
	}

	public function get_bibliography() {
		$books = get_post_meta( get_the_ID(), Type\Meta\Writer::PREFIX . 'writer_books', TRUE );

		if ( ! empty( $books ) ) {
			Main::get_template_part( 'partials/block.html', [
				'class'   => 'bibliography',
				'title'   => __( 'Bibliography', Main::TEXT_DOMAIN ),
				'content' => apply_filters( 'the_content', $books ),
			] );
		}
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
			'connected_type'  => 'book_to_writer',
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
			'title' => __( 'Written Books', Main::TEXT_DOMAIN ),
			'list'  => $list,
		] );
	}
}
