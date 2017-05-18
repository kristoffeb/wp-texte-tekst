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

		// add_action( 'cmb2_init', [ $this, 'meta_boxes' ] );

		//add_action( 'wp_loaded', [ $this, 'setup_template' ], 10 );

		// add_filter( THEMEDOMAIN . '-show_sidebar', [ $this, 'show_sidebar' ], 10, 2 );
		//add_filter( THEMEDOMAIN . '-page_class', [ $this, 'page_classes' ], 10 );

	}

	public function meta_boxes() {

		/**
		 * We create a metabox to redirect to Customizer
		 * @TODO add support for grid template
		**/
		// $mesa_grid_to_customizer_metabox = new_cmb2_box( [
		// 	'id'            => $this->get_key( 'to_customizer_metabox' ),
		// 	'title'         => __( 'Grid Layout', THEMEDOMAIN ),
		// 	'object_types'  => [ 'page' ], // Post type
		// 	'context'       => 'normal',
		// 	'priority'      => 'high',
		// 	'show_names'    => true
		// ] );

		// Text box to link user to Customizer if grid layout chosen
		// $mesa_grid_to_customizer_metabox->add_field( [
		// 	'name'         => __( 'This page will be displayed as a grid.<br /> You can edit the widget contents from the <a href="' . $this->get_post_customizer_link() . '">Customizer &raquo;</a>', THEMEDOMAIN ),
		// 	'id'           => $this->get_key( 'to_customizer' ),
		// 	'type'         => 'title'
		// ] );

		/**
		 * We create a metabox to choose the layout
		**/
		$mesa_grid_layout_metabox = new_cmb2_box( [
			'id'            => self::get_key( 'template_metabox' ),
			'title'         => '<span class="fa">&#xf00a;</span>' . __( '&nbsp; Choose the page layout', THEMEDOMAIN ),
			'object_types'  => [ 'page' ], // Post type
			'context'       => 'normal',
			'priority'      => 'default',
			'show_names'    => true
		] );

		// Radio buttons to choose the layout
		$mesa_grid_layout_metabox->add_field( [
			// 'desc'         => __( 'Select page template', THEMEDOMAIN ),
			// 'desc'         => __( 'Normal Page: the layout is editable with inline content from the editor - this is the normal page behaviour<br />Grid Page: the layout is editable using WP Customizer, by adding widget contents', THEMEDOMAIN ),
			'id'           => self::get_key( 'template' ),
			'type'         => 'radio_inline',
			'default'      => 'aside-left',
			'options'      => [
				'aside-left' 	=> '<div class="aside-left"><span class="title">' . __( 'Page w. left aligned sidebar', THEMEDOMAIN ) . '</span></div>',
				'aside-right' 	=> '<div class="aside-right"><span class="title">' . __( 'Page w. right aligned sidebar', THEMEDOMAIN ) . '</span></div>',
				// 'grid'     		=> __( '<div class="grid"><span class="title">Grid Page</span></div>', THEMEDOMAIN ) . '</span></div>',
				'fullwidth' 	=> '<div class="fullwidth"><span class="title">' . __( 'Full width Page', THEMEDOMAIN ) . '</span></div>',
			]
		] );

	}

	// Return customizer link
	public function get_post_customizer_link() {
		global $pagenow;

		if ( $pagenow != 'post.php' && $pagenow != 'post-new.php' ) {
			return;
		}

		if ( $pagenow == 'post.php' ) {
			$page_id = isset( $_GET['post'] ) ? intval( $_GET['post'] ) : '';
		}

		if ( ! empty( $page_id ) ) {
			$url = '?url=' . urlencode( get_permalink( $page_id ) );
		} else {
			$url = '';
		}

		$customizer_link = admin_url( 'customize.php' ) . $url;

		return $customizer_link;
	}

	public function setup_template() {
		// Get layout
		$layout = get_post_meta( get_the_ID(), self::get_key( 'layout' ), true );

		switch ( $layout ) {
			case 'grid':
				get_template_part( 'template', 'grid' );
				break;
			case 'aside-left':
			case 'aside-right':
			case 'fullwidth':
			default:
				add_action( THEMEDOMAIN . '-before_main_content', [ $this, 'get_featured_image' ] );
				add_action( THEMEDOMAIN . '-loop', [ $this, 'get_content' ] );
				break;
		}
	}

	public function get_featured_image() {
		return get_template_part( 'partial/post', 'featured' );
	}

	public function get_content() {
		return get_template_part( 'template-part/content', $this->get_context() );
	}

	private function get_context() {

		if ( is_page() ) {
			$context = 'page';
		} elseif ( is_single() ) {
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
