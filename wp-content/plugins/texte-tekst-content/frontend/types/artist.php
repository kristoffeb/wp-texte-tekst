<?php

namespace TexteTekst\Content\Frontend\Type;

use TexteTekst\Content\Main;
use TexteTekst\Content\Core\Type;
use TexteTekst\Content\Frontend\Sections;

class Artist {

	public function __construct() {
		add_action( 'wp', [ $this, 'init' ], 10 );
		add_action( 'pre_get_posts', [ $this, 'nopaging' ] );
	}

	public function init() {
		if ( is_singular( Type\Artist::POST_TYPE ) ) {
			add_filter( THEMEDOMAIN . '-post_featured_type', [ $this, 'featured_type' ], 10 );
			add_filter( THEMEDOMAIN . '-post_featured_size', [ $this, 'featured_size' ], 10 );
			add_action( THEMEDOMAIN . '-article_meta', [ $this, 'meta' ] );
			add_action( THEMEDOMAIN . '-article_content', [ $this, 'content' ] );
			add_action( THEMEDOMAIN . '-after_article_content', [ $this, 'portfolio' ], 10 );
			add_action( THEMEDOMAIN . '-after_article_content', [ $this, 'title' ], 20 );
			add_action( THEMEDOMAIN . '-after_article_content', [ $this, 'related' ], 30 );
		}

		if ( is_post_type_archive( Type\Artist::POST_TYPE ) ) {
			add_filter( THEMEDOMAIN . '-post_featured_type', [ $this, 'featured_type' ], 10 );
			add_filter( THEMEDOMAIN . '-post_featured_size', [ $this, 'archive_featured_size' ], 10 );
		}
	}

	public function featured_type() {
		return false;
	}

	public function featured_size() {
		return 'Pnoise-portfolio-large';
	}

	public function archive_featured_size() {
		return 'Pnoise-tile-medium';
	}

	public function meta() {
		$countries = wp_get_post_terms( get_the_ID(), Type\Taxonomy\Country::TERM );
		$genres = wp_get_post_terms( get_the_ID(), Type\Taxonomy\Genre::TERM );
		$terms = array_merge( $countries, $genres );

		$meta_items = '';
		foreach ( $terms as $term ) {
			$name = $term->name;
			$meta_items .= sprintf( '<li>%s</li>', $name );
		}

		$meta_list = sprintf( '<ul>%s</ul>', $meta_items );

		echo $meta_list;
	}

	public function content() {
		Sections::content();
	}

	public function portfolio() {
		Sections::portfolio();
	}

	public function title() {
		echo sprintf(
			'<section class="footer-title"><div class="inner-grid">%s</div></section>',
			get_the_title()
		);
	}

	public function related() {
		Sections::artists();
	}

	public function nopaging( $query ) {
		if ( $query->is_main_query() && is_post_type_archive( Type\Artist::POST_TYPE ) ) {
			$query->set( 'nopaging', true );
			$query->set( 'order', 'ASC' );
			$query->set( 'orderby', 'name' );
		}
	}
}
