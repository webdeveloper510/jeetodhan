<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Competition Product Class
 *
 * @class WC_Product_Competition
 * 
 */ 
class WC_Product_Competition extends WC_Product {

	public $post_type    = 'product';
	public $product_type = 'competition';
	public $is_closed;
	public $is_started;

	/**
	 * __construct function.
	 *
	 * @param mixed $product
	 * 
	 */
	public function __construct( $product ) {

		if ( is_array( $this->data ) ) {
			$this->data = array_merge( $this->data, $this->extra_data );
		}
		parent::__construct( $product );
		$this->is_closed  = $this->is_closed();
		$this->is_started = $this->is_started();
	}

	/**
	 * Returns the unique ID for this object.
	 *
	 * @return int
	 */
	public function get_id() {
		return $this->id; 
	}

	/**
	 * Get internal type.
	 *
	 * @return string
	 */
	public function get_type() {
		return 'competition';
	}
	/**
	 * Get remaining seconds till competition end
	 *
	 * @return mixed
	 * 
	 */      
	public function get_seconds_remaining() {
		if ( $this->get_competition_dates_to() ) {
			return strtotime( $this->get_competition_dates_to() ) - ( get_option( 'gmt_offset' ) * 3600 );
		} else {
			return false;
		}
	}    
	/**
	 * Get seconds till competition starts
	 *
	 * @return mixed
	 * 
	 */      
	public function get_seconds_to_competition() {
		if ( $this->get_competition_dates_from() ) {
			return strtotime( $this->get_competition_dates_from() ) - ( get_option( 'gmt_offset' ) * 3600 );
		} else {
			return false;
		}
	}    
	/**
	 * Has competition started
	 *
	 * @return mixed
	 * 
	 */ 
	public function is_started() {

		if ( '1' === $this->get_competition_has_started() ) {
			return true;
		}
		$id                     = $this->get_main_wpml_product_id();
		$competition_dates_form = $this->get_competition_dates_from();
		if ( ! empty( $competition_dates_form ) ) {
			$date1 = new DateTime($competition_dates_form);
			$date2 = new DateTime(current_time('mysql'));
			if ($date1 < $date2) {
					update_post_meta( $id, '_competition_has_started', '1');
					delete_post_meta( $id, '_competition_started');
					do_action('woocommerce_competition_started', $id);

			} else {
					update_post_meta( $id, '_competition_started', '0');
			}

			return ( $date1 < $date2 );
		} else {
			update_post_meta( $id, '_competition_started', '0');
			return false;
		}
	}    

