<?php

function competitions_for_woocommerce_get_taken_numbers( $product_id = false, $user_id = false, $context = 'edit'  ) {
	global $product;

	$wheredatefrom = '';
	$result        = false;

	if ( ! $product_id && $product ) {
			$product_id = $product->get_id();
	}

	$taken_numbers = wp_cache_get( 'competitions_for_woocommerce_get_taken_numbers_' . $product_id , 'competitions_for_woocommerce' );
	if ( false === $taken_numbers || 'edit' === $context ) {
		global $wpdb;

		$relisteddate = get_post_meta( $product_id, '_competition_relisted', true );

		if ( $relisteddate ) {
			$taken_numbers = $wpdb->get_col(
						$wpdb->prepare(
							'SELECT ' . $wpdb->prefix . 'cfw_log.ticket_number
							FROM ' . $wpdb->prefix . 'cfw_log
							WHERE ' . $wpdb->prefix . 'cfw_log.competition_id = %d
							AND CAST(' . $wpdb->prefix . 'cfw_log.date AS DATETIME) > %s' ,
							$product_id, $relisteddate ) );
		} else {

			$taken_numbers = $wpdb->get_col(
						$wpdb->prepare(
							'SELECT ' . $wpdb->prefix . 'cfw_log.ticket_number
							FROM ' . $wpdb->prefix . 'cfw_log
							WHERE ' . $wpdb->prefix . 'cfw_log.competition_id = %d ',
							$product_id ) );
		}
		wp_cache_set( 'competitions_for_woocommerce_get_taken_numbers_' . $product_id, $taken_numbers, 'competitions_for_woocommerce' );
	}

	return $taken_numbers;
}


function competitions_for_woocommerce_get_reserved_numbers( $product_id = false, $session_key = false, $context = 'edit' ) {
	global $product;

	if ( ! $product_id && $product ) {
			$product_id = $product->get_id();
	}
	$reserved_numbers = wp_cache_get( 'competitions_for_woocommerce_get_reserved_numbers_' . $product_id , 'competitions_for_woocommerce' );
	if ( false === $reserved_numbers || 'edit' === $context) {
		global $wpdb;

		$minutes = get_option( 'competition_answers_reserved_minutes', '5' );

		$delete_reserved_numbers = wp_cache_get( 'delete_reserved_numbers', 'competitions_for_woocommerce' );
		if ( false === $delete_reserved_numbers ) {
			$wpdb->query( $wpdb->prepare( 'DELETE FROM ' . $wpdb->prefix . 'cfw_log_reserved WHERE date < (NOW() - INTERVAL %d MINUTE)', $minutes ) );
			wp_cache_set( 'delete_reserved_numbers', '1', 'competitions_for_woocommerce' );
		}

		if ( ! $session_key ) {
			$reserved_numbers = $wpdb->get_col( $wpdb->prepare( 'SELECT ' . $wpdb->prefix . 'cfw_log_reserved.ticket_number FROM ' . $wpdb->prefix . 'cfw_log_reserved  WHERE ' . $wpdb->prefix . 'cfw_log_reserved.competition_id = %d ', $product_id ) );
		} else {
			$reserved_numbers = $wpdb->get_col( $wpdb->prepare( 'SELECT ' . $wpdb->prefix . 'cfw_log_reserved.ticket_number FROM ' . $wpdb->prefix . 'cfw_log_reserved  WHERE ' . $wpdb->prefix . 'cfw_log_reserved.competition_id = %d AND session_key != %s', $product_id, $session_key ) );
		}
		wp_cache_set( 'competitions_for_woocommerce_get_reserved_numbers_' . $product_id, $reserved_numbers, 'competitions_for_woocommerce' );
	}

	return $reserved_numbers;
}


