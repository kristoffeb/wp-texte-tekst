<?php
/**
 * Displays the 404 page (Not Found).
 *
 * @link http://codex.wordpress.org/Creating_an_Error_404_Page
 * @package WordPress
 *
 */
?>

<?php get_header(); ?>

	<div class="inner-grid">

		<main class="main" role="main">

			<article id="article-not-found">

				<h1><?php echo apply_filters( THEMEDOMAIN . '404_title', __( '404 - Not Found', THEMEDOMAIN ) ); ?></h1>

				<div class="article-content">

					<p><?php echo apply_filters( THEMEDOMAIN . '404_content', __( 'The content you were looking for may have been moved or unpublished', THEMEDOMAIN ) ); ?></p>

				</div> <!-- .article-content -->

			</article>

		</main>

		<?php get_sidebar(); ?>

	</div> <!-- .inner-grid -->

<?php get_footer(); ?>
