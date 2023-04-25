<?php
/**
 * Competition widget countdown template
 *
 */

defined( 'ABSPATH' ) || exit;

global  $product;
$futureclass = ( false === $product->is_closed() ) && ( false ===$product->is_started() ) ? 'future' : '';
$data_time   = ( 'future' === $futureclass ) ? $product->get_seconds_to_competition() : $product->get_seconds_remaining();
?>

<div class="competition-time-countdown <?php echo esc_attr( $futureclass ); ?> " data-time="<?php echo esc_attr( $data_time ); ?>" data-competitionid="<?php echo  intval( $product->get_id() ); ?>" data-format="<?php echo esc_attr( get_option( 'competitions_for_woocommerce_countdown_format' ) ); ?>"></div>
