<?php
/**
 * Displays the search form
 *
 * @link http://codex.wordpress.org/Function_Reference/get_search_form
 * @package WordPress
 */


?>
<div class="search">

	<?php do_action( THEMEDOMAIN . '-before_search_form' ); ?>

	<div class="search-form">

		<form role="search" method="get" id="searchform" action="<?php echo home_url(); ?>/">

			<div class="input-wrap">
				<label class="screen-reader-text" for="s"><?php _e( 'Search for', THEMEDOMAIN ); ?></label>
				<input type="search" value="<?php echo get_search_query(); ?>" name="s" id="s" placeholder="<?php _e( 'Keywords', THEMEDOMAIN ); ?>" />
			</div>

			<?php do_action( THEMEDOMAIN . '-search_fields' ); ?>

			<input type="submit" id="searchsubmit" class="button" value="<?php echo esc_attr( __( 'Search', THEMEDOMAIN ) ); ?>" />
		</form>

	</div>

	<?php do_action( THEMEDOMAIN . '-after_search_form' ); ?>

</div>
