<?php

namespace TexteTekst\Content\Core\Type\Meta;

use TexteTekst\Content\Main;
use TexteTekst\Content\Core\Utility;
use TexteTekst\Content\Core\Type\Writer as Post_Type;

class Writer {

	const PREFIX = 'textetekst_';

	public function __construct() {
		$this->default_metabox_args = [
			'object_types' => [ Post_Type::POST_TYPE ],
			'show_names'   => true,
			'context'      => 'normal',
			'priority'     => 'default',
			'cmb_styles'   => is_admin() ? true : false,
		];

		add_action( 'cmb2_init', [ $this, 'bibliography' ] );
	}

	public function bibliography() {
		$metabox_args = array_merge(
			[
				'id'    => self::PREFIX . 'writer_bibliography',
				'title' => __( 'Bibliography', Main::TEXT_DOMAIN ),
	   		],
			$this->default_metabox_args
		);

		$metabox = new_cmb2_box( $metabox_args );

		$metabox->add_field( [
			'name'    => __( 'Books', Main::TEXT_DOMAIN ),
			'id'      => self::PREFIX . 'writer_books',
			'type'    => 'wysiwyg',
			'options' => [
				'media_buttons' => false,
				'textarea_rows' => 5,
				'teeny'         => true,
			],
		] );
	}
}
