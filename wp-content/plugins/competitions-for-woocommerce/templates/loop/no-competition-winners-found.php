<?php
/**
 * Displayed when no lotteries are found matching the current query
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>
<p class="woocommerce-info"><?php esc_html_e( 'There are no competition winners right now.', 'competitions_for_woocommerce' ); ?></p>
