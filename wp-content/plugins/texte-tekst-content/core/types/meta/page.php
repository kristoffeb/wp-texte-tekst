<?php

namespace TexteTekst\Content\Core\Type\Meta;

use TexteTekst\Content\Main;
use TexteTekst\Content\Core\Utility;

class Page {

	const PREFIX = 'textetekst_';

	public function __construct() {
		$this->default_metabox_args = [
			'object_types' => [ 'page' ],
			'show_names'   => true,
			'context'      => 'normal',
			'priority'     => 'default',
			'cmb_styles'   => is_admin() ? true : false,
		];

		add_action( 'cmb2_init', [ $this, 'about_cta' ] );
	}

	public function about_cta() {

		$metabox_args = array_merge(
			[
				'id'         => self::PREFIX . 'frontpage_about_cta',
				'title'      => __( 'Call-to-action', Main::TEXT_DOMAIN ),
				'show_on_cb' => [ $this, 'display' ],
	   		],
			$this->default_metabox_args
		);

		$metabox = new_cmb2_box( $metabox_args );

		$metabox->add_field( [
			'name'    => __( 'Page to link to', Main::TEXT_DOMAIN ),
			'id'      => self::PREFIX . 'frontpage_cta_page',
			'type'    => 'select',
			'options' => $this->get_pages(),
		] );

		$metabox->add_field( [
			'name' => __( 'Text', Main::TEXT_DOMAIN ),
			'id'   => self::PREFIX . 'frontpage_cta_text',
			'type' => 'text_medium',
		] );
	}

	public function get_pages() {

		$pages = get_posts( [
			'post_type'      => 'page',
			'post_status'    => 'publish',
			'posts_per_page' => -1,
			'lang'           => Utility::get_post_language()->slug,
		] );

		$options = [];
		foreach ( $pages as $page ) {
			$options[ $page->ID ] = $page->post_title;
		}

		return $options;
	}

	public function display() {
		$frontpage_id = (int) pll_get_post( get_option( 'page_on_front' ) );
		$is_front_page = get_the_ID() == $frontpage_id ? TRUE : FALSE;

		return $is_front_page;
	}
}
