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
			add_action( THEMEDOMAIN . '-main_front_page', [ $this, 'partners' ] );
			add_action( THEMEDOMAIN . '-article_footer', [ $this, 'cta' ] );
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
		$featured_id = cmb2_get_option( 'texttekst_featured_book_options', 'texttekst_featured_book_' . pll_current_language( 'slug' ) );
		$image = wp_get_attachment_image_src( get_post_thumbnail_id( $featured_id ), 'large' );

		$title = sprintf(
			'<strong>%s</strong> <em>%s</em>, %s',
			__( 'Featured book', Main::TEXT_DOMAIN ),
			get_the_title( $featured_id ),
			$this->get_author( $featured_id )
		);

		Main::get_template_part( 'partials/book-loop.html', [
			'cover'  => isset( $image ) ? $image[0] : '',
			'title'  => $title,
		] );
	}

	public function get_author( $post_id ) {
		$args = [
			'connected_type'  => 'book_to_author',
			'connected_items' => $post_id,
			'posts_per_page'  => 1,
		];

		$author = new WP_Query( $args );

		return $author->post->post_title;
	}

	public function partners() {
		ob_start();

			echo sprintf( '<h2>%s</h2>', __( 'Partners', Main::TEXT_DOMAIN ) );
			$this->get_partners_loop();

		$content = ob_get_clean();

		$intro = sprintf( '<section class="partners">%s<div class="inner-grid">%s</div></section>', Utility::get_bg_lines(), $content );

		echo $intro;
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
}
