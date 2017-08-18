<?php
/**
 * Displays archives.
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
				<?php if ( is_home() ) : ?>
					<?php _e( 'Blog', THEMEDOMAIN ); ?>

				<?php elseif ( is_category() ) : ?>
					<span><?php _e( 'Category:', THEMEDOMAIN ); ?></span> <?php single_cat_title(); ?>

				<?php elseif ( is_tag() ) : ?>
					<span><?php _e( 'Tag:', THEMEDOMAIN ); ?></span> <?php single_tag_title(); ?>

				<?php elseif ( is_tax() ) : ?>
					<?php single_term_title(); ?>

				<?php elseif ( is_post_type_archive() ) : ?>
					<?php post_type_archive_title(); ?>

				<?php elseif ( is_day() ) : ?>
					<?php the_time( 'l, F j, Y' ); ?>

				<?php elseif ( is_month() ) : ?>
					<?php the_time( 'F Y' ); ?>

				<?php elseif ( is_year() ) : ?>
					<?php the_time( 'Y' ); ?>

				<?php elseif ( is_author() ) : ?>
					<?php global $post; ?>
					<span><?php _e( 'Author:', THEMEDOMAIN ); ?></span> <?php the_author_meta( 'display_name', $post->post_author ); ?>

				<?php endif; ?>
			</h1>

			<?php if( ( is_tax() || is_category() || is_tag() ) ) : ?>
				<?php $term_description = term_description(); ?>
				<?php if( !empty( $term_description ) ) : ?>
					<div class="term-description">
						<?php echo wpautop( $term_description ); ?>
					</div>
				<?php endif; ?>
			<?php endif; ?>

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
