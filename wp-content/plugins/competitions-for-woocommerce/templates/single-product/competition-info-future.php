<?php
/**
 * Competition info template
 *
 */

defined( 'ABSPATH' ) || exit;
global $product, $post;

$competition_dates_to   = $product->get_competition_dates_to();
$competition_dates_from = $product->get_competition_dates_from();
?>
<p class="competition-starts"><?php echo  esc_html__( 'Competition starts:', 'wc_competition' ); ?> <?php echo  esc_html( date_i18n( get_option( 'date_format' ), strtotime( $competition_dates_from ) ) ); ?> <?php echo  esc_html( date_i18n( get_option( 'time_format' ), strtotime( $competition_dates_from ) ) ); ?></p>
<p class="competition-end"><?php echo  esc_html__( 'Competition ends:', 'wc_competition' ); ?> <?php echo  esc_html( date_i18n( get_option( 'date_format' ), strtotime( $competition_dates_to ) ) ); ?>  <?php echo  esc_html( date_i18n( get_option( 'time_format' ), strtotime( $competition_dates_to ) ) ); ?> </p>
