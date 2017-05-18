<?php
namespace TexteTekst;
?>

<?php do_action( THEMEDOMAIN . '-before_top_nav' ); ?>

<div class="top-nav-wrap">
	<div class="inner-grid">
		<?php top_menu(); ?>
	</div>
</div> <!-- .top-nav -->

<?php do_action( THEMEDOMAIN . '-after_top_nav' ); ?>
