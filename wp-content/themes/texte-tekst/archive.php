<?php
/**
 * Displays archives.
 *
 * @link http://codex.wordpress.org/Creating_an_Archive_Index
 * @package WordPress
 *
 */
?>

<?php get_header(); ?>

<main class="main" role="main"  itemscope="itemscope" itemtype="http://schema.org/Blog">

	<header class="archive-header">

		<div class="inner-grid">

			<h1 class="archive-title">
				<?php if ( is_category() ) : ?>
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

		</div>

	</header>

	<div class="archive-content">

		<?php do_action( THEMEDOMAIN . '-before_archive' ); ?>

		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'template-part/content', 'loop' ); ?>

			<?php endwhile; ?>

		<?php else : ?>

			<?php get_template_part( 'template-part/content', '404' ); ?>

		<?php endif; ?>

		<?php do_action( THEMEDOMAIN . '-after_archive' ); ?>

	</div> <!-- .archive-content -->

	<footer class="archive-footer">
	</footer>

	</main>

</div> <!-- .inner-grid -->

<?php get_footer(); ?>
