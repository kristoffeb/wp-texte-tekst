<?php
/**
 * @link https://github.com/WebDevStudios/CMB2-Snippet-Library/blob/master/options-and-settings-pages/theme-options-cmb.php
 */

namespace TexteTekst\Content\Admin;

use TexteTekst\Content\Main;
use TexteTekst\Content\Core\Type;
use TexteTekst\Content\Core\Utility;
use WP_Query;

class Settings {

	const PREFIX = 'pnoise_settings_';
	const METABOX_ID = 'pnoise_options';

	public function __construct() {
		add_action( 'admin_init', [ $this, 'register' ] );
		add_action( 'admin_menu', [ $this, 'add_options_page' ] );
		add_action( 'cmb2_admin_init', [ $this, 'add_options_page_metabox' ] );
	}

	public function register() {

	}

	public function add_options_page() {
		$options_page = '';

		$options_page = add_submenu_page(
			'edit.php?post_type=book',
			__( 'Options', Main::TEXT_DOMAIN ),
			__( 'Featured books', Main::TEXT_DOMAIN ),
			'manage_options',
			self::PREFIX . 'options',
			[ $this, 'admin_page_display' ]
		);

		// Include CMB CSS in the head to avoid FOUC
		add_action( "admin_print_styles-{$options_page}", [ 'CMB2_hookup', 'enqueue_cmb_css' ] );
	}

	public function admin_page_display() {
		?>
		<div class="wrap cmb2-options-page <?php echo self::PREFIX . 'options'; ?>">
			<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
			<?php cmb2_metabox_form( self::METABOX_ID, self::PREFIX . 'options' ); ?>
		</div>
		<?php
	}

	function add_options_page_metabox() {
		add_action( 'cmb2_save_options-page_fields_' . self::METABOX_ID, [ $this, 'settings_notices' ], 10, 2 );

		$meta_box = new_cmb2_box( array(
			'id'         => self::METABOX_ID,
			'hookup'     => false,
			'cmb_styles' => false,
			'show_on'    => [
				'key'   => 'options-page',
				'value' => [ self::PREFIX . 'options', ]
			],
		) );

		$languages = Utility::get_languages();

		foreach ( $languages as $slug => $language ) {
			$meta_box->add_field( [
				'name'    => sprintf( '%s - %s', __( 'Featured book', Main::TEXT_DOMAIN ), $language ),
				'id'      => self::PREFIX . 'featured_book_' . $slug,
				'type'    => 'select',
				'options' => $this->get_books( $slug ),
			] );
		}
	}

	public function settings_notices( $object_id, $updated ) {
		if ( $object_id !== self::PREFIX . 'options' || empty( $updated ) ) {
			return;
		}
		add_settings_error( self::PREFIX . 'options-notices', '', __( 'Settings updated.', Main::TEXT_DOMAIN ), 'updated' );
		settings_errors( self::PREFIX . 'options-notices' );
	}

	public function get_books( $lang = '' ) {
		$args = [ 'post_type' => Type\Book::POST_TYPE, 'lang' => $lang ];

		$books = new WP_Query( $args );

		$posts = [];
		foreach ( $books->posts as $post ) {
			$posts[ $post->ID ] = $post->post_title;
		}

		return $posts;
	}
}
