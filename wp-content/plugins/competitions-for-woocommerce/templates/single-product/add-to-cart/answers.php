<?php
/**
 * Competition add to cart answers
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/answers.php.
 *
 */
defined( 'ABSPATH' ) || exit;

global $product;

$use_answers                      = competitions_for_woocommerce_use_answers( $product->get_id() );
$answers                          = maybe_unserialize( get_post_meta( $product->get_id(), '_competition_answers', true ) );
$competition_question             = get_post_meta( $product->get_id(), '_competition_question', true );
$competition_use_dropdown_answers = get_option( 'competitions_for_woocommerce_use_dropdown_answers', 'no' );

if ( true === $use_answers ) :
	if ( ! ( empty( $competition_question ) || empty( $answers ) ) ) { ?>
		<h3><?php esc_html_e( 'Answer the question:' , 'competitions_for_woocommerce' ) ; ?></h3>
		<p class="competition-question"><?php echo wp_kses_post( $competition_question ); ?>
		<?php
		if ( is_array( $answers ) ) {
			if ( 'yes' === $competition_use_dropdown_answers ) {
				echo '<select id="competition_answer_drop" name="competition_answer_drop">';
				echo '<option value="-1">' . esc_html__('Select answer from dropdown' , 'competitions_for_woocommerce' ) . '</option>';
				foreach ($answers as $key => $answer) {
					echo '<option data-answer-id=' . intval( $key ) . ' value="' . intval( $key ) . '"" >' . wp_kses_post( $answer['text'] ) . '</option>';
				}
				echo '</select>';
				
				

			} else {
				echo '<ul class="competition-answers">';
				foreach ($answers as $key => $answer) {
					echo '<li data-answer-id=' . intval( $key ) . ' >' . wp_kses_post( $answer['text'] ) . '</li>';
				}
				echo '</ul>';

			}
		}
		echo '</p>';
	}
	?>

	
	<?php
	if ( 'yes' === get_post_meta( $product->get_id() , '_competition_only_true_answers', true ) ) {

		$true_answers = competitions_for_woocommerce_get_true_answers( $product->get_id() );
		if ( is_array($true_answers) ) {
			$true_answers_value = implode(',', array_keys($true_answers));
		}
		echo '<input type="hidden" value="' . esc_attr( $true_answers_value ) . '" name="competition_true_answers">';

	}

endif;
