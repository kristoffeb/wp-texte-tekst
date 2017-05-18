<?php
/**
 * Displays the search form
 *
 * @link http://codex.wordpress.org/Function_Reference/get_search_form
 * @package WordPress
 *
 */
?>

<form role="search" method="get" id="search-form" action="<?php echo home_url(); ?>/">
	<div class="input-group">
		<label class="hide input-group-label" for="s"><?php _e( 'Search for', THEMEDOMAIN ); ?></label>
		<input type="search" class="input-group-field" value="<?php echo get_search_query(); ?>" name="s" id="s" placeholder="<?php __( 'Search...', THEMEDOMAIN ); ?>" />
		<div class="input-group-button">
			<button class="button" type="submit" id="search-submit"><?php echo esc_attr( __( 'Search', THEMEDOMAIN ) ); ?></button>
		</div> <!-- .input-group-button -->
	</div> <!-- .input-group -->
</form>
