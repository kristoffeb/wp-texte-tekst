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
function excerpt( $post_id = false ) {
	if( ! $post_id ) {
		global $post;
		$post_id = $post->ID;
	}

	$excerpt = get_post_meta( get_the_ID(), '_textetekst_excerpt', true );

	if ( $excerpt ) {
		$excerpt = $excerpt . ' <span class="read-more"><a href="' . get_permalink( $post_id ) . '">' . __( 'Read more &raquo;', THEMEDOMAIN ) . '</a></span>';
	} elseif ( has_excerpt( $post_id ) ) {
		$excerpt = get_the_excerpt() . ' <span class="read-more"><a href="' . get_permalink( $post_id ) . '">' . __( 'Read more &raquo;', THEMEDOMAIN ) . '</a></span>';
	} elseif( textetekst_has_more() ) {
		$excerpt = get_the_content( '<span class="read-more">' . __( 'Read more &raquo;', THEMEDOMAIN ) . '</span>' );
	} else {
		$excerpt = textetekst_get_first_paragraph( get_the_content() ) . ' <span class="read-more"><a href="' . get_permalink( $post_id ) . '">' . __( 'Read more &raquo;', THEMEDOMAIN ) . '</a></span>';
	}

	echo wpautop( $excerpt );
}

function textetekst_get_first_paragraph( $content ) {
	$content = wpautop( $content );

	$start = strpos( $content, '<p>' );
	$end = strpos( $content, '</p>', $start );

	return wp_strip_all_tags( substr( $content, $start, $end - $start + 4 ) );
}

/**
 * Checks a post to see if it has a read more tag
 */
function textetekst_has_more() {
	global $post;

	// Check we're in the right context
	if ( empty( $post ) ) {
		return;
	}

	// Parse the post content for a more tag
	return ( bool ) preg_match( '/<!--more(.*?)?-->/', $post->post_content );
}

// Replaces the excerpt "more" text by a link
function new_excerpt_more( $more ) {
    global $post;

	return '<span class="read-more"><a href="' . get_permalink( $post->ID ) . '">' . __( 'Read more &raquo;', THEMEDOMAIN ) . '</a></span>';
}

// add_filter( 'excerpt_more', __NAMESPACE__ . '\new_excerpt_more' );

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
