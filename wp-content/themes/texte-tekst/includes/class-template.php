<?php

namespace TexteTekst;

class Template {

	// Metabox prefix in custom fields
	const PREFIX = 'bf_template';

	public function __construct() {

		if ( ! in_array( 'cmb2/init.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
			return false;
		}

		add_action( THEMEDOMAIN . '-loop', [ $this, 'get_content' ] );
		// add_filter( THEMEDOMAIN . '-show_sidebar', [ $this, 'show_sidebar' ], 10, 2 );
		//add_filter( THEMEDOMAIN . '-page_class', [ $this, 'page_classes' ], 10 );

	}

	public function get_content() {
		return get_template_part( 'template-part/content', $this->get_context() );
	}

	private function get_context() {

		if ( is_page() ) {
			$context = 'page';
		} elseif ( is_singular( 'post' ) ) {
			$context = 'single';
		} elseif ( is_archive() ) {
			$context = 'loop';
		} else {
			$context = 'page';
		}

		return $context;
	}

	/**
	 * Add page classes to wrapper
	 * @param  string $classes
	 * @return string
	 */
	public function page_classes( $classes ) {
		// Get layout
		$layout = get_post_meta( get_the_ID(), self::get_key( 'template' ), true );

		if ( ! $layout ) {
			return $classes;
		}

		return $classes . ' ' . $layout;
	}

	/**
	 * Show sidebar or not
	 * @param  bool $show_sidebar
	 * @param  int $post_id
	 * @return bool
	 */
	public function show_sidebar( $show_sidebar, $post_id ) {
		// Get layout
		$layout = get_post_meta( $post_id, self::get_key( 'template' ), true );

		// if ( ! is_front_page() && ( ! is_page( $post_id ) || ! in_array( $layout, [ 'fullwidth', 'grid' ] ) ) ) {
		// 	return $show_sidebar;
		// }

		if ( ! in_array( $layout, [ 'fullwidth', 'grid' ] ) ) {
			return $show_sidebar;
		}

		return false;
	}

	// Returns custom field ID with prefix
	public static function get_key( $id = '' ) {
		return sprintf( '%s_%s', self::PREFIX, $id );
	}
}
