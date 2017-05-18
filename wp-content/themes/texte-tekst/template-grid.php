<?php
/**
 * Template for grid pages.
 * Used in page.php
 *
 * @package WordPress
 * @subpackage Mesa
 */
?>
<?php if ( is_front_page() ) : ?>

	<?php if ( is_active_sidebar( 'page_grid_' . get_option( 'page_on_front' ) ) ) : ?>
		<div id="front_page_grid" class="page_grid">
			<?php dynamic_sidebar( 'page_grid_' . get_option( 'page_on_front' ) ); ?>
		</div>
	<?php endif; ?>

<?php else : ?>

	<?php if ( is_active_sidebar( 'page_grid_' . $post->ID ) ) : ?>
		<div id="page_grid_<?php echo $post->ID; ?>" class="page_grid">
			<?php dynamic_sidebar( 'page_grid_' . $post->ID ); ?>
		</div>
	<?php endif; ?>

<?php endif; ?>
