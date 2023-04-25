<?php
/**
 * Lottery Pick Number Addon - admin email notification for duplicated ticket
 *
 */

defined( 'ABSPATH' ) || exit;
echo "=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=\n";
echo esc_html( wp_strip_all_tags( $email_heading ) );
echo "\n=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=\n\n";

/* translators: 1) oredre id 2) ticket number */
printf( wp_kses_post( __( 'Sorry. Order %1\$s has duplicate ticket number %2\$%s. Order has been put on hold please check it!', 'competitions_for_woocommerce') ), intval( $order_id ), esc_html( $ticket_number ) );
echo "\n\n";
echo esc_url( admin_url( 'post.php?post=' . $order_id . '&action=edit' ) );
echo "\n\n";

echo wp_kses_post( apply_filters( 'woocommerce_email_footer_text', get_option( 'woocommerce_email_footer_text' ) ) );
