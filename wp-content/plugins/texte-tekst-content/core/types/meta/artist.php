<?php

namespace TexteTekst\Content\Core\Type\Meta;

use TexteTekst\Content\Main;
use TexteTekst\Content\Core\Utility;
use TexteTekst\Content\Core\Type\Artist as Post_Type;

class Artist {

	const PREFIX = 'pnoise_';

	public function __construct() {
		$this->default_metabox_args = [
			'object_types' => [ Post_Type::POST_TYPE ],
			'show_names'   => true,
			'context'      => 'normal',
			'priority'     => 'default',
			'cmb_styles'   => is_admin() ? true : false,
		];

		add_action( 'cmb2_init', [ $this, 'artist_information' ] );
		add_action( 'cmb2_init', [ $this, 'artist_portfolio' ] );
		add_action( 'cmb2_init', [ $this, 'artist_links' ] );
	}

	public function artist_information() {
		$metabox_args = array_merge(
			[
				'id'    => self::PREFIX . 'artist_metabox_information',
				'title' => __( 'Artist Information', Main::TEXT_DOMAIN ),
	   		],
			$this->default_metabox_args
		);

		$metabox = new_cmb2_box( $metabox_args );

		$metabox->add_field( [
			'name'    => __( 'Description', Main::TEXT_DOMAIN ),
			'id'      => self::PREFIX . 'artist_description',
			'type'    => 'wysiwyg',
			'options' => [
				'media_buttons' => false,
				'textarea_rows' => 12,
			],
		] );
	}

	public function artist_portfolio() {
		$metabox_args = array_merge(
			[
				'id'    => self::PREFIX . 'artist_metabox_portfolio',
				'title' => __( 'Artist Portfolio', Main::TEXT_DOMAIN ),
	   		],
			$this->default_metabox_args
		);

		$metabox = new_cmb2_box( $metabox_args );

		$metabox->add_field( [
			'name'       => __( 'Videos', Main::TEXT_DOMAIN ),
			'id'         => self::PREFIX . 'artist_videos',
			'desc'       => __( 'Insert youtube or vimeo link', Main::TEXT_DOMAIN ),
			'type'       => 'oembed',
			'repeatable' => true,
		] );

		$metabox->add_field( [
			'name'  => __( 'Pictures', Main::TEXT_DOMAIN ),
			'id'    => self::PREFIX . 'artist_pictures',
			'type'  => 'file_list'
		] );
	}

	public function artist_links() {
		$metabox_args = array_merge(
			[
				'id'    => self::PREFIX . 'artist_metabox_links',
				'title' => __( 'Artist Links', Main::TEXT_DOMAIN ),
	   		],
			$this->default_metabox_args
		);

		$metabox = new_cmb2_box( $metabox_args );

		$group_links_id = $metabox->add_field( [
			'id'          => self::PREFIX . 'artist_group_link',
			'type'        => 'group',
			'repeatable'  => true,
			'options'     => [
			    'group_title'   => __( 'Link {#}', Main::TEXT_DOMAIN ),
			    'add_button'    => __( 'Add Another Link', Main::TEXT_DOMAIN ),
			    'remove_button' => __( 'Remove Link', Main::TEXT_DOMAIN ),
			    'sortable'      => true,
			],
		] );

		$metabox->add_group_field( $group_links_id, [
			'name' => __( 'Label', Main::TEXT_DOMAIN ),
			'id'   => 'title',
			'type' => 'text_medium',
		] );

		$metabox->add_group_field( $group_links_id, [
			'name' => __( 'URL', Main::TEXT_DOMAIN ),
			'id'   => 'url',
			'type' => 'text_url',
		] );
	}
}