function competitions_for_woocommerce_get_true_answers( $product_id = false ) {
	global $product;

	$answers_id = array();

	if ( ! $product_id && $product ) {
			$product_id = $product->get_id();
	}

	$answers = maybe_unserialize( get_post_meta( $product_id, '_competition_answers', true ) );
	if ( $answers ) {
		foreach ( $answers as $key => $answer ) {
			if ( 1 === $answer['true'] ) {
					$answers_id[ $key ] = $answer['text'];
			}
		}
	}

	return $answers_id;
}


function competitions_for_woocommerce_get_ticket_numbers_from_cart( $product_id = false ) {
	$items          = WC()->cart->get_cart();
	$ticket_numbers = array();
	foreach ( $items as $key => $value ) {
		if ( isset( $ticket_numbers[ $value['product_id'] ] ) ) {
			$ticket_numbers[ $value['product_id'] ] = array_merge( $ticket_numbers[ $value['product_id'] ], $value['competition_tickets_number'] );
		} elseif ( isset( $value['competition_tickets_number'] ) ) {
			$ticket_numbers[ $value['product_id'] ] = $value['competition_tickets_number'];
		}
	}
	if ( $product_id ) {
		return isset( $ticket_numbers[ $product_id ] ) ? $ticket_numbers[ $product_id ] : array();
	}
	return $ticket_numbers;
}


function competitions_for_woocommerce_use_answers( $product_id = false ) {

	global $product;

	if ( ! $product_id && $product ) {
			$product_id = $product->get_id();
	}

	$use_answers = get_post_meta( $product_id, '_competition_use_answers', true );

	if ( 'yes' !== $use_answers ) {
		return false;
	}

	$competition_question = get_post_meta( $product_id, '_competition_question', true );

	if ( ! $competition_question ) {
		return false;
	}

	$answers = maybe_unserialize( get_post_meta( $product_id, '_competition_answers', true ) );
	if ( ! $answers ) {
		return false;
	}

	return true;
}


function competitions_for_woocommerce_generate_random_ticket_numbers( $product_id, $qty ) {

	$random_tickets = array();

	$available_tickets = competitions_for_woocommerce_get_available_ticket( $product_id );
	if ( empty( $available_tickets ) || count( $available_tickets ) < $qty ) {
		return false;
	}

	$random_tickets =   (array) array_rand( array_flip ($available_tickets) , $qty);
	if ( !empty( $random_tickets ) ) {

		$session_key = WC()->session->get_customer_id();
		competitions_for_woocommerce_reserve_ticket($product_id, $random_tickets, $session_key);
	} 

	if ( empty( $random_tickets ) ) {
		return false;
	}
	
	return apply_filters( 'competitions_for_woocommerce_generate_random_ticket_numbers', $random_tickets, $product_id, $qty );
}


function competitions_for_woocommerce_reserve_ticket( $competition_id, $ticket_number, $session_key ) {
	global $wpdb;
	$result = false;

	$override = apply_filters( 'woocommerce_competition_reserve_ticket_override', false, $competition_id, $ticket_number, $session_key);
	if ( $override ) {
			return $override;
	}

	if ( is_array( $ticket_number ) && ! empty( $ticket_number ) ) {

		$i = 0;
		while ( $i < count($ticket_number) ) {
			$result = $wpdb->query( $wpdb->prepare( 'INSERT IGNORE INTO ' . $wpdb->prefix . 'cfw_log_reserved (competition_id, ticket_number, session_key) VALUES  (%d, %d, %s)', $competition_id, $ticket_number[$i], $session_key ) );
			$i++;
		}

	} else {
		$result = $wpdb->query( $wpdb->prepare( 'INSERT IGNORE INTO ' . $wpdb -> prefix . 'cfw_log_reserved (competition_id, ticket_number, session_key) VALUES ( %d, %d, %s)', $competition_id, $ticket_number, $session_key) );
	}

	return $result;
}