	/**
	 * Has competition met min participants limit
	 *
	 * @return mixed
	 */
	public function is_min_tickets_met() {

		$min_tickets                    = $this->get_min_tickets();
		$competition_participants_count = $this->get_competition_participants_count();

		if ( !empty($min_tickets) && $competition_participants_count ) {
			return ( intval($competition_participants_count) >= intval($min_tickets) );
		}			
		return true;
	}    
	/**
	 * Has competition met max participants limit
	 *
	 * @return mixed
	 */
	public function is_max_tickets_met() {
		
		$max_tickets                    = $this->get_max_tickets();
		$competition_participants_count = $this->get_competition_participants_count();

		if ( !empty($max_tickets) ) {
			return ( $competition_participants_count >= $max_tickets );
		} else {
			return false;
		}
		
		return true;
	}    
	/**
	 * Has competition finished
	 *
	 * @return mixed
	 */
	public function is_finished() {
		$competition_dates_to = $this->get_competition_dates_to();
		if ( ! empty( $competition_dates_to ) ) {
			$date1 = new DateTime($competition_dates_to);
			$date2 = new DateTime(current_time('mysql'));
			return ( $date1 < $date2 );
		} else {
			return false;
		}
	}	
	/**
	 * Is competition closed
	 *
	 * @return bool
	 */
	public function is_closed() {
		global $wpdb;

		$id = $this->get_main_wpml_product_id();

		if ($this->get_competition_closed() && in_array($this->get_competition_closed(), array('1','2'), true ) ) {
			return true;
		} else {
			
			if ( ( $this->is_finished() && $this->is_started() ) || ( 'yes' === get_option( 'competitions_for_woocommerce_close_when_max' ) && $this->is_max_tickets_met() )  ) {

				if ( get_post_meta( $this->get_main_wpml_product_id(), '_order_hold_on', true ) ) {
					return true;
				}

				$result = $wpdb->get_var(
					$wpdb->prepare(
					"	SELECT meta_value
						FROM $wpdb->postmeta
						WHERE meta_key = '_competition_closed'
						AND post_id = %d ",
						$id
					)
				);
				if ( $result ) {
					return true;
				}
				update_post_meta( $id, '_competition_closed', 'true');

				$participants = $this->get_competition_participants() ;

				if ( empty( $this->get_competition_participants_count() ) ) {
					
					update_post_meta( $id, '_competition_closed', '1');
					update_post_meta( $id, '_competition_fail_reason', '1');
					$order_id = false;
					do_action('wc_competition_close', $id);
					do_action('wc_competition_fail', array('competition_id' => $id , 'reason' => esc_html__('There were no participants', 'competitions_for_woocommerce') ));
					return false;
				}
				
				if ( false === $this->is_min_tickets_met() ) {
					
					update_post_meta( $id, '_competition_closed', '1');
					update_post_meta( $id, '_competition_fail_reason', '2');
					$order_id = false;
					do_action('wc_competition_close', $id);
					do_action('wc_competition_min_fail', array('participants' => $participants, 'product_id' => $id ));
					do_action('wc_competition_fail', array('competition_id' => $id , 'reason' => esc_html__('The item did not make it to minimum participants', 'competitions_for_woocommerce') ));
					return false;
					
				}

				$participants = apply_filters( 'woocommerce_competition_participants', $participants, $id, $this );

				delete_post_meta( $id, '_competition_winners');
				
				$winners = array();

				$use_ticket_numbers = get_post_meta( $id, '_competition_use_pick_numbers', true );

				if ( 'yes' !== get_post_meta( $id, '_competition_manualy_winners', true ) ) {


					$paricipants = $this->get_competition_draw_participants( '', $id, $this );

					$picked_winners = false;

					if ( $paricipants ) {
						$picked_winners = $this->pick_competition_winers_from_array( $paricipants, $this );
					}

					$winners = apply_filters( 'woocommerce_competition_winners', $picked_winners, $id, $this );

					if ( $winners ) {
						update_post_meta( $id, '_competition_winners', $winners );
					}


				}
				foreach ($winners as $key => $userid) {
					add_user_meta( $userid, '_competition_win', $id);
					add_user_meta( $userid, '_competition_win_' . $id . '_position', $key );
				}

				update_post_meta( $id, '_competition_closed', '2');

				if ( 'yes' !== get_post_meta( $id, '_competition_manualy_winners', true ) ) {
					do_action('wc_competition_close', $id);
					do_action('wc_competition_won', $id);
				}

				return true;

			} else {

				return false;

			}	
		}
	}	
	/**
	 * Get competition history
	 *
	 * @return object
	 * 
	 */     
	public function competition_history( $datefrom = false, $user_id = false ) {

		global $wpdb;
		
		$wheredatefrom = '';
		$relisteddate = '';

		$id = $this->get_main_wpml_product_id();

		$history = wp_cache_get( 'competition_history' . $user_id . $id , 'competitions_for_woocommerce' );

		if ( false === $history ) {

			$relisteddate = get_post_meta( $id, '_competition_relisted', true );

			if ( ! is_admin() && !empty($relisteddate) ) {
				$datefrom = $relisteddate;
			}

			if ( $datefrom ) {
				if ( $user_id ) {
					$history = $wpdb->get_results( $wpdb->prepare( 'SELECT * FROM ' . $wpdb->prefix . 'cfw_log WHERE competition_id = %d AND CAST(date AS DATETIME) > %s AND userid = %d   ORDER BY  `date` DESC' , $id, $datefrom, $user_id ) );
				} else {
					$history = $wpdb->get_results( $wpdb->prepare( 'SELECT * FROM ' . $wpdb->prefix . 'cfw_log WHERE competition_id = %d AND CAST(date AS DATETIME) > %s   ORDER BY  `date` DESC' , $id, $datefrom ) );
				}
			} else {
				if ( $user_id ) {
					$history = $wpdb->get_results( $wpdb->prepare( 'SELECT * FROM ' . $wpdb->prefix . 'cfw_log WHERE competition_id = %d AND userid = %d   ORDER BY  `date` DESC' , $id, $user_id ) );
				} else {
					$history = $wpdb->get_results( $wpdb->prepare( 'SELECT * FROM ' . $wpdb->prefix . 'cfw_log WHERE competition_id = %d  ORDER BY  `date` DESC' , $id ) );
				}
			}
			wp_cache_set( 'competition_history' . $user_id . $id, $history, 'competitions_for_woocommerce' );
		}

		return apply_filters( 'woocomerce_competition_history', $history, $id, $user_id, $relisteddate );
	}
	
	
	/**
	 * Wrapper for get_permalink
	 * 
	 * @return string
	 * 
	 */
	public function get_permalink() {
		
			$id = $this->get_main_wpml_product_id();
			return get_permalink( $id );
	}
	/**
	 * Is user participating in competition
	 *
	 * @return bool
	 */ 
	public function is_user_participating( $userid = false ) {
	   global $wpdb;
		if ( !$userid ) {
			$userid = get_current_user_id();
		}

		$id           = $this->get_main_wpml_product_id();
		$result = wp_cache_get( 'is_user_participating' . $userid . $id , 'competitions_for_woocommerce' );

		if ( false === $result ) {

			$relisteddate = get_post_meta( $id, '_competition_relisted', true );

			if ( $relisteddate ) {
				$result = $wpdb->get_row(
				$wpdb->prepare(
					'SELECT      1
					FROM ' . $wpdb -> prefix . 'cfw_log
					WHERE       competition_id = %d
					AND  userid = %d
					AND CAST(date AS DATETIME) > %s',
				$id,
				$userid,
				$relisteddate
				)
			);
			} else {
				$result = $wpdb->get_row(
					$wpdb->prepare(
						'SELECT      1
			   	        FROM ' . $wpdb -> prefix . 'cfw_log
			   	        WHERE       competition_id = %d
			   	        AND  userid = %d',
					$id,
					$userid
					)
			   );
			}
			wp_cache_set( 'is_user_participating' . $userid . $id, $result, 'competitions_for_woocommerce' );
		}

	   
		if ( null !== $result ) {
			return true;
		} else {
			return false;
		}
		return false;
	}

