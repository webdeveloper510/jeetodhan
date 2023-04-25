<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package Modeltheme
 */

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
}
?>

<div id="secondary" class="widget-area" role="complementary">
    <?php if ( is_active_sidebar ( 'sidebar-1' ) ) { ?>
		<?php  dynamic_sidebar( 'sidebar-1' ); ?>
	<?php } ?>
</div><!-- #secondary -->