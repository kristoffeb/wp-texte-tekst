<?php
/**
 * Widgets
 *
 * @package WordPress
 *
 *
 * @link http://codex.wordpress.org/Widgets_API
 */

/**
 * Help
 * https://core.trac.wordpress.org/browser/tags/4.1.1/src/wp-includes/option.php#L0
 */

namespace TexteTekst;

class Sidebar {

	var $sidebars = array();
	var $current_id = '';

	public function __construct() {
		add_action( 'widgets_init', array( $this, 'register_sidebars' ) );
		add_action( 'init', array( $this, 'display_sidebars' ) );
	}


	public function add( $sidebar ) {

		$sidebar_defaults = array(
			'name' => '',
			'id' => '',
			'class' => '',
			'description' => '',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'hook' => '',
			'priority' => 10,
			'main_site' => false,
			'global' => false,
		);

		$args = array_merge( $sidebar_defaults, $sidebar );

		$this->sidebars[] = $args;
	}

	public function get_sidebars() {
		return apply_filters( 'get_sidebars', $this->sidebars );
	}

	public function register_sidebars() {
		$sidebars = $this->get_sidebars();

		if ( empty( $sidebars ) ) {
			return;
		}

		foreach( $sidebars as $sidebar ) {

			if ( $sidebar['main_site'] && ! is_main_site() ) {
				return;
			}

			register_sidebar( [
				'id' => $sidebar['id'],
				'name' => $sidebar['name'],
				'description'  => $sidebar['description'],
				'before_widget' => $sidebar['before_widget'],
				'after_widget' => $sidebar['after_widget'],
				'before_title' => '<h4 class="widgettitle">',
				'after_title' => '</h4>'
			] );
		}
	}

	public function display_sidebars() {

		$sidebars = $this->get_sidebars();

		if ( empty( $sidebars ) ) {
			return;
		}

		foreach( $sidebars as $sidebar ) {

			if ( ! is_active_sidebar( $sidebar['id'] ) && ! $sidebar['global'] ) {
				continue;
			}

			// We use closures to pass through the sidebar args array. Possible from PHP 5.3+
			// http://php.net/manual/de/functions.anonymous.php
			add_action( $this->get_hook( $sidebar['hook'] ), function() use ( $sidebar ) { $this->sidebar_template( $sidebar ); }, $sidebar['priority'] );
		}
	}



	public function sidebar_template( $sidebar ) {

		if ( ! isset( $sidebar['id'] ) && ! $sidebar['id'] ) {
			return;
		}

		$sidebar_id = $sidebar['id'];

		$classes[] = 'widget-area';

		if ( isset( $sidebar['class'] ) ) {
			$classes[] = $sidebar['class'];
		}

		if ( $sidebar['global'] && is_multisite() ) {

			$global_elements = new Global_Elements();
			$global_elements->set_widget_transient( $sidebar_id );
			$global_sidebar = get_site_transient( $sidebar_id );

			echo '<div id="' . $sidebar_id . '" class="' . implode( ' ',  $classes ) . '">';
				// echo '<div class="widget-wrap">';
					echo $global_sidebar;
				// echo '</div>';
			echo '</div>';
		} else {

			echo '<div id="' . $sidebar_id . '" class="' . implode( ' ',  $classes ) . '">';
				// echo '<div class="widget-wrap">';
					dynamic_sidebar( $sidebar_id );
				// echo '</div>';
			echo '</div>';
		}
	}

	/**
	 * Deprecated?
	 */
	public function get_sidebar_id( $name, $id ) {
		return sanitize_title( $name ) . '-' . sanitize_title( $id );
	}

	public function get_hook( $hook ) {
		return THEMEDOMAIN . '-' . $hook;
	}
}
