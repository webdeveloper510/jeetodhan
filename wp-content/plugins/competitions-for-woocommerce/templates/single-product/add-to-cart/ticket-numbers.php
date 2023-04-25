<?php
/**
 * Competition add to cart ticket numbers
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/ticket-numbers.php.
 *
 */
defined( 'ABSPATH' ) || exit;
global $product;

$use_ticket_numbers    = get_post_meta( $product->get_id() , '_competition_use_pick_numbers', true );
$random_ticket_numbers = get_post_meta( $product->get_id() , '_competition_pick_numbers_random', true );

if ( 'yes' === $use_ticket_numbers && 'yes' !== $random_ticket_numbers ) : ?>
	<?php
	if ( 'yes' ===  get_post_meta( $product->get_id() , '_competition_pick_number_use_tabs', true ) ) {
		wc_get_template('single-product/tickets-numbers-tabbed.php' );
	} else {
		wc_get_template('single-product/tickets-numbers.php' );
	}

endif;
