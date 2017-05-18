<?php
/**
 * Displays image attachments.
 *
 * @TODO This file needs revision
 *
 * @link http://codex.wordpress.org/Using_Image_and_File_Attachments#Usage_in_Themes
 * @package WordPress
 *
 */
?>

<?php // Usually we don't use this so redirect to the relevant post. ?>
<?php // Uncomment this to revert to a real template. ?>
<?php wp_redirect( get_permalink( $post->post_parent ) ); ?>

<?php get_header(); ?>

	<main role="main">

		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

		<article id="article-<?php the_ID(); ?>" <?php post_class(); ?>>

			<h1>
				<a href="<?php echo get_permalink( $post->post_parent ); ?>" rev="attachment"><?php echo get_the_title( $post->post_parent ); ?></a> &raquo; <?php the_title(); ?>
			</h1>

			<div class="article-content">
				<p class="attachment">
					<a href="<?php echo wp_get_attachment_url( $post->ID ); ?>"><?php echo wp_get_attachment_image( $post->ID, 'medium' ); ?></a>
				</p>
				<p class="caption">
					<?php if ( !empty($post->post_excerpt) ) the_excerpt(); // this is the "caption" ?>
				</p>

				<?php the_content( __( 'Read more &raquo;', THEMEDOMAIN ) ); ?>
			</div>

			<footer>
				<nav class="prev-next-links">
					<ul>
						<li><?php previous_image_link() ?></li>
						<li><?php next_image_link() ?></li>
					</ul>
				</nav>
			</footer>

		</article>

		<?php endwhile;
		else : ?>

		<div class="help">
			<p><?php _e( 'Sorry, no attachments matched your criteria.', THEMEDOMAIN ); ?></p>
		</div>

		<?php endif; ?>

	</main> <!-- end main -->

<?php get_footer(); ?>
