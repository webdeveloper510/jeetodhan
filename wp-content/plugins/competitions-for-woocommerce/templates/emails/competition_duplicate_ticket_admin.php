<?php
/**
 * Compettion for woocommerce - admin email notification for duplicated ticket
 *
 */

defined( 'ABSPATH' ) || exit;
?>

<?php do_action('woocommerce_email_header', $email_heading, $email); ?>

<p>
	<?php
	/* translators: 1) order id 2) order id 3)ticket number */
	printf( wp_kses_post( __( 'Sorry. Order <a href="' . admin_url( 'post.php?post=%s&action=edit' ) . '">%s</a> has duplicate ticket number %s. Order has been put on hold please check it!', 'competitions_for_woocommerce' ), intval( $order_id ), intval( $order_id ), esc_html( $ticket_number ) ) );
	?>

</p>


<?php
	do_action('woocommerce_email_footer', $email);
