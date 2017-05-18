<?php
/**
 * Displays the search results page.
 *
 * @link http://codex.wordpress.org/Creating_an_Archive_Index
 * @package WordPress
 *
 */
?>

<?php get_header(); ?>

<div class="inner-grid">

	<main class="main" role="main"  itemscope="itemscope" itemtype="http://schema.org/Blog">

		<header class="archive-header">

			<div class="fullwidth">

				<h1 class="archive-title">
					<span><?php _e( 'Search Results for:', THEMEDOMAIN ); ?></span> <?php echo esc_attr(get_search_query()); ?>
				</h1>

			</div> <!-- .fullwidth -->

		</header>

		<div class="archive-content">

			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'partials/content', 'loop' ); ?>

				<?php endwhile; ?>

			<?php else : ?>

				<?php get_template_part( 'partials/post', 'not-found' ); ?>

			<?php endif; ?>


		</div> <!-- .archive-content -->

		<footer class="archive-footer">

			<?php get_search_form(); ?>

		</footer>

	</main>

	<?php get_sidebar(); ?>

</div> <!-- .inner-grid -->

<?php get_footer(); ?>
