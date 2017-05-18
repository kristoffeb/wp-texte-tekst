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

		add_action( 'cmb2_init', [ $this, 'pdf' ] );
		add_action( 'cmb2_init', [ $this, 'presse' ] );
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
			'id'      => self::PREFIX . 'file_group',
			'type'    => 'group',
			'options' => [
				'group_title'   => __( 'Document {#}', Main::TEXT_DOMAIN ),
				'add_button'    => __( 'Add Another Document', Main::TEXT_DOMAIN ),
				'remove_button' => __( 'Remove Document', Main::TEXT_DOMAIN ),
			],
		] );

		$metabox->add_group_field( $group_id, [
			'name'    => __( 'Upload PDF', Main::TEXT_DOMAIN ),
			'id'      => 'file',
			'type'    => 'file',
		] );

		$metabox->add_group_field( $group_id, [
			'name'    => __( 'Language', Main::TEXT_DOMAIN ),
			'id'      => 'language',
			'type'    => 'select',
			'options' => [
				'de' => __( 'German', Main::TEXT_DOMAIN ),
				'dk' => __( 'Danish', Main::TEXT_DOMAIN ),
				'fr' => __( 'French', Main::TEXT_DOMAIN ),
			],
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
			'name'    => __( 'Quote', Main::TEXT_DOMAIN ),
			'id'      => 'quote',
			'type'    => 'textarea',
		] );

		$metabox->add_group_field( $group_id, [
			'name'    => __( 'Source', Main::TEXT_DOMAIN ),
			'id'      => 'source',
			'type'    => 'text_medium',
		] );
	}
}
