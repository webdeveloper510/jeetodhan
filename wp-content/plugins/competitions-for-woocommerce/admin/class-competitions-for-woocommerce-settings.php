<?php
/**
* WooCommerce competitions Settings
*
*/
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if (  class_exists( 'WC_Settings_Page' ) ) :

	/**
	* WC_Settings_Accounts
	*/
	class Competitions_For_Woocommerce_Settings extends WC_Settings_Page {

			/**
			* Constructor.
			*/
		public function __construct() {

		$this->id    = 'competitions-for-woocommerce';
		$this->label = __( 'Competitions', 'competitions_for_woocommerce' );

		add_filter( 'woocommerce_settings_tabs_array', array( $this, 'add_settings_page' ), 20 );
		add_action( 'woocommerce_settings_' . $this->id, array( $this, 'output' ) );
		add_action( 'woocommerce_settings_save_' . $this->id, array( $this, 'save' ) );
		}

		/**
		* Get settings array
		*
		* @return array
		*/
		public function get_settings() {

			return apply_filters( 'woocommerce_' . $this->id . '_settings',
				array(

					array(
						'title' => __( 'WC competitions options', 'competitions_for_woocommerce' ),
						'type'  => 'title',
						'desc'  => '',
						'id'    => 'competitions_for_woocommerce_options' ),
					array(
						'title'   => __( 'Past competitions', 'competitions_for_woocommerce' ),
						'desc'    => __( 'Show finished lotteries', 'competitions_for_woocommerce' ),
						'type'    => 'checkbox',
						'id'      => 'competitions_for_woocommerce_finished_enabled',
						'default' => 'no'
					),
					array(
						'title'   => __( 'Future competitions', 'competitions_for_woocommerce' ),
						'desc'    => __( 'Show lotteries that did not start yet', 'competitions_for_woocommerce' ),
						'type'    => 'checkbox',
						'id'      => 'competitions_for_woocommerce_future_enabled',
						'default' => 'yes'
					),
					array(
						'title'   => __( 'Do not show competitions on shop page', 'competitions_for_woocommerce' ),
						'desc'    => __( 'Do not mix competitions and regular products on shop page. Just show competitions on the competitions page (competitions base page)', 'competitions_for_woocommerce' ),
						'type'    => 'checkbox',
						'id'      => 'competitions_for_woocommerce_dont_mix_shop',
						'default' => 'no'
					),
					array(
						'title'   => __( 'Do not show competitions on product search page', 'competitions_for_woocommerce' ),
						'desc'    => __( 'Do not mix competitions and regular products on product search page (show lotteries only when using competitions search)', 'competitions_for_woocommerce' ),
						'type'    => 'checkbox',
						'id'      => 'competitions_for_woocommerce_dont_mix_search',
						'default' => 'no'
					),
					array(
						'title'   => __( 'Do not show competitions on product category page', 'competitions_for_woocommerce' ),
						'desc'    => __( 'Do not mix competitions and regular products on product category page. Just show competitions on the competitions page (competitions base page)', 'competitions_for_woocommerce' ),
						'type'    => 'checkbox',
						'id'      => 'competitions_for_woocommerce_dont_mix_cat',
						'default' => 'no'
					),
					array(
						'title'   => __( 'Do not show competitions on product tag page', 'competitions_for_woocommerce' ),
						'desc'    => __( 'Do not mix competitions and regular products on product tag page. Just show competitions on the competitions page (competitions base page)', 'competitions_for_woocommerce' ),
						'type'    => 'checkbox',
						'id'      => 'competitions_for_woocommerce_dont_mix_tag',
						'default' => 'no'
					),
					array(
						'title'    => __( 'Countdown format', 'competitions_for_woocommerce' ),
						'desc'     => __( 'The format for the countdown display. Default is yowdHMS', 'competitions_for_woocommerce' ),
						'desc_tip' => __( 'Use the following characters (in order) to indicate which periods you want to display: "Y" for years, "O" for months, "W" for weeks, "D" for days, "H" for hours, "M" for minutes, "S" for seconds. Use upper-case characters for mandatory periods, or the corresponding lower-case characters for optional periods, i.e. only display if non-zero. Once one optional period is shown, all the ones after that are also shown.', 'competitions_for_woocommerce' ),
						'type'     => 'text',
						'id'       => 'competitions_for_woocommerce_countdown_format',
						'default'  => 'yowdHMS'
					),
					array(
						'title'   => __( 'Use compact countdown ', 'competitions_for_woocommerce' ),
						'desc'    => __( 'Indicate whether or not the countdown should be displayed in a compact format.', 'competitions_for_woocommerce' ),
						'type'    => 'checkbox',
						'id'      => 'competitions_for_woocommerce_compact_countdown',
						'default' => 'no'
					),
					array(
						'title'    => __( 'WC competitions Base Page', 'competitions_for_woocommerce' ),
						'desc'     => __( 'Set the base page for your competitions - this is where your competitions archive page will be.', 'competitions_for_woocommerce' ),
						'id'       => 'competitions_for_woocommerce_competitions_page_id',
						'type'     => 'single_select_page',
						'default'  => '',
						'class'    => 'chosen_select_nostd',
						'css'      => 'min-width:300px;',
						'desc_tip' =>  true
					),
					array(
						'title'    => __( 'WC competitions Entry Page', 'competitions_for_woocommerce' ),
						'desc'     => __( 'Set the entry page for your competitions', 'competitions_for_woocommerce' ),
						'id'       => 'competitions_for_woocommerce_competition_entry_page_id',
						'type'     => 'single_select_page',
						'default'  => '',
						'class'    => 'chosen_select_nostd',
						'css'      => 'min-width:300px;',
						'desc_tip' =>  true
					),
					array(
						'title'   => __( 'Competitions history tab', 'competitions_for_woocommerce' ),
						'desc'    => __( 'Show competitions history tab on single product page (competitions details page)', 'competitions_for_woocommerce' ),
						'id'      => 'competitions_for_woocommerce_history',
						'type'    => 'checkbox',
						'default' => 'yes'
					),

					array(
						'title'   => __( 'Show progress bar', 'competitions_for_woocommerce' ),
						'desc'    => __( 'Show competitions progress bar on single product page (competitions details page)', 'competitions_for_woocommerce' ),
						'id'      => 'competitions_for_woocommerce_progressbar',
						'type'    => 'checkbox',
						'default' => 'yes'
					),
					array(
						'title'    => __( 'Progress bar type', 'competitions_for_woocommerce' ),
						'desc'     => __( 'This controls progres bar type.', 'competitions_for_woocommerce' ),
						'id'       => 'competitions_for_woocommerce_type',
						'class'    => 'wc-enhanced-select',
						'default'  => 'available',
						'type'     => 'select',
						'options'  => array(
							'available' => __( 'Tickets available', 'competitions_for_woocommerce' ),
							'sold'      => __( 'Tickets sold', 'competitions_for_woocommerce' ),
						),
						'desc_tip' => true,
					),
					array(
						'title'   => __( 'Competitions badge', 'competitions_for_woocommerce' ),
						'desc'    => __( 'Show competitions badge in loop', 'competitions_for_woocommerce' ),
						'id'      => 'competitions_for_woocommerce_bage',
						'type'    => 'checkbox',
						'default' => 'yes'
					),
					array(
						'title'   => __( 'Close competitions when maximum ticket was sold', 'competitions_for_woocommerce' ),
						'desc'    => __( 'Option to instantly finish competitions when maximum number  of tickets was sold', 'competitions_for_woocommerce' ),
						'type'    => 'checkbox',
						'id'      => 'competitions_for_woocommerce_close_when_max',
						'default' => 'no'
					),
					array(
						'title'   => __( 'Show competitions history in admin product page', 'competitions_for_woocommerce' ),
						'desc'    => __( 'Option to show history table in admin page', 'competitions_for_woocommerce' ),
						'type'    => 'checkbox',
						'id'      => 'competitions_for_woocommerce_history_admin',
						'default' => 'yes'
					),
					array(
						'title'   => __( 'Show answers in history tab', 'competitions_for_woocommerce' ),
						'type'    => 'checkbox',
						'id'      => 'competitions_for_woocommerce_answers_in_history',
						'default' => 'yes',
					),
					array(
						'title'   => __( 'Show answers in history only when competitions is finished', 'competitions_for_woocommerce' ),
						'type'    => 'checkbox',
						'id'      => 'competitions_for_woocommerce_answers_in_history_finished',
						'default' => 'no',
					),
					array(
						'title'   => __( 'Allow log in at later stage of checkout (guest checkout)', 'competitions_for_woocommerce' ),
						'type'    => 'checkbox',
						'id'      => 'competitions_for_woocommerce_alow_non_login',
						'default' => 'yes',
					),
					array(
						'title'   => __( 'Reserve ticket number when user puts it in cart', 'competitions_for_woocommerce' ),
						'type'    => 'checkbox',
						'id'      => 'competitions_for_woocommerce_tickets_reserved',
						'default' => 'no',
					),
					array(
						'title'   => __( 'Hold reserve tickets for n minutes', 'competitions_for_woocommerce' ),
						'type'    => 'number',
						'id'      => 'competitions_for_woocommerce_tickets_reserved_minutes',
						'default' => '5',
					),
					array(
						'title'   => __( 'Show notice for reserving tickets', 'competitions_for_woocommerce' ),
						'type'    => 'checkbox',
						'id'      => 'competitions_for_woocommerce_tickets_reserved_notice',
						'default' => 'yes',
					),
					array(
						'title'   => __( 'Remove ticket numbers from orders with wrong answer.', 'competitions_for_woocommerce' ),
						'type'    => 'checkbox',
						'id'      => 'competitions_for_woocommerce_remove_ticket_wrong_answer',
						'default' => 'no',
					),
					array(
						'title'   => __( 'Show notice for wrong answer in user order email', 'competitions_for_woocommerce' ),
						'type'    => 'checkbox',
						'id'      => 'competitions_for_woocommerce_wrong_answers_email_notice',
						'default' => 'yes',
					),
					array(
						'title'   => __( 'Show lucky dip button', 'competitions_for_woocommerce' ),
						'type'    => 'checkbox',
						'id'      => 'competitions_for_woocommerce_use_lucky_dip',
						'default' => 'no',
					),
					array(
						'title'   => __( 'Use qty with lucky dip button', 'competitions_for_woocommerce' ),
						'type'    => 'checkbox',
						'id'      => 'competitions_for_woocommerce_use_lucky_dip_qty',
						'default' => 'no',
					),
					array(
						'title'   => __( 'Use dropdown for answers', 'competitions_for_woocommerce' ),
						'type'    => 'checkbox',
						'id'      => 'competitions_for_woocommerce_use_dropdown_answers',
						'default' => 'no',
					),



					array( 'type' => 'sectionend', 'id' => 'competitions_for_woocommerce_options'),

				)
			); // End pages settings
		}
	}
return new Competitions_For_Woocommerce_Settings();

endif;
