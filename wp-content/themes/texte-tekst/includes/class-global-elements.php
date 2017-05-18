<?php

namespace TexteTekst;


/**
 * Multisite class.
 * Mainly used to control global elements
 */
class Global_Elements {

	public function __construct() {
		$switch_blog = array(
			'before_main_nav',
			'before_top_nav',
			'before_footer',
		);

		$restore_blog = array(
			'after_main_nav',
			'after_top_nav',
			'after_footer',
		);

		$this->run_hooks( $switch_blog, 'switch_to_main_site', 10 );
		$this->run_hooks( $restore_blog, 'restore_blog', 10 );

		add_action( 'updated_option', [ $this, 'update_transient' ] );
	}

	public function run_hooks( $hooks, $callback ) {
		foreach( $hooks as $hook ) {
			add_action( $this->get_hook( $hook ), array( $this, $callback ) );
		}
	}

	public function get_hook( $hook ) {
		return THEMEDOMAIN . '-' .$hook;
	}

	public function switch_to_main_site() {
		global $current_site;
		\switch_to_blog( $current_site->blog_id );
	}

	public function restore_blog() {
		\restore_current_blog();
	}

	public function update_transient() {
		$sidebars = [ 'footer-1', 'footer-2' ];

		foreach ( $sidebars as $sidebar ) {
			$this->delete_transient( $sidebar );
			$this->set_widget_transient( $sidebar );
		}
	}

	public function set_widget_transient( $id ) {

		if ( $transient = get_site_transient( $id ) ) {
			return;
		}

		ob_start();

		dynamic_sidebar( $id );

		$sidebar = ob_get_clean();

		set_site_transient( $id, $sidebar, 7 * 24 * HOUR_IN_SECONDS );

		return $sidebar;
	}

	public function delete_transient( $option ) {
		delete_site_transient( $option );
	}
}

new Global_Elements();
