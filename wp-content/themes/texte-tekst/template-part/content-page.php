<?php
/**
 * Template part for single pages.
 * Used in page.php
 *
 * @package WordPress
 *
 */
?>

<article id="article-<?php the_ID(); ?>" <?php post_class( 'article' ); ?> role="article" itemscope itemtype="http://schema.org/WebPage">

	<div class="inner-grid">

		<?php do_action( THEMEDOMAIN . '-before_article' ); ?>

		<header class="article-header">

			<?php do_action( THEMEDOMAIN . '-before_article_header' ); ?>

				<h1 class="article-title" itemprop="name"><?php the_title(); ?></h1>

			<?php do_action( THEMEDOMAIN . '-after_article_header' ); ?>

		</header>

		<div class="article-content">

			<?php do_action( THEMEDOMAIN . '-before_article_content' ); ?>

				<div class="content">
					<?php the_content(); ?>
				</div>

			<?php do_action( THEMEDOMAIN . '-after_article_content' ); ?>

		</div>

		<footer class="article-footer">

			<?php do_action( THEMEDOMAIN . '-article_footer' ); ?>

		</footer>

		<?php do_action( THEMEDOMAIN . '-after_article' ); ?>

	</div>

</article>
