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

	<div class="inner-grid">

		<header class="article-header">

			<h1 class="article-title" itemprop="name headline"><?php the_title(); ?></h1>

		</header>

		<div class="article-content" itemprop="articleBody">

			<?php get_template_part( 'partial/post', 'featured' ); ?>

			<div class="content">
				<?php the_content(); ?>

				<?php wp_link_pages( array( 'before' => '<div class="article-pagination">' . __( 'Pages:', THEMEDOMAIN ), 'after'  => '</div>' ) ); ?>
			</div>

			<div class="sidebar">
				<?php if ( has_category() ) : ?>
				<div class="article-categories items-list">
					<h2 class="categories-title"><?php _e( 'Categories', THEMEDOMAIN ); ?></h2>
					<?php the_category(); ?>
				</div>
				<?php endif; ?>

				<?php if ( has_tag() ) : ?>
				<div class="article-tags items-list">
					<h2 class="tags-title"><?php _e( 'Tags', THEMEDOMAIN ); ?></h2>
					<?php the_tags('<ul class="article-tags"><li class="item">','</li><li>','</li></ul>'); ?>
				</div>
				<?php endif; ?>
			</div>

		</div>

		<footer class="article-footer">
			<p class="meta article-meta">
				<time class="date" datetime="<?php echo the_time( 'Y-m-d' ); ?>" itemprop="datePublished"><?php the_time( 'j. F Y' ); ?></time><span class="sep">, </span><?php _e( 'by', THEMEDOMAIN ); ?> <span itemprop="author" itemscope itemtype="http://schema.org/Person" class="author"><span itemprop="name" class="fn"><?php the_author_posts_link(); ?></span></span>
			</p>
		</footer>

		<?php if ( comments_open() || '0' != get_comments_number() ) : ?>
			<?php #comments_template(); ?>
		<?php endif; ?>

	</div>

</article>
