<?php

namespace TexteTekst;

/**
 * Setup sidebars
 */
function setup_sidebars() {
	$sidebar = new Sidebar();

	/**
	 * Init the sidebar
	 */
	$sidebar->add( array(
		'name' => __( 'Frontpage', THEMEDOMAIN ),
		'id' => 'frontpage',
		'description' => __( 'Top widget area on the front page. Display widgets before the posts.', THEMEDOMAIN ),
		'hook' => 'before_front_page',
		'priority' => 5,
	) );

	/**
	 * Init the sidebar
	 */
	$sidebar->add( array(
		'name' => __( 'Sidebar', THEMEDOMAIN ),
		'id' => 'sidebar-1',
		'description' => __( 'This is the primary sidebar. Shows up on all pages.', THEMEDOMAIN ),
		'hook' => 'sidebar',
		'priority' => 5,
	) );

	/**
	 * Init the footer widget area
	 */
	$sidebar->add( array(
		'name' =>  __( 'Footer - Main area', THEMEDOMAIN ),
		'id' => 'footer',
		'description' => __( 'This is the primary area in the footer.', THEMEDOMAIN ),
		'hook' => 'footer',
		'priority' => 5,
	) );
}
