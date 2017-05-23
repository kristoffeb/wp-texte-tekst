<?php
/**
 * @link https://github.com/WebDevStudios/CMB2-Snippet-Library/blob/master/options-and-settings-pages/theme-options-cmb.php
 */

namespace TexteTekst\Content\Admin;

use TexteTekst\Content\Main;
use TexteTekst\Content\Core\Type;
use TexteTekst\Content\Core\Utility;
use WP_Query;

class Partners {

	const PREFIX = 'texttekst_partners_';
	const METABOX_ID = 'texttekst_partners_options';

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
			'options-general.php',
			__( 'Partners', Main::TEXT_DOMAIN ),
			__( 'Partners', Main::TEXT_DOMAIN ),
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

		$group_id = $meta_box->add_field( [
			'id'          => self::PREFIX . 'partner',
			'type'        => 'group',
			'repeatable'  => TRUE,
			'options'     => [
				'group_title'   => __( 'Partner {#}', Main::TEXT_DOMAIN ),
				'add_button'    => __( 'Add Partner', Main::TEXT_DOMAIN ),
				'remove_button' => __( 'Remove Partner', Main::TEXT_DOMAIN ),
			],
		] );

		$meta_box->add_group_field( $group_id, [
			'name' => __( 'Name', Main::TEXT_DOMAIN ),
			'id'   => 'title',
			'type' => 'text_medium',
		] );

		$meta_box->add_group_field( $group_id, [
			'name' => __( 'URL', Main::TEXT_DOMAIN ),
			'id'   => 'url',
			'type' => 'text_url',
		] );

		$meta_box->add_group_field( $group_id, [
			'name' => __( 'Logo', Main::TEXT_DOMAIN ),
			'id'   => 'logo',
			'type' => 'file',
		] );
	}

	public function settings_notices( $object_id, $updated ) {
		if ( $object_id !== self::PREFIX . 'options' || empty( $updated ) ) {
			return;
		}
		add_settings_error( self::PREFIX . 'options-notices', '', __( 'Settings updated.', Main::TEXT_DOMAIN ), 'updated' );
		settings_errors( self::PREFIX . 'options-notices' );
	}
}
