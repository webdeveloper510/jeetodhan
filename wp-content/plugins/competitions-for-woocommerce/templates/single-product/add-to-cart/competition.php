<?php
/**
 * Competition add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/competition.php.
 *
 */
defined( 'ABSPATH' ) || exit;

global $product;
if ( ! $product->is_purchasable() ) {
	return;
}

if ( ! $product->is_in_stock() ) {
	return;
}
if ( $product->get_max_purchase_quantity() <= 0 ) { ?>
	<p class="competition-max-ticket-txt">
		<?php
		/* translators: 1) product title 2) Max ticket per user */
		printf( esc_html__( 'The maximum allowed number of entries per user for %1$s is %2$d.', 'competitions-for-woocommerce' ), esc_html( $product->get_title() ), esc_html( $product->get_max_tickets_per_user() ) );
		?>
	</p>
	<?php
	return;
}
$use_answers           = competitions_for_woocommerce_use_answers( $product->get_id() );
$use_ticket_numbers    = get_post_meta( $product->get_id() , '_competition_use_pick_numbers', true );
$random_ticket_numbers = get_post_meta( $product->get_id() , '_competition_pick_numbers_random', true );

do_action( 'woocommerce_before_add_to_cart_form' );
?>

<form class="cart pick-number <?php echo ( 'yes' !== $random_ticket_numbers && 'yes' === $use_ticket_numbers )  ? 'hidden-qty' : '' ; ?> " action="<?php echo esc_url( get_permalink() ); ?>" method="post" enctype='multipart/form-data'>

		<?php
			do_action( 'woocommerce_before_add_to_cart_button' );
			do_action( 'woocommerce_before_add_to_cart_quantity' );
			woocommerce_quantity_input( array(
				'min_value'   => apply_filters( 'woocommerce_quantity_input_min_competition', $product->get_min_purchase_quantity(), $product ),
				'max_value'   => apply_filters( 'woocommerce_quantity_input_max_competition', $product->get_max_purchase_quantity(), $product ),
				'input_value' => $product->get_min_purchase_quantity(),
			), $product);

			do_action( 'woocommerce_after_add_to_cart_quantity' );

			if ( 'yes' === $use_ticket_numbers && 'yes' !== $random_ticket_numbers ) :
				?>
				<input type="hidden" value="" name='competition_tickets_number'  >
				<input type="hidden" name='quantity' value= "" >
				<?php
				if ( $product->get_max_purchase_quantity() ) {
					?>
					<input type="hidden" name='max_quantity' value= "<?php echo intval( $product->get_max_purchase_quantity() ); ?>" >
				<?php
				}
			endif;
			if ( true === $use_answers ) :
				echo '<input type="hidden" value="" name="competition_answer">';
			endif;
			?>

			<?php wp_nonce_field( 'competition-for-woocommerce-cart', 'competition-for-woocommerce-cart-nonce' ); ?>
	<button type="submit" name="add-to-cart" value="<?php echo esc_attr( $product->get_id() ); ?>" class="single_add_to_cart_button button alt <?php echo 'yes' === $use_ticket_numbers && 'yes' !== $random_ticket_numbers ? ' competition-must-pick ' : ''; ?> <?php echo true === $use_answers ? ' competition-must-answer ' : '' ; ?>" ><?php echo wp_kses_post( $product->single_add_to_cart_text() ); ?></button>

	<?php
		do_action( 'woocommerce_after_add_to_cart_button' );
	?>
</form>

<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>
