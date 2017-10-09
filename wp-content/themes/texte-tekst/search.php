<?php
/**
 * Displays the search results page.
 *
 * @link http://codex.wordpress.org/Creating_an_Archive_Index
 * @package WordPress
 *
 */
 namespace TexteTekst;
 ?>

<?php get_header(); ?>

<main class="<?php echo main_class( [ 'main' ] ); ?>" role="main"  itemscope="itemscope" itemtype="http://schema.org/Blog">

	<?php do_action( THEMEDOMAIN . '-before_main_content' ); ?>

	<div class="inner-grid">

		<header class="archive-header">

			<h1 class="archive-title">
				<?php _e( 'Books', THEMEDOMAIN ); ?>
			</h1>

		</header>

		<div class="archive-content">

			<?php do_action( THEMEDOMAIN . '-before_archive' ); ?>

			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

				<?php do_action( THEMEDOMAIN . '-loop' ); ?>

				<?php endwhile; ?>

			<?php else : ?>

				<?php get_template_part( 'template-part/content', '404' ); ?>

			<?php endif; ?>

			<?php do_action( THEMEDOMAIN . '-after_archive' ); ?>

		</div>

		<footer class="archive-footer">

			<?php do_action( THEMEDOMAIN . '-archive_footer' ); ?>

		</footer>

	</div>

	<?php do_action( THEMEDOMAIN . '-after_main_content' ); ?>

</main>

<?php get_footer(); ?>
