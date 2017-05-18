<article id="article-<?php the_ID(); ?>" <?php post_class( 'article' ); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">

	<header class="article-header">

		<a href="<?php the_permalink() ?>" rel="bookmark">
			<?php get_template_part( 'partial/post', 'featured' ); ?>
		</a>

	</header> <!-- .article-header -->

	<div class="article-content">

		<div class="article-content-inner">

			<h2>
				<?php echo apply_filters( THEMEDOMAIN . '-post_loop_title', sprintf( '<a href="%s" rel="bookmark">%s</a>',  get_the_permalink(), get_the_title() ) ); ?>
			</h2>

			<p class="meta">
				<time datetime="<?php the_time( 'Y-m-d' ); ?>" class="date updated"><?php the_time( 'j. F Y' ); ?></time>
			</p>

			<?php get_template_part( 'partial/post', 'excerpt' ); ?>

		</div> <!-- .article-content-inner -->

	</div> <!-- .article-content -->

</article> <!-- .article -->
