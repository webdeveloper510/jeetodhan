<?php 
/**
* 
* Register "Ask a Question tab" in WooCommerce
*
* @since    1.0.0
*/

function modeltheme_product_tabs_lottery( $tabs) {
	    $tabs['mt_add_question'] = array(
	      'label'	=> esc_html__( 'Add Question to Lottery ', 'modeltheme' ),
	      'target' 	=> 'mt_add_question_product_options',
	      'class'  	=> 'show_if_lottery hide_if_grouped hide_if_external hide_if_variable hide_if_simple',
	     );
	    return $tabs;
}
add_filter('woocommerce_product_data_tabs','modeltheme_product_tabs_lottery');



/**
* 
* Register options for "Ask a Question tab" in WooCommerce
*
* @since    1.0.0
*/

function modeltheme_product_tab_lottery_content() {  ?>
	<div id='mt_add_question_product_options' class='panel woocommerce_options_panel'>

		<div class='options_group'><?php	
			woocommerce_wp_checkbox(
				array(
					'id' => 'mt_enable_question',
					'label' => esc_html__( 'Enable Question?', 'modeltheme' ),
					'desc_tip' => 'true'
				)
			); ?>
		</div>

		<div class='options_group'><?php	
			woocommerce_wp_checkbox(
				array(
					'id' => 'mt_enable_only_true_ans',
					'label' => esc_html__( 'Limit to correct answers', 'modeltheme' ),
					'desc_tip' => 'true'
				)
			); ?>
		</div>

		<div class="options_group"><?php					
			woocommerce_wp_textarea_input( 
				array(
					'id'          	=> 'mt_lottery_question',
					'label'       	=> esc_html__( 'Question', 'modeltheme' ),
					'desc_tip' 		=> 'true'
				) 
			); ?>
		</div>

		<div class="mt_all_possible_answers_wrapper answers">
		<?php
		$answers = maybe_unserialize( get_post_meta( get_the_ID(), 'mt_all_possible_answers', true ) );
						
		if ( ! empty( $answers ) ) {
			$answer_no = 1;
			foreach ($answers as $key => $answer) {
				echo '<table class="options_group" cellpadding="0" cellspacing="0" width="100%">';
					echo '<tbody>';
						echo '<tr>';
							echo '<td>';
								echo '<label>'.esc_html__( 'Answer', 'modeltheme' ).' '.esc_attr( $answer_no ).'</label>';
								echo '<input type="text" class="lottery_answer" name="lottery_answer['.esc_attr( $key ).']"  value="'.esc_attr( $answer['text'] ).'" attr="'.esc_attr( $key ).'" />';
							echo '</td>';

							echo '<td>'; ?>
								<label><input type="checkbox" class="checkbox" <?php echo checked( $answer['true'], 1 );?> name="lottery_answer_true[<?php echo esc_attr( $key );?>]" value="1" /> <?php echo esc_html_e( 'Correct', 'modeltheme' );?></label><?php
							echo '</td>';

							echo '<td><a href="#" class="mt_remove_row">x</a></td>';
						echo '</tr>';
					echo '</tbody>';
				echo '</table>';
				$answer_no++;
			}
		}?>
		</div>
		<button type="button" class="button add_lottery_answer"><?php esc_html_e( 'Add New Answer', 'modeltheme' ); ?></button>
 	</div>
 	<?php
}
add_action( 'woocommerce_product_data_panels', 'modeltheme_product_tab_lottery_content');



/**
* 
* Save meta for Ask A Question Tab
*
* @since    1.0.0
*/

function modeltheme_save_meta_lottery( $post_id ){
	$mt_add_question 	= $_POST['mt_lottery_question'];

	if ( isset( $_POST['mt_enable_question'] ) && ! empty( $_POST['mt_enable_question'] ) ) {
		update_post_meta( $post_id, 'mt_enable_question', 'yes' );
	} else {
		update_post_meta( $post_id, 'mt_enable_question', 'no' );
	}

	if( !empty( $mt_add_question ) ) {
		update_post_meta( $post_id, 'mt_lottery_question', esc_attr( $mt_add_question ) );
	}
}
add_action( 'woocommerce_process_product_meta', 'modeltheme_save_meta_lottery');



/**
* 
* AJAX Add new Answer line
*
* @since    1.0.0
*/

function modeltheme_ajax_add_answer_line() {

	ob_start();
	check_ajax_referer( 'add_lottery_answer_nonce', 'security' );

	if ( ! current_user_can( 'edit_products' ) ) {
		die( -1 );
	}

	$thepostid     = 0;
	$answer_key    = absint( $_POST['key'] );
	$position      = 0;
	$metabox_class = array();
	$answer        = array(
		'text' => '',
		'true' => 0,
	);
	
		echo '<table class="options_group" cellpadding="0" cellspacing="0" width="100%">';
			echo '<tbody>';
				echo '<tr>';
					echo '<td>';
						echo '<label>'.esc_html__( 'Answer', 'modeltheme' ).'</label>';
							echo '<input type="text" class="lottery_answer" name="lottery_answer['.esc_attr( $key ).']"  value="'.esc_attr( $answer['text'] ).'" attr="'.esc_attr( $key ).'" />';
					echo '</td>';
					
					echo '<td>'; ?>
						<label><input type="checkbox" class="checkbox" <?php echo checked( $answer['true'], 1 );?> name="lottery_answer_true[<?php echo esc_attr( $key );?>]" value="1" /> <?php echo esc_html_e( 'Correct', 'modeltheme' );?></label><?php
					echo '</td>';
					echo '<td><a href="#" class="mt_remove_row">x</a></td>';
				echo '</tr>';
			echo '</tbody>';
		echo '</table>';
	
	die();
}
add_action( 'wp_ajax_woocommerce_add_lottery_answer',  'modeltheme_ajax_add_answer_line' );


