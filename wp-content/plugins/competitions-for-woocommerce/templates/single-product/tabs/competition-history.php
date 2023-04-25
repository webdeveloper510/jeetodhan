<?php
/**
 * Competition history tab template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/tabs/competition-history.php
 *
 */

defined( 'ABSPATH' ) || exit;

global $post, $product;

$competition_winers = get_post_meta($post->ID, '_competition_winners', true);
$users_names        = '';
$use_answers        = competitions_for_woocommerce_use_answers( $post->ID );
$use_ticket_numbers = get_post_meta( $post->ID , '_competition_use_pick_numbers', true );
$answers            = maybe_unserialize( get_post_meta( $post->ID, '_competition_answers', true ) );
$date_format        = get_option( 'date_format' );
$time_format        = get_option( 'time_format' );

?>

<h2><?php esc_html_e( 'Competition History', 'competitions_for_woocommerce' ) ; ?></h2>


<?php if ( ( true === $product->is_closed() ) && ( true === $product->is_started() ) && is_array( $competition_winers ) ) : ?>

	<p> <?php esc_html_e('Competition has finished', 'competitions_for_woocommerce'); ?></p>
	<?php
	if ( 1  === $product->get_competition_fail_reason() ) {
		esc_html_e('Competition failed because there were no minimal number of participants', 'competitions_for_woocommerce');
	} else {
		if ( count($competition_winers) > 1 ) {
			?>
			<p>
				<?php
				esc_html_e('Competition winners are: ', 'competitions_for_woocommerce');
				foreach ($competition_winers as $winner) {
					if ( isset( $winner['userid'] ) ) {
						$display_name = get_userdata($winner['userid']) ? get_userdata($winner['userid'])->display_name : '';
						$users_names .= '<span>';
						$users_names .= $display_name;
						$users_names .= '</span>, ';
					}

				}
				echo wp_kses_post ( rtrim( $users_names , ', ') );
				?>

			</p>
	<?php
		} elseif ( 1 === count($competition_winers) ) {
			$winner = reset($competition_winers);
			if ( isset( $winner['userid'] ) ) {
				$display_name = get_userdata($winner['userid']) ? get_userdata($winner['userid'])->display_name : '';
				?>
			<p><?php esc_html_e('Competition winner is: ', 'competitions_for_woocommerce'); ?> <span><?php echo esc_html( $display_name ); ?></span></p>
	<?php
			}
		}
	}
	?>

<?php endif; ?>

<table>
	<thead>
		<tr>
			<th><?php esc_html_e('Date', 'competitions_for_woocommerce'); ?></th>
			<th><?php esc_html_e('User', 'competitions_for_woocommerce'); ?></th>
			<?php if ( 'yes' === $use_ticket_numbers ) : ?>
				<th><?php esc_html_e('Ticket number', 'competitions_for_woocommerce'); ?></th>
			<?php endif; ?>
			<?php
			if ( true === $use_answers && 'yes' === get_option('competitions_for_woocommerce_answers_in_history', 'yes')  && ( 'no' === get_option('competitions_for_woocommerce_answers_in_history_finished', 'no') || true === $product->is_closed() ) ) :
				?>
				<th><?php esc_html_e('Answer', 'competitions_for_woocommerce'); ?></th>
			<?php endif; ?>
		</tr>
	</thead>
	<?php
	$competition_history = $product->competition_history();

	if ( $competition_history ) {

		foreach ( $competition_history as $history_value ) {

			echo '<tr>';
			echo '<td class="date">' . esc_html( date_i18n( $date_format, strtotime( $history_value->date ) ) ) . ' ' . esc_html( date_i18n( $time_format, strtotime( $history_value->date ) ) ) . '</td>';
			if ( $history_value->userid ) {
				echo "<td class='username'>" . esc_html( apply_filters( 'competitions_for_woocommerce_displayname', get_userdata( $history_value->userid )->display_name ) ) . '</td>';
			} else {
				echo '';
			}

			if ( 'yes' === $use_ticket_numbers ) {
				echo "<td class='ticket_number'>" . esc_html( apply_filters( 'ticket_number_display_html' , $history_value->ticket_number, $product ) ) . '</td>';
			}

			if ( true === $use_answers && 'yes' === get_option('competitions_for_woocommerce_answers_in_history', 'yes')  && ( 'no' === get_option('competitions_for_woocommerce_answers_in_history_finished', 'no') || true === $product->is_closed() ) ) {
				$answer = isset( $answers[$history_value->answer_id] ) ? $answers[$history_value->answer_id] : false;

				echo "<td class='answer'>";
				echo ! empty( $answer ) ? esc_html( $answer['text'] ) : '' ;
				echo '</td>';
			}

			echo '</tr>';
		}

	}
	?>
	<tr class="start">
			<?php

			$competition_dates_to = $product->get_competition_dates_from();


			if ( true === $product->is_started() ) {
				echo '<td class="date">' . esc_html( date_i18n( $date_format, strtotime( $competition_dates_to ) ) ) . ' ' . esc_html( date_i18n( $time_format, strtotime( $competition_dates_to ) ) ) . '</td>';
				echo '<td class="started">';
				esc_html_e( 'Competition started', 'competitions_for_woocommerce' );
				echo '</td>';

			} else {
				echo '<td class="date">' . esc_html( date_i18n( $date_format, strtotime( $competition_dates_to ) ) ) . ' ' . esc_html( date_i18n( $time_format, strtotime( $competition_dates_to ) ) ) . '</td>';
				echo '<td class="starting">';
				esc_html_e( 'Competition starting', 'competitions_for_woocommerce' );
				echo '</td>' ;
			}
			?>
	</tr>
</table>
