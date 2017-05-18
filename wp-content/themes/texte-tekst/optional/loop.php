<?php
/**
 * Displays the post loop.
 *
 * @link http://codex.wordpress.org/The_Loop
 * @package WordPress
 *
 */
?>

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

	<?php get_template_part( 'template-part/content', 'loop-posts' ); ?>

	<?php endwhile; ?>

	<?php if ( function_exists( 'textetekst_page_navi' ) ) : // if better page navigation is active ?>

		<?php textetekst_page_navi(); // use the page navi function ?>

	<?php endif; ?>

<?php else : ?>

	<?php get_template_part( 'template-part/content', '404' ); ?>

<?php endif; ?>
