<?php
namespace TexteTekst;
?>

<?php do_action( THEMEDOMAIN . '-before_main_nav' ); ?>

	<nav id="main-nav" role="navigation">
		<div id="logo" itemscope="" itemtype="http://schema.org/Organization"></div>

		<div id="menu">
			<?php _e( 'Menu', THEMEDOMAIN ); ?>
		</div>
	</nav>

<?php do_action( THEMEDOMAIN . '-after_main_nav' ); ?>
