<?php
/**
 * The main template file. Acts as a fallback if more specific templates don't exist.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 * @package WordPress
 *
 */

namespace TexteTekst;
?>

<?php get_header(); ?>

	<?php do_action( THEMEDOMAIN . '-before_main_content' ); ?>

	<main class="<?php echo main_class( [ 'main' ] ); ?>" role="main">

		<?php while ( have_posts() ) : the_post(); ?>

			<?php do_action( THEMEDOMAIN . '-loop' ); ?>

		<?php endwhile; ?>

	</main>

	<?php do_action( THEMEDOMAIN . '-after_main_content' ); ?>

<?php get_footer(); ?>
