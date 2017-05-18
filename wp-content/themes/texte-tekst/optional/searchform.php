<?php
/**
 * Displays the search form
 *
 * @link http://codex.wordpress.org/Function_Reference/get_search_form
 * @package WordPress
 *
 */


?>
<form role="search" method="get" id="searchform" action="<?php echo home_url(); ?>/">
	<label class="screen-reader-text" for="s"><?php _e( 'Search for', THEMEDOMAIN ); ?></label>
	<input type="search" value="<?php echo get_search_query(); ?>" name="s" id="s" placeholder="<?php __( 'Search...', THEMEDOMAIN ); ?>" />
	<input type="submit" id="searchsubmit" value="<?php echo esc_attr( __( 'Search', THEMEDOMAIN ) ); ?>" />
</form>