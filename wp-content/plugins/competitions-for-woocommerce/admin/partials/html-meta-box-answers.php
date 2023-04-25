<?php global $post, $thepostid; ?>

	<div id="wc_competition_answers-tb" class="wc-metaboxes-wrapper" >
		<div class="toolbar toolbar-top">
			<p class="form-field">
			<?php
				woocommerce_wp_textarea_input( array(
				'id'          => '_competition_question',
				'label'       => esc_html__( 'Question', 'competitions_for_woocommerce' ),
				'desc_tip'    => true,
				'description' => esc_html__( 'Ask user a question.', 'competitions_for_woocommerce' ),
			) );
				?>


			
			</p>
		</div>
		<div class="competition_answers_wrapper wc-metaboxes answers">
			<?php
				// Product answers - taxonomies and custom, ordered, with visibility and variation answers set
				$answers = maybe_unserialize( get_post_meta( $thepostid, '_competition_answers', true ) );
				
			// Output All Set answers
			if ( ! empty( $answers ) ) {

				foreach ($answers as $answer_key => $answer) {

					$metabox_class = array();

				include  plugin_dir_path( dirname( __FILE__ ) ) . 'partials/html-product-competition-answers.php';
				}
			}
			?>
		</div>
		<div class="toolbar">
			<button type="button" class="button add_competition_answer"><?php esc_html_e( 'Add Answer', 'competitions_for_woocommerce' ); ?></button>
		</div>
	</div>
