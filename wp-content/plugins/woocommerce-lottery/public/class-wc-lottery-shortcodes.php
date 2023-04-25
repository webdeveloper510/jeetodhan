<?php
/**
 * Wc lotteries Shortcode
 *
 */

class WC_Shortcode_Lottery extends WC_Shortcodes {

	/**
	 * Init shortcodes.
	 */
	public static function init() {
		$shortcodes = array(
			'lotteries'             => __CLASS__ . '::lotteries',
			'featured_lotteries'    => __CLASS__ . '::featured_lotteries',
			'recent_lotteries'      => __CLASS__ . '::recent_lotteries',
			'ending_soon_lotteries' => __CLASS__ . '::ending_soon_lotteries',
			'future_lotteries'      => __CLASS__ . '::future_lotteries',
			'finished_lotteries'    => __CLASS__ . '::finished_lotteries',
			'my_active_lotteries'   => __CLASS__ . '::my_active_lotteries',
			'my_lotteries'          => __CLASS__ . '::my_lotteries',
			'winned_lotteries'      => __CLASS__ . '::winned_lotteries',
			'lotteries_winners'     => __CLASS__ . '::lotteries_winners',
		);
		foreach ( $shortcodes as $shortcode => $function ) {
			add_shortcode( apply_filters( "{$shortcode}_shortcode_tag", $shortcode ), $function );
		}

	}
	/**
	 * List multiple products shortcode.
	 *
	 * @param array $atts Attributes.
	 * @return string
	 */
	public static function lotteries( $atts ) {
		$atts = (array) $atts;
		$type = 'lotteries';
		// Allow list product based on specific cases.
		if ( isset( $atts['winned_lotteries'] ) && wc_string_to_bool( $atts['winned_lotteries'] ) ) {
			$type = 'winned_lotteries';
		} elseif ( isset( $atts['lotteries_winners'] ) && wc_string_to_bool( $atts['lotteries_winners'] ) ) {
			$type = 'lotteries_winners';
		} elseif ( isset( $atts['my_lotteries'] ) && wc_string_to_bool( $atts['my_lotteries'] ) ) {
			$type = 'my_lotteries';
		}
		$shortcode = new WC_Shortcode_Lotteries( $atts, $type );

		return $shortcode->get_content();
	}

	/**
	 * Output featured products.
	 *
	 * @param array $atts Attributes.
	 * @return string
	 */
	public static function featured_lotteries( $atts ) {
		$atts = array_merge(
			array(
				'limit'        => '12',
				'columns'      => '4',
				'orderby'      => 'date',
				'order'        => 'DESC',
				'category'     => '',
				'cat_operator' => 'IN',
			),
			(array) $atts
		);

		$atts['visibility'] = 'featured';

		$shortcode = new WC_Shortcode_Lotteries( $atts, 'featured_lotteries' );

		return $shortcode->get_content();
	}

	/**
	 * Output featured products.
	 *
	 * @param array $atts Attributes.
	 * @return string
	 */
	public static function recent_lotteries( $atts ) {
		$atts = array_merge(
			array(
				'limit'        => '12',
				'columns'      => '4',
				'orderby'      => 'date',
				'order'        => 'DESC',
				'category'     => '',
				'cat_operator' => 'IN',
			),
			(array) $atts
		);

		$shortcode = new WC_Shortcode_Lotteries( $atts, 'recent_lotteries' );

		return $shortcode->get_content();
	}

	/**
	 * Output featured products.
	 *
	 * @param array $atts Attributes.
	 * @return string
	 */
	public static function ending_soon_lotteries( $atts ) {
		$atts = array_merge(
			array(
				'limit'        => '12',
				'columns'      => '4',
				'orderby'      => 'meta_value',
				'order'        => 'ASC',
				'category'     => '',
				'meta_key' => '_lottery_dates_to',
				'cat_operator' => 'IN',
				'lottery_status' =>'active',
				'future' =>'yes',
			),
			(array) $atts
		);


		$shortcode = new WC_Shortcode_Lotteries( $atts, 'ending_soon_lotteries' );

		return $shortcode->get_content();
	}

