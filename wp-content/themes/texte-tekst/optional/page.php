<?php
/**
 * Displays a page.
 *
 * @link http://codex.wordpress.org/Page_Templates
 * @package WordPress
 *
 */

namespace TexteTekst;
?>

<?php get_header(); ?>

	<div class="<?php echo apply_filters( THEMEDOMAIN . '-page_class', 'inner-grid', 10 ); ?>">

		<?php do_action( THEMEDOMAIN . '-before_main_content' ); ?>

		<main class="main" role="main">

			<?php while ( have_posts() ) : the_post(); ?>

				<?php do_action( THEMEDOMAIN . '-loop' ); ?>

			<?php endwhile; ?>

		</main>

		<?php apply_filters( THEMEDOMAIN . '-show_sidebar', true, get_the_ID() ) ? get_sidebar() : false; ?>

	</div> <!-- .inner-grid -->

<?php get_footer(); ?>
