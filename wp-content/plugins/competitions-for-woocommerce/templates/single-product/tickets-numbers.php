<?php
/**
 * Tickets numbers
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/tickets-numbers.php.
 *
 */
defined( 'ABSPATH' ) || exit;

global $product;

$max_tickets      = intval( $product->get_max_tickets() );
$tickets_sold     = competitions_for_woocommerce_get_taken_numbers();
$tickets_in_cart  = competitions_for_woocommerce_get_ticket_numbers_from_cart( $product->get_id() );
$reserved         = competitions_for_woocommerce_get_reserved_numbers( $product->get_id() );
$use_answers      = competitions_for_woocommerce_use_answers( $product->get_id() );
$available_ticket = competitions_for_woocommerce_get_available_ticket( $product->get_id() );

if ( $max_tickets ) {

	echo '<h3>' . esc_html__('Pick your ticket number(s)' , 'competitions-for-woocommerce' ) . '</h3>';
	
	echo '<div id="competitions-ticket-numbers"';
	$max_tickets_per_user = $product->get_max_tickets_per_user() ? $product->get_max_tickets_per_user() : false;
	if ( ! is_user_logged_in() &&  $max_tickets_per_user > 0  && $max_tickets_per_user !== $product->get_max_tickets() && 'yes' !== get_option( 'competitions_for_woocommerce_alow_non_login', 'yes' ) ) {
		echo 'class=" guest"';
	}
	echo '>';

	do_action('wc_competition_before_ticket_numbers');

	echo '<ul class="tickets_numbers" data-product-id="' . intval( $product->get_id() ) . '">';

	$i = intval( apply_filters( 'woocommerce_competition_start_ticket_number ', 1 , $product ) );
	while ( $i<= $max_tickets) {

		$alt_text = '';
		$class    = '';
		$class    = in_array( strval( $i ), $reserved, true) ? ' reserved ' : $class ;
		$class    = in_array( strval( $i ), $tickets_in_cart, true) ? ' in_cart ' : $class ;
		$class    = in_array( strval( $i ), $tickets_sold, true) ? ' taken ' : $class ;

		if ( ' taken ' === $class ) {
			$alt_text = esc_html__( 'Sold!' , 'competitions-for-woocommerce' );
		} elseif ( ' in_cart ' === $class ) {
			$alt_text = esc_html__( 'Already in your cart!' , 'competitions-for-woocommerce' );
		} elseif ( ' reserved ' === $class ) {
			$alt_text = esc_html__( 'Reserved!' , 'competitions-for-woocommerce' );
		}
		echo '<li class="tn ' . esc_attr( $class ) . '"data-ticket-number="' . intval( $i ) . '" alt="' . esc_attr( $alt_text ) . '" title="' . esc_attr( $alt_text ) . '">' . esc_html( apply_filters( 'ticket_number_display_html' , intval( $i ), $product) ) . '</li>';
		$i++;
	}
	
	echo '</ul></div>';
}
