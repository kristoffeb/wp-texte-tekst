<?php
namespace TexteTekst;
?>

<?php do_action( THEMEDOMAIN . '-before_main_nav' ); ?>

	<nav id="main-nav" role="navigation">
		<a href="<?php echo get_home_url(); ?>">
			<div id="logo" itemscope="" itemtype="http://schema.org/Organization"></div>
		</a>

		<ul id="languages">
			<?php pll_the_languages(); ?>
		</ul>

		<div id="menu">
			<button class="burger">
				<?php _e( 'Menu', THEMEDOMAIN ); ?>
			</button>
		</div>
	</nav>

<?php do_action( THEMEDOMAIN . '-after_main_nav' ); ?>
