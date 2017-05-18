<?php

namespace TexteTekst;

/**
 * Owl default attributes
 */
 function owl_default_atts( $atts, $default ) {

	 $custom = array(
		  'items' => '1',
		  'size' => 'pnoise-landing',
		  'autoplay' => 'true',
		  'dots' => 'true',
		  'loop' => 'true',
		  'video' => 'true',
		  'autoplayhoverpause' => 'true',
	 );

	 $atts = array_merge( $default, $custom, $atts );

	 return $atts;
}

add_filter( 'owl_custom_default_atts', 'owl_default_atts', 10, 2 );


/**
 * Add owl corousel classes
 */
function owl_item_meta_classes( $classes, $post_id ){

	$classes[] = get_post_meta( $post_id, '_textetekst_owl_button_color', true );
	$classes[] = get_post_meta( $post_id, '_textetekst_owl_text_alignment', true );
	return $classes;
}

add_filter( 'owl_item_classes', 'owl_item_meta_classes', 10, 2 );


/**
 * Filter owl corousel overlay content
 */
function owl_add_button( $content, $post_id ){

	$button_url = get_post_meta( $post_id, '_textetekst_owl_button_url', true );
	$call_to_action = get_post_meta( $post_id, '_textetekst_owl_call_to_action', true );

	if ( $button_url != '' ) {
		$content .= '<div><a class="button call-to-action" href="' . $button_url . '">' . $call_to_action . '</a></div>';
	}

	return $content;
}

add_filter( 'owl_carousel_img_overlay_content', 'owl_add_button', 10, 2 );


/**
 *  Filter owl add link to overlay
 */
function owl_add_link_overlay( $overlay, $title, $content, $link ) {
    $result = sprintf( '<a href="%s">%s</a>', $link, $overlay );
    return $result;
}

add_filter( 'owlcarousel_img_overlay', 'owl_add_link_overlay', 10, 4 );


/**
 * Filter owl thumbnail size for WP Gallery
 */
function owl_gallery_thumbnail_size() {
    return 'pnoise-large';
}
add_filter( 'owl_carousel_wp_gallery_thumbnail_size', 'owl_gallery_thumbnail_size' );
