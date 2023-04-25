<?php
/**
 * Email competition not won - better luck next time
 *
 */


defined( 'ABSPATH' ) || exit;
$product_data = wc_get_product(  $product_id );
do_action('woocommerce_email_header', $email_heading, $email); ?>
<p>
	<?php
	/* translators: 1) product link 2) product title */
	printf( wp_kses_post(  __( "We are sorry. You have not been picked in competition <a href='%1\$s'>%2\$s</a>. Better luck next time.", 'competitions_for_woocommerce') ), esc_url( get_permalink($product_id) ), esc_html( $product_data -> get_title() ) );
	?>
</p>

<?php
do_action('woocommerce_email_footer', $email);
