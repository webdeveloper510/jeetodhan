<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 *
 * AJAX Event Handler.
 *
 * @class    AFW_AJAX
 */
class Competitions_For_Woocommerce_Ajax {

	/**
	 * Hook in ajax handlers.
	 */
	public static function init() {
		add_action( 'init', array( __CLASS__, 'define_ajax' ), 0 );
		add_action( 'wp_loaded', array( __CLASS__, 'do_wc_ajax' ), 10 );
		self::add_ajax_events();

	}

	/**
	 * Get WC Ajax Endpoint.
	 *
	 * @param string $request Optional.
	 *
	 * @return string
	 */
	public static function get_endpoint( $request = '' ) {
		return esc_url_raw( apply_filters( 'woocommerce_ajax_get_endpoint', add_query_arg( 'cfw-ajax', $request, remove_query_arg( array( 'remove_item', 'add-to-cart', 'added-to-cart', 'order_again', '_wpnonce' ), home_url( '/', 'relative' ) ) ), $request ) );
	}

	/**
	 * Set WC AJAX constant and headers.
	 */
	public static function define_ajax() {
		if ( ! empty( $_GET['cfw-ajax'] ) ) {
			wc_maybe_define_constant( 'DOING_AJAX', true );
			wc_maybe_define_constant( 'WC_DOING_AJAX', true );
			$GLOBALS['wpdb']->hide_errors();
		}
	}

	/**
	 * Send headers for WC Ajax Requests.
	 *
	 * @since 2.5.0
	 */
	private static function wc_ajax_headers() {
		send_origin_headers();
		send_nosniff_header();
		wc_nocache_headers();
		status_header( 200 );
	}

	/**
	 * Check for WC Ajax request and fire action.
	 */
	public static function do_wc_ajax() {
		if ( ! empty( $_GET['cfw-ajax'] ) ) {
			self::wc_ajax_headers();
			do_action( 'cfw_ajax_' . sanitize_text_field( $_GET['cfw-ajax'] ) );
			wp_die();
		}
	}

	/**
	 * Hook in methods - uses WordPress ajax handlers (admin-ajax).
	 */
	public static function add_ajax_events() {
		$ajax_events = array(
			'competitions_for_woocommerce_get_taken_numbers' => true,
			'competitions_for_woocommerce_lucky_dip'         => true,
			'add_answer'                                     => false,
			'save_answers'                                   => false,
			'save_answers'                                   => false,
			'delete_competition_participate_entry'           => false,
			'delete_competition_history_csv'                 => false,
			'competition_refund'                             => false,
		);

		foreach ( $ajax_events as $ajax_event => $nopriv ) {
			add_action( 'wp_ajax_' . $ajax_event, array( __CLASS__, $ajax_event ) );

			if ( $nopriv ) {
				add_action( 'wp_ajax_nopriv_woocommerce_' . $ajax_event, array( __CLASS__, $ajax_event ) );
				// AFW AJAX can be used for frontend ajax requests.
				add_action( 'cfw_ajax_' . $ajax_event, array( __CLASS__, $ajax_event ) );
			}
		}
	}

