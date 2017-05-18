<?php do_action( THEMEDOMAIN . '-before_subsite_nav' ); ?>

<?php if ( has_nav_menu( 'subsite-nav' ) ) : ?>

	<nav id="subsite-nav" class="top-bar text-center" data-topbar="" data-options="is_hover: true" role="navigation">
		<?php if ( is_front_page() ) : ?>
			<h1 class="nav-site-title"><?php echo get_bloginfo( 'name' ); ?></h1>
		<?php else : ?>
			<div class="nav-site-title"><?php echo get_bloginfo( 'name' ); ?></div>
		<?php endif; ?>
		<ul class="title-area">
			<li class="name">
			</li>
			<li class="toggle-topbar menu-icon"><a href="#"><span>Menu</span></a></li>
		</ul>
		<section class="top-bar-section">
			<?php textetekst_subsite_menu(); ?>
		</section>
	</nav> <!-- .subsite-menu -->

<?php endif; ?>

<?php do_action( THEMEDOMAIN . '-after_subsite_nav' ); ?>
