<?php
/**
 * Competition countdown template
 *
 */

defined( 'ABSPATH' ) || exit;
global  $product, $post;

if ( false === ( $product->is_closed() ) && ( true === $product->is_started() ) ) : ?>
	<div class="competition-time countdown"><?php echo esc_html__( 'Time left:', 'competitions-for-woocommerce' ); ?>
		<div class="main-competition competition-time-countdown" data-time="<?php echo esc_attr( $product->get_seconds_remaining() ); ?>" data-competitionid="<?php echo intval( $product->get_id() ); ?>" data-format="<?php echo esc_attr( get_option( 'simple_competition_countdown_format' ) ); ?>"></div>
	</div>

<?php 
elseif ( false === ( $product->is_closed() ) && ( false === $product->is_started() ) ) :
	?>
	<div class="competition-time future countdown"><?php echo  esc_html__( 'Competition starts in:', 'competitions-for-woocommerce' ); ?>
		<div class="competition-time-countdown future" data-time="<?php echo esc_attr( $product->get_seconds_to_competition() ); ?>" data-competitionid="<?php echo intval( $product->get_id() ); ?>"  data-format="<?php echo esc_attr( get_option( 'simple_competition_countdown_format' ) ); ?>"></div>
	</div>
<?php
endif;
