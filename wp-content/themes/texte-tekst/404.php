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

	<main class="main" role="main">

		<article id="article-not-found">

			<h1><?php echo apply_filters( THEMEDOMAIN . '404_title', __( '404', THEMEDOMAIN ) ); ?></h1>

			<div class="article-content">

				<p><?php echo apply_filters( THEMEDOMAIN . '404_content', __( 'The content you were looking for may have been moved or unpublished.', THEMEDOMAIN ) ); ?></p>

				<p><?php echo sprintf( '<a href="%s">%s</a>', get_home_url(), __( 'Go to the homepage.', THEMEDOMAIN ) ); ?></p>

			</div> <!-- .article-content -->

		</article>

	</main>

<?php get_footer(); ?>
