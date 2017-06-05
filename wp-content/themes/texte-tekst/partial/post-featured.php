<?php
/**
 * Displays the featured content for varies post types.
 *
 * @package WordPress
 */
?>

<?php $image_id = apply_filters( THEMEDOMAIN . '-post_featured', get_post_thumbnail_id(), 10 ); ?>
<?php $embed_type = apply_filters( THEMEDOMAIN . '-post_featured_type', true, 10 ); ?>
<?php $size_type = apply_filters( THEMEDOMAIN . '-post_featured_size', $post->thumbnail_size, 10 ); ?>
<?php $classes = apply_filters( THEMEDOMAIN . '-post_featured_class', 'wp-post-image-wrap', 10 ); ?>

<?php if ( ! empty( $image_id ) ) : ?>

	<?php $size = $size_type ? $size_type : 'full'; ?>
	<?php $image = wp_get_attachment_image_src( $image_id, $size ); ?>
	<?php $caption = get_posts( [ 'p' => $image_id, 'post_type' => 'attachment' ] ); ?>

	<div class="<?php echo $classes; ?>">

		<?php if ( $embed_type ) : ?>
			<div class="post-image wp-images">
				<?php echo wp_get_attachment_image( $image_id, $size ); ?>
			</div>
		<?php else : ?>
			<div class="post-image" style="background-image: url(<?php echo $image[0]; ?>);"></div>
		<?php endif; ?>

		<?php if ( ! empty( $caption[0]->post_content ) && ! empty( $caption[0]->post_excerpt ) ) : ?>
			<div class="post-image-meta">

				<div class="post-image-caption">
					<?php echo wpautop( $caption[0]->post_content ); ?>
				</div>

				<div class="post-image-copyright">
					<?php echo wpautop( $caption[0]->post_excerpt ); ?>
				</div>

			</div>
		<?php endif; ?>
	</div>

<?php endif; ?>

<?php do_action( THEMEDOMAIN . '-after_post_featured' ); ?>
