<?php
namespace TexteTekst;
?>

<?php do_action( THEMEDOMAIN . '-before_main_nav' ); ?>

	<nav id="main-nav" role="navigation">
		<a href="<?php echo get_home_url(); ?>">
			<div id="logo" itemscope="" itemtype="http://schema.org/Organization"></div>
		</a>

		<ul id="languages">
			<?php if ( function_exists( 'pll_the_languages' ) ) : ?>
				<?php pll_the_languages(); ?>
			<?php endif; ?>
		</ul>

		<div id="menu">
			<button class="burger">
				<?php _e( 'Menu', THEMEDOMAIN ); ?>
			</button>
		</div>
	</nav>

<?php do_action( THEMEDOMAIN . '-after_main_nav' ); ?>
