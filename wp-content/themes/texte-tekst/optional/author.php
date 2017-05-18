<?php
/**
 * Displays author archives.
 *
 * @link http://codex.wordpress.org/Author_Templates
 * @package WordPress
 *
 */
?>

<?php get_header(); ?>

	<div class="inner-grid">

		<main class="main" role="main">

			<h1 class="archive_title h2">
				<span><?php _e( 'Posts By:', THEMEDOMAIN ); ?></span>
				<?php // google+ rel=me function
				$current_author = ( get_query_var( 'author_name' ) ) ? get_user_by( 'slug', get_query_var( 'author_name' ) ) : get_userdata( get_query_var( 'author' ) );
				$google_profile = get_the_author_meta( 'google_profile', $current_author->ID );

				if ( $google_profile )
					echo '<a href="' . esc_url( $google_profile ) . '" rel="me"></a>' . $current_author->display_name;
				else
					echo get_the_author_meta( 'display_name', $current_author->ID );
				?>
			</h1>

			<?php get_template_part( 'loop', 'author' ); ?>

		</main>

		<?php get_sidebar(); ?>

	</div><!-- .inner-grid -->

<?php get_footer(); ?>
