<?php

namespace TexteTekst;

// Navigation only for the main site
if ( is_main_site() ) {
	register_nav_menus(	array(
		'main-nav' => __( 'Main Navigation', THEMEDOMAIN ),
	) );
} else {
	register_nav_menus(	array(
		'subsite-nav' => __( 'Subsite Navigation', THEMEDOMAIN ),
	) );
}

/**
 * Main navigation
 */
function main_menu( $float = '' ) {
    wp_nav_menu( array(
        'container' => false,                           // remove nav container
        'container_class' => '',                        // class of container
        'menu' => '',                                   // menu name
        'menu_class' => 'menu dropdown vertical medium-horizontal' . $float,			    // adding custom nav class
        'theme_location' => 'main-nav',           		// where it's located in the theme
        'before' => '',                                 // before each link <a>
        'after' => '',                                  // after each link </a>
        'link_before' => '',                            // before each link text
        'link_after' => '',                             // after each link text
		'items_wrap' => '<ul id="%1$s" class="%2$s" data-dropdown-menu>%3$s</ul>',
        'depth' => 5,                                   // limit the depth of the nav
        'fallback_cb' => false,                         // fallback function (see below)
        //'walker' => new top_bar_walker()
    ) );
}

function submenu_get_children_ids( $id, $items ) {

    $ids = wp_filter_object_list( $items, [ 'menu_item_parent' => $id ], 'and', 'ID' );

    foreach ( $ids as $id ) {
        $ids = array_merge( $ids, submenu_get_children_ids( $id, $items ) );
    }

    return $ids;
}

function submenu_limit( $items, $args ) {
    if ( empty( $args->submenu ) ) {
        return $items;
    }

    $parent_menu = wp_filter_object_list( $items, [ 'ID' => $args->submenu ], 'and', 'ID' );
    $parent_id = array_pop( $parent_menu );

    $children  = submenu_get_children_ids( $parent_id, $items );

    foreach ( $items as $key => $item ) {
        if ( ! in_array( $item->ID, $children ) ) {
            unset( $items[ $key ] );
        }
    }

    return $items;
}

// add_filter( 'wp_nav_menu_objects', 'submenu_limit', 10, 2 );
