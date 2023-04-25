<?php
/**
 * Email competition not won - better luck next time
 *
 */
defined( 'ABSPATH' ) || exit;

$product_data = wc_get_product($product_id);
?>

<?php do_action('woocommerce_email_header', $email_heading, $email); ?>

<p>
	<?php
		/* translators: 1) product link 2) product title */
		 printf( wp_kses_post(  __("Competition <a href='%1\$s'>%2%s</a> has been extended and you still have chance to win it. Good luck!", 'competitions_for_woocommerce') ), esc_url( get_permalink($product_id) ), esc_html( $product_data -> get_title() ) );
	?>
</p>

<?php
do_action('woocommerce_email_footer', $email);
