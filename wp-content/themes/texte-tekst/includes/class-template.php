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

	}

	public function get_content() {
		return get_template_part( 'template-part/content', $this->get_context() );
	}

	private function get_context() {

		if ( is_home() ) {
			$context = 'loop';
		} elseif ( is_page() ) {
			$context = 'page';
		} elseif ( is_singular( 'post' ) ) {
			$context = 'single';
		} elseif ( is_archive() ) {
			$context = 'loop';
		} elseif ( is_tax() ) {
			$context = 'loop';
		} elseif ( is_search() ) {
			$context = 'loop';
		} else {
			$context = 'page';
		}

		return $context;
	}
}