	/**
	 * Is user participating in competition
	 *
	 * @return bool
	 */
	public function is_user_winner( $userid = false ) {

		if ( !$userid ) {
			$userid = get_current_user_id();
		}

		$winners = $this->get_competition_winners();
		if ( is_array( $winners ) ) {
			foreach ( $winners as $winner ) {
				if ( !empty ( $winner ) && intval( $winner['userid'] ) === $userid ) {
					return true;
				}
			}
		}
		return false;

	}

	public function get_user_tickets( $userid = false ) {
	   global $wpdb;

		if ( !$userid ) {
			$userid = get_current_user_id();
		}

		$id = $this->get_main_wpml_product_id();


		$user_tickets = wp_cache_get( 'get_user_tickets_' . $userid . $id , 'competitions_for_woocommerce' );

		if ( false === $user_tickets ) {
			$relisteddate = get_post_meta( $id, '_competition_relisted', true );
			if ( $relisteddate ) {
				$user_tickets = $wpdb->get_results(
					$wpdb->prepare(
						'SELECT *
						FROM ' . $wpdb -> prefix . 'cfw_log
						WHERE       competition_id = %d
						AND  userid = %d
						AND CAST(date AS DATETIME) > %s	',
						$id,
						$userid,
						$relisteddate
					)
				);
			} else {
				$user_tickets = $wpdb->get_results(
					$wpdb->prepare(
						'SELECT *
						FROM ' . $wpdb -> prefix . 'cfw_log
						WHERE       competition_id = %d
						AND  userid = %d ',
						$id,
						$userid
					)
				);
			}
			wp_cache_set( 'get_user_tickets_' . $userid . $id, $user_tickets, 'competitions_for_woocommerce' );
		}

	   return $user_tickets;
	}

	/**
	 * Is user participating in competition
	 *
	 * @return int
	 * 
	 */ 

