<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 *  *
 * This class defines all code necessary to run cronjobs.
 *
 * @since      1.0.0
 */
class Competitions_For_Woocommerce_Cronjobs {

	/**
	 * Hook in cronjobs handlers.
	 */
	public static function init() {

		add_action( 'init', array( __CLASS__, 'cron_job_handler' ), 99);

	}

	public static function cron_job_handler() {

		if ( empty( $_REQUEST['competitions-cron'] ) ) {
			return;
		}

		self::cronjob_headers();

		if ( 'check' === $_REQUEST['competitions-cron'] ) {

			self::check_competition_for_closing();

		} elseif ( 'relist' === $_REQUEST['competitions-cron'] ) {

			self::relist();

		}

		die();

	}

	/**
	 * Send headers for cronjob requests.
	 *
	 * @since 2.0.0
	 */
	private static function cronjob_headers() {
		send_origin_headers();
		send_nosniff_header();
		wc_nocache_headers();
		status_header( 200 );
	}

	public static function check_competition_for_closing() {

		update_option( 'competitions_for_woocommerce_cron_check', 'yes' );
		set_time_limit( 0 );
		ignore_user_abort( 1 );

		$args = array(
				'post_type'           => 'product',
				'posts_per_page'      => '-1',
				'meta_query'          => array(
					'relation' => 'AND', // Optional, defaults to "AND"

					array(
						'key'     => '_competition_closed',
						'compare' => 'NOT EXISTS',
					),
					array(
						'key'     => '_competition_dates_to',
						'compare' => 'EXISTS',
					),
				),
				'meta_key'            => '_competition_dates_to',
				'orderby'             => 'meta_value',
				'order'               => 'ASC',
				'tax_query'           => array(
					array(
						'taxonomy' => 'product_type',
						'field'    => 'slug',
						'terms'    => 'competition',
					),
				),
				'competition_archive'     => true,
				'show_past_competition'   => true,
				'show_future_competition' => true,
				'cache_results'           => false,
				'fields'                  => 'ids',
			);

		$i = 0;
		while (  $i < 3 ) {
			$i++;
			$time      = microtime( 1 );
			$the_query = new WP_Query( $args );
			$posts_ids = $the_query->posts;

			if ( is_array( $posts_ids ) ) {

				foreach ( $posts_ids as $posts_id ) {
					clean_post_cache( $posts_id );
					$product_data = wc_get_product( $posts_id );
					$product_data->is_closed();

				}
			}

			$time = microtime( 1 ) - $time;
			if ( $i < 3 ) {
				sleep( 20 - $time );
			}
		}
	}



	public static function relist() {


		update_option( 'competitions_for_woocommerce_cron_relist', 'yes' );
		set_time_limit( 0 );
		ignore_user_abort( 1 );

		$args = array(
			'post_type'          => 'product',
			'posts_per_page'     => '200',
			'tax_query'          => array(
				array(
					'taxonomy' => 'product_type',
					'field'    => 'slug',
					'terms'    => 'competition',
				),
			),
			'meta_query'         => array(
				'relation' => 'AND',

				array(
					'key'     => '_competition_closed',
					'compare' => 'EXISTS',
				),
				array(
					'key'   => '_competition_automatic_relist',
					'value' => 'yes',
				),
			),
			'competition_archive'     => true,
			'is_competition_archive' => true,
			'show_past_competition' => true,
			'show_future_competition' => true,
			'cache_results'  => false,
			'fields'             => 'ids',
		);

		$the_query = new WP_Query( $args );
		$posts_ids = $the_query->posts;

		if ( is_array( $posts_ids ) ) {
			foreach ( $posts_ids as $post_id ) {
				Competitions_For_Woocommerce_Admin::automatic_relist_competition( $post_id );
			}
		}
	}




}

Competitions_For_Woocommerce_Cronjobs::init();

