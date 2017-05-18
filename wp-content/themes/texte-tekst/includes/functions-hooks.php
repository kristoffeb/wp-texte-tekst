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
 * Changes the excerpt […] to a Read More link
 * @param string $more Existing read more content
 */
function excerpt_more( $more ) {
	global $post;
	return '...  <span class="read-more"><a href="' . get_permalink( $post->ID ) . '" title="' . __( 'Read', THEMEDOMAIN ) .' ' . get_the_title( $post->ID ) . '">' . __( 'Read more &raquo;', THEMEDOMAIN ) . '</a></span>';
}
// add_filter( 'excerpt_more', __NAMESPACE__ . '\excerpt_more' );


/**
 * Split p2p widgets into sections by metadata
 *
 * @link https://github.com/scribu/wp-posts-to-posts/wiki/Actions-and-filters
 */
function p2p_widget_sections( $html, $connected ) {

	$general  = [];
	$upcoming = [];
	$current  = [];

	foreach ( $connected->items as $connection ) {
		switch ( p2p_get_meta( $connection->p2p_id, 'relevance', true ) ) {
			case 'upcoming' :
				$upcoming[] = $connection;
				break;

			case 'current' :
				$current[] = $connection;
				break;

			default :
				$default[] = $connection;
				break;
		}
	}

	ob_start();

	if ( ! empty( $default ) ) {
		echo '<ul>';
		foreach ( $default as $item ) {
			printf( '<li><a href="%1$s">%2$s</a></li>', get_permalink( $item->ID ), esc_html( $item->post_title ) );
		}
		echo '</ul>';
	}

	if ( ! empty( $upcoming ) ) {
		printf( '<h3>%1$s</h3>', __( 'For Upcoming Students', THEMEDOMAIN ) );
		echo '<ul>';
		foreach ( $upcoming as $item ) {
			printf( '<li><a href="%1$s">%2$s</a></li>', get_permalink( $item->ID ), esc_html( $item->post_title ) );
		}
		echo '</ul>';
	}

	if ( ! empty( $current ) ) {
		printf( '<h3>%1$s</h3>', __( 'For Current Students', THEMEDOMAIN ) );
		echo '<ul>';
		foreach ( $current as $item ) {
			printf( '<li><a href="%1$s">%2$s</a></li>', get_permalink( $item->ID ), esc_html( $item->post_title ) );
		}
		echo '</ul>';
	}

	return ob_get_clean();
}
// add_filter( 'p2p_widget_html', __NAMESPACE__ . '\p2p_widget_sections', 10, 2 );
// add_filter( 'p2p_shortcode_html', __NAMESPACE__ . '\p2p_widget_sections', 10, 2 );

/**
 * Format taxonomy archive titles
 */
function span_archive_title( $title ) {
	$prefix = strstr( $title, ':', true );

	if ( $prefix === false ) {
		return $title;
	}

	return str_replace( $prefix . ': ', '<span>' . $prefix . ': </span>', $title );
}

// add_filter( 'get_the_archive_title', __NAMESPACE__ . '\span_archive_title' );


/**
 * Adds menu active class to archives and single custom post types
 */
function nav_archive_class( $classes = array(), $menu_item = false ) {
	if( is_singular() ) {
		if( is_singular( 'post' ) ) {
			$archive = get_option( 'page_for_posts' );
			$archive_url = get_permalink( $archive );
		} else {
			$post_type = get_post_type();
			$archive_url = get_post_type_archive_link( $post_type );
		}

		if ( ! empty( $archive_url ) ) {
			$parsed_archive = parse_url( $archive_url );
			$parsed_url = parse_url( $menu_item->url );

			if ( isset( $parsed_url['path'] ) && trailingslashit( $parsed_url['path'] ) == $parsed_archive['path'] ) {
				$classes[] = 'current-page-ancestor';
			}
		}
	}

	return $classes;
}

// add_filter( 'nav_menu_css_class', __NAMESPACE__ . '\nav_archive_class', 10, 2 );

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

function multisite_body_classes( $classes ) {
	$id = get_current_blog_id();
	$slug = strtolower( str_replace( ' ', '-', trim( get_bloginfo( 'name' ) ) ) );
	$classes[] = $slug;
	$classes[] = 'site-id-' . $id;
	return $classes;
}

add_filter( 'body_class', __NAMESPACE__ . '\multisite_body_classes' );

function page_navi() {

	add_filter( 'previous_posts_link_attributes', __NAMESPACE__ . '\button_class' );
	add_filter( 'next_posts_link_attributes', __NAMESPACE__ . '\button_class' );
	?>

	<div class="archive-pagination">
		<div class="left">
			<?php previous_posts_link( '« Newer Entries', 0 ); ?>
		</div> <!-- button-wrap -->

		<div class="right">
			<?php next_posts_link( 'Older Entries »', 0 ); ?>
		</div> <!-- button-wrap -->
	</div> <!-- archive-pagination -->

	<?php
}