	public function count_user_tickets( $userid = false ) {
		global $wpdb;

		$id           = $this->get_main_wpml_product_id();
		$relisteddate = get_post_meta( $id, '_competition_relisted', true );

		if ( !$userid ) {
			$userid = get_current_user_id();
		}
		$user_tickets = wp_cache_get( 'count_user_tickets_' . $userid . $id , 'competitions_for_woocommerce' );

		if ( false === $user_tickets ) {
			if ( $relisteddate ) {
				$user_tickets = $wpdb->get_var(
					$wpdb->prepare(
						'SELECT COUNT(1)
						FROM ' . $wpdb -> prefix . 'cfw_log
						WHERE       competition_id = %d
						AND  userid = %d
						AND CAST(date AS DATETIME) > %s',
						$id,
						$userid,
						$relisteddate
					)
				);
			} else {
				$user_tickets = $wpdb->get_var(
					$wpdb->prepare(
						'SELECT COUNT(1)
						FROM ' . $wpdb -> prefix . 'cfw_log
						WHERE       competition_id = %d
						AND  userid = %d',
						$id,
						$userid
					)
				);
			}
			wp_cache_set( 'count_user_tickets_' . $userid . $id, $user_tickets, 'competitions_for_woocommerce' );
		}

		return intval( $user_tickets );
	}



	/**
	 * Is user participating in competition
	 *
	 * @return int
	 * 
	 */ 

	public function count_user_tickets_in_cart( $userid = false ) {
		
		$id = $this->get_main_wpml_product_id();

		if ( !$userid ) {
			$userid = get_current_user_id();
		}
		$count = 0; // Initializing

		foreach ( wc()->cart->get_cart() as $cart_item_key => $values ) {

			if ( ! isset( $product_quantities[ $values['product_id'] ] ) ) {
				$product_quantities[ $values['product_id'] ] = 0;
			}
			if ( intval( $values['product_id'] ) === intval( $id ) ) {
				$count += $values['quantity'];
			}

		}

		 return intval( $count );


	}

	/**
	 * Get main product id for multilanguage purpose
	 *
	 * @return int
	 * 
	 */ 

	public function get_main_wpml_product_id() {

		global $sitepress;
		$_id = $this->get_id();
		if (function_exists('icl_object_id') && function_exists('pll_default_language')) { // Polylang with use of WPML compatibility mode
			$id = icl_object_id( $_id, 'product', false, pll_default_language() );
			if ( null === $id ) {
				$id = $this->id;
			}
		} elseif (function_exists('icl_object_id') && method_exists($sitepress, 'get_default_language')) { // WPML
			$id = icl_object_id($_id, 'product', false, $sitepress->get_default_language() );
			if ( null === $id ) {
				$id = $this->id;
			}
		} else {
			$id = $_id;
		}

		return $id;

	}

	/**
	 * Get the add to cart button text.
	 *
	 * @return string
	 */
	public function add_to_cart_text() {
		
		if ( $this->is_closed() ) {
		   
			$text =  esc_html__( 'View winners', 'competitions_for_woocommerce' );

		} elseif ( !$this->is_started() || $this->is_max_tickets_met() ) {

			$text = esc_html__( 'Read more', 'competitions_for_woocommerce' );

		} else {

			$text = esc_html__( 'Participate', 'competitions_for_woocommerce' );

		}

		return apply_filters( 'woocommerce_product_add_to_cart_text', $text, $this );
			



	}

	/**
	 * Get max quantity which can be purchased at once.
	 *
	 * @since  3.0.0
	 * @return int Quantity or -1 if unlimited.
	 */
	public function get_max_purchase_quantity() {
		$max_tickets_per_user = $this->get_max_tickets_per_user() ? intval( $this->get_max_tickets_per_user() ): false;
		if ( false !== $max_tickets_per_user ) {
			if ( is_cart() ) {
				$user_tickets        = $this->count_user_tickets();
				$max_ticket_for_user = intval($max_tickets_per_user) - intval($user_tickets);
				return ( $this->get_stock_quantity() > $max_ticket_for_user ) ? $max_ticket_for_user : $this->get_stock_quantity();
			}
			$max_tickets_per_user = $max_tickets_per_user - $this->count_user_tickets_in_cart();
			if ( is_user_logged_in() ) {
				$user_tickets        = $this->count_user_tickets();
				$max_ticket_for_user = intval($max_tickets_per_user) - intval($user_tickets);
				return ( $this->get_stock_quantity() > $max_ticket_for_user ) ? $max_ticket_for_user : $this->get_stock_quantity();
			}
			return ( $this->get_stock_quantity() > $max_tickets_per_user ) ? $max_tickets_per_user : $this->get_stock_quantity();
		} 
		if ( $this->is_sold_individually() ) {
			return 1;
		}
		return $this->get_stock_quantity();
	}


