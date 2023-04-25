<?php
/**
 * Participate button
 *
 *
 */
defined( 'ABSPATH' ) || exit;

global $product;

$use_answers           = competitions_for_woocommerce_use_answers( $product->get_id() );
$lucky_dip             = get_option( 'competitions_for_woocommerce_use_lucky_dip', 'no' );
$lucky_dip_qty         = get_option( 'competitions_for_woocommerce_use_lucky_dip_qty', 'no' );
$available_ticket      = competitions_for_woocommerce_get_available_ticket( $product->get_id() );
$random_ticket_numbers = get_post_meta( $product->get_id() , '_competition_pick_numbers_random', true );
$qty_dip               = ! empty( $qty ) ? $qty : '1';
$qty_label             = ! empty( $label ) ? $label : __('Lucky Dip' , 'competitions-for-woocommerce' ) ;

if ( 'yes' === $lucky_dip &&  ( count( $available_ticket ) > 0 ) && 'yes' !== $random_ticket_numbers ) {
	echo '<div class="lucky_dip_predef">';
	echo '<button data-product-id="' . intval( $product->get_id() ) . '" class="button alt lucky-dip-button"';
	if ( 'yes' === $use_answers ) {
		echo 'alt= "' . esc_attr__('Please answer the question.' , 'competitions-for-woocommerce') . '"';
		echo 'title= "' . esc_attr__('Please answer the question.' , 'competitions-for-woocommerce') . '"';
		echo ' disabled ';

	}
	if ( $product->get_max_purchase_quantity() <= 0 ) {
		/* translators: 1) max ticket number */
		echo 'alt= "' . sprintf( esc_attr__( 'The maximum allowed number of entries per user is %1$d.', 'competitions-for-woocommerce' ), intval( $product->get_max_tickets_per_user() ) ) . '"';
		/* translators: 1) tmax icket number */
		echo 'title= "' . sprintf( esc_attr__( 'The maximum allowed number of entries per user for is %1$d.', 'competitions-for-woocommerce' ), intval( $product->get_max_tickets_per_user() ) ) . '"';
		echo ' disabled ';
	}
	echo ' >' . esc_html( $label) . '</button>';
	echo '<input type="hidden" value="' . intval( $qty_dip ) . '" name="qty_dip" />';
	echo '</div>';
}
