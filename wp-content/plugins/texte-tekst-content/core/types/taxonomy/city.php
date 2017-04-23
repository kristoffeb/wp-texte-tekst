<?php

namespace TexteTekst\Content\Core\Type\Taxonomy;

use TexteTekst\Content\Main;
use TexteTekst\Content\Core\Type;

class City {

	const TERM = 'city';

	public function __construct() {
		$this->register_taxonomy();
	}

	public function register_taxonomy() {
		$post_types = [
			Type\Event::POST_TYPE,
		];

		$labels = [
			'name'              => _x( 'Cities', 'taxonomy general name', Main::TEXT_DOMAIN ),
			'singular_name'     => _x( 'City', 'taxonomy singular name', Main::TEXT_DOMAIN ),
			'search_items'      => __( 'Search Cities', Main::TEXT_DOMAIN ),
			'all_items'         => __( 'All Cities', Main::TEXT_DOMAIN ),
			'parent_item'       => __( 'Parent City', Main::TEXT_DOMAIN ),
			'parent_item_colon' => __( 'Parent City:', Main::TEXT_DOMAIN ),
			'edit_item'         => __( 'Edit City', Main::TEXT_DOMAIN ),
			'update_item'       => __( 'Update City', Main::TEXT_DOMAIN ),
			'add_new_item'      => __( 'Add New City', Main::TEXT_DOMAIN ),
			'new_item_name'     => __( 'New City Name', Main::TEXT_DOMAIN ),
			'menu_name'         => __( 'Cities', Main::TEXT_DOMAIN ),
		];

		$args = [
			'hierarchical'      => true,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => self::TERM ),
		];

		register_taxonomy( self::TERM, $post_types, $args );
	}
}