	/**
	 * Get competition start date .
	 *
	 * @since 1.1
	 * @param  string $context
	 * @return string
	 */
	public function get_competition_dates_from() {
		
		return get_post_meta( $this->get_main_wpml_product_id(), '_competition_dates_from', true );
		
	}

	/**
	 * Get competition end date .
	 *
	 * @since 1.1
	 * @param  string $context
	 * @return string
	 */
	public function get_competition_dates_to() {
		
		return get_post_meta( $this->get_main_wpml_product_id(), '_competition_dates_to', true );
	}
	 /**
	 * Get competition min tickets .
	 *
	 * @since 1.1
	 * @param  string $context
	 * @return string
	 */
	public function get_min_tickets() {
		 
		return intval( get_post_meta( $this->get_main_wpml_product_id(), '_competition_min_tickets', true ) );
	}
	 /**
	 * Get competition max tickets .
	 *
	 * @since 1.1
	 * @param  string $context
	 * @return string
	 */
	public function get_max_tickets() {
		 
		return intval( get_post_meta( $this->get_main_wpml_product_id(), '_competition_max_tickets', true ) );
		
	}

	/**
	 * Get competition participants count .
	 *
	 * @since 1.1
	 * @param  string $context
	 * @return string
	 */
	public function get_competition_participants_count( $context = 'view' ) {

		global $wpdb;
		$wheredatefrom ='';
		$id = $this->get_main_wpml_product_id();

		$participants_count = wp_cache_get( 'competition_participants_count' . $id, 'competitions_for_woocommerce' );

		if ( false === $participants_count || 'edit' === $context ) {

			$id = $this->get_main_wpml_product_id();

			$relisteddate = get_post_meta( $id, '_competition_relisted', true );

			if ( $relisteddate ) {
				$participants_count = $wpdb->get_var(
					$wpdb->prepare(
						'SELECT COUNT(1)
						FROM ' . $wpdb -> prefix . 'cfw_log
						WHERE competition_id = %d
						AND CAST(date AS DATETIME) > %s',
						$id,
						$relisteddate
					)
				);

			} else {

				$participants_count = $wpdb->get_var( $wpdb->prepare( 'SELECT COUNT(1) FROM ' . $wpdb -> prefix . 'cfw_log WHERE competition_id = %d', $id )	);
			}
			wp_cache_set( 'competition_participants_count' . $id, $participants_count, 'competitions_for_woocommerce' );
		}


		return intval( $participants_count );

	}

	public function get_competition_participants() {
		global $wpdb;
		$id           = $this->get_main_wpml_product_id();
		$participants = wp_cache_get( 'competition_participants' . $id, 'competitions_for_woocommerce' );
		if ( false === $participants ) {
			$relisteddate = get_post_meta( $id, '_competition_relisted', true );
			if ( $relisteddate ) {
				$participants = $wpdb->get_col(
					$wpdb->prepare(
						'SELECT userid
						FROM ' . $wpdb -> prefix . 'cfw_log
						WHERE       competition_id = %d
						AND CAST(date AS DATETIME) > %s',
						$id,
						$relisteddate
					)
				);
			} else {
				$participants = $wpdb->get_col(
					$wpdb->prepare(
						'SELECT      userid
						FROM ' . $wpdb -> prefix . 'cfw_log
						WHERE       competition_id = %d',
						$id
					)
				);
			}
			wp_cache_set( 'competition_participants' . $id, $participants, 'competitions_for_woocommerce' );
		}

		return $participants;
	}

