<?php
/**
 * My account active tickets template
 *
 */
defined( 'ABSPATH' ) || exit;

global $wpdb;
$current_user_id = get_current_user_id();
?>


<header class="woocommerce-products-header">
	<h4 class="woocommerce-products-header__title page-title mytickets active"><?php esc_html_e( 'Active Tickets', 'competitions-for-woocommerce' ); ?></h4>
	<h4 class="woocommerce-products-header__title page-title mytickets"><a href="<?php echo esc_url( wc_get_account_endpoint_url('comp-tickets-past') ); ?>"><?php esc_html_e( 'Past Tickets', 'competitions-for-woocommerce' ); ?></a></h4>
</header>

<?php
if ( is_array( $posts_ids ) && count( $posts_ids ) > 0 ) {
	?>

	<table class="woocommerce-orders-table woocommerce-MyAccount-orders shop_table shop_table_responsive my_account_orders account-orders-table">
		<thead>
			<tr>
				<th class="woocommerce-orders-table__header woocommerce-orders-table__header"><span class="nobr"></span></th>
				<th class="woocommerce-orders-table__header woocommerce-orders-table__header"><span class="nobr"><?php esc_html_e( 'Competition', 'competitions-for-woocommerce' ); ?></span></th>
				<th class="woocommerce-orders-table__header woocommerce-orders-table__header"><span class="nobr"><?php esc_html_e( 'Tickets', 'competitions-for-woocommerce' ); ?></span></th>
			</tr>
		</thead>
	<?php
	foreach ( $posts_ids as $posts_id ) {

		$product       = wc_get_product( $posts_id );
		$order_history = $wpdb->get_results(
			$wpdb->prepare(
				'SELECT ticket_number, orderid
				FROM ' . $wpdb->prefix . 'cfw_log
				WHERE competition_id = %d AND userid = %d',
				$posts_id,
				$current_user_id
			)
		);
		if ( 'yes' === get_post_meta( $posts_id , '_competition_pick_number_alphabet', true ) ) {
			add_filter( 'ticket_number_display_html', 'competitions_for_woocommerce_change_ticket_numbers_to_alphabet', 10, 2 );
			add_filter( 'ticket_number_tab_display_html', 'competitions_for_woocommerce_change_ticket_tab_to_alphabet', 10, 2 );
		} else {
			remove_filter( 'ticket_number_display_html', 'competitions_for_woocommerce_change_ticket_numbers_to_alphabet', 10 );
			remove_filter( 'ticket_number_tab_display_html', 'competitions_for_woocommerce_change_ticket_tab_to_alphabet', 10 );
		}

		?>
		<tr class="woocommerce-orders-table__row woocommerce-orders-table__row--status order">

				<td class="woocommerce-orders-table__cell woocommerce-orders-table__cell">
				<?php echo wp_kses_post( $product->get_image( 'thumbnail' ) ); ?>
				</td>
				<td class="woocommerce-orders-table__cell woocommerce-orders-table__cell">
					<p><a href="<?php echo esc_url( get_permalink( $posts_id ) ); ?>"><?php echo esc_html( $product->get_title() ); ?></a></p>
				</td>
				<td class="woocommerce-orders-table__cell woocommerce-orders-table__cell">
					<p>
					<?php

					foreach ( $order_history as $order_item ) {
						echo ! empty( $order_item->ticket_number ) ? esc_html( apply_filters( 'ticket_number_display_html' , $order_item->ticket_number , $product ) ) : esc_html__( 'n/a', 'competitions-for-woocommerce' );
						if ( next( $order_history ) ) {
							echo ', ';
						}
					} // end foreach
					?>
					</p>
				</td>
		</tr>
		<?php
	} // end foreach
	?>
	</tbody>
</table>
	<?php

} else {
	?>

	<div class="woocommerce-message woocommerce-message--info woocommerce-Message woocommerce-Message--info woocommerce-info">
		<?php esc_html_e( 'No active competition ticket(s) found.', 'competitions-for-woocommerce' ); ?>
	</div>

	<?php
}
