<?php
/**
 * Helper functions
 * To call elsewhere in the theme (No hooks please!)
 *
 * @package WordPress
 *
 */

namespace TexteTekst;

/**
 * Special excerpt
 * Logic...
 * use custom excerpt if exists
 * elseif not check for and use 'read more' content
 * else use auto excerpt
 * @param int $post_id The id of the post
 */
function get_excerpt( $post_id = false ) {
	if( ! $post_id ) {
		global $post;
		$post_id = $post->ID;
	}

	if ( has_excerpt( $post_id ) ) {
		$excerpt = wp_trim_words( get_the_excerpt( $post_id ), 28, new_excerpt_more() );
	} else {
		$excerpt = wp_trim_words( get_post_field( 'post_content', $post_id ), 28, new_excerpt_more() );
	}

	return wpautop( $excerpt );
}

// Replaces the excerpt "more" text by llipsis
function new_excerpt_more() {
    return ' <span class="read-more">[...]</span>';
}

add_filter( 'excerpt_more', __NAMESPACE__ . '\new_excerpt_more' );

/**
 * Get taxonomies terms links
 */
function textetekst_taxonomies_terms_links() {
    global $post, $post_id;

    // get post by post id
    $post = get_post( $post->ID );

    // get post type by post
    $post_type = $post->post_type;

    // get post type taxonomies
    $taxonomies = get_object_taxonomies( $post_type );

    $out = "<ul>";

    foreach ( $taxonomies as $taxonomy ) {
        $out .= "<li> ";
        // get the terms related to post
        $terms = get_the_terms( $post->ID, $taxonomy );
        if ( ! empty( $terms ) ) {
            foreach ( $terms as $term )
                $out .= '<a href="' . get_term_link( $term->slug, $taxonomy ) . '">' . $term->name . '</a> ';
        }
        $out .= "</li>";
    }

    $out .= "</ul>";

    return $out;
}

/**
 * Get post thumbnail
 */
function textetekst_get_post_thumbnail( $post_id, $size = 'full' ) {
	if( has_post_thumbnail( $post_id ) ) {
		$source = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), $size );
		$thumbnail = $source[0];
	} else {
		$thumbnail = textetekst_get_default_image_url();
	}

	return $thumbnail;
}

function textetekst_get_default_image_url( $type = '' ) {
	return get_template_directory_uri() . '/img/default-image.png';
}

/**
 * Add post type to main class
 */
function main_class( $classes ) {
	$prefix = is_singular() ? 'type-' : 'archive-';
	$classes[] = $prefix . get_post_type();

	echo implode( ' ', $classes );
}