	/**
	 * Add answer(s) via ajax.
	 *
	 */
	public static function add_answer() {

		ob_start();

		check_ajax_referer( 'add_competition_answer_nonce', 'security' );

		if ( ! current_user_can( 'edit_products' ) ) {
			die( -1 );
		}

		$thepostid     = 0;
		$answer_key    = isset( $_POST['key'] ) ? absint( $_POST['key'] ) : 0;
		$position      = 0;
		$metabox_class = array();
		$answer        = array(
			'text' => '',
			'true' => 0,
		);

		include plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/html-product-competition-answers.php';
		die();

	}
	// /**
	//  * Save discounts via ajax.
	//  *
	//  */
	public static function save_answers( $post_id, $post ) {

		check_ajax_referer( 'save_competition_answer_nonce', 'security' );

		if ( ! current_user_can( 'edit_products' ) ) {
			return;
		}

		// Save Attributes
		$answers = array();

		$competition_question = isset( $_POST['_competition_question'] ) ? wp_kses_post( $_POST['_competition_question'] ) : '';
		update_post_meta( $post_id, '_competition_question', $competition_question );

		if ( isset( $_POST['competition_answer'] ) ) {

			$post_answers = isset( $_POST['competition_answer'] ) ? wc_clean( $_POST['competition_answer'] ) : array();
			$answers_true = isset( $_POST['competition_answer_true'] ) ? wc_clean( $_POST['competition_answer_true'] ) : array();

			foreach ( $post_answers as $key => $answer ) {
				if ( ! empty( $answer ) ) {
					$answers[ $key ]['text'] = $answer;
					$answers[ $key ]['true'] = isset( $answers_true[ $key ] ) ? 1 : 0;
				}
			}
		}

		update_post_meta( $post_id, '_competition_answers', $answers );

	}
	public static function delete_competition_participate_entry() {
		check_ajax_referer( 'add_competition_answer_nonce', 'security' );

		global $wpdb;

		$post_id = isset( $_POST['postid'] ) ? intval( $_POST['postid'] ) : false ;
		$log_id  = isset( $_POST['logid'] ) ? intval( $_POST['logid'] ) : false;

		if ( ! current_user_can( 'edit_product', $post_id ) ) {
			die();
		}
		if ( $post_id && $log_id ) {
			$product = wc_get_product( $post_id );
			$log     = $wpdb->get_row( $wpdb->prepare( 'SELECT * FROM ' . $wpdb->prefix . 'cfw_log WHERE id=%d', $log_id ) );
			if ( ! is_null( $log ) ) {
				$wpdb->query( $wpdb->prepare( 'DELETE FROM ' . $wpdb->prefix . 'cfw_log WHERE id= %d', $log_id ) );
				delete_post_meta( $post_id, '_order_id', $log->orderid );
				$count = get_post_meta( $post_id, '_competition_participants_count', true ) ? get_post_meta( $post_id, '_competition_participants_count', true ) : 0;

				if ( $count > 0 ) {
						update_post_meta( $post_id, '_competition_participants_count', intval( $count ) - 1 );
				}
				do_action('wc_competition_delete_participate_entry' , $post_id, $log_id);
				wp_send_json( 'deleted' );
				exit;
			}
			wp_send_json( 'failed' );
			exit;
		}
		wp_send_json( 'failed' );
		exit;


	}

	/**
	 * Ajax delete lotery csv
	 *
	 * Function for deleting participate entry in wp admin
	 *
	 * @param  array
	 * @return string
	 *
	 */
	public static function delete_competition_history_csv() {

		check_ajax_referer( 'add_competition_answer_nonce', 'security' );

		global $wpdb;

		$post_id = isset( $_POST['postid'] ) ? intval( $_POST['postid'] ) : false ;
		$log_id  = isset( $_POST['logid'] ) ? intval( $_POST['logid'] ) : false;

		if ( ! current_user_can( 'edit_product', $post_id ) ) {
			die();
		}



		if ( $post_id ) {
			$product = wc_get_product( $post_id );
			$log     = get_post_meta($post_id, '_history_competition_csv_files');
			if ( $log ) {
				if ( isset( $log[ $log_id ] ) ) {
					$filename = $log[ $log_id ][1];
					unset($log[ $log_id ]);
					delete_post_meta($post_id, '_history_competition_csv_files' );
					foreach ( $log as $data ) {
						add_post_meta($post_id, '_history_competition_csv_files' , $data );
					}
					$path                   = apply_filters( 'woocommerce_competition_export_dir_path', wp_upload_dir() );
					$competition_upload_dir = apply_filters( 'woocommerce_competition_export_dir_path', '/wc-competition-export/');
					$upload_dir             =  $path['basedir'] . $competition_upload_dir;
					unlink($upload_dir . '/' . $filename);
					do_action('wc_delete_competition_history_csv' , $post_id, $log_id);
					wp_send_json( 'deleted' );
					exit;
				}
			}
			wp_send_json( 'failed' );
			exit;
		}
		wp_send_json( 'failed' );
		exit;
	}

	public static function competitions_for_woocommerce_get_taken_numbers() {
		check_ajax_referer( 'competition_for_woocommerce_nonce', 'security' );
		$response       = null;
		$competition_id = isset( $_GET['competition_id'] ) ? intval( $_GET['competition_id'] ) : false;

		if ( $competition_id ) {
			$response['taken']   = competitions_for_woocommerce_get_taken_numbers($competition_id);
			$response['in_cart'] = competitions_for_woocommerce_get_ticket_numbers_from_cart($competition_id);
			if ( isset( $_GET['reserve_ticket'] ) &&'yes' === $_GET['reserve_ticket'] ) {
				$response['reserved'] = competitions_for_woocommerce_get_reserved_numbers($competition_id);
			}
		}
		wp_send_json( $response );
	}

