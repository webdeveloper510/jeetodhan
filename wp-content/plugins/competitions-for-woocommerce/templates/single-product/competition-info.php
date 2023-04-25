<?php
/**
 * Competition info template
 *
 */

defined( 'ABSPATH' ) || exit;
global $product, $post;

$min_tickets                    = $product->get_min_tickets();
$max_tickets                    = $product->get_max_tickets();
$competition_participants_count = !empty($product->get_competition_participants_count()) ? $product->get_competition_participants_count() : '0';
$competition_dates_to           = $product->get_competition_dates_to();
$competition_dates_from         = $product->get_competition_dates_from();
$competition_num_winners        = $product->get_competition_num_winners();
$gmt_offset                     = get_option( 'gmt_offset' ) > 0 ? '+' . get_option( 'gmt_offset' ) : get_option( 'gmt_offset' );
?>

<p class="competition-end"><?php esc_html_e( 'Competition ends:', 'competitions-for-woocommerce' ); ?> <?php echo esc_html( date_i18n( get_option( 'date_format' ), strtotime( $competition_dates_to ) ) ); ?>  <?php echo esc_html( date_i18n( get_option( 'time_format' ), strtotime( $competition_dates_to ) ) ); ?> <br />
	<?php
	printf(
		// translators: 1) timezone
		esc_html__( 'Timezone: %s', 'competitions-for-woocommerce' ),
		get_option( 'timezone_string' ) ? esc_html( get_option( 'timezone_string' ) ) : esc_html__( 'UTC', 'competitions-for-woocommerce' ) . esc_html(  '0' !== $gmt_offset ? $gmt_offset : '' )
	);
	?>
</p>

<?php if ( $min_tickets && ( $min_tickets > 0 )  ) : ?>
	<p class="min-pariticipants">
		<?php
		// translators: 1) mininmum tickets
		printf ( esc_html__( 'This competition has a minimum of %d tickets', 'competitions-for-woocommerce'), intval( $min_tickets ) );
		?>
	</p>
<?php endif; ?>	

<?php if ( $max_tickets  &&( $max_tickets > 0 )  ) : ?>
	<p class="max-pariticipants">
		<?php
		// translators: 1) maximum tickets
		printf( esc_html__( 'This competition is limited to %s tickets', 'competitions-for-woocommerce' ), intval( $max_tickets ) ) ;
		?>

	</p>
<?php endif; ?>

<p class="cureent-participating"><?php esc_html_e( 'Tickets sold:', 'competitions-for-woocommerce' ); ?> <?php echo  intval( $competition_participants_count ); ?></p>

<?php if (  $competition_num_winners > 0  ) : ?>

<p class="max-pariticipants">
	<?php
	// translators: 1) Number of winners
	printf( esc_html ( _n( 'This competition will have %d winner' , 'This competition will have %d winners', intval( $competition_num_winners ) , 'competitions-for-woocommerce' ) ), intval( $competition_num_winners ) );
	?>
</p>

<?php
endif;