function competitions_for_woocommerce_get_int_number_from_alphabet( $alphabet_number, $product) {

	if ( ! $product ) {
		return $alphabet_number;
	}
	$max_tickets = intval( $product->get_max_tickets() );
	$tabnumbers  = get_post_meta( $product->get_id() , '_competition_pick_number_tab_qty', true );
	$tabnumbers  = $tabnumbers ? intval( $tabnumbers )  : 100;

	if ( $max_tickets > $tabnumbers * 26 ) {
		$tabnumbers = ceil ( $max_tickets / 26 );
	}

	$alphabet          = array_flip  ( range('A', 'Z') );
	$letter            = $alphabet_number[0];
	$in                = $alphabet[ strtoupper( $letter )];
	$first_digits      = $in;
	$add_numbers       = $in * $tabnumbers;
	$int_ticket_number = intval( $add_numbers + intval( substr($alphabet_number, 1) ) );

	return $int_ticket_number;
}


function competitions_for_woocommerce_get_available_ticket( $product_id ) {

	$taken_numbers     = competitions_for_woocommerce_get_taken_numbers( $product_id, false, 'edit' );
	$reserved_numbers  = competitions_for_woocommerce_get_reserved_numbers( $product_id, false, 'edit' );
	$tickets_from_cart = competitions_for_woocommerce_get_ticket_numbers_from_cart( $product_id );
	$max_tickets       = intval( get_post_meta( $product_id, '_competition_max_tickets', true ) );
	$tickets           = range(1, $max_tickets);
	$available_tickets = array_diff ($tickets, $taken_numbers, $reserved_numbers, $tickets_from_cart);
	return $available_tickets;
}


function competitions_for_woocommerce_get_tickets_from_cart( $product_id ) {

	$tickets_in_cart = array();

	if ( ! WC()->cart->is_empty() ) {
		foreach ( WC()->cart->get_cart() as $cart_item ) {
			if ( $product_id === $cart_item['product_id'] ) {
				if ( isset( $cart_item[ 'competition_tickets_number' ] ) && $cart_item['competition_tickets_number'] && is_array( $cart_item['competition_tickets_number'] ) ) {
					$tickets_in_cart = array_merge($tickets_in_cart, $cart_item['competition_tickets_number']);
				}
			}

		}
	}
	return $tickets_in_cart;

}

if ( ! function_exists( 'competitions_for_woocommerce_get_finished_competitions_id' ) ) {
	/**
	* Return finished competition IDs
	*
	* @subpackage  Loop
	*
	*/
	function competitions_for_woocommerce_get_finished_competitions_id() {
		$args = array(
			'post_type'              => 'product',
			'posts_per_page'         => '-1',
			'tax_query'              => array( array( 'taxonomy' => 'product_type', 'field' => 'slug', 'terms' => 'competition' ) ),
			'meta_query'             => array(
											array(
											'key'                    => '_competition_closed',
											'compare'                => 'EXISTS',
											)
			),
			'is_competition_archive' => true,
			'show_past_competition'  => true,
			'fields'                 => 'ids',
		);

		$query = new WP_Query( $args );
		$woocommerce_competition_finished_competition_ids = $query->posts;
		return $woocommerce_competition_finished_competition_ids;
	}

}

if ( ! function_exists( 'competitions_for_woocommerce_get_future_competitions_id' ) ) {

	/**
	* Return future competition IDs
	*
	* @subpackage  Loop
	*
	*/
	function competitions_for_woocommerce_get_future_competitions_id() {
		$args = array(
			'post_type'              => 'product',
			'posts_per_page'         => '-1',
			'tax_query'              => array( array( 'taxonomy' => 'product_type', 'field' => 'slug', 'terms' => 'competition' ) ),
			'meta_query'             => array(
											array(
												'key'                    => '_competition_started',
												'value'                  => '0',
											)
			),
			'is_competition_archive' => true,
			'show_future_competitions'  => true,
			'show_past_competition'  => false,
			'fields'                 => 'ids',
		);

		$query = new WP_Query( $args );

		$woocommerce_competition_future_competitions_ids = $query->posts;
		return $woocommerce_competition_future_competitions_ids;
	}

}


