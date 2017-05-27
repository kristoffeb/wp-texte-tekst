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
		}
	}

	public function metas() {
		ob_start();

			$this->get_cover();
			$this->get_infos();

		$content = ob_get_clean();

		$meta = sprintf( '<div class="meta">%s</div>', $content );

		echo $meta;
	}

	public function get_cover() {
		$source = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large' );

		$image = sprintf( '<div class="cover"><img src="%s" alt="" /></div>', $source[0] );

		echo $image;
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

		$title = sprintf( '<li><strong>%s</strong>, %s</li>', get_the_title(), $this->get_author()->post_title );
		$infos = sprintf( '<ul class="infos">%s%s</ul>', $title, $content );

		echo $infos;
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
}