	public static function competitions_for_woocommerce_lucky_dip() {

		check_ajax_referer( 'competition_for_woocommerce_nonce', 'security' );


		$response   = null;
		$guest_cart = false;

		$competition_id       = isset( $_GET['competition_id'] ) ? intval( $_GET['competition_id'] ) : false;
		$max_tickets_per_user = intval( get_post_meta( $competition_id, '_competition_max_tickets_per_user', true ) );
		$max_tickets          = intval( get_post_meta( $competition_id, '_competition_max_tickets', true ) );

		if ( empty( $max_tickets_per_user )  || $max_tickets_per_user === $max_tickets ) {
			$guest_cart = true;
		}

		if ( ! is_user_logged_in() && false === $guest_cart ) {
			$response ['status'] = 'failed';
			/* translators: 1) login link */
			$response ['message'] = sprintf( __('Sorry, you must be logged in to participate in competition. <a href="%s" class="button">Login &rarr;</a>', 'competitions-for-woocommerce'), get_permalink(wc_get_page_id('myaccount') ) );
			wp_send_json( $response );
			die();
		}

		if ( 'yes' === get_post_meta( $competition_id , '_competition_pick_number_alphabet', true ) ) {
			add_filter( 'ticket_number_display_html', 'competitions_for_woocommerce_change_ticket_numbers_to_alphabet', 10, 2 );
			add_filter( 'ticket_number_tab_display_html', 'competitions_for_woocommerce_change_ticket_tab_to_alphabet', 10, 2 );
		}

		$competition_answer = isset( $_GET['competition_answer'] ) ? intval( $_GET['competition_answer'] ) : false;
		$qty                = isset( $_GET['qty'] ) ? intval( $_GET['qty'] ) : 1;
		$use_answers        = competitions_for_woocommerce_use_answers( $competition_id );

		if ( $competition_id ) {
			if ( $use_answers ) {
				if (! $competition_answer ) {
					$response ['status']  = 'failed';
					$response ['message'] = esc_html__('Please answer the question.' , 'competitions-for-woocommerce');
					wp_send_json( $response );
					die();
				}

			}
			$numbers = competitions_for_woocommerce_generate_random_ticket_numbers( $competition_id, $qty );

			if ( $numbers ) {
				WC()->cart->add_to_cart( $competition_id, $qty, 0, array(), array( 'competition_tickets_number' => $numbers, 'competition_answer' => $competition_answer ) ) ;
				foreach ($numbers as $key => $value) {
					$display_numbers[$key] = apply_filters( 'ticket_number_display_html' , $value, wc_get_product( $competition_id ) );
				}
				$response['message']        =  wc_get_template_html( 'global/lucky-dip-modal.php', array( 'display_numbers' => $display_numbers, 'product_id' => $competition_id ) );
				$response['ticket_numbers'] =  $numbers ;
				$response ['status']        = 'success';
			} else {
				$response ['status'] = 'failed';
				$response['message'] =  wc_get_template_html( 'global/lucky-dip-modal-error.php');
			}
		}
		wp_send_json( $response );
	}