if ( ! function_exists( 'competitions_for_woocommerce_get_user_competitions' ) ) {

	/**
	* Return user competition IDs
	*
	* @subpackage  Loop
	*
	*/
	function competitions_for_woocommerce_get_user_competitions( $user_id = false) {
		global $wpdb;

		if ( !$user_id ) {
			$user_id = get_current_user_id();
		}
		$result = $wpdb->get_col(
			$wpdb->prepare('
			SELECT  DISTINCT competition_id
			FROM ' . $wpdb -> prefix . 'cfw_log
			WHERE  userid = %d',
			$user_id
			));

	return 	$result;
	}

}

if ( ! function_exists( 'competitions_for_woocommerce_use_alphabet' ) ) {
	function competitions_for_woocommerce_use_alphabet( $post_id = false ) {
		if ( is_product() || is_admin()  ) {
			$post_id = !$post_id ? get_the_ID() : $post_id;
			if ( 'yes' === get_post_meta( $post_id , '_competition_pick_number_alphabet', true ) ) {
				add_filter( 'ticket_number_display_html', 'competitions_for_woocommerce_change_ticket_numbers_to_alphabet', 10, 2 );
				add_filter( 'ticket_number_tab_display_html', 'competitions_for_woocommerce_change_ticket_tab_to_alphabet', 10, 2 );
			}
		}
	}
}
if ( ! function_exists( 'competitions_for_woocommerce_change_ticket_numbers_to_alphabet' ) ) {

	function competitions_for_woocommerce_change_ticket_numbers_to_alphabet( $ticket_number, $product ) {

		$_ticket_number = $ticket_number;
		if ( ! $product || !$ticket_number ) {
			return $ticket_number;
		}
		$max_tickets = intval( $product->get_max_tickets() );
		$tabnumbers  = get_post_meta( $product->get_id() , '_competition_pick_number_tab_qty', true );
		$tabnumbers  = $tabnumbers ? intval( $tabnumbers ) : 100;

		if ( $max_tickets > $tabnumbers * 26 ) {
			$tabnumbers = ceil ( $max_tickets / 26 );
		}

		$tabnumbers = apply_filters( 'competition_numbers_to_alphabet_number_per_letter', $tabnumbers );
		$alphabet   = range('A', 'Z');
		$in         =  ( intval(( $ticket_number - 1 )/$tabnumbers) );

		if ( $in > 0 ) {
			$ticket_number = $ticket_number - ( $tabnumbers * $in );
		}

		$is_100 = $ticket_number % 100;

		if ('00' === $ticket_number && 0 === $is_100 ) {
			$ticket_number = '100';
		}

		$ticket_number = ltrim($ticket_number, 0 );

		if ( isset( $alphabet[$in] ) ) {
			$ticket_number = $alphabet[$in] . $ticket_number;
		} else {
			return $_ticket_number;
		}

		return $ticket_number;
	}
}
if ( ! function_exists( 'competitions_for_woocommerce_change_ticket_tab_to_alphabet' ) ) {

	function competitions_for_woocommerce_change_ticket_tab_to_alphabet( $tabnumbers, $product ) {

		if ( 'yes' !== get_post_meta( $product->get_id() , '_competition_pick_number_alphabet', true ) ) {
			return $tabnumbers;
		}

		$alphabet   = range('A', 'Z');
		$tabs       = get_post_meta( $product->get_id() , '_competition_pick_number_tab_qty', true );
		$tabs       = $tabs ? intval( $tabs )  : 100;
		$last_digit = substr($tabnumbers, strpos($tabnumbers, '-') + 1);
		$in         =  ( intval( $last_digit -1 ) / intval($tabs) );

		if ( isset( $alphabet[$in] ) ) {
			$tabnumbers = $alphabet[$in];
		}
		return $tabnumbers;
	}
}
if ( ! function_exists( 'competitions_for_woocommerce_get_main_wpml_product_id' ) ) {

	function competitions_for_woocommerce_get_main_wpml_product_id( $product_id ) {

		return intval( apply_filters( 'wpml_object_id', $product_id, 'product', false, apply_filters( 'wpml_default_language', null ) ) );

	}

}
