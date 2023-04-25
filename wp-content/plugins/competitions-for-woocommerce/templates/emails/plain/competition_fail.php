<?php
/**
 * Admin competition failed email (plain)
 *
 */

defined( 'ABSPATH' ) || exit;
echo "=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=\n";
echo esc_html( wp_strip_all_tags( $email_heading ) );
echo "\n=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=\n\n";

$product_data = wc_get_product(  $product_id );
/* translators: 1) product title 2) feail reason */
printf( wp_kses_post( __( 'Sorry competition for %1\$s has failed. %2\$s', 'competitions_for_woocommerce' ) ), esc_html( $product_data->get_title() ), esc_html( $reason) );
echo "\n\n";
echo esc_url( get_permalink($product_id) );
echo "\n\n";

echo wp_kses_post( apply_filters( 'woocommerce_email_footer_text', get_option( 'woocommerce_email_footer_text' ) ) );
