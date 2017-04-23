<?php

namespace TexteTekst\Content\Frontend;

use TexteTekst\Content\Main;
use TexteTekst\Content\Core\Type;
use TexteTekst\Content\Core\Utility;

class Load_Template {

	public function __construct() {
		add_action( 'wp', [ __CLASS__, 'load_custom_template' ] );
	}

	public static function load_custom_template( $template ) {

		$custom_templates = [
			TYPE\Artist::POST_TYPE,
			TYPE\Event::POST_TYPE,
			TYPE\Sponsors::POST_TYPE,
			TYPE\Team::POST_TYPE,
			TYPE\Work::POST_TYPE,
		];

		if ( in_array( get_post_type(), $custom_templates ) ) {
			Utility::remove_filters_for_anonymous_class( THEMEDOMAIN . '-loop', 'TexteTekst\Template', 'get_content', 10 );
			add_action( THEMEDOMAIN . '-loop', [ __CLASS__, 'get_template' ] );
		}
	}

	public static function get_template() {
		switch( get_post_type() ) {
			case Type\Artist::POST_TYPE :
			case Type\Team::POST_TYPE :
			case Type\Work::POST_TYPE :
				$template = 'profile';
				break;
			case Type\Event::POST_TYPE :
				$template = 'event';
				break;
		}

		return Main::get_template_part( 'types/' . $template . '.php' );
	}

}
