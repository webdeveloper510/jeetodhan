<?php
/**
 * Winners block template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/winners.php.
 * 
 */

defined( 'ABSPATH' ) || exit;
global  $product, $post;
?>

<p><?php esc_html_e('Please be patient. We are waiting for some orders to be paid!', 'competitions-for-woocommerce'); ?></p>

<p><?php esc_html_e('Please be patient. We are picking winners!', 'competitions-for-woocommerce'); ?></p>

<p><?php esc_html_e('Congratulations! You are winner!', 'competitions-for-woocommerce'); ?></p>

<p><?php esc_html_e('Sorry, better luck next time.', 'competitions-for-woocommerce'); ?></p>

<p><?php esc_html_e('Lottery failed because there were no participants', 'competitions-for-woocommerce'); ?></p>

<p><?php esc_html_e('Lottery failed because there was not enough participants', 'competitions-for-woocommerce'); ?></p>
	

<h3><?php esc_html_e('Winners:', 'competitions-for-woocommerce'); ?></h3>


<div class="lottery-winners">
<h3><?php esc_html_e('Winner is:', 'competitions-for-woocommerce'); ?> <?php esc_html_e('Example user', 'competitions-for-woocommerce'); ?> </h3>
	<?php 
		echo " <span class='ticket-number'>";
		esc_html_e( 'Ticket number: ', 'competitions-for-woocommerce' );
		echo esc_html( apply_filters( 'ticket_number_display_html' , '1', $product ) );
		echo '</span>';
		echo " <span class='ticket-answer'>";
		esc_html_e( 'Answer: ', 'competitions-for-woocommerce' );
		esc_html_e( 'Sample Answer', 'competitions-for-woocommerce' );
		echo '</span>';
echo '</div>';


echo '<h3>';
esc_html_e( 'There is no winner for this lottery', 'competitions-for-woocommerce' );
echo '</h3>';
