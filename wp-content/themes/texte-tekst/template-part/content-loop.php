<article id="article-<?php the_ID(); ?>" <?php post_class( 'article' ); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">

	<div class="inner-grid">

		<?php get_template_part( 'partial/post', 'featured' ); ?>

		<div class="content-wrap">

			<header class="article-header">

				<?php do_action( THEMEDOMAIN . '-before_article_header' ); ?>

				<h2>
					<a href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a>
				</h2>

				<?php do_action( THEMEDOMAIN . '-after_article_header' ); ?>

			</header>

			<div class="article-content">

				<?php do_action( THEMEDOMAIN . '-before_article_content' ); ?>

					<div class="content">
						<?php echo TexteTekst\get_excerpt(); ?>
					</div>

				<?php do_action( THEMEDOMAIN . '-after_article_content' ); ?>

			</div>

		</div>

	</div>

</article>
