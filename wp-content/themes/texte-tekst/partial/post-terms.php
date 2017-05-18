<?php if ( has_category() || has_tag() ) : ?>

	<?php if ( has_category() ) : ?>
		<div class="article-categories">
			<h2 class="categories-title"><?php _e( 'Categories', THEMEDOMAIN ); ?></h2>
			<?php the_category(); ?>
		</div>
	<?php endif; ?>

	<?php if ( has_tag() ) : ?>
		<div class="article-tags">
			<h2 class="tags-title"><?php _e( 'Tags', THEMEDOMAIN ); ?></h2>
			<?php the_tags( '<ul class="article-tags"><li>', '</li><li>', '</li></ul>' ); ?>
		</div>
	<?php endif; ?>

<?php endif; ?>
