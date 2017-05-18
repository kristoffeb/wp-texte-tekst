<?php
/**
 * Everything that modifies the administration screens
 *
 * @package WordPress
 *
 */

namespace TexteTekst\Admin;

/**
 * Adds custom js and css for admin panel
 */
function enqueue() {
	wp_enqueue_script( 'admin-js', get_template_directory_uri() . '/assets/dist/admin.min.js' );
	wp_enqueue_style( 'admin-css', get_template_directory_uri() . '/assets/dist/admin.min.css' );
}

add_action( 'admin_enqueue_scripts', __NAMESPACE__ . '\enqueue', 1 );

// add_editor_style( '/assets/css/admin-editor.css' );