	/**
	 * Handle a refund via the edit order screen.
	 */
	public static function competition_refund() {

		check_ajax_referer( 'competition-refund', 'security' );

		if ( ! current_user_can( 'edit_shop_orders' ) ) {
			die( -1 );
		}

		$item_ids = array();
		$succes   = array();
		$error    = array();

		$product_id    = isset( $_POST['product_id'] ) ? intval( $_POST['product_id'] ) : false;
		$refund_amount = 0;
		$refund_reason = __( 'Competition failed. No minimum ticket sold', 'competitions-for-woocommerce' );
		$refund        = false;
		$response_data = array();

		$orders = self::get_product_orders( $product_id );
		$competition_order_refunded = get_post_meta( $product_id, '_competition_order_refunded' );

		foreach ( $orders as $key => $order_id ) {

			if ( in_array( $order_id, $competition_order_refunded, true) ) {
				$error[ $order_id ] = __( 'Competition amount allready returned', 'competitions-for-woocommerce' );
				continue;
			}

			try {

				// Validate that the refund can occur
				$order         = wc_get_order( $order_id );
				$order_items   = $order->get_items();
				$refund_amount = 0;

				// Prepare line items which we are refunding
				$line_items  = array();
				$item_ids    = array();
				$order_items = $order->get_items();
				if ( $order_items ) {

					foreach ( $order_items as $item_id => $item ) {

						$item_meta    = wc_get_order_item_meta( $item_id, '' );
						$product_data = wc_get_product( $item_meta['_product_id'][0] );

						if ( $product_data->get_type() === 'competition' && intval( $item_meta['_product_id'][0] ) === $product_id ) {
							$item_ids[]    = $product_data->get_id();
							$refund_amount = wc_format_decimal( $refund_amount ) + wc_format_decimal( $item_meta['_line_total'] [0] );

							$line_items[ $product_data->get_id() ] = array(
								'qty'          => $item_meta['_qty'],
								'refund_total' => wc_format_decimal( $item_meta['_line_total'] ),
								'refund_tax'   => array_map( 'wc_format_decimal', $item_meta['_line_tax_data'] ),
							);

						}
					}
				}
				$max_refund = wc_format_decimal( $refund_amount - $order->get_total_refunded() );

				if ( ! $refund_amount || $max_refund < $refund_amount || 0 > $refund_amount ) {
					throw new exception( __( 'Invalid refund amount', 'competitions-for-woocommerce' ) );
				}

				if ( WC()->payment_gateways() ) {
					$payment_gateways = WC()->payment_gateways->payment_gateways();
				}

				$payment_method = method_exists( $order, 'get_payment_method' ) ? $order->get_payment_method() : $order->payment_method;

				if ( isset( $payment_gateways[ $payment_method ] ) && $payment_gateways[ $payment_method ]->supports( 'refunds' ) ) {
					$result = $payment_gateways[ $payment_method ]->process_refund( $order_id, $refund_amount, $refund_reason );

					do_action( 'woocommerce_refund_processed', $refund, $result );

					if ( is_wp_error( $result ) ) {
						throw new Exception( $result->get_error_message() );
					} elseif ( ! $result ) {
						throw new Exception( __( 'Refund failed', 'competitions-for-woocommerce' ) );
					} else {
						// Create the refund object
						$refund = wc_create_refund(
							array(
								'amount'     => $refund_amount,
								'reason'     => $refund_reason,
								'order_id'   => $order_id,
								'line_items' => $line_items,
							)
						);

						if ( is_wp_error( $refund ) ) {
							throw new Exception( $refund->get_error_message() );
						}

						add_post_meta( $product_id, '_competition_order_refunded', $order_id );
					}

					// Trigger notifications and status changes
					if ( $order->get_remaining_refund_amount() > 0 || ( $order->has_free_item() && $order->get_remaining_refund_items() > 0 ) ) {
					/**
					 * Woocommerce_order_partially_refunded.
					 *
					 * @since 2.4.0
					 * Note: 3rd arg was added in err. Kept for bw compat. 2.4.3.
					 */
						do_action( 'woocommerce_order_partially_refunded', $order_id, $refund->id, $refund->id );
					} else {
						do_action( 'woocommerce_order_fully_refunded', $order_id, $refund->id );

						$order->update_status( apply_filters( 'woocommerce_order_fully_refunded_status', 'refunded', $order_id, $refund->id ) );
						$response_data['status'] = 'fully_refunded';
					}

					do_action( 'woocommerce_order_refunded', $order_id, $refund->id );

					// Clear transients
					wc_delete_shop_order_transients( $order_id );
					$succes[ $order_id ] = __( 'Refunded', 'woocommerce' );

				} elseif ( isset( $payment_gateways[ $payment_method ] ) && ! $payment_gateways[ $payment_method ]->supports( 'refunds' ) ) {
					$error[ $order_id ] = esc_html__( 'Payment gateway does not support refunds', 'competitions-for-woocommerce' );
				}
			} catch ( Exception $e ) {
				if ( $refund && is_a( $refund, 'WC_Order_Refund' ) ) {
					wp_delete_post( $refund->id, true );
				}

				$error[ $order_id ] = $e->getMessage();
			}
		}

		wp_send_json(
			array(
				'error'  => $error,
				'succes' => $succes,
			)
		);

	}

	/**
	 * Get the orders for a product
	 *
	 * @return array
	 */
	public static function get_product_orders( $id ) {
		global $wpdb;

		if ( is_wp_error( $id ) ) {
			return $id;
		}

		$order_ids = $wpdb->get_col(
			$wpdb->prepare(
				"SELECT order_id
				FROM {$wpdb->prefix}woocommerce_order_items
				WHERE order_item_id IN ( SELECT order_item_id FROM {$wpdb->prefix}woocommerce_order_itemmeta WHERE meta_key = '_product_id' AND meta_value = %d )
				AND order_item_type = 'line_item' ", $id
			)
		);

		if ( empty( $order_ids ) ) {
			return array( 'orders' => array() );
		}

		return $order_ids;

	}





}
Competitions_For_Woocommerce_Ajax::init();

