<?php
/**
 * Displays the sidebar, typicallly containing the primary widget area.
 *
 * @link http://codex.wordpress.org/Sidebars
 * @package WordPress
 *
 */
?>

<?php do_action( THEMEDOMAIN . '-before_sidebar' ); ?>

<aside class="sidebar" role="complementary">

	<?php do_action( THEMEDOMAIN . '-sidebar' ); ?>

</aside>

<?php do_action( THEMEDOMAIN . '-after_sidebar' ); ?>
