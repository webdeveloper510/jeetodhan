<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
	$product          = wc_get_product( $product_id );
	$cart_url         = wc_get_cart_url();
	$available_ticket = competitions_for_woocommerce_get_available_ticket( $product_id );
?>
<p class="lucky-dip-text">
	<?php
	/* translators: 1) ticket number */
	 printf( esc_html( _n( 'Congratulations! Your ticket number %s has been added to cart.', 'Congratulations! Your ticket numbers %s have been added to cart.', count( $display_numbers ), 'competitions-for-woocommerce'  ) ), esc_html( implode(', ', $display_numbers) ) );
	?>
</p>
<?php if ( count( $available_ticket) > 0 && $product->get_max_purchase_quantity() > 0) { ?>
	<a href="#" class="button alt lucky-dip-button-second" ><?php esc_html_e( 'Add more with lucky dip' , 'competitions-for-woocommerce' ); ?></a>
<?php } ?>

<a href="<?php echo esc_url( $cart_url ); ?>" class="button alt gtc"><?php esc_html_e( 'Go to cart' , 'competitions-for-woocommerce' ); ?></a>

<script type="text/javascript">
	jQuery('.lucky-dip-button-second').on('click',function(e){
		e.preventDefault();
		var competition_answer = false;
		var available_tickets = <?php echo intval( count( $available_ticket) ); ?>;
		var max_tickets = <?php echo intval( $product->get_max_purchase_quantity() ); ?>;
		var numbers = jQuery( 'ul.tickets_numbers');
		var competition_id = numbers.data( 'product-id' );
		var qty = jQuery('#qty_dip').closest('#qty_dip').val();
		var max_qty = jQuery('input[name=max_quantity]').val();
		var new_max_qty = max_qty - qty;
		if( new_max_qty < 0 ){
			jQuery.alertable.alert(competitions_for_woocommerce_data.maximum_text);
			return;
		}
		if( available_tickets < qty ){
			qty = available_tickets;
		}
		if( max_tickets < qty ){
			qty = max_tickets;
		}
		if ( jQuery('input[name=competition_answer]').val() > 0) {
			competition_answer = jQuery('input[name=competition_answer]').val();
		}
		if ( new_max_qty < 1 ){
			jQuery('div.lucky_dip button').prop('disabled', true);
		}
		jQuery.ajax({
			type : "get",
			url : competitions_for_woocommerce_data.ajax_url.toString().replace( '%%endpoint%%', 'competitions_for_woocommerce_lucky_dip' ),
			data : { 'competition_id' : competition_id, 'competition_answer' : competition_answer,'qty' : qty, security: competitions_for_woocommerce_data.ajax_nonce },
			success: function(response) {
				jQuery.alertable.alert( response.message, { html : true } );
				jQuery.each(response.ticket_numbers, function(index, value){
					jQuery( 'li.tn[data-ticket-number=' + value + ' ]' ).addClass('in_cart');
				});
				jQuery(document.body).trigger('added_to_cart');
				jQuery(document.body).trigger('wc_fragment_refresh');
				jQuery( document.body).trigger('competitions_for_woocommerce_lucky_dip_finished',[response,competition_id] );
				jQuery('input[name=max_quantity]').val(  parseInt(new_max_qty) );
			},
			error: function() {

			}
		});
		jQuery(document.body).trigger('wc_fragment_refresh');
		jQuery(document.body).trigger('added_to_cart');
		e.preventDefault();
	});
</script>
