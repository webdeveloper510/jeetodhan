<?php

if ( ! function_exists( 'woocommerce_competition_participate_template' ) ) {
	/**
	 * Load participate template part
	 *
	 */
	function woocommerce_competition_participate_template() {
		global $product;
		if ( 'competition' === $product->get_type() ) {
			wc_get_template( 'single-product/participate.php' );
		}
	}

}

if ( ! function_exists( 'woocommerce_competition_winners_template' ) ) {
	/**
	 * Load winners template part
	 *
	 */
	function woocommerce_competition_winners_template() {
		global $product;
		if ( 'competition' === $product->get_type() ) {
			wc_get_template( 'single-product/winners.php' );
		}
	}
}

if ( ! function_exists( 'woocommerce_competition_add_to_cart_template' ) ) {
	/**
	 * Load competition product add to cart template part.
	 *
	 */
	function woocommerce_competition_add_to_cart_template() {
		wc_get_template( 'single-product/add-to-cart/competition.php' );
	}
}

if ( ! function_exists( 'woocommerce_competition_countdown_template' ) ) {
	/**
	 * Load competition product add to cart template part.
	 *
	 */
	function woocommerce_competition_countdown_template() {
		wc_get_template( 'global/competition-countdown.php' );
	}
}

if ( ! function_exists( 'woocommerce_competition_info_template' ) ) {
	/**
	 * Load competition product add to cart template part.
	 *
	 */
	function woocommerce_competition_info_template() {
		wc_get_template( 'single-product/competition-info.php' );
	}
}

if ( ! function_exists( 'woocommerce_competition_info_future_template' ) ) {
	/**
	 * Load competition product add to cart template part.
	 *
	 */
	function woocommerce_competition_info_future_template() {
		wc_get_template( 'single-product/competition-info-future.php' );
	}
}
if ( ! function_exists( 'woocommerce_competition_progressbar_template' ) ) {
	/**
	 * Load competition product add to cart template part.
	 *
	 */
	function woocommerce_competition_progressbar_template () {
		wc_get_template( 'global/competition-progressbar.php' );
	}
}
if ( ! function_exists( 'woocommerce_competition_entry_info_template' ) ) {
	/**
	 * Load competition product add to cart template part.
	 *
	 */
	function woocommerce_competition_entry_info_template () {
		wc_get_template( 'single-entry/entry-info.php' );
	}
}
if ( ! function_exists( 'woocommerce_competition_entry_table_template' ) ) {
	/**
	 * Load competition product add to cart template part.
	 *
	 */
	function woocommerce_competition_entry_table_template () {
		wc_get_template( 'single-entry/entry-table.php' );
	}
}
if ( ! function_exists( 'woocommerce_competition_entry_table_list' ) ) {
	function woocommerce_competition_entry_table_list() {
		if ( ! isset($competition_single_entry_table) ) {
			$competition_single_entry_table = new Competitions_For_Woocommerce_Entry_List_Table();
		}
		if ( $competition_single_entry_table ) {
			$competition_single_entry_table->prepare_items();
			$competition_single_entry_table->display();
		}
	}
}
if ( ! function_exists( 'competition_questions_add_to_cart_button' ) ) {

	function competition_questions_add_to_cart_button() {
		wc_get_template( 'single-product/add-to-cart/answers.php' );
	}

}

if ( ! function_exists( 'competition_ticket_numbers_add_to_cart_button' ) ) {

	function competition_ticket_numbers_add_to_cart_button() {
		wc_get_template( 'single-product/add-to-cart/ticket-numbers.php' );
	}

}

if ( ! function_exists( 'woocommerce_competition_lucky_dip_button_template' ) ) {

	function woocommerce_competition_lucky_dip_button_template() {
		wc_get_template( 'single-product/lucky-dip-button.php' );
	}

}
if ( ! function_exists( 'remove_added_to_cart_notice_entry_table' ) ) {

	function remove_added_to_cart_notice_entry_table() {
		add_filter( 'woocommerce_competition_participating_message', '__return_false' );

	}

}
