<?php
/**
 * Winners block template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/winners.php.
 * 
 */

defined( 'ABSPATH' ) || exit;

global  $product, $post, $current_user;
if ( $product && true !== $product->is_closed() ) {
	return;
}
//$current_user       = wp_get_current_user();
$competition_winers = get_post_meta($post->ID, '_competition_winners', true);
$use_answers        = competitions_for_woocommerce_use_answers( $post->ID );
$use_ticket_numbers = get_post_meta( $post->ID , '_competition_use_pick_numbers', true );
$answers            = maybe_unserialize( get_post_meta( $post->ID, '_competition_answers', true ) );



?>


<?php
if ( get_post_meta($post->ID, '_order_hold_on') ) {
	?>

	<p><?php esc_html_e('Please be patient. We are waiting for some orders to be paid!', 'competitions-for-woocommerce'); ?></p>

<?php
} elseif ( '2' === $product->get_competition_closed() && 'yes' === get_post_meta( $post->ID, '_competition_manualy_winners', true ) && empty($competition_winers) ) {
	esc_html_e('Please be patient. We are picking winners!', 'competitions-for-woocommerce');
} else {
	if ( '2' === $product->get_competition_closed() ) {
		if ($product->is_user_participating()) :
			if ( $product->is_user_winner() ) :
				?>
				<p><?php esc_html_e('Congratulations! You are the winner!', 'competitions-for-woocommerce'); ?></p>
			<?php
			else :
				?>
				<p><?php esc_html_e('Sorry, better luck next time.', 'competitions-for-woocommerce'); ?></p>
			<?php
			endif;
			?>
		<?php
		endif;
		?>
	<?php
	} else {
		if ( '1' === $product->get_competition_fail_reason() ) {
			?>
			<p><?php esc_html_e('Competition failed because there were no participants', 'competitions-for-woocommerce'); ?></p>
		<?php
		} elseif ( '2' === $product->get_competition_fail_reason() ) {
			?>
			<p><?php esc_html_e('Competition failed because there was not enough participants', 'competitions-for-woocommerce'); ?></p>
		<?php
		}
		?>
	<?php
	}
	?>

<?php
}


if ( ! empty( $competition_winers ) ) {

	if (count($competition_winers) > 1) {
		?>
		<h3><?php esc_html_e('Winners:', 'competitions-for-woocommerce'); ?></h3>
		<ol class="competition-winners">
		<?php
		foreach ($competition_winers as $winner) {
			echo '<li>';
			if ( intval( $winner ) > 0) {
			echo esc_html( get_userdata($winner['userid'])->display_name );
				echo '<br>';
				if ( 'yes' === $use_ticket_numbers ) {
					echo '<span class="ticket-number">';
					esc_html_e( 'Ticket number: ', 'competitions-for-woocommerce' );
					echo wp_kses_post( apply_filters( 'ticket_number_display_html' , $winner['ticket_number'], $product ) );
					echo ' </span>';
				}
				if ( true === $use_answers ) {
					echo "<br><span class='ticket-answer'>";
					esc_html_e( 'Answer: ', 'competitions-for-woocommerce' );
					$answer = isset( $answers[$winner['answer_id']]['text'] ) ? $answers[$winner['answer_id']]['text'] : '';
					echo wp_kses_post( $answer );
					echo '</span>';
				}
			}
			echo '</li>';
		}
		?>
		</ol>

	<?php
	} elseif ( 1 === count( $competition_winers )  ) {
		$winner = reset($competition_winers);
		if ( ! empty ( $winner ) ) {
			?>
			<div class="competition-winners">
			<h3><?php esc_html_e('Winner is:', 'competitions-for-woocommerce'); ?> <?php echo esc_html( get_userdata($winner['userid'])->display_name ); ?></h3>
				<?php
				if ( 'yes' === $use_ticket_numbers ) {
					echo ' <span class="ticket-number">';
					esc_html_e( 'Ticket number: ', 'competitions-for-woocommerce' );
					echo wp_kses_post( apply_filters( 'ticket_number_display_html' , $winner['ticket_number'], $product ) );
					echo '</span>';
				}
				if ( true === $use_answers ) {
					echo ' <span class="ticket-answer">';
					esc_html_e( 'Answer: ', 'competitions-for-woocommerce' );
					$answer = isset( $answers[$winner['answer_id']]['text'] ) ? $answers[$winner['answer_id']]['text'] : '';
					echo wp_kses_post( $answer );
					echo '</span>';
				}
			echo '</div>';
		} else {
			echo '<h3>';
			esc_html_e( 'There is no winner for this competition', 'competitions-for-woocommerce' );
			echo '</h3>';
		}


	} else {
		echo '<h3>';
		esc_html_e( 'There is no winner for this competition', 'competitions-for-woocommerce' );
		echo '</h3>';
	}

} else {

	if ( is_array($competition_winers) && ! empty ( $competition_winers ) ) {

		if ( count($competition_winers) > 1 ) {
			?>

			<h3><?php esc_html_e('Winners:', 'competitions-for-woocommerce'); ?></h3>

			<ol class="competition-winners">
			<?php
			foreach ($competition_winers as $winner_id) {
				echo '<li>';
				echo intval($winner_id) > 0 ? esc_html( get_userdata($winner_id)->display_name ) : esc_html_e( 'N/A ', 'competitions-for-woocommerce' );
				echo '</li>';
			}
			?>
			</ol>

		<?php
		} elseif ( isset( $competition_winers[0] ) ) {
			?>
			<h3><?php esc_html_e('Winner is:', 'competitions-for-woocommerce'); ?> <?php echo esc_html( get_userdata( $competition_winers[0] )->display_name ); ?></h3>

		<?php
		}
		?>

	<?php
	}
}

$pick_text = get_post_meta($post->ID, '_competition_manualy_pick_text', true );
if ( $pick_text ) {
	echo '<p>';
	echo wp_kses_post( $pick_text );
	echo '</p>';
}
