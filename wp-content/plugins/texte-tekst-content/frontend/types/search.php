<?php

namespace TexteTekst\Content\Frontend\Type;

use TexteTekst\Content\Main;
use TexteTekst\Content\Core\Type\Taxonomy;

class Search {

	public function __construct() {
		add_action( 'wp', [ $this, 'init' ], 10 );
	}

	public function init() {
		add_action( THEMEDOMAIN . '-before_search_form', [ $this, 'title' ] );
		add_action( THEMEDOMAIN . '-search_fields', [ $this, 'fields' ] );
	}

	public function title() {
		echo sprintf( '<h2>%s</h2>', __( 'Find books', Main::TEXT_DOMAIN ) );
	}

	public function fields() {
		ob_start();

			$this->get_select_field( [
				'name'    => 'year',
				'options' => $this->get_years(),
			] );

			$this->get_select_field( [
				'name'    => 'languages',
				'options' => $this->get_languages(),
			] );

			$this->get_select_field( [
				'name'    => 'categories',
				'options' => $this->get_categories(),
			] );

		$content = ob_get_clean();

		echo $content;
	}

	public function get_select_field( $args ) {
		$options = '';

		foreach ( $args['options'] as $key => $option ) {
			$options .= sprintf( '<option value="%s">%s</option>', $key, $option );
		}

		$select = sprintf( '<div class="select-wrap"><select name="%s">%s</select></div>', $args['name'], $options );

		echo $select;
	}

	public function get_years() {
		$default = [ '' => __( 'Year', Main::TEXT_DOMAIN ) ];
		$years   = array_combine( range( date('Y'), 2016 ), range( date( 'Y' ), 2016 ) );

		$options = array_merge( $default, $years );

		return $options;
	}

	public function get_languages() {
		if ( ! function_exists( 'pll_the_languages' ) ) {
			return;
		}

		$default   = [ '' => __( 'Language', Main::TEXT_DOMAIN ) ];
		$languages = pll_the_languages( [ 'raw' => TRUE ] );

		$options = [];
		foreach ( $languages as $key => $language ) {
			$options[ $key ] = $language['name'];
		}

		$options = array_merge( $default, $options );

		return $options;
	}

	public function get_categories() {
		$default    = [ '' => __( 'Category', Main::TEXT_DOMAIN ) ];
		$categories = get_terms( [ 'taxonomy' => Taxonomy\Book_Category::TERM ] );

		$options = [];
		foreach ( $categories as $category ) {
			$options[ $category->term_id ] = $category->name;
		}

		$options = array_merge( $default, $options );

		return $options;
	}
}
