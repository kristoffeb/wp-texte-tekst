<?php
/**
 * Front-page.
 *
 * @link http://codex.wordpress.org/Page_Templates
 * @package WordPress
 */

namespace TexteTekst;
?>

<?php get_header(); ?>

	<?php do_action( THEMEDOMAIN . '-before_front_page' ); ?>

	<main class="main" role="main">

		<?php do_action( THEMEDOMAIN . '-main_front_page' ); ?>

	</main>

	<?php do_action( THEMEDOMAIN . '-after_front_page' ); ?>

<?php get_footer(); ?>