	/**
	 * Get competition closed status.
	 *
	 * @since 1.1
	 * @param  string $context
	 * @return string
	 */
	public function get_competition_closed() {
		return get_post_meta( $this->get_main_wpml_product_id(), '_competition_closed', true );
		
	}
	/**
	 * Get competition started status.
	 *
	 * @since 1.1
	 * @param  string $context
	 * @return string
	 */
	public function get_competition_started() {
		 
		return get_post_meta( $this->get_main_wpml_product_id(), '_competition_started', true );
		
	}
	/**
	 * Get competition has_started status.
	 *
	 * @since 1.1
	 * @param  string $context
	 * @return string
	 */
	public function get_competition_has_started() {
		 
		return get_post_meta( $this->get_main_wpml_product_id(), '_competition_has_started', true );
		
	}

	/**
	 * Get competition closed status.
	 *
	 * @since 1.1
	 * @param  string $context
	 * @return string
	 */
	public function get_competition_fail_reason() {

		return get_post_meta( $this->get_main_wpml_product_id(), '_competition_fail_reason', true );
		
	}

  
	
	/**
	 * Get competition number of winners.
	 *
	 * @since 1.1
	 * @param  string $context
	 * @return string
	 */
	public function get_competition_num_winners() {
		 
		return get_post_meta( $this->get_main_wpml_product_id(), '_competition_num_winners', true );
		
	}

	/**
	 * Get competition multiple winner per user.
	 *
	 * @since 1.1
	 * @param  string $context
	 * @return string
	 */
	public function get_competition_multiple_winner_per_user() {
		 
		return get_post_meta( $this->get_main_wpml_product_id(), '_competition_multiple_winner_per_user', true );
		
	}


	/**
	 * Get competition max ticket per user
	 *
	 * @since 1.1
	 * @param  string $context
	 * @return string
	 */
	public function get_max_tickets_per_user() {

		return get_post_meta( $this->get_main_wpml_product_id(), '_competition_max_tickets_per_user', true );
		
	}

	/**
	 * Get get_competition_relisted
	 *
	 * @since 1.2.8
	 * @param  string $context
	 * @return string
	 */
	public function get_competition_relisted() {

		return get_post_meta( $this->get_main_wpml_product_id(), '_competition_relisted', true );
		
	}

	/**
	 * Get get_competition_relisted
	 *
	 * @since 1.2.8
	 * @param  string $context
	 * @return string
	 */
	public function get_competition_winners() {
		return get_post_meta( $this->get_main_wpml_product_id(), '_competition_winners', true );

	}
	
	public function competition_update_lookup_table() {
		global $wpdb;

		$id            = absint( $this->get_main_wpml_product_id() );
		$table         = 'wc_product_meta_lookup';
		$existing_data = wp_cache_get( 'lookup_table', 'object_' . $id );
		$update_data   = $this->competition_get_data_for_lookup_table( $id );

		if ( ! empty( $update_data ) && $update_data !== $existing_data ) {
			$wpdb->replace(
				$wpdb->$table,
				$update_data
			);
			wp_cache_set( 'lookup_table', $update_data, 'object_' . $id );
		}
	}

	public function competition_get_data_for_lookup_table( $id ) {

		$price_meta   = (array) get_post_meta( $id, '_price', false );
		$manage_stock = get_post_meta( $id, '_manage_stock', true );
		$stock        = 'yes' === $manage_stock ? wc_stock_amount( get_post_meta( $id, '_stock', true ) ) : null;
		$price        = wc_format_decimal( get_post_meta( $id, '_price', true ) );
		$sale_price   = wc_format_decimal( get_post_meta( $id, '_sale_price', true ) );
		return array(
			'product_id'     => absint( $id ),
			'sku'            => get_post_meta( $id, '_sku', true ),
			'virtual'        => 'yes' === get_post_meta( $id, '_virtual', true ) ? 1 : 0,
			'downloadable'   => 'yes' === get_post_meta( $id, '_downloadable', true ) ? 1 : 0,
			'min_price'      => reset( $price_meta ),
			'max_price'      => end( $price_meta ),
			'onsale'         => $sale_price && $price === $sale_price ? 1 : 0,
			'stock_quantity' => $stock,
			'stock_status'   => get_post_meta( $id, '_stock_status', true ),
			'rating_count'   => array_sum( (array) get_post_meta( $id, '_wc_rating_count', true ) ),
			'average_rating' => get_post_meta( $id, '_wc_average_rating', true ),
			'total_sales'    => get_post_meta( $id, 'total_sales', true ),
		);
	}

