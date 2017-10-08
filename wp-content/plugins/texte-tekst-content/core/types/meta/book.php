<?php

namespace TexteTekst\Content\Core\Type\Meta;

use TexteTekst\Content\Main;
use TexteTekst\Content\Core\Utility;
use TexteTekst\Content\Core\Type\Book as Post_Type;

class Book {

	const PREFIX = 'textetekst_';

	public function __construct() {
		$this->default_metabox_args = [
			'object_types' => [ Post_Type::POST_TYPE ],
			'show_names'   => true,
			'context'      => 'normal',
			'priority'     => 'default',
			'cmb_styles'   => is_admin() ? true : false,
		];

		add_action( 'cmb2_init', [ $this, 'information' ] );
		add_action( 'cmb2_init', [ $this, 'pdf' ] );
		add_action( 'cmb2_init', [ $this, 'presse' ] );
	}

	public function information() {
		$metabox_args = array_merge(
			[
				'id'    => self::PREFIX . 'book_information',
				'title' => __( 'Information', Main::TEXT_DOMAIN ),
	   		],
			$this->default_metabox_args
		);

		$metabox = new_cmb2_box( $metabox_args );

		$metabox->add_field( [
			'name' => __( 'Original title', Main::TEXT_DOMAIN ),
			'id'   => self::PREFIX . 'book_original_title',
			'type' => 'text',
		] );

		$metabox->add_field( [
			'name' => __( 'Publisher', Main::TEXT_DOMAIN ),
			'id'   => self::PREFIX . 'book_publisher',
			'type' => 'text_medium',
		] );

		$metabox->add_field( [
			'name' => __( 'Publisher Link', Main::TEXT_DOMAIN ),
			'id'   => self::PREFIX . 'book_publisher_link',
			'type' => 'text_url',
		] );

		$metabox->add_field( [
			'name' => __( 'ISBN', Main::TEXT_DOMAIN ),
			'id'   => self::PREFIX . 'book_isbn',
			'type' => 'text_medium',
		] );

		$metabox->add_field( [
			'name'    => __( 'Year of publication', Main::TEXT_DOMAIN ),
			'id'      => self::PREFIX . 'book_year',
			'type'    => 'select',
			'options' => array_combine( range( date('Y'), 2016 ), range( date('Y'), 2016 ) ),
		] );

		$metabox->add_field( [
			'name' => __( 'Amount of pages', Main::TEXT_DOMAIN ),
			'id'   => self::PREFIX . 'book_pages',
			'type' => 'text_small',
		] );

		$metabox->add_field( [
			'name' => __( 'More information (link)', Main::TEXT_DOMAIN ),
			'id'   => self::PREFIX . 'book_link',
			'type' => 'text_url',
		] );

		$metabox->add_field( [
			'name' => __( 'Foreign rights sold to', Main::TEXT_DOMAIN ),
			'id'   => self::PREFIX . 'book_foreign_rights',
			'type' => 'text_medium',
		] );

		$metabox->add_field( [
			'name' => __( 'Foreign rights (contact)', Main::TEXT_DOMAIN ),
			'id'   => self::PREFIX . 'book_foreign_rights_contact',
			'type' => 'text_medium',
		] );

		$metabox->add_field( [
			'name' => __( 'Foreign rights (email)', Main::TEXT_DOMAIN ),
			'id'   => self::PREFIX . 'book_foreign_rights_email',
			'type' => 'text_medium',
		] );

		$metabox->add_field( [
			'name' => __( 'Rights sold to following countries', Main::TEXT_DOMAIN ),
			'id'   => self::PREFIX . 'book_foreign_rights_countries',
			'type' => 'text',
		] );
	}

	public function pdf() {
		$metabox_args = array_merge(
			[
				'id'    => self::PREFIX . 'book_pdf',
				'title' => __( 'First Chapters', Main::TEXT_DOMAIN ),
	   		],
			$this->default_metabox_args
		);

		$metabox = new_cmb2_box( $metabox_args );

		$group_id = $metabox->add_field( [
			'id'      => self::PREFIX . 'book_pdf',
			'type'    => 'group',
			'options' => [
				'group_title'   => __( 'Document {#}', Main::TEXT_DOMAIN ),
				'add_button'    => __( 'Add Another Document', Main::TEXT_DOMAIN ),
				'remove_button' => __( 'Remove Document', Main::TEXT_DOMAIN ),
			],
		] );

		$metabox->add_group_field( $group_id, [
			'name' => __( 'Upload PDF', Main::TEXT_DOMAIN ),
			'id'   => 'file',
			'type' => 'file',
		] );

		$metabox->add_group_field( $group_id, [
			'name'    => __( 'Language', Main::TEXT_DOMAIN ),
			'id'      => 'language',
			'type'    => 'select',
			'options' => Utility::get_languages(),
		] );
	}

	public function presse() {
		$metabox_args = array_merge(
			[
				'id'    => self::PREFIX . 'book_press',
				'title' => __( 'Press Reviews', Main::TEXT_DOMAIN ),
	   		],
			$this->default_metabox_args
		);

		$metabox = new_cmb2_box( $metabox_args );

		$group_id = $metabox->add_field( [
			'id'      => self::PREFIX . 'reviews_group',
			'type'    => 'group',
			'options' => [
				'group_title'   => __( 'Review {#}', Main::TEXT_DOMAIN ),
				'add_button'    => __( 'Add Another Review', Main::TEXT_DOMAIN ),
				'remove_button' => __( 'Remove Review', Main::TEXT_DOMAIN ),
			],
		] );

		$metabox->add_group_field( $group_id, [
			'name' => __( 'Quote', Main::TEXT_DOMAIN ),
			'id'   => 'quote',
			'type' => 'textarea',
		] );

		$metabox->add_group_field( $group_id, [
			'name' => __( 'Source', Main::TEXT_DOMAIN ),
			'id'   => 'source',
			'type' => 'text_medium',
		] );

		$metabox->add_group_field( $group_id, [
			'name' => __( 'URL', Main::TEXT_DOMAIN ),
			'id'   => 'url',
			'type' => 'text_url',
		] );
	}
}
