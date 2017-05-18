<?php
/**
 * Template part for single posts.
 * Used in single.php
 *
 * @package WordPress
 *
 */
?>

<article id="article-<?php the_ID(); ?>" <?php post_class( 'article' ); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">

	<header class="article-header">

		<h1 class="article-title" itemprop="name headline"><?php the_title(); ?></h1>

		<?php if ( $subtitle = get_post_meta( get_the_ID(), '_textetekst_subtitle', true ) ) : ?>
			<?php echo wpautop( $subtitle ); ?>
		<?php endif; ?>

		<?php if ( is_home() ) : ?>
			<p class="meta article-meta">
				<time class="date" datetime="<?php echo the_time( 'Y-m-d' ); ?>" itemprop="datePublished"><?php the_time( 'j. F Y' ); ?></time><span class="sep">, </span><?php _e( 'by', THEMEDOMAIN ); ?> <span itemprop="author" itemscope itemtype="http://schema.org/Person" class="author"><span itemprop="name" class="fn"><?php the_author_posts_link(); ?></span></span>
			</p>
		<?php endif; ?>

	</header><!-- .article-header -->

	<div class="article-content" itemprop="articleBody">

		<?php the_content(); ?>

		<?php wp_link_pages( array( 'before' => '<div class="article-pagination">' . __( 'Pages:', THEMEDOMAIN ), 'after'  => '</div>' ) ); ?>

	</div><!-- .article-content -->

	<?php if ( has_category() || has_tag() ) : ?>
	<footer class="article-footer">

		<?php if ( has_category() ) : ?>
		<div class="article-categories">
			<h2 class="categories-title"><?php _e( 'Categories', THEMEDOMAIN ); ?></h2>
			<?php the_category(); ?>
		</div>
		<?php endif; ?>

		<?php if ( has_tag() ) : ?>
		<div class="article-tags">
			<h2 class="tags-title"><?php _e( 'Tags', THEMEDOMAIN ); ?></h2>
			<?php the_tags('<ul class="article-tags"><li>','</li><li>','</li></ul>'); ?>
		</div>
		<?php endif; ?>

	</footer><!-- .article-footer -->
	<?php endif; // end if has category/tag ?>

	<?php if ( comments_open() || '0' != get_comments_number() ) : ?>
		<?php #comments_template(); ?>
	<?php endif; ?>

</article>