<?php

namespace TexteTekst\Content\Core;

use TexteTekst\Content\Main;

class Utility {

	/**
	 * Allow to remove method for an hook when, it's a class method used and class don't have variable, but you know the class name :)
	 */
	public static function remove_filters_for_anonymous_class( $hook_name = '', $class_name ='', $method_name = '', $priority = 0 ) {
		global $wp_filter;

		// Take only filters on right hook name and priority
		if ( ! isset( $wp_filter[ $hook_name ][ $priority ] ) || ! is_array( $wp_filter[ $hook_name ][ $priority ] ) ) {
			return false;
		}

		// Loop on filters registered
		foreach ( ( array ) $wp_filter[ $hook_name ][ $priority ] as $unique_id => $filter_array ) {
			// Test if filter is an array ! (always for class/method)
			if ( isset( $filter_array['function'] ) && is_array( $filter_array['function'] ) ) {
				// Test if object is a class, class and method is equal to param !
				if ( is_object( $filter_array['function'][0] ) && get_class( $filter_array['function'][0] ) && get_class( $filter_array['function'][0] ) == $class_name && $filter_array['function'][1] == $method_name ) {
					unset( $wp_filter[ $hook_name ][ $priority ][ $unique_id ] );
				}
			}
		}

		return false;
	}

	public static function is_plugin_active( $plugin ) {
		if (
			in_array( $plugin, apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) )
			|| function_exists( 'is_plugin_active' ) && is_plugin_active( $plugin )
		) {
			return true;
		}

		return false;
	}

	public static function get_languages( $type = 'select' ) {
		$languages = PLL()->model->get_languages_list();

		$list = [];

		foreach ( $languages as $language ) {
			if ( $type === 'slug' ) {
				$list[] = $language->slug;
			} else {
				$list[ $language->slug ] = $language->name;
			}
		}

		return $list;
	}

	public static function get_post_language() {
		$language = PLL()->curlang;

		return $language;
	}

	public static function get_bg_lines() {
		ob_start();
			get_template_part( 'partial/background', 'lines' );
		$bg = ob_get_clean();

		return $bg;
	}
}
