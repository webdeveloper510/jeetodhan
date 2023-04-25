<?php
/**
 * Email competition not won - better luck next time (plain)
 *
 */

defined( 'ABSPATH' ) || exit;
echo "=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=\n";
echo esc_html( wp_strip_all_tags( $email_heading ) );
echo "\n=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=\n\n";

/* translators: 1) product title */
printf( wp_kses_post( __('Competition %s  has been extended and you still have chance to win it. Good luck!', 'competitions_for_woocommerce') ), esc_html( $product_data -> get_title() ) );
echo "\n\n";
echo esc_url( get_permalink($product_id) );
echo "\n\n";

echo wp_kses_post( apply_filters( 'woocommerce_email_footer_text', get_option( 'woocommerce_email_footer_text' ) ) );
