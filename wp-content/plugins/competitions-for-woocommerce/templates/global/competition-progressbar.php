<?php
/**
 * Competition progressbar template
 *
 */

defined( 'ABSPATH' ) || exit;
global  $product, $post;
if ( 'yes' !== get_option( 'competitions_for_woocommerce_progressbar', 'yes' ) ) {
	return;
}
$min_tickets                    = $product->get_min_tickets();
$max_tickets                    = $product->get_max_tickets();
$competition_participants_count = !empty($product->get_competition_participants_count()) ? $product->get_competition_participants_count() : '0';
?>

<?php if ( $max_tickets  && ( $max_tickets > 0 )  ) : ?>

<div class="wcl-progress-meter <?php echo  $product->is_max_tickets_met() ? 'full' : ''; ?>">
	<span class="zero">0</span>
	<?php
	if ( 'sold' !== get_option( 'competitions_for_woocommerce_type', 'sold' ) ) {
		?>
		<span class="sold"><?php echo  esc_html__( 'Tickets available:', 'competitions-for-woocommerce' ); ?> <?php echo intval( $max_tickets - $competition_participants_count ); ?></span>
	<?php } else { ?>
		<span class="sold"><?php echo  esc_html__( 'Tickets sold:', 'competitions-for-woocommerce' ); ?> <?php echo intval( $competition_participants_count ); ?></span>
	<?php } ?>
	<span class="max"><?php echo intval( $max_tickets ); ?></span>
	<progress  max="<?php echo intval( $max_tickets ); ?>" value="<?php echo intval( $competition_participants_count ); ?>"  low="<?php echo intval( $min_tickets ); ?>"></progress>
</div>

<?php
endif;
