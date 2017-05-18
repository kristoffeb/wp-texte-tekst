<?php
/**
 * Displays Woocommerce pages.
 *
 * @link http://docs.woothemes.com/documentation/plugins/woocommerce/
 * @package WordPress
 *
 */
?>

<?php get_header(); ?>

	<div class="inner-grid">

		<main class="main" role="main">

			<?php if ( have_posts() ) : ?>

				<?php woocommerce_content(); ?>

			<?php else : ?>

				<?php get_template_part( 'template-part/content', '404' ); ?>

			<?php endif; ?>

		</main>

		<?php get_sidebar(); ?>

	</div><!-- .inner-grid -->

<?php get_footer(); ?>
