<?php
/**
 * Displays existing comments and the comment form.
 * Usually not used - 3rd party plugins are better (facebook, disqus, livefyre)
 *
 * @package WordPress
 *
 */

// Do not delete these lines
if ( !empty( $_SERVER['SCRIPT_FILENAME'] ) && 'comments.php' == basename( $_SERVER['SCRIPT_FILENAME'] ) )
	die ( 'Please do not load this page directly. Thanks!' );

if ( post_password_required() )
	return;
?>

<section id="comments">

	<?php if ( have_comments() ) : ?>
	<h2 id="comments"><?php comments_number( __( '<span>No</span> Responses', THEMEDOMAIN ), __( '<span>One</span> Response', THEMEDOMAIN ), __( '<span>%</span> Responses', THEMEDOMAIN ) ); ?></h2>

	<ol class="commentlist">
		<?php wp_list_comments( array( 'type' => 'comment', 'style' => 'ol' ) ); ?>
	</ol>

	<?php if ( ! comments_open() && get_comments_number() ) : ?>
		<p class="no-comments"><?php _e( 'Comments are closed.' , 'twentythirteen' ); ?></p>
	<?php endif; // end if open ?>
	<?php endif; // end if have comments ?>

	<?php comment_form(); ?>

</section>

