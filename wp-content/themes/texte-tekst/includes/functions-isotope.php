<?php

namespace TexteTekst;

// Isotope filters
// http://codepen.io/desandro/pen/wfaGu
function textetekst_isotope_filters( $taxonomy = '' ) {

	if ( ! empty( $taxonomy ) ) {
		$categories = get_terms( $taxonomy );
	} elseif ( is_category() ) { // is blog category
		$categories = get_categories();
	} else { // is custom taxonomy
		$categories = get_terms( get_query_var( 'taxonomy' ) );
	}

	// If we get nothing, return
	if ( empty( $categories ) || ! is_array( $categories ) ) {
		return;
	}
	?>
	<div id="filters" class="button-group">
		<button class="button tiny is-checked" data-filter="*"><?php _e( 'All', THEMEDOMAIN ); ?></button>
	    <?php foreach( $categories as $category ) : ?>
	    	<button class="button tiny" data-filter=".<?php echo( $taxonomy . '-' . $category->slug ); ?>"><?php echo( $category->name ); ?></button>
		<?php endforeach; ?>
	</div>
<?php
}

// Add category slugs to post classes
function textetekst_category_slug_class( $classes ) {
	global $post;

	// We only want this on taxonomy pages for pnoise
	if ( ! is_archive() || ! is_tax() ) {
		return $classes;
	}

	// $taxonomy = 'prep_level';
	// if ( ! empty( $taxonomy ) ) {
	// 	$categories = get_the_terms( $post->ID, $taxonomy );
	// } elseif ( is_category() ) { // is blog category
	// 	$categories = get_the_category( $post->ID );
	// } elseif( is_tax() ) { // is custom taxonomy
	// 	$categories = get_the_terms( $post->ID, get_query_var( 'taxonomy' ) );
	// } else { // else we don't want to do anything
	// 	return;
	// }

	// If we get nothing, return
	// if ( empty( $categories ) || ! is_array( $categories ) ) {
	// 	return $classes;
	// }

	$classes[] = 'iso-item';

	// foreach ( $categories as $category ) {
	// 	$classes[] = $category->slug;
	// }

	return $classes;
}

add_filter( 'post_class', 'textetekst_category_slug_class' );


// Add filters and start isotope container
function textetekst_iso_container_start() {
	// textetekst_isotope_filters( 'prep_level' );

	echo '<div class="iso-container">';
}

add_action( THEMEDOMAIN . '-before_taxonomy_archive', 'textetekst_iso_container_start' );


// End isotope container
function textetekst_iso_container_end() {
	echo '</div>';
}

add_action( THEMEDOMAIN . '-after_taxonomy_archive', 'textetekst_iso_container_end' );

// Change the number of posts on custom taxonomy archive pages
function textetekst_taxonomy_page_size( $query ) {
    if ( is_admin() || ! $query->is_main_query() ) {
		return;
	}

	if ( ! is_tax() ) {
		return;
	}

	$query->set( 'posts_per_page', -1 );
	return;
}

add_action( 'pre_get_posts', 'textetekst_taxonomy_page_size', 1 );
