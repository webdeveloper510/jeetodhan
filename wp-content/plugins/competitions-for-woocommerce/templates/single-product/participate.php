<?php
/**
 * Participate in competition template
 *
 */

defined( 'ABSPATH' ) || exit;

global $woocommerce, $product, $post;


$competition_dates_to   = $product->get_competition_dates_to();
$competition_dates_from = $product->get_competition_dates_from();

if ( ( false === $product->is_closed() ) && ( true  === $product->is_started() ) ) :
	do_action( 'woocommerce_competition_before_participate')
	?>

	<div class='competition-ajax-change'>
		<?php do_action( 'woocommerce_competition_ajax_change_participate'); ?>
	</div>

<?php
elseif ( ( false === $product->is_closed() ) && ( false === $product->is_started() ) ) :
	do_action( 'woocommerce_competition_participate_future');
endif; 
