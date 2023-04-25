<div class="woocommerce_competition_answer_box wc-metabox closed" rel="<?php echo esc_attr( $answer_key ); ?>">
	<div class="woocommerce_answer_data">
		<table cellpadding="0" cellspacing="0" width="100%">
		<tbody>
		<tr>
			<td>
				<label><?php esc_html_e( 'Answer', 'competitions_for_woocommerce' ); ?>:</label>

				<input type="text" class="competition_answer" name="competition_answer[<?php echo esc_attr( $answer_key ); ?>]" size="20" value="<?php echo esc_attr( $answer['text'] ); ?>" data-answer-id="<?php echo esc_attr( $answer_key ); ?>" />
			</td>

			<td class="answer_checkbox">
				<label><input type="checkbox" class="checkbox" <?php checked( $answer['true'], 1 ); ?> name="competition_answer_true[<?php echo esc_attr( $answer_key ) ; ?>]" value="1" /> <?php esc_html_e( 'True', 'competitions_for_woocommerce' ); ?></label>
			</td>

			<td class="remove-answer"><a href="#" class="remove_row delete"><?php esc_html_e( 'Remove', 'competitions_for_woocommerce' ); ?></a></td>
		</tr>
		</tbody>
		</table>
	</div>
</div>
