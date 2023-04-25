<?php
/**
 * Competition info template
 *
 */

defined( 'ABSPATH' ) || exit;

global $product, $post;

if ( $product && 'competition' === $product->get_type()  ) {
	if ( ! $product->is_closed() ) {
		woocommerce_competition_info_template();
	}
}
