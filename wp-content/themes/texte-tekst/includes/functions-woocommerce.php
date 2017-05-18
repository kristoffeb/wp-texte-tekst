<?php

namespace TexteTekst;

// Template hooks
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );
add_action( 'woocommerce_before_main_content', 'wc_wrapper_content_start', 20 );
add_action( 'woocommerce_after_main_content', 'wc_wrapper_content_end', 20 );
add_action( 'nav_menu_css_class', 'wc_active_menu', 10, 2 );
add_filter( 'woocommerce_breadcrumb_defaults', 'wc_breadcrumbs' );
add_filter( 'woocommerce_breadcrumb_home_url', 'wc_breadrumb_home_url' );
add_filter( THEMEDOMAIN . '-after_main_nav', 'wc_mini_cart' );

// Homepage
add_action( 'woocommerce_before_main_content', 'wc_home_landing_carousel', 10 );
add_action( 'woocommerce_after_main_content', 'wc_home_categories', 10 );
add_filter( 'loop_shop_per_page', 'wc_home_number_products', 10 );
add_filter( 'woocommerce_page_title', 'wc_page_title' );
add_filter( 'body_class', 'wc_home_body_class' );

// Single products
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
add_action( 'woocommerce_after_single_product_summary', 'wc_template_product_description', 5 );
add_action( 'woocommerce_after_single_product_summary', 'wc_template_more_products_wrapper_start', 10 );
add_action( 'woocommerce_after_single_product_summary', 'wc_output_upsells', 15 );
add_action( 'woocommerce_after_single_product_summary', 'wc_template_newsletter', 20 );
add_action( 'woocommerce_after_single_product_summary', 'wc_template_more_products_wrapper_end', 25 );


// Carousel acscasacson shop frontpage
function wc_home_landing_carousel() {
	if ( is_shop() ) {
		echo do_shortcode( '[owl-carousel category="shopforside"]' );
	}
}

// Products categories on shop frontpage
function wc_home_categories() {
	if ( is_shop() || is_archive() ) {
		echo wc_get_categories();
	}
}

// Content wrapper
function wc_wrapper_content_start() {
	echo '<div class="wc-main-wrapper inner-grid">';
}

function wc_wrapper_content_end() {
	echo '</div>';
}

// Menu active if on WC page
function wc_active_menu( $classes, $item ) {
 	if ( is_woocommerce() && $item->object_id == get_page_by_path( 'shop' )->ID ) {
		$classes[] = 'active';
	}
	return $classes;
}

// Number of products on Homepage
function wc_home_number_products() {
	if ( is_shop() ) {
		return 4;
	}
}

// Change page title
function wc_page_title( $page_title ) {
	if( is_shop() ) {
		return __( ' Must-haves', THEMEDOMAIN );
	} else {
		return $page_title;
	}
}

// Home to body class
function wc_home_body_class( $classes ) {
	if ( is_shop() ) {
		$classes[] = 'shop';
	}
	return $classes;
}

// Get categories list
function wc_get_categories() {
	$args = array(
		'orderby'    => 'count',
		'order'      => 'DESC',
		'hide_empty' => true,
	);

	$categories = get_terms( 'product_cat', $args );

	$categories_list = '<div class="wc-list-categories inner-grid"><ul>';

	foreach ( $categories as $cat) {
		$thumbnail_id = get_woocommerce_term_meta( $cat->term_id, 'thumbnail_id', true );
		$image = ( $thumbnail_id ) ? wp_get_attachment_url( $thumbnail_id ) : textetekst_get_default_image_url();

		$categories_list .= '<li><a href="' . get_term_link( $cat ) . '">';
		$categories_list .= '<div class="illustration"><img src="' . $image . '" alt="' . $cat->name . '" /></div>';
		$categories_list .= $cat->name;
		$categories_list .= '</a></li>';
	}

	$categories_list .= '</ul></div>';

	return $categories_list;
}

// Change single product tabs to summary
function wc_template_product_description() {
	echo '<div class="description">';
		woocommerce_get_template( 'single-product/tabs/description.php' );
	echo '</div>';
}

// Breadcrumbs
function wc_breadcrumbs() {
    return array(
		'delimiter'   => ' <span class="sep">&raquo;</span> ',
		'wrap_before' => '<nav class="woocommerce-breadcrumb" itemprop="breadcrumb">',
        'wrap_after'  => '</nav>',
		'before'      => '',
		'after'       => '',
		'home'        => __( 'Shop', THEMEDOMAIN ),
	);
}
function wc_breadrumb_home_url() {
    return get_permalink( woocommerce_get_page_id( 'shop' ) );
}

// Single product - More wrapper
function wc_template_more_products_wrapper_start() {
	echo '<div class="more-products">';
}
function wc_template_more_products_wrapper_end() {
	echo '</div>';
}

// Newsletter
function wc_template_newsletter() {
	echo '<aside>';
		get_template_part( 'partial/sidebar', 'newsletter' );
	echo '</aside>';
}

// Number of product upsell
function wc_output_upsells() {
    woocommerce_upsell_display( 3, 1 );
}

// Display mini-cart
function wc_mini_cart() {
	if ( is_woocommerce() ) {
		global $woocommerce;

		$cart_contents_count = $woocommerce->cart->cart_contents_count;
		$cart_contents = sprintf( _n( '%d product', '%d products', $cart_contents_count, THEMEDOMAIN ), $cart_contents_count );
		$cart_total = $woocommerce->cart->get_cart_subtotal();
		$cart_text = sprintf( '%s - %s', $cart_contents, $cart_total );
		$cart_url = $woocommerce->cart->get_cart_url();

		echo '<div id="mini-cart">';
		echo '<a href="' . $cart_url . '"><button class="menu-icon">' . $cart_text . '</button></a>';
		echo '<div class="wrapper">';
			woocommerce_mini_cart();
		echo '</div></div>';
	}
}
