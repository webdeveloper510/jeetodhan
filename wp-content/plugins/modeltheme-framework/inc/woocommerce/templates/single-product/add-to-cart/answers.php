<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $product;

$use_answers  		= modeltheme_question_enabled( $product->get_id() );
$answers 			= maybe_unserialize( get_post_meta( $product->get_id(), 'mt_all_possible_answers', true ) );
$lottery_question 	=  get_post_meta( $product->get_id(), 'mt_lottery_question', true );

if( true === $use_answers ){
	if ( ! ( empty( $lottery_question ) || empty( $answers ) ) ) { ?>
		<h4><?php echo esc_html($lottery_question); ?></h4>
		<?php
		if ( is_array( $answers ) ){
			echo '<ul class="mt-all-answers">';
				foreach ($answers as $key => $answer) {
					echo '<li attr='. intval( $key ) .' >' . wp_kses_post( $answer['text'] ) . '</li>';
				}
				echo '</ul>';
		}
	}
	if ( 'yes' === get_post_meta( $product->get_id() , 'mt_enable_only_true_ans', true ) ) {
		$true_answers = modeltheme_check_true_answers( $product->get_id() );
		if( is_array($true_answers) ) {
			$true_answers_value = implode(",", array_keys($true_answers));
		}
		echo '<input type="hidden" value="' . esc_attr( $true_answers_value ) . '" name="mt_true_answers">';
	}
}