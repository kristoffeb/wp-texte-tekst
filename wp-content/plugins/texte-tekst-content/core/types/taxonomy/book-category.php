<?php

namespace TexteTekst\Content\Core\Type\Taxonomy;

use TexteTekst\Content\Main;
use TexteTekst\Content\Core\Type;

class Book_Category {

	const TERM = 'book-category';

	public function __construct() {
		$this->register_taxonomy();
	}

	public function register_taxonomy() {
		$post_types = [
			Type\Book::POST_TYPE,
		];

		$labels = [
			'name'              => _x( 'Category', 'taxonomy general name', Main::TEXT_DOMAIN ),
			'singular_name'     => _x( 'Category', 'taxonomy singular name', Main::TEXT_DOMAIN ),
			'search_items'      => __( 'Search Categories', Main::TEXT_DOMAIN ),
			'all_items'         => __( 'All Categories', Main::TEXT_DOMAIN ),
			'parent_item'       => __( 'Parent Category', Main::TEXT_DOMAIN ),
			'parent_item_colon' => __( 'Parent Category:', Main::TEXT_DOMAIN ),
			'edit_item'         => __( 'Edit Category', Main::TEXT_DOMAIN ),
			'update_item'       => __( 'Update Category', Main::TEXT_DOMAIN ),
			'add_new_item'      => __( 'Add New Category', Main::TEXT_DOMAIN ),
			'new_item_name'     => __( 'New Category Name', Main::TEXT_DOMAIN ),
			'menu_name'         => __( 'Categories', Main::TEXT_DOMAIN ),
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
