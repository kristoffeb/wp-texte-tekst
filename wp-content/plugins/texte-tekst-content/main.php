<?php
/**
 *
 * @package texte-tekst
 * @author  Kristoffe Biglete
 * @link https://make.wordpress.org/core/handbook/best-practices/coding-standards/php/
 * @link http://www.phpdoc.org/docs/latest/guides/docblocks.html
 *
 * Plugin Name: Texte/Tekst - Content
 * Plugin URI:
 * Description: Content for Texte / Tekst
 * Version:     1.0.0
 * Writer:      Kristoffe Biglete
 * Writer URI:
 * Text Domain: textetekst
 * Domain Path: /languages
 */

namespace TexteTekst\Content;

// Do not access this file directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Register plugin specific hooks
register_activation_hook( __FILE__,   [ __NAMESPACE__ . '\Main', 'activate' ] );
register_deactivation_hook( __FILE__, [ __NAMESPACE__ . '\Main', 'deactivate' ] );

class Main {

	/**
	 * Text domain for translators
	 * Don't use "-" (dash) in the name, as it can potentially break the site if the text domain is used in a certain context.
	 */
	const TEXT_DOMAIN = 'textetekst';

	/**
	 * @var object Instance of this class.
	 */
	protected static $instance = null;

	/**
	 * @var string Filename of this class.
	 */
	public $file;

	/**
	 * @var string Basename of this class.
	 */
	public $basename;

	/**
	 * @var string Plugins directory for this plugin.
	 */
	public $plugin_dir;

	/**
	 * @var string Plugins url for this plugin.
	 */
	public $plugin_url;

	/**
	 * @var string Lang dir for this plugin.
	 */
	public $lang_dir;

	/**
	 * Do not load this more than once.
	 */
	private function __construct() {

		add_action( 'after_setup_theme', [ $this, 'load_textdomain' ], 10 );
		add_action( 'after_setup_theme', [ $this, 'bootstrap' ], 20 );

		// add_action( 'wp_enqueue_scripts', [ $this, 'enqueue' ] );
		// add_action( 'wp_enqueue_scripts', [ $this, 'js_params' ] );
	}

	/**
	 * Returns the instance of this class.
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * General setup.
	 */
	public function load_textdomain() {
		load_plugin_textdomain( self::TEXT_DOMAIN, false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
	}

	/**
	 * Init plugin
	 */
	public function bootstrap() {

		if ( self::require_file( 'core/bootstrap.php' ) ) {
			$this->init_core();
		}

		if ( is_admin() ) {
			if ( self::require_file( 'admin/bootstrap.php' ) ) {
				$this->init_admin();
			}
		} else {
			if ( self::require_file( 'frontend/bootstrap.php' ) ) {
				$this->init_frontend();
			}
		}
	}

	public function init_admin() {
		$admin = new Admin\Bootstrap;
	}

	public function init_frontend() {
		$frontend = new Frontend\Bootstrap;
	}

	public function init_core() {
		$core = new Core\Bootstrap;
	}

	/**
	 * Inject php options into the js file.
	 */
	private function js_params() {
		$options = array(
			'ajaxurl'      => admin_url( 'admin-ajax.php' ),
			'submit_nonce' => wp_create_nonce( 'submit-nonce' ),
		);

		wp_localize_script( self::TEXT_DOMAIN . '-js', self::TEXT_DOMAIN, $options );
	}

	/**
	 * Enqueue scripts
	 */
	public function enqueue() {

		// Enqueue styles
		wp_enqueue_style( self::TEXT_DOMAIN . '-css', plugins_url( 'assets/dist/styles.min.css', __FILE__ ) );

		// Enqueue scripts
		wp_enqueue_script( self::TEXT_DOMAIN . '-js', plugins_url( 'assets/dist/scripts.js', __FILE__ ), [ 'jquery' ], '1.0', true );
		// wp_enqueue_script( self::TEXT_DOMAIN . '-js', plugins_url( 'assets/dist/scripts.min.js', __FILE__ ), [ 'jquery' ], '1.0', true );
	}

	public static function activate() {
		// @TODO Find out why this gives a "headers already sent" error
		// $main = self::instance();
		// $main->load_textdomain();
		// $main->bootstrap();

		// Add more caps for subscribers
		$subscriber = get_role( 'subscriber' );
		$subscriber->add_cap( 'read_private_pages' );
		$subscriber->add_cap( 'read_private_posts' );

		flush_rewrite_rules();
	}

	public static function deactivate() {
		flush_rewrite_rules();
	}

	public static function require_file( $file ) {
		if ( ! file_exists( self::plugin_path() . '/' . $file ) ) {
			return false;
		}

		require_once self::plugin_path() . '/' . $file;
		return true;
	}

	/**
	 * Get the plugin url.
	 * @return string
	 */
	public static function plugin_url() {
		return untrailingslashit( plugins_url( '/', __FILE__ ) );
	}

	/**
	 * Get the plugin path.
	 * @return string
	 */
	public static function plugin_path() {
		return untrailingslashit( plugin_dir_path( __FILE__ ) );
	}

	/**
	 * Get the template path.
	 * @return string
	 */
	public static function template_path( $template_name ) {
		return self::plugin_path() . '/templates/' . $template_name;
	}

	/**
	 * Check if template exists
	 * @return bool
	 */
	public static function template_exist( $template_name ) {
		return file_exists( self::template_path( $template_name ) );
	}

	/**
	 * Get the template part and send along any variables.
	 * @return string
	 */
	public static function get_template_part( $template_name, $vars = array() ) {
		extract( $vars );
		include self::template_path( $template_name );
	}

}

/**
 * Instantiate the plugin
 */
function main() {
	return Main::instance();
}
add_action( 'plugins_loaded', __NAMESPACE__ . '\main' );
