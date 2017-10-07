<?php
/**
 * Hooks for the frontend
 *
 * @package WordPress
 *
 *
 * @link http://codex.wordpress.org/Plugin_API/Filter_Reference
 * @link http://codex.wordpress.org/Plugin_API/Action_Reference
 */

namespace TexteTekst;

/**
 * Loads css in the head and js at the end of body
 */
function enqueue() {

	if ( defined( 'WP_DEBUG' ) && WP_DEBUG && file_exists( get_stylesheet_directory() . '/assets/dist/main.css' ) ) {
		$suffix = '.';
	} else {
		$suffix = '.min.';
	}

	// Register stylesheet
	wp_register_style( __NAMESPACE__ . '-css', get_template_directory_uri() . '/assets/dist/main' . $suffix . 'css', false, '1.0', 'all' );
	wp_enqueue_style( __NAMESPACE__ . '-css' );

	// Adding scripts in the footer
	wp_register_script( __NAMESPACE__ . '-scripts', get_template_directory_uri() . '/assets/dist/scripts.min.js', [ 'jquery' ], '1.0', true );
	wp_enqueue_script( __NAMESPACE__ . '-scripts' );

	// Inbuilt comment reply
	if ( is_singular() && comments_open() && ( get_option( 'thread_comments' ) == 1 ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}

add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\enqueue', 1 );


/**
 * Avoids returning random page if empty search string
 */
function search_filter( $query_vars ) {
	if ( isset( $_GET['s'] ) && empty( $_GET['s'] ) ) {
		$query_vars['s'] = ' ';
	}

	return $query_vars;
}

add_filter( 'request', __NAMESPACE__ . '\search_filter' );


/**
 * Add taxonomy class to the body tag
 */
function body_classes( $classes ) {
	global $post;

	if ( function_exists( 'pll_current_language' ) ) {
		$classes[] = sprintf( 'lang-%s', pll_current_language( 'slug' ) );
	}

	if ( isset( $post ) && isset( $post->post_type ) ) {
		$classes[] = $post->post_type . '-' . $post->post_name;
	}

	if ( is_tax() ) {
		$classes[] = 'taxonomy';
	}

	return $classes;
}

add_filter( 'body_class', __NAMESPACE__ . '\body_classes' );


/**
 * Deregister unused scripts.
 */
function deregister_scripts() {
	// WP Emoji
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );

	// Remove wp-embed script
	remove_action( 'rest_api_init', 'wp_oembed_register_route' );
	remove_filter( 'oembed_dataparse', 'wp_filter_oembed_result', 10 );
	remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
	remove_action( 'wp_head', 'wp_oembed_add_host_js' );

	// Plugins
	wp_dequeue_script( 'optinmonster-api-script' );
}

add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\deregister_scripts', 100 );

/**
 * Show background lines.
 */
function bg_lines() {
	get_template_part( 'partial/background', 'lines' );
}

add_action( THEMEDOMAIN . '-before_header', __NAMESPACE__ . '\bg_lines' );

/**
 * Facebook Script
 */
function header_fb_script() {
	?>
	<div id="fb-root"></div>
	<script>(function(d, s, id) {
	var js, fjs = d.getElementsByTagName(s)[0];
	if (d.getElementById(id)) return;
	js = d.createElement(s); js.id = id;
	js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.10&appId=158338760929078";
	fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>
	<?php
}

add_action( 'wp_head', __NAMESPACE__ . '\header_fb_script' );