function button_class() {
	return 'class="button tiny"';
}


// Add taxonomy class to the body tag
function body_classes( $classes ) {
	global $post;

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
 * Show social media links
 */
function show_social_links() {
	$title = '[' . get_bloginfo( 'name' ) . ']' . ' ' . get_the_title();
	$url = get_permalink();

	$links = '<ul class="social-media">';
	$links .= '<li>' . __( 'Share:', THEMEDOMAIN ) . '</li>';
	$links .= '<li><a target="_blank" href="http://www.facebook.com/sharer/sharer.php?u=' . $url . '"><i class="fa fa-facebook"></i>' . __( 'facebook', THEMEDOMAIN ) . '</a></li>';
	$links .= '<li><a target="_blank" href="https://twitter.com/home?status=' . urlencode( $title ) . ' ' . $url . '"><i class="fa fa-twitter"></i>' . __( 'twitter', THEMEDOMAIN ) . '</a></li>';
	$links .= '<li><a target="_blank" href="https://www.linkedin.com/shareArticle?mini=true&url=' . $url . '&title=' . urlencode( $title ) . '"><i class="fa fa-linkedin"></i>' . __( 'linkedin', THEMEDOMAIN ) . '</a></li>';
	$links .= '<li><a target="_blank" href="https://plus.google.com/share?url=' . $url . '"><i class="fa fa-google-plus"></i>' . __( 'google+', THEMEDOMAIN ) . '</a></li>';
	$links .= '</ul>';

	echo $links;
}

// add_action( THEMEDOMAIN . '-social_links', __NAMESPACE__ . '\show_social_links' );

/**
 * Responsive oembeds in WordPress so they scale to the containers width (from Mesa)
 *
 * @param  string $html The html to filter
 * @param  string $url The source of the oembed as specified by the user
 * @param  string $attr Shortcode content - contains the <img> element
 */
function oembeds_responsive( $html, $url, $attr ) {

	// Only run this process for embeds that don't require fixed dimensions
	$resize = false;
	$accepted_providers = [
		'youtube',
		'vimeo',
		'slideshare',
		'dailymotion',
		'viddler.com',
		'hulu.com',
		'blip.tv',
		'revision3.com',
		'funnyordie.com',
		'wordpress.tv',
		'scribd.com',
		'spotify.com'
	];

	// Check each provider
	foreach ( $accepted_providers as $provider ) {
		if ( strstr( $url, $provider ) ) {
			$resize = true;
			$this_type = $provider;
			break;
		}
	}

	// Not an accepted provider
	if ( ! $resize )
		return $html;

	// Stop related videos if youtube, and make branding more discreet
	$youtube_params = '?feature=oembed&amp;rel=0&amp;showinfo=0&amp;modestbranding=1';
	if( $this_type == 'youtube' )
		$html = str_replace( '?feature=oembed', $youtube_params, $html );

	// Remove width and height attributes
	$attr_pattern = '/(width|height)="[0-9]*"/i';
	$embed = preg_replace( $attr_pattern, "", $html );

	// Clean up whitespace
	$whitespace_pattern = '/\s+/';
	$embed = preg_replace( $whitespace_pattern, ' ', $embed ); // Clean-up whitespace
	$embed = trim( $embed );

	// Add container around the video
	$html = '<div class="embed-container">';
	$html .= '<div class="embed-container-inner">';
	$html .= $embed;
	$html .= "</div></div>";

	return $html;
}

// add_filter( 'embed_oembed_html', 'oembeds_responsive', 9999, 3 );

/**
 * Add search form in header
 */
function add_search_form() {
	get_template_part( 'partial/searchform', 'header' );
}

// add_filter( THEMEDOMAIN . '-after_top_nav', __NAMESPACE__ . '\add_search_form' );


/**
 * Display future posts
 * snippet: http://www.telegraphicsinc.com/2013/01/show-future-posts-in-wordpress-without-a-plugin/
 */
function show_future_posts( $posts ) {

	global $wp_query, $wpdb;

	if( is_single() && $wp_query->post_count == 0 ) {
		$posts = $wpdb->get_results( $wp_query->request );
	}

	return $posts;
}

// add_filter( 'the_posts', __NAMESPACE__ . '\show_future_posts' );


/**
 * Remove unwanted post type fields
 *
 * @access public
 * @return void
 */
function textetekst_post_type_support() {
	remove_post_type_support( 'post', 'excerpt' );
}

// add_action( 'init', 'textetekst_post_type_support', 10 );


function polylang_display_slug( $args ) {
	$args['display_names_as'] = 'slug';

	return $args;
}
 add_filter( 'pll_the_languages_args', __NAMESPACE__ . '\polylang_display_slug' );