	/**
	 * Output featured products.
	 *
	 * @param array $atts Attributes.
	 * @return string
	 */
	public static function future_lotteries( $atts ) {
		$atts = array_merge(
			array(
				'limit'        => '12',
				'columns'      => '4',
				'orderby'      => 'date',
				'order'        => 'DESC',
				'category'     => '',
				'cat_operator' => 'IN',
				'lottery_status' =>'future',
			),
			(array) $atts
		);

		$shortcode = new WC_Shortcode_Lotteries( $atts, 'future_lotteries' );

		return $shortcode->get_content();
	}

	/**
	 * Output featured products.
	 *
	 * @param array $atts Attributes.
	 * @return string
	 */
	public static function finished_lotteries( $atts ) {
		$atts = array_merge(
			array(
				'limit'        => '12',
				'columns'      => '4',
				'orderby'      => 'date',
				'order'        => 'DESC',
				'category'     => '',
				'cat_operator' => 'IN',
				'lottery_status' =>'finished',
			),
			(array) $atts
		);

		$shortcode = new WC_Shortcode_Lotteries( $atts, 'future_lotteries' );

		return $shortcode->get_content();
	}

	/**
	 * Output featured products.
	 *
	 * @param array $atts Attributes.
	 * @return string
	 */
	public static function my_active_lotteries( $atts ) {
		
		if ( is_user_logged_in() ) {

			$user_id  = get_current_user_id();
			$postids = woocommerce_lottery_get_user_lotteries();
			if( is_array($postids) ) {
				$postids = implode (',', $postids );
			}
			
			$atts = array_merge(
				array(
					'limit'        => '-1',
					'ids' => $postids,
					'columns'      => '4',
					'orderby'      => 'date',
					'order'        => 'DESC',
					'category'     => '',
					'cat_operator' => 'IN',
					'lottery_status' =>'active',
				),
				(array) $atts
			);

			$shortcode = new WC_Shortcode_Lotteries( $atts, 'my_active_lotteries' );

			return $shortcode->get_content();
		}
	}

	/**
	 * Output featured products.
	 *
	 * @param array $atts Attributes.
	 * @return string
	 */
	public static function winned_lotteries( $atts ) {

		if ( is_user_logged_in() ) {

			$atts = array_merge(
				array(
					'limit'        => '-1',
					'columns'      => '4',
					'orderby'      => 'meta_value',
					'order'        => 'ASC',
					'category'     => '',
					'cat_operator' => 'IN',
					'meta_key' => '_lottery_dates_to',
					'lottery_status' =>'finished',
				),
				(array) $atts
			);

			$shortcode = new WC_Shortcode_Lotteries( $atts, 'my_winned_lotteries' );

			return $shortcode->get_content();
		}
	}

	/**
	 * Output featured products.
	 *
	 * @param array $atts Attributes.
	 * @return string
	 */
	public static function my_lotteries( $atts ) {

		if ( is_user_logged_in() ) {
			$output = '<div class="wc-lotterys active-lotteries clearfix woocommerce"><h2>' . __( 'Active Lottery', 'wc_lottery' ) . '</h2>';
			$output .= WC_Shortcode_Lottery::my_active_lotteries($atts) ;
			$output .= '</div><div class="wc-lotteries active-lotteries clearfix woocommerce"><h2>' . __( 'Won lotteries', 'wc_lottery' ) . '</h2>';
			$output .= WC_Shortcode_Lottery::winned_lotteries($atts);
			$output .= "</div>";
			return $output;

		} else {
			$output = '<div class="woocommerce"><p class="woocommerce-info">' . __('Please log in to see your lotteries.','wc_lottery' ) . '</p></div>';
			return $output;
		}
	}

	/**
	 * Output featured products.
	 *
	 * @param array $atts Attributes.
	 * @return string
	 */
	public static function lotteries_winners( $atts ) {

				$atts = array_merge(
					array(
						'limit'        => '-1',
						'columns'      => '4',
						'orderby'      => 'meta_value',
						'order'        => 'DESC',
						'category'     => '',
						'cat_operator' => 'IN',
						'meta_key' => '_lottery_dates_to',
						'lottery_status' =>'finished',
					),
					(array) $atts
				);

				$shortcode = new WC_Shortcode_Lotteries( $atts, 'lotteries_winners' );

				return $shortcode->get_content_lotteries_winners();



	}

	
}