	/**
	 * Get the add to cart button text for the single page.
	 *
	 * @return string
	 */
	public function single_add_to_cart_text() {
		if ( 'incl' === get_option( 'woocommerce_tax_display_shop' ) ) {
			$unformated_price = wc_get_price_including_tax( $this );
		} else {
			$unformated_price = wc_get_price_excluding_tax( $this );
		}

		/* translators: 1) data-price 2) data-id 3) price */
		$text = sprintf( __( 'Participate now for <span class="atct-price" data-price="%1$s" data-id="%2$d">%3$s</span>', 'competitions_for_woocommerce' ), $unformated_price, $this->get_id(), $unformated_price ? wc_price($unformated_price) : esc_html__('free', 'woocommerce')	);
		return  wp_kses_post( apply_filters( 'woocommerce_product_single_add_to_cart_text', $text, $this ) );
	}

	/**
	 * Get competition draw participants.
	 *
	 */
	public function get_competition_draw_participants() {
		global $wpdb;
		$paricipants        = array();
		$id                 = absint( $this->get_main_wpml_product_id() );
		$use_ticket_numbers = get_post_meta( $id, '_competition_use_pick_numbers', true );
		$true_answers       = competitions_for_woocommerce_get_true_answers( $id );
		$relisteddate       = get_post_meta( $id, '_competition_relisted', true );


		if ( competitions_for_woocommerce_use_answers( $id ) && $true_answers ) {
			$answers_ids = array_keys( $true_answers );
			$answers_ids = join( ',', $answers_ids );
			if ( $relisteddate ) {

				$paricipants = $wpdb->get_results(
					$wpdb->prepare(
					'SELECT *
					FROM ' . $wpdb->prefix . 'cfw_log
					WHERE competition_id = %d AND answer_id IN ( %s ) AND CAST(date AS DATETIME) > %s', $id, $answers_ids , $relisteddate
					),
					ARRAY_A
				);
			} else {
				$paricipants = $wpdb->get_results(
					$wpdb->prepare(
					'SELECT *
					FROM ' . $wpdb->prefix . 'cfw_log
					WHERE competition_id = %d AND answer_id IN ( %s )  ', $id, $answers_ids
					),
					ARRAY_A
				);
			}

		} else {

			if ( $relisteddate ) {

				$paricipants = $wpdb->get_results(
					$wpdb->prepare(
					'SELECT *
					FROM ' . $wpdb->prefix . 'cfw_log
					WHERE competition_id = %d  AND CAST(date AS DATETIME) > %s', $id, $relisteddate
					),
					ARRAY_A
				);

			} else {

				$paricipants = $wpdb->get_results(
					$wpdb->prepare(
					'SELECT *
					FROM ' . $wpdb->prefix . 'cfw_log
					WHERE competition_id = %d  ', $id
					),
					ARRAY_A
				);
			}

		}
		return $paricipants;

	}
	/**
	 * Pick competition winners from array.
	 *
	 */
	public function pick_competition_winers_from_array( $participants ) {
		$winners = array();
		if ( is_array( $participants ) ) {
			$i = 0;

			$competition_num_winners = $this->get_competition_num_winners() ? $this->get_competition_num_winners() : 1;

			while ( $i <= ( $competition_num_winners - 1 ) ) {
				$winner_id = '';
				if ( 1 === count( $participants ) ) {
					$winners_key[ $i ] = 0;
				} else {
					$winners_key[ $i ] = wp_rand( 0, count( $participants ) - 1 );
				}

				$winners[] = $participants[ $winners_key[ $i ] ];
				$winner_id = $participants[ $winners_key[ $i ] ]['userid'];

				if ( 'yes' !== $this->get_competition_multiple_winner_per_user() ) {
					unset( $participants[ $winners_key[ $i ] ] );
				} else {
					foreach ( $participants as $key => $participant ) {
						if ( $participant['userid'] === $winner_id ) {
							unset( $participants[ $key ] );
						}
					}
				}

				$participants = array_values( $participants );
				$i++;
				if ( count( $participants ) <= 0 ) {
					break;
				}
			}
		}
		return $winners;
	}
	

}