/**
* 
* AJAX Save Answers for New Lines
*
* @since    1.0.0
*/
function modeltheme_lottery_tab_save_answers( $post_id, $post ) {
		if ( ! current_user_can( 'edit_products' ) ) {
			return;
		}
		$answers = array();

		$lottery_question = isset( $_POST['mt_lottery_question'] ) ? wp_kses_post( $_POST['mt_lottery_question'] ) : '';
		update_post_meta( $post_id, 'mt_lottery_question', $lottery_question );

		if ( isset( $_POST['lottery_answer'] ) ) {

			$post_answers = isset( $_POST['lottery_answer'] ) ? wc_clean( $_POST['lottery_answer'] ) : array();
			$answers_true = isset( $_POST['lottery_answer_true'] ) ? wc_clean( $_POST['lottery_answer_true'] ) : array();

			foreach ( $post_answers as $key => $answer ) {
				if ( ! empty( $answer ) ) {
					$answers[ $key ]['text'] = $answer;
					$answers[ $key ]['true'] = isset( $answers_true[ $key ] ) ? 1 : 0;
				}
			}
		}
		update_post_meta( $post_id, 'mt_all_possible_answers', $answers );

}
add_action( 'lottery_product_save_data', 'modeltheme_lottery_tab_save_answers', 80, 2 );



/**
* 
* AJAX Save for Only True Answers
*
* @since    1.0.0
*/
function modeltheme_lottery_tab_save_answers_only_true( $post_id, $post ) {

	if ( ! current_user_can( 'edit_products' ) ) {
		return;
	}
	$product_type = empty( $_POST['product-type'] ) ? 'simple' : sanitize_title( wc_clean( $_POST['product-type'] ) );
	$product = wc_get_product( $post_id );

	if ( $product_type == 'lottery' ) {
		if ( isset( $_POST['mt_enable_only_true_ans'] ) && ! empty( $_POST['mt_enable_only_true_ans'] ) ) {
			update_post_meta( $post_id, 'mt_enable_only_true_ans', 'yes' );
		} else {
			update_post_meta( $post_id, 'mt_enable_only_true_ans', 'no' );
		}
	}
}
add_action( 'lottery_product_save_data','modeltheme_lottery_tab_save_answers_only_true', 80, 2 );


add_action( 'woocommerce_before_add_to_cart_button', 'modeltheme_lottery_questions_add_to_cart_button', 7 );
function modeltheme_lottery_questions_add_to_cart_button(){
	wc_get_template( 'single-product/add-to-cart/answers.php' );
}

/**
* 
* WooCommerce Check if template is found
*
* @since    1.0.0
*/
function modeltheme_woo_locate_template( $template, $template_name, $template_path ) {
	$_template = $template;
	if ( ! $template_path ) $template_path = wc()->template_url;
		$plugin_path  = plugin_dir_path( dirname( __FILE__ ) ) . 'woocommerce/templates/';
		$template = locate_template(
			array(
				$template_path . $template_name,
				$template_name
			)
		);
		if ( ! $template && file_exists( $plugin_path . $template_name ) )
			 $template = $plugin_path . $template_name;
		if ( ! $template )
			$template = $_template;

		return $template;
}
add_filter( 'woocommerce_locate_template',  'modeltheme_woo_locate_template', 10, 3 );


/**
* 
* Check if Question is enabled
*
* @since    1.0.0
*/
function modeltheme_question_enabled( $product_id = false ) {
	global $product;

	if ( ! $product_id && $product ) {
			$product_id = $product->get_id();
	}
	$use_answers = get_post_meta( $product_id, 'mt_enable_question', true );
	if ( 'yes' !== $use_answers ) {
		return false;
	}

	return true;
}



/**
* 
* Message if answer was not selected;
*
* @since    1.0.0
*/
function modeltheme_confirm_answer_message($product) {
	if ( class_exists( 'WooCommerce' ) && is_product()) {
		global $product;
		$use_answers  		= modeltheme_question_enabled( $product->get_id() );
		if( true === $use_answers ) {
		?>
		<script type="text/javascript">
			jQuery('.buy-now.cart').submit(function() {
						if (jQuery(".mt-all-answers li").hasClass("selected")) {
				            return true;
				        }  else {
				            alert('<?php esc_html_e('No answer has been selected!','modeltheme'); ?>');
				            return false;
				        }
					});
				</script>
			<?php
			}   
		}
}
add_action( 'wp_footer', 'modeltheme_confirm_answer_message',1);



/**
* 
* Check if answer is valid;
*
* @since    1.0.0
*/
function modeltheme_check_true_answers( $product_id = false ) {
	global $product;
	$answers_id = array();

	if ( ! $product_id && $product ) {
			$product_id = $product->get_id();
	}
	$answers = maybe_unserialize( get_post_meta( $product_id, 'mt_all_possible_answers', true ) );

	if ( $answers ) {
		foreach ( $answers as $key => $answer ) {
			if ( 1 === $answer['true'] ) {
					$answers_id[ $key ] = $answer['text'];
			}
		}
	}

	return $answers_id;
}