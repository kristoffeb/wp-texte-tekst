<?php
namespace TexteTekst;
?>

<?php do_action( THEMEDOMAIN . '-before_main_nav' ); ?>

	<div class="title-bar" data-responsive-toggle="main-nav" data-hide-for="medium">
		<button class="menu-icon" type="button" data-toggle></button>
		<div class="title-bar-title">Menu</div>
	</div> <!-- title-bar -->

	<nav class="top-bar" id="main-nav" data-topbar data-options="sticky_on: [small, medium, large]" role="navigation">
		<div id="logo" itemscope="" itemtype="http://schema.org/Organization">

			<?php if ( ! get_header_image() == '' ) : ?>
				<a itemprop="url" rel="nofollow" href="<?php bloginfo('url'); ?>">
					<img itemprop="logo" src="<?php echo( get_header_image() ); ?>" alt="<?php bloginfo('name'); ?>" />
				</a>
			<?php else : ?>
				<a itemprop="url" href="<?php echo home_url(); ?>" rel="nofollow" title="<?php _e( 'Home', THEMEDOMAIN ); ?>">
					<span class="title"><?php bloginfo( 'name' ); ?></span>
				</a>
			<?php endif; ?>
		</div> <!-- logo -->

		<div class="tagline">
			<?php bloginfo('description'); ?>
		</div> <!-- tagline -->

		<?php main_menu(); ?>
	</nav>

<?php do_action( THEMEDOMAIN . '-after_main_nav' ); ?>
