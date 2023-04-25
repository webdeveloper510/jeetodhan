<?php
/**
 * Admin competition finish email
 *
 */

defined( 'ABSPATH' ) || exit;
$product_data       = wc_get_product(  $product_id );
$competition_winers = get_post_meta($product_id, '_competition_winners', true);

do_action('woocommerce_email_header', $email_heading, $email); ?>

<p>
	<?php
	/* translators: 1) product link 2) product title */
	printf( wp_kses_post(  __("Competition <a href='%1\$s'>%2\$s</a> has finished.", 'competitions_for_woocommerce') ), esc_url( get_permalink($product_id) ), esc_html( $product_data -> get_title() ) );
	?>
<?php
if ( $competition_winers ) {
	if ( count( $competition_winers ) === 1 ) {
		$winnerid = reset( $competition_winers );
		if ( ! empty( $winnerid ) ) {
			?>
			<p>
				<?php esc_html_e( 'Competition winner is', 'competitions_for_woocommerce' ); ?>: <span><a href='<?php echo esc_url( get_edit_user_link( $winnerid['userid'] ) ); ?>'><?php echo esc_html( get_userdata( $winnerid['userid'] )->display_name); ?></a></span>
			</p>
		<?php } ?>
	<?php } else { ?>

	<p><?php esc_html_e( 'Competition winners are', 'competitions_for_woocommerce' ); ?>:
		<ul>
		<?php
		foreach ( $competition_winers as $key => $winnerid ) {
			if ( $winnerid > 0 ) {
				?>
				<li><a href='<?php echo esc_url (get_edit_user_link( $winnerid['userid'] ) ); ?>'><?php echo esc_html( get_userdata( $winnerid['userid'] )->display_name ); ?></a></li>
		<?php
			}
		}
		?>
		</ul>
	</p>

<?php
	}
}

do_action('woocommerce_email_footer', $email);
