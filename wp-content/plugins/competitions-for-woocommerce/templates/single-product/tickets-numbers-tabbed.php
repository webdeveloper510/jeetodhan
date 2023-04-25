<?php
/**
 * Tickets numbers
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/tickets-numbers.php.
 *
 */
defined( 'ABSPATH' ) || exit;

global $product;
$tabnumbers       = get_post_meta( $product->get_id() , '_competition_pick_number_tab_qty', true );
$max_tickets      = intval( $product->get_max_tickets() );
$tabnumbers       = $tabnumbers > $max_tickets ? $max_tickets : $tabnumbers;
$tabnumbers       = $tabnumbers ? intval( $tabnumbers )  : 100;
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
	echo '> ';

	do_action('wc_competition_before_ticket_numbers');

	echo '<div class="ticket-tab-bar">
		<button class="ticket-tab-bar-item tablink ticket-tab-active" id="button-tab1_' . intval( $tabnumbers ) . '" onclick="opentab(event,\'tab1_' . intval( $tabnumbers ) . '\' )" data-number-range=1_' . intval( $tabnumbers ) . '">' . esc_html( apply_filters( 'ticket_number_tab_display_html', '1-' . $tabnumbers , $product) ) . '</button>
	';
	$i                =  1;
	$a                =  2;
	$numberoftabs     = $max_tickets / $tabnumbers;
	$start_tab_number = $tabnumbers + 1;

	while ( $i < $numberoftabs) {

		$end_tab_number =  $tabnumbers * $a;
		$end_tab_number =  $end_tab_number > $max_tickets ? $max_tickets : $end_tab_number;

		echo' <button class="ticket-tab-bar-item tablink" id="button-tab' . intval( $start_tab_number ) . '_' . intval( $tabnumbers ) . '" onclick="opentab(event,\'tab' . intval( $start_tab_number ) . '_' . intval( $end_tab_number ) . '\')" data-number-range="' . intval( $start_tab_number ) . '_' . intval( $end_tab_number ) . '">' . esc_html( apply_filters( 'ticket_number_tab_display_html', $start_tab_number . '-' . $end_tab_number, $product) ) . '</button>';
		$start_tab_number = $start_tab_number + $tabnumbers;
		$i++;
		$a++;
	}

	echo '</div>
	
	<ul class="tickets_numbers" data-product-id="' . intval( $product->get_id() ) . '">';
	$i                = 1;
	$i2               = 0;
	$a                = 1;
	$numberoftabs     = $max_tickets / $tabnumbers;
	$start_tab_number = 1;

	while ( $i2 < $numberoftabs) {
		
		$end_tab_number =  $tabnumbers * $a;
		$end_tab_number =  $end_tab_number > $max_tickets ? $max_tickets : $end_tab_number;
		$hidden         = 0 !== $i2 ? 'display:none' : '' ;
		echo '<li id="tab' . intval( $start_tab_number ) . '_' . intval( $end_tab_number ) . '" class="ticketnumber-tab-container" style=" ' . esc_attr( $hidden ) . '" ><ul class="tickets_numbers_tab" data-number-range="' . intval( $start_tab_number ) . '_' . intval( $end_tab_number ) . '" >';
		
		while ( $i<= $end_tab_number) {

			$alt_text = '';
			$class    = '';
			$class    = in_array( strval( $i ), $reserved, true) ? ' reserved ' : $class ;
			$class    = in_array( strval( $i ), $tickets_in_cart, true) ? ' in_cart ' : $class ;
			$class    = in_array( strval( $i ), $tickets_sold, true) ? ' taken ' : $class ;

			if ( ' taken ' ===  $class ) {
				$alt_text = esc_html__( 'Sold!' , 'competitions-for-woocommerce' );
			} elseif ( ' in_cart ' === $class ) {
				$alt_text = esc_html__( 'Already in your cart!' , 'competitions-for-woocommerce' );
			} elseif ( ' reserved ' === $class ) {
				$alt_text = esc_html__( 'Reserved!' , 'competitions-for-woocommerce' );
			}
			echo '<li class="tn ' . esc_attr( $class ) . '"data-ticket-number="' . intval( $i ) . '" alt="' . esc_attr( $alt_text ) . '" title="' . esc_attr( $alt_text ) . '">' . esc_html( apply_filters( 'ticket_number_display_html', intval( $i ), $product ) ) . '</li>';
			$i++;
		}
		echo '</ul></li>';
		$start_tab_number = $start_tab_number + $tabnumbers;
		$i2++;
		$a++;
	}
	echo '</ul></div>';
} ?>

<script>
var tablinks = document.getElementsByClassName("tablink");
for(i=0, len=tablinks.length; i<len; i++){
	tablinks[i].addEventListener('click', function(e){e.preventDefault();});
}
function opentab(evt, tabName) {
  var i, x, tablinks;
  x = document.getElementsByClassName("ticketnumber-tab-container");
  for (i = 0; i < x.length; i++) {
		x[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablink");
  for (i = 0; i < x.length; i++) {
		tablinks[i].className = tablinks[i].className.replace(" ticket-tab-active", "");
  }
  document.getElementById(tabName).style.display = "block";
  evt.currentTarget.className += " ticket-tab-active";
}
</script>
