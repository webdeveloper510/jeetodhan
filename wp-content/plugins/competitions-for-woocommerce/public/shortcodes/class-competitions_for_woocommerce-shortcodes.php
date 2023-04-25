<?php
/**
 * Wc competitions Shortcode
 *
 */

class Competitions_For_Woocommerce_Shortcodes extends WC_Shortcodes {

	/**
	 * Init shortcodes.
	 */
	public static function init() {
		$shortcodes = array(
			'competitions'                => __CLASS__ . '::competitions',
			'featured_competitions'       => __CLASS__ . '::featured_competitions',
			'recent_competitions'         => __CLASS__ . '::recent_competitions',
			'ending_soon_competitions'    => __CLASS__ . '::ending_soon_competitions',
			'future_competitions'         => __CLASS__ . '::future_competitions',
			'finished_competitions'       => __CLASS__ . '::finished_competitions',
			'my_active_competitions'      => __CLASS__ . '::my_active_competitions',
			'my_competitions'             => __CLASS__ . '::my_competitions',
			'won_competitions'            => __CLASS__ . '::won_competitions',
			'competitions_winners'        => __CLASS__ . '::competitions_winners',
			'competition_lucky_dip_button' => __CLASS__ . '::competition_lucky_dip_button',
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
	public static function competitions( $atts ) {
		$atts = (array) $atts;
		$type = 'competitions';
		// Allow list product based on specific cases.
		if ( isset( $atts['won_competitions'] ) && wc_string_to_bool( $atts['won_competitions'] ) ) {
			$type = 'won_competitions';
		} elseif ( isset( $atts['competitions_winners'] ) && wc_string_to_bool( $atts['competitions_winners'] ) ) {
			$type = 'competitions_winners';
		} elseif ( isset( $atts['my_competitions'] ) && wc_string_to_bool( $atts['my_competitions'] ) ) {
			$type = 'my_competitions';
		}
		$shortcode = new Shortcode_Competition( $atts, $type );

		return $shortcode->get_content();
	}

	/**
	 * Output featured competitions shortcode
	 *
	 * @param array $atts Attributes.
	 * @return string
	 */
	public static function featured_competitions( $atts ) {
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

		$shortcode = new Shortcode_Competition( $atts, 'featured_competitions' );

		return $shortcode->get_content();
	}

	/**
	 * Output recent competitions shortcode
	 *
	 * @param array $atts Attributes.
	 * @return string
	 */
	public static function recent_competitions( $atts ) {
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

		$shortcode = new Shortcode_Competition( $atts, 'recent_competitions' );

		return $shortcode->get_content();
	}

	/**
	 * Output ending soon competitions shortcode
	 *
	 * @param array $atts Attributes.
	 * @return string
	 */
	public static function ending_soon_competitions( $atts ) {
		$atts = array_merge(
			array(
				'limit'        => '12',
				'columns'      => '4',
				'orderby'      => 'meta_value',
				'order'        => 'ASC',
				'category'     => '',
				'meta_key' => '_competition_dates_to',
				'cat_operator' => 'IN',
				'competition_status' =>'active',
				'future' =>'yes',
			),
			(array) $atts
		);


		$shortcode = new Shortcode_Competition( $atts, 'ending_soon_competitions' );

		return $shortcode->get_content();
	}

	/**
	 * Output future competitions shortcode
	 *
	 * @param array $atts Attributes.
	 * @return string
	 */
	public static function future_competitions( $atts ) {
		$atts = array_merge(
			array(
				'limit'              => '12',
				'columns'            => '4',
				'orderby'            => 'date',
				'order'              => 'DESC',
				'category'           => '',
				'cat_operator'       => 'IN',
				'competition_status' =>'future',
			),
			(array) $atts
		);

		$shortcode = new Shortcode_Competition( $atts, 'future_competitions' );

		return $shortcode->get_content();
	}

	/**
	 * Output finished competitions shortcode
	 *
	 * @param array $atts Attributes.
	 * @return string
	 */
	public static function finished_competitions( $atts ) {
		$atts = array_merge(
			array(
				'limit'              => '12',
				'columns'            => '4',
				'orderby'            => 'date',
				'order'              => 'DESC',
				'category'           => '',
				'cat_operator'       => 'IN',
				'competition_status' =>'finished',
			),
			(array) $atts
		);

		$shortcode = new Shortcode_Competition( $atts, 'future_competitions' );

		return $shortcode->get_content();
	}

	/**
	 * Output my active competitions shortcode
	 *
	 * @param array $atts Attributes.
	 * @return string
	 */
	public static function my_active_competitions( $atts ) {
		
		if ( is_user_logged_in() ) {

			$user_id = get_current_user_id();
			$postids = competitions_for_woocommerce_get_user_competitions();

			if ( !empty( $postids ) ) {
				if ( is_array( $postids ) ) {
					$postids = implode (',', $postids );
				}


				$atts = array_merge(
					array(
						'limit'              => '-1',
						'ids'                => $postids,
						'columns'            => '4',
						'orderby'            => 'date',
						'order'              => 'DESC',
						'category'           => '',
						'cat_operator'       => 'IN',
						'competition_status' =>'active',
					),
					(array) $atts
				);

				$shortcode = new Shortcode_Competition( $atts, 'my_active_competitions' );

				return $shortcode->get_content();

			} else {
				$output = '<div class="woocommerce"><p class="woocommerce-info">' . esc_html__("You don't have any active competition.", 'competitions_for_woocommerce' ) . '</p></div>';
				return $output;
			}

		}
	}

	/**
	 * Output won competitions shortcode
	 *
	 * @param array $atts Attributes.
	 * @return string
	 */
	public static function won_competitions( $atts ) {

		if ( is_user_logged_in() ) {

			$atts = array_merge(
				array(
					'limit'              => '-1',
					'columns'            => '4',
					'orderby'            => 'meta_value',
					'order'              => 'ASC',
					'category'           => '',
					'cat_operator'       => 'IN',
					'meta_key'           => '_competition_dates_to',
					'competition_status' =>'finished',
				),
				(array) $atts
			);

			$shortcode = new Shortcode_Competition( $atts, 'my_won_competitions' );

			return $shortcode->get_content();
		}
	}

	/**
	 * Output my competition shortcode.
	 *
	 * @param array $atts Attributes.
	 * @return string
	 */
	public static function my_competitions( $atts ) {

		if ( is_user_logged_in() ) {
			$output = '<div class="wc-competitions active-competitions clearfix woocommerce"><h2>' . esc_html__( 'Active competition', 'competitions_for_woocommerce' ) . '</h2>';
			$output .= self::my_active_competitions($atts) ;
			$output .= '</div><div class="wc-competitions active-competitions clearfix woocommerce"><h2>' . esc_html__( 'Won competitions', 'competitions_for_woocommerce' ) . '</h2>';
			$output .= self::won_competitions($atts);
			$output .= '</div>';
			return $output;

		} else {
			$output = '<div class="woocommerce"><p class="woocommerce-info">' . esc_html__('Please log in to see your competitions.', 'competitions_for_woocommerce' ) . '</p></div>';
			return $output;
		}
	}

	/**
	 * Output competition winners shortcode.
	 *
	 * @param array $atts Attributes.
	 * @return string
	 */
	public static function competitions_winners( $atts ) {

				$atts = array_merge(
					array(
						'limit'              => '-1',
						'columns'            => '4',
						'orderby'            => 'meta_value',
						'order'              => 'DESC',
						'category'           => '',
						'cat_operator'       => 'IN',
						'meta_key'           => '_competition_dates_to',
						'competition_status' =>'finished',
					),
					(array) $atts
				);

				$shortcode = new Shortcode_Competition( $atts, 'competitions_winners' );

				return $shortcode->get_content_competition_winners();



	}

	public static function competition_lucky_dip_button( $atts ) {
		wc_get_template( '/global/competition-participate-button.php', $atts );
	}

	
}

new Competitions_For_Woocommerce_Shortcodes();
