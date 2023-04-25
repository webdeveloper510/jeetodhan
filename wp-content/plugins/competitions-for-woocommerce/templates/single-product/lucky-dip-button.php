<?php
/**
 * Lucky dip button
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/lucky-dip-button.php.php.
 *
 */
defined( 'ABSPATH' ) || exit;

global $product;
$use_answers           = competitions_for_woocommerce_use_answers( $product->get_id() );
$lucky_dip             =  get_option( 'competitions_for_woocommerce_use_lucky_dip', 'no' );
$lucky_dip_qty         = get_option( 'competitions_for_woocommerce_use_lucky_dip_qty', 'no' );
$available_ticket      = competitions_for_woocommerce_get_available_ticket( $product->get_id() );
$random_ticket_numbers = get_post_meta( $product->get_id() , '_competition_pick_numbers_random', true );

if ( 'yes' === $lucky_dip &&  ( count( $available_ticket ) > 0 ) && 'yes' !== $random_ticket_numbers ) {
	echo '<div class="lucky_dip">';
	echo '<button data-product-id="' . intval( $product->get_id() ) . '" id="lucky-dip" class="button alt lucky-dip-button"';
	if ( 'yes' === $use_answers ) {
		echo 'alt= "' . esc_attr__('Please answer the question.' , 'competitions-for-woocommerce') . '"';
		echo 'title= "' . esc_attr__('Please answer the question.' , 'competitions-for-woocommerce') . '"';
		echo ' disabled ';
	}
	if ( $product->get_max_purchase_quantity() <= 0 ) {
		/* translators: 1) The maximum allowed quantity number */
		echo 'alt= "' . sprintf( esc_attr__( 'TThe maximum allowed number of entries per user is %1$d.', 'competitions-for-woocommerce' ), intval( $product->get_max_tickets_per_user() ) ) . '"';
		/* translators: 1) The maximum allowed quantity number */
		echo 'title= "' . sprintf( esc_attr__( 'The maximum allowed number of entries per user is %1$d.', 'competitions-for-woocommerce' ), intval( $product->get_max_tickets_per_user() ) ) . '"';
		echo ' disabled ';
	}
	echo ' >' . esc_html__('Lucky Dip' , 'competitions-for-woocommerce' ) . '</button>';
	if ( 'yes' === $lucky_dip_qty) {
		woocommerce_quantity_input( array(
			'min_value'   => apply_filters( 'woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product ),
			'max_value'   => $product->get_max_purchase_quantity() > 0 ? apply_filters( 'woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product ) : 0 ,
			'input_value' => $product->get_min_purchase_quantity(),
			'input_id' => 'qty_dip', 
			'input_name' => 'qty_dip',
			'classes'      => apply_filters( 'woocommerce_quantity_input_classes', array( 'input-text', 'qty', 'text' , 'lucky-dip'), $product ),
		), $product);

	} else {
		echo '<input type="hidden" value="1" name="qty_dip" id="qty_dip" />';
	}
	echo '</div>';
}
