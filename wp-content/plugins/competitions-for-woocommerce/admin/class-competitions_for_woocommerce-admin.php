<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://wpinstitut.com/
 * @since      1.0.0
 *
 * @package    Competitions_for_woocommerce
 * @subpackage Competitions_for_woocommerce/admin
 */

class Competitions_For_Woocommerce_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles( $hook ) {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Competitions_for_woocommerce_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Competitions_for_woocommerce_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		global $post_type;
		if ( 'post-new.php' === $hook|| 'post.php' === $hook || 'woocommerce_page_wc-settings' === $hook) {
			wp_enqueue_style( 'DataTables', CFW()->plugin_url() . '/admin/js/DataTables/datatables.min.css', array(), '1.10.20' );
			wp_enqueue_style( 'DataTables-buttons', CFW()->plugin_url() . '/admin/js/DataTables/buttons.dataTables.min.css', array(), '1.10.20' );
			wp_enqueue_style( $this->plugin_name, CFW()->plugin_url() . '/admin/css/competitions_for_woocommerce-admin.css', array(), $this->version, 'all' );
		}

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts( $hook ) {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Competitions_for_woocommerce_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Competitions_for_woocommerce_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		if ( 'post-new.php' === $hook  || 'post.php' === $hook ) {
			if ( 'product' === get_post_type() ) {


				$params = array(
					'i18_max_ticket_less_than_min_ticket_error' => esc_js( __( 'Please enter in a value greater than the min tickets.', 'competitions_for_woocommerce' ) ),
					'i18_minimum_winers_error'                  => esc_js( __( 'You must set at least one competition winner', 'competitions_for_woocommerce' ) ),
					'competition_refund_nonce'                  => wp_create_nonce( 'competition-refund' ),
					'add_competition_answer_nonce'                  => wp_create_nonce( 'add_competition_answer_nonce' ),
					'save_competition_answer_nonce'                 => wp_create_nonce( 'save_competition_answer_nonce' ),
					'remove_wcsbs'                              => esc_js( __( 'Remove this answer?', 'competitions_for_woocommerce' ) ),
					'datatable_language' => array(
						'sEmptyTable'     => esc_js( __('No data available in table', 'competitions_for_woocommerce' ) ),
						'sInfo'           => esc_js( __('Showing _START_ to _END_ of _TOTAL_ entries', 'competitions_for_woocommerce' ) ),
						'sInfoEmpty'      => esc_js( __('Showing 0 to 0 of 0 entries', 'competitions_for_woocommerce' ) ),
						'sInfoFiltered'   => esc_js( __('(filtered from _MAX_ total entries)', 'competitions_for_woocommerce' ) ),
						'sLengthMenu'     => esc_js( __('Show _MENU_ entries', 'competitions_for_woocommerce' ) ),
						'sLoadingRecords' => esc_js( __('Loading...', 'competitions_for_woocommerce' ) ),
						'sProcessing'     => esc_js( __('Processing...', 'competitions_for_woocommerce' ) ),
						'sSearch'         => esc_js( __('Search:', 'competitions_for_woocommerce' ) ),
						'sZeroRecords'    => esc_js( __('No matching records found', 'competitions_for_woocommerce' ) ),
						'oPaginate'=> array(
							'sFirst'    => esc_js( __('First', 'competitions_for_woocommerce' ) ),
							'sLast'     => esc_js( __('Last', 'competitions_for_woocommerce' ) ),
							'sNext'     => esc_js( __('Next', 'competitions_for_woocommerce' ) ),
							'sPrevious' => esc_js( __('Previous', 'competitions_for_woocommerce' ) ),
						),
						'oAria'           => array(
							'sSortAscending'  => esc_js( __(': activate to sort column ascending', 'competitions_for_woocommerce' ) ),
							'sSortDescending' => esc_js( __(': activate to sort column descending', 'competitions_for_woocommerce' ) )

						)
					)
				);

				wp_enqueue_script( 'DataTables', CFW()->plugin_url() . '/admin/js/DataTables/datatables.min.js', array( 'jquery' ), '1.10.20', false );
				wp_enqueue_script( 'DataTables-buttons', CFW()->plugin_url() . '/admin/js/DataTables/dataTables.buttons.min.js', array( 'jquery', 'DataTables' ), '1.10.20', false );
				wp_enqueue_script( 'jszip', CFW()->plugin_url() . '/admin/js/DataTables/jszip.min.js', array( 'jquery', 'DataTables', 'DataTables-buttons' ), '1.10.20', false );
				wp_enqueue_script( 'buttons.html5', CFW()->plugin_url() . '/admin/js/DataTables/buttons.html5.min.js', array( 'jquery', 'DataTables', 'DataTables-buttons' ), '1.10.20', false );
				wp_enqueue_script( 'buttons.colVis', CFW()->plugin_url() . '/admin/js/DataTables/buttons.colVis.min.js', array( 'jquery', 'DataTables', 'DataTables-buttons' ), '1.10.20', false );
				wp_register_script(
					$this->plugin_name . '-admin',
					plugin_dir_url( __FILE__ ) . 'js/competitions_for_woocommerce-admin.js',
					array( 'jquery', 'jquery-ui-core', 'jquery-ui-datepicker', 'timepicker-addon',  'DataTables' ),
					$this->version,
					true
				);
				wp_localize_script( $this->plugin_name . '-admin', 'competitions_for_woocommerce', $params );
				wp_enqueue_script( $this->plugin_name . '-admin' );

				wp_enqueue_script(
					'timepicker-addon',
					CFW()->plugin_url() . '/admin/js/jquery-ui-timepicker-addon.js',
					array( 'jquery', 'jquery-ui-core', 'jquery-ui-datepicker' ),
					$this->version,
					true
				);

				wp_enqueue_style( 'jquery-ui-datepicker' );
			}
		}

	}


	/**
	 * Hides any admin notices.
	 *
	 * @since 4.0.0
	 * @version 4.0.0
	 */
	public function hide_notices() {
		if ( isset( $_GET['competitions-for-woocommerce-hide-notice'] ) && isset( $_GET['competitions-for-woocommerce-hide-notice-nonce'] ) ) {
			if ( ! wp_verify_nonce( sanitize_key( $_GET['competitions-for-woocommerce-hide-notice-nonce'] ), 'competitions-for-woocommerce-hide-notice-nonce' ) ) {
				wp_die( esc_html__( 'Action failed. Please refresh the page and retry.', 'competitions-for-woocommerce' ) );
			}

			if ( ! current_user_can( 'manage_woocommerce' ) ) {
				wp_die( esc_html__( 'Cheatin&#8217; huh?', 'woocommerce-gateway-competitions-for-woocommerce' ) );
			}

			$notice = wc_clean( sanitize_key( $_GET['competitions-for-woocommerce-hide-notice'] ) );

			switch ( $notice ) {
				case 'cronjob_main':
					update_option( 'competitions_for_woocommerce_show_cron_main_notice', 'no' );
					break;
			}
		}
	}

	/**
	 * Allow this class and other classes to add slug keyed notices (to avoid duplication).
	 *
	 * @since 2.0.0
	 * @version 2.0.0
	 * @param string $slug slug for notice.
	 * @param string $class class for notice.
	 * @param string $message message of notice.
	 * @param bolean $dismissible is notice dismissible.
	 **/
	public function add_admin_notice( $slug, $class, $message, $dismissible = false ) {
		$this->notices[ $slug ] = array(
			'class'       => $class,
			'message'     => $message,
			'dismissible' => $dismissible,
		);
	}

	/**
	 * Display any notices we've collected thus far.
	 *
	 * @since 2.0.0
	 * @version 2.0.0
	 */
	public function admin_notices() {
		if ( ! current_user_can( 'manage_woocommerce' ) || ! isset( $this->notices ) ) {
			return;
		}

		foreach ( (array) $this->notices as $notice_key => $notice ) {
			echo '<div class="' . esc_attr( $notice['class'] ) . '" style="position:relative;">';

			if ( $notice['dismissible'] ) { ?>
				<a href="<?php echo esc_url( wp_nonce_url( add_query_arg( 'competitions-for-woocommerce-hide-notice', $notice_key ), 'competitions-for-woocommerce-hide-notice-nonce', 'competitions-for-woocommerce-hide-notice-nonce' ) ); ?>" class="woocommerce-message-close notice-dismiss" style="position:absolute;right:1px;padding:9px;text-decoration:none;"></a>
				<?php
			}

			echo '<p>';
			echo wp_kses(
				$notice['message'],
				array(
					'a' => array(
						'href' => array(),
					),
				)
			);
			echo '</p></div>';
		}
	}


	/**
	 * Checks the environment for compatibility problems.  Returns a string with the first incompatibility
	 * found or false if the environment has no problems.
	 *
	 * @since 1.0.0
	 * @version 4.0.0
	 */
	public function get_environment_warning() {
		if ( version_compare( phpversion(), COMPETITIONS_FOR_WOOCOMMERCE_MIN_PHP, '<' ) ) {
			/* translators: 1) int version 2) int version */
			$message = esc_html__( 'Competitions for WooCommerce - The minimum PHP version required for this plugin is %1$s. You are running %2$s.', 'competitions_for_woocommerce' );

			return sprintf( $message, COMPETITIONS_FOR_WOOCOMMERCE_MIN_PHP, phpversion() );
		}

		if ( ! defined( 'WC_VERSION' ) ) {
			return esc_html__( 'Competitions for WooCommerce requires WooCommerce to be activated to work.', 'competitions_for_woocommerce' );
		}

		if ( version_compare( WC_VERSION, COMPETITIONS_FOR_WOOCOMMERCE_MIN_WC, '<' ) ) {
			/* translators: 1) int version 2) int version */
			$message = esc_html__( 'Competitions for WooCommerce - The minimum WooCommerce version required for this plugin is %1$s. You are running %2$s.', 'competitions_for_woocommerce' );

			return sprintf( $message, COMPETITIONS_FOR_WOOCOMMERCE_MIN_WC, WC_VERSION );
		}

		return false;
	}
	/**
	 * The backup sanity check, in case the plugin is activated in a weird way,
	 * or the environment changes after activation. Also handles upgrade routines.
	 *
	 * @since 1.0.0
	 * @version 4.0.0
	 */
	public function check_environment() {

		$cronjob_documentation = 'https://wpinstitut.com/competitions-for-woocommerce-documentation/#cronjobs';

		$environment_warning = $this->get_environment_warning();

		if ( $environment_warning && is_plugin_active( plugin_basename( __FILE__ ) ) ) {
			$this->add_admin_notice( 'bad_environment', 'error', $environment_warning );
		}

		if ( get_option( 'competitions_for_woocommerce_cron_check' ) !== 'yes' && ! get_option( 'competitions_for_woocommerce_show_cron_main_notice' ) ) {
			$message = wp_kses(
				/* translators: 1) blog url */
				__( 'Competitions for WooCommerce recommends that you set up a cron job to check finished competitions: <strong>%1$s/?competitions-cron=check</strong>. Set it to every minute. See <a href="%2$s">documentation</a> for this!', 'competitions_for_woocommerce' ),
				array(
					'a' => array(
						'href' => array(),
					),
				)
			);
			$this->add_admin_notice( 'cronjob_main', 'notice notice-warning', sprintf( $message, get_bloginfo( 'url' ), $cronjob_documentation ), true );
		}

		if ( get_option( 'competitions_for_woocommerce_cron_relist' ) !== 'yes' && ! get_option( 'competitions_for_woocommerce_show_cron_relis_notice' ) ) {
			$message = wp_kses(
				/* translators: 1) blog url */
				__( 'For automated relisting feature, please setup cron job every 1 hour: <strong>%1$s/?competitions-cron=relist</strong>. See <a href="%2$s">documentation</a> for this!', 'competitions_for_woocommerce' ),
				array(
					'a' => array(
						'href' => array(),
					),
				)
			);
			$this->add_admin_notice( 'cronjob_relist', 'notice notice-warning', sprintf( $message, get_bloginfo( 'url' ), $cronjob_documentation ), true );
		}

		if ( 'yes' === get_option( 'woocommerce_enable_guest_checkout' ) ) {
				$message = wp_kses(
				/* translators: 1) blog url */
				__( 'Competitions for WooCommerce can not work with enabled option "Allow customers to place orders without an account", please turn it off. <a href="%1$s">Accounts & Privacy settings</a>', 'competitions_for_woocommerce' ),
				array(
					'a' => array(
						'href' => array(),
					),
				)
			);
			$this->add_admin_notice( 'cronjob_main', 'notice notice-warning', sprintf( $message, get_admin_url() . 'admin.php?page=wc-settings&tab=account' ), true );

		}


	}


	/*
	* competitions settings page
	 */
	public function competitions_settings_class( $settings ) {
		$settings[] = include COMPETITIONS_FOR_WOOCOMMERCE_ABSPATH . 'admin/class-competitions-for-woocommerce-settings.php';
		return $settings;
	}

	/**
	 * Add product type
	 *
	 * @return array
	 *
	 */
	public function add_product_type( $types ) {
		$types['competition'] = esc_html__( 'Competition', 'competitions_for_woocommerce' );
		return $types;
	}

	/**
	 * Adds a new tab to the Product Data postbox in the admin product interface
	 *
	 * @return void
	 *
	 */
	public function product_write_panel_tab( $product_data_tabs ) {
		$tab_icon = plugin_dir_url( __FILE__ ) . 'images/competition.jpg';

		$competition_tab = array(
			'competition_tab' => array(
				'label'  => __( 'Competition', 'competitions_for_woocommerce' ),
				'target' => 'competition_tab',
				'class'  => array( 'competition_tab', 'show_if_competition', 'hide_if_grouped', 'hide_if_external', 'hide_if_variable', 'hide_if_simple' ),
			),
		);

		return $competition_tab + $product_data_tabs;
	}


	/**
	* Add to mail class
	*
	* @return object
	*
	*/
	public function add_to_mail_class( $emails ) {

		include_once COMPETITIONS_FOR_WOOCOMMERCE_ABSPATH . 'admin/emails/class-wc-email-competition-win.php';
		include_once COMPETITIONS_FOR_WOOCOMMERCE_ABSPATH . 'admin/emails/class-wc-email-competition-failed.php';
		include_once COMPETITIONS_FOR_WOOCOMMERCE_ABSPATH . 'admin/emails/class-wc-email-competition-no-luck.php';
		include_once COMPETITIONS_FOR_WOOCOMMERCE_ABSPATH . 'admin/emails/class-wc-email-competition-finished.php';
		include_once COMPETITIONS_FOR_WOOCOMMERCE_ABSPATH . 'admin/emails/class-wc-email-competition-failed-users.php';
		include_once COMPETITIONS_FOR_WOOCOMMERCE_ABSPATH . 'admin/emails/class-wc-email-competition-extended.php';

		$emails->emails['WC_Email_Competition_Win']        = new WC_Email_Competition_Win();
		$emails->emails['WC_Email_Competition_Failed']     = new WC_Email_Competition_Failed();
		$emails->emails['WC_Email_Competition_Finished']   = new WC_Email_Competition_Finished();
		$emails->emails['WC_Email_Competition_No_Luck']    = new WC_Email_Competition_No_Luck();
		$emails->emails['WC_Email_Competition_Fail_Users'] = new WC_Email_Competition_Fail_Users();
		$emails->emails['WC_Email_Competition_Extended']   = new WC_Email_Competition_Extended();

		return $emails;
	}


	/**
	 * Adds the panel to the Product Data postbox in the product interface
	 *
	 * @return void
	 *
	 */
	public function product_write_panel() {
		global $post;
		$product = wc_get_product( $post->ID );

		echo '<div id="competition_tab" class="panel woocommerce_options_panel">';

		woocommerce_wp_text_input(
			array(
				'id'                => '_competition_price',
				'class'             => 'input_text',
				'label'             => esc_html__( 'Price', 'competitions_for_woocommerce' ) . ' (' . get_woocommerce_currency_symbol() . ')',
				'data_type'         => 'price',
				'desc_tip'          => 'true',
				'description'       => esc_html__( 'competition Price, put 0 for free competition.', 'competitions_for_woocommerce' ),
			)
		);
		woocommerce_wp_text_input(
			array(
				'id'                => '_competition_sale_price',
				'class'             => 'input_text',
				'label'             => esc_html__( 'Sale Price', 'competitions_for_woocommerce' ) . ' (' . get_woocommerce_currency_symbol() . ')',
				'data_type'         => 'price',
				'desc_tip'          => 'true',
				'description'       => esc_html__( 'competition Sale Price', 'competitions_for_woocommerce' ),
			)
		);

		woocommerce_wp_text_input(
			array(
				'id'                => '_competition_min_tickets',
				'class'             => 'input_text',
				'size'              => '6',
				'label'             => esc_html__( 'Min tickets', 'competitions_for_woocommerce' ),
				'type'              => 'number',
				'custom_attributes' => array(
					'step' => 'any',
					'min'  => '0',
				),
				'desc_tip'          => 'true',
				'description'       => esc_html__( 'Minimum tickets to be sold', 'competitions_for_woocommerce' ),
			)
		);

		woocommerce_wp_text_input(
			array(
				'id'                => '_competition_max_tickets',
				'class'             => 'input_text required',
				'size'              => '6',
				'label'             => esc_html__( 'Max tickets', 'competitions_for_woocommerce' ),
				'type'              => 'number',
				'custom_attributes' => array(
					'step' => 'any',
					'min'  => '1',
				),
				'desc_tip'          => 'true',
				'description'       => esc_html__( 'Maximum tickets to be sold', 'competitions_for_woocommerce' ),
			)
		);
		woocommerce_wp_text_input(
			array(
				'id'                => '_competition_max_tickets_per_user',
				'class'             => 'input_text',
				'size'              => '6',
				'label'             => esc_html__( 'Max tickets per user', 'competitions_for_woocommerce' ),
				'type'              => 'number',
				'custom_attributes' => array(
					'step' => 'any',
					'min'  => '0',
				),
				'desc_tip'          => 'true',
				'description'       => esc_html__( 'Maximum tickets sold per user', 'competitions_for_woocommerce' ),
			)
		);

		woocommerce_wp_text_input(
			array(
				'id'                => '_competition_num_winners',
				'class'             => 'input_text required',
				'size'              => '6',
				'label'             => esc_html__( 'Number of winners', 'competitions_for_woocommerce' ),
				'type'              => 'number',
				'custom_attributes' => array(
					'step' => 'any',
					'min'  => '0',
				),
				'desc_tip'          => 'true',
				'description'       => esc_html__( 'Number of possible winners', 'competitions_for_woocommerce' ),
			)
		);
		woocommerce_wp_checkbox(
			array(
				'id'            => '_competition_multiple_winner_per_user',
				'wrapper_class' => 'competition_single_winner_per_user',
				'label'         => esc_html__( 'Multiple prizes per user?', 'competitions_for_woocommerce' ),
				'description'   => esc_html__( 'Allow multiple prizes for single user if there are multiple competition winners', 'competitions_for_woocommerce' ),
				'desc_tip'      => 'true',
			)
		);
		woocommerce_wp_checkbox(
			array(
				'id'            => '_competition_manualy_winners',
				'wrapper_class' => '',
				'label'         => __( 'Manual winner picking', 'competitions_for_woocommerce' ),
				'description'   => __( 'Pick winners manually when competition has finished.', 'competitions_for_woocommerce' ),
				'desc_tip'      => 'true',
			)
		);

		$competition_dates_from =  get_post_meta( $post->ID, '_competition_dates_from', true ) ? get_post_meta( $post->ID, '_competition_dates_from', true ) : '';
		$competition_dates_to   = get_post_meta( $post->ID, '_competition_dates_to', true ) ? get_post_meta( $post->ID, '_competition_dates_to', true ) : '';

		echo '	<p class="form-field competition_dates_fields">
					<label for="_competition_dates_from">' . esc_html__( 'Competition from date', 'competitions_for_woocommerce' ) . '</label>
					<input type="text" class="short datetimepicker required" name="_competition_dates_from" id="_competition_dates_from" value="' . esc_attr( $competition_dates_from ) . '" placeholder="' . esc_html_x( 'From&hellip;', 'placeholder', 'competitions_for_woocommerce' ) . esc_html__( 'YYYY-MM-DD HH:MM' ) . '"maxlength="16" pattern="[0-9]{4}-(0[1-9]|1[012])-(0[1-9]|1[0-9]|2[0-9]|3[01])[ ](0[0-9]|1[0-9]|2[0-4]):(0[0-9]|1[0-9]|2[0-9]|3[0-9]|4[0-9]|5[0-9])" />
				 </p>
				 <p class="form-field competition_dates_fields">
					<label for="_competition_dates_to">' . esc_html__( 'Competition to date', 'competitions_for_woocommerce' ) . '</label>
					<input type="text" class="short datetimepicker required" name="_competition_dates_to" id="_competition_dates_to" value="' . esc_attr( $competition_dates_to ) . '" placeholder="' . esc_html_x( 'To&hellip;', 'placeholder', 'competitions_for_woocommerce' ) . esc_html__( 'YYYY-MM-DD HH:MM' ) . '" maxlength="16" pattern="[0-9]{4}-(0[1-9]|1[012])-(0[1-9]|1[0-9]|2[0-9]|3[01])[ ](0[0-9]|1[0-9]|2[0-4]):(0[0-9]|1[0-9]|2[0-9]|3[0-9]|4[0-9]|5[0-9])" />
				</p>';

		$product_type = method_exists( $product, 'get_type' ) ? $product->get_type() : $product->product_type;
		if ( 'competition' === $product_type && $product->get_competition_closed() === '1'  ) {
			echo '<p class="form-field extend_dates_fields"><a class="button extend" href="#" id="extendcompetition">' . esc_html__( 'Extend competition', 'competitions_for_woocommerce' ) . '</a>
				   <p class="form-field extend_competition_dates_fields">
						<label for="_extend_competition_dates_from">' . esc_html__( 'Extend Date', 'competitions_for_woocommerce' ) . '</label>
						<input type="text" class="short datetimepicker" name="_extend_competition_dates_to" id="_extend_competition_dates_to" value="" placeholder="' . esc_html_x( 'To&hellip; YYYY-MM-DD HH:MM', 'placeholder', 'competitions_for_woocommerce' ) . '" maxlength="16" pattern="[0-9]{4}-(0[1-9]|1[012])-(0[1-9]|1[0-9]|2[0-9]|3[01])[ ](0[0-9]|1[0-9]|2[0-4]):(0[0-9]|1[0-9]|2[0-9]|3[0-9]|4[0-9]|5[0-9])" />
					</p>
					</p>';
		}
		if ( 'competition' === $product_type && $product->is_closed() ) {
			echo '<p class="form-field relist_dates_fields"><a class="button relist" href="#" id="relistcompetition">' . esc_html__( 'Relist', 'competitions_for_woocommerce' ) . '</a>
				   <p class="form-field relist_competition_dates_fields">
						<label for="_relist_competition_dates_from">' . esc_html__( 'Relist Dates', 'competitions_for_woocommerce' ) . '</label>
						<input type="text" class="short datetimepicker" name="_relist_competition_dates_from" id="_relist_competition_dates_from" value="" placeholder="' . esc_html_x( 'From&hellip; YYYY-MM-DD HH:MM', 'placeholder', 'competitions_for_woocommerce' ) . '" maxlength="16" pattern="[0-9]{4}-(0[1-9]|1[012])-(0[1-9]|1[0-9]|2[0-9]|3[01])[ ](0[0-9]|1[0-9]|2[0-4]):(0[0-9]|1[0-9]|2[0-9]|3[0-9]|4[0-9]|5[0-9])" />
					</p>
					<p class="form-field relist_competition_dates_fields">
						<input type="text" class="short datetimepicker" name="_relist_competition_dates_to" id="_relist_competition_dates_to" value="" placeholder="' . esc_html_x( 'To&hellip; YYYY-MM-DD HH:MM', 'placeholder', 'competitions_for_woocommerce' ) . '" maxlength="16" pattern="[0-9]{4}-(0[1-9]|1[012])-(0[1-9]|1[0-9]|2[0-9]|3[01])[ ](0[0-9]|1[0-9]|2[0-4]):(0[0-9]|1[0-9]|2[0-9]|3[0-9]|4[0-9]|5[0-9])" />
					</p>';
				woocommerce_wp_checkbox(
					array(
						'value'         => 'no',
						'id'            => '_competition_delete_log_on_relist',
						'wrapper_class' => 'relist_competition_dates_fields',
						'label'         => esc_html__( 'Delete logs on relist?', 'competitions_for_woocommerce' ),
						'description'   => esc_html__( "Delete all logs for this competition on relist. It can't be undone!", 'competitions_for_woocommerce' ),
						'desc_tip'      => 'true',
					)
				);

				echo '</p>';

		}

		woocommerce_wp_checkbox(
			array(
				'id'            => '_competition_use_pick_numbers',
				'wrapper_class' => '',
				'label'         => __( 'Allow ticket numbers?', 'competitions_for_woocommerce' ),
				'description'   => __( 'Allow customer to pick ticket number(s) ', 'competitions_for_woocommerce' ),
				'desc_tip'      => 'true',
			)
		);
		woocommerce_wp_checkbox(
			array(
				'id'            => '_competition_pick_number_alphabet',
				'wrapper_class' => '',
				'label'         => __( 'Use alphabet?', 'competitions_for_woocommerce' ),
			)
		);
		woocommerce_wp_checkbox(
			array(
				'id'            => '_competition_pick_numbers_random',
				'wrapper_class' => '',
				'label'         => __( 'Randomly assign ticket number(s) without ticket number picking', 'competitions_for_woocommerce' ),
				'description'   => __( 'Customer gets random assing ticket number', 'competitions_for_woocommerce' ),
				'desc_tip'      => 'false',
			)
		);
		woocommerce_wp_checkbox(
			array(
				'id'            => '_competition_pick_number_use_tabs',
				'wrapper_class' => '',
				'label'         => __( 'Sort tickets in tabs?', 'competitions_for_woocommerce' ),
			)
		);

		woocommerce_wp_text_input(
			array(
				'id'                => '_competition_pick_number_tab_qty',
				'class'             => 'input_text',
				'size'              => '6',
				'label'         => __( 'Number of tickets per tab', 'competitions_for_woocommerce' ),
				'type'              => 'number',
				'custom_attributes' => array(
					'step' => '1',
					'min'  => '0',
				),
			)
		);

		woocommerce_wp_checkbox(
			array(
				'id'            => '_competition_use_answers',
				'wrapper_class' => '',
				'label'         => __( 'Force user to answer a question?', 'competitions_for_woocommerce' ),
				'description'   => __( 'Force user to answer a question before adding competition number to cart', 'competitions_for_woocommerce' ),
				'desc_tip'      => 'true',
			)
		);
		woocommerce_wp_checkbox(
			array(
				'id'            => '_competition_only_true_answers',
				'wrapper_class' => '',
				'label'         => __( 'Only allow true answers.', 'competitions_for_woocommerce' ),
				'description'   => __( 'Only allow users to pick correct answers', 'competitions_for_woocommerce' ),
				'desc_tip'      => 'true',
			)
		);
		include plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/html-meta-box-answers.php';

		if ( is_object($product) && 'competition' === $product->get_type() && '2' === $product->get_competition_closed() && 'yes' === get_post_meta( $post->ID, '_competition_manualy_winners', true ) ) {

			$competition_num_winners = intval( $product->get_competition_num_winners() );

			$i = 1;
			echo '<p>';
			echo '<h3>' . esc_html__( 'Manual winner picking' ) . '</h3>';
			while ( $i <= $competition_num_winners ) {
				$type = 'yes' === get_post_meta( $post->ID, '_competition_pick_number_alphabet', true ) ? 'text' : 'number';
				woocommerce_wp_text_input(
					array(
						'id'                => '_competition_manualy_winner_' . $i,
						'wrapper_class'     => '',
						/* translators: 1) ticket number */
						'description'       => sprintf( __( 'Enter number of winning ticket. Fom 1-%d', 'competitions_for_woocommerce' ), $product->get_max_tickets() ),
						'label'             => __( 'Winning ticket', 'competitions_for_woocommerce' ),
						'type'              => $type,
						'custom_attributes' => array(
							'step' => '1',
							'min'  => '1',
							'max'  => $product->get_max_tickets(),
						),
						'desc_tip'          => 'false',
					)
				);

				$i++;

			}
			echo '</p>';
			echo '<p>';
			woocommerce_wp_textarea_input(
				array(
					'id'            => '_competition_manualy_pick_text',
					'wrapper_class' => '',
					'label'         => __( 'Manual pick text', 'competitions_for_woocommerce' ),
					'description'   => __( 'Some text explaining how mmanual winner picking is done.', 'competitions_for_woocommerce' ),
					'desc_tip'      => 'true',
				)
			);
			echo '</p>';
		}
		wp_nonce_field( 'save_competition_data_' . $post->ID, 'save_competition_data' );
		do_action( 'woocommerce_product_options_competition' );

		echo '</div>';
	}

	/**
	 * Saves the data inputed into the product boxes, as post meta data
	 *
	 * @param stdClass $post the post (product)
	 *
	 */
	public function product_save_data( $post_id, $post ) {

		if ( ! isset( $_POST['save_competition_data'] ) || ! wp_verify_nonce( sanitize_text_field( $_POST['save_competition_data'] ), 'save_competition_data_' . $post_id ) ) {
			wp_die( esc_html__( 'Action failed. Please refresh the page and retry.', 'woocommerce' ) );
		} else {

			$product_type = empty( $_POST['product-type'] ) ? 'simple' : sanitize_title( wc_clean( $_POST['product-type'] ) );

			if ( 'competition' === $product_type ) {

				$product = wc_get_product( $post_id );

				if ( isset( $_POST['_competition_max_tickets'] ) && ! empty( $_POST['_competition_max_tickets'] ) ) {

					update_post_meta( $post_id, '_manage_stock', 'yes' );

					if ( get_post_meta( $post_id, '_competition_participants_count', true ) ) {
						update_post_meta( $post_id, '_stock', intval( wc_clean( $_POST['_competition_max_tickets'] ) ) - intval( get_post_meta( $post_id, '_competition_participants_count', true ) ) );
					} else {
						update_post_meta( $post_id, '_stock', wc_clean( $_POST['_competition_max_tickets'] ) );
					}

					update_post_meta( $post_id, '_backorders', 'no' );
				} else {

					update_post_meta( $post_id, '_manage_stock', 'no' );
					update_post_meta( $post_id, '_backorders', 'no' );
					update_post_meta( $post_id, '_stock_status', 'instock' );

				}

				if ( isset( $_POST['_competition_price'] ) && '' !== $_POST['_competition_price'] ) {

					$lottey_price = wc_format_decimal( wc_clean( $_POST['_competition_price'] ) );

					update_post_meta( $post_id, '_competition_price', $lottey_price );
					update_post_meta( $post_id, '_regular_price', $lottey_price );
					update_post_meta( $post_id, '_price', $lottey_price );

				} else {
					delete_post_meta( $post_id, '_competition_price' );
					delete_post_meta( $post_id, '_regular_price' );
					delete_post_meta( $post_id, '_price' );

				}

				if ( isset( $_POST['_competition_sale_price'] ) && '' !== $_POST['_competition_sale_price'] ) {
					$lottey_sale_price = wc_format_decimal( wc_clean( $_POST['_competition_sale_price'] ) );
					update_post_meta( $post_id, '_competition_sale_price', $lottey_sale_price );
					update_post_meta( $post_id, '_sale_price', $lottey_sale_price );
					update_post_meta( $post_id, '_price', $lottey_sale_price );
				} else {
					delete_post_meta( $post_id, '_competition_sale_price' );
					delete_post_meta( $post_id, '_sale_price' );
				}
				if ( ( '0' === $_POST['_competition_price'] || ! isset( $_POST['_competition_price'] ) ) && ( ! isset( $_POST['_competition_max_tickets_per_user'] ) || empty( $_POST['_competition_max_tickets_per_user'] ) ) ) {
						update_post_meta( $post_id, '_sold_individually', 'yes' );
				}
				if ( isset( $_POST['_competition_max_tickets_per_user'] ) && ! empty( $_POST['_competition_max_tickets_per_user'] ) ) {
					update_post_meta( $post_id, '_competition_max_tickets_per_user', wc_clean( $_POST['_competition_max_tickets_per_user'] ) );
					if ( $_POST['_competition_max_tickets_per_user'] <= 1 ) {
						update_post_meta( $post_id, '_sold_individually', 'yes' );
					} else {
						update_post_meta( $post_id, '_sold_individually', 'no' );
					}
				} else {
					delete_post_meta( $post_id, '_competition_max_tickets_per_user' );
					update_post_meta( $post_id, '_sold_individually', 'no' );
				}

				if ( isset( $_POST['_competition_num_winners'] ) && ! empty( $_POST['_competition_num_winners'] ) ) {
					update_post_meta( $post_id, '_competition_num_winners', wc_clean( $_POST['_competition_num_winners'] ) );
					if ( $_POST['_competition_num_winners'] <= 1 ) {
						update_post_meta( $post_id, '_competition_multiple_winner_per_user', 'no' );
					} else {
						if ( isset( $_POST['_competition_multiple_winner_per_user'] ) && ! empty( $_POST['_competition_multiple_winner_per_user'] ) ) {
							update_post_meta( $post_id, '_competition_multiple_winner_per_user', 'yes' );
						} else {
							update_post_meta( $post_id, '_competition_multiple_winner_per_user', 'no' );
						}
					}
				}

				if ( isset( $_POST['_competition_min_tickets'] ) ) {
					update_post_meta( $post_id, '_competition_min_tickets', wc_clean( $_POST['_competition_min_tickets'] ) );
				} else {
					delete_post_meta( $post_id, '_competition_min_tickets' );
				}
				if ( isset( $_POST['_competition_max_tickets'] ) ) {
					update_post_meta( $post_id, '_competition_max_tickets', wc_clean( $_POST['_competition_max_tickets'] ) );
				} else {
					delete_post_meta( $post_id, '_competition_max_tickets' );
				}
				if ( isset( $_POST['_competition_dates_from'] ) ) {
					update_post_meta( $post_id, '_competition_dates_from', wc_clean( $_POST['_competition_dates_from'] ) );
				}
				if ( isset( $_POST['_competition_dates_to'] ) ) {
					update_post_meta( $post_id, '_competition_dates_to', wc_clean( $_POST['_competition_dates_to'] ) );
				}
				if ( isset( $_POST['_competition_use_pick_numbers'] ) && ! empty( $_POST['_competition_use_pick_numbers'] ) ) {
				update_post_meta( $post_id, '_competition_use_pick_numbers', 'yes' );
				} else {
					update_post_meta( $post_id, '_competition_use_pick_numbers', 'no' );
				}
				if ( isset( $_POST['_competition_pick_numbers_random'] ) && ! empty( $_POST['_competition_pick_numbers_random'] ) &&  ( isset( $_POST['_competition_use_pick_numbers'] ) && ! empty( $_POST['_competition_use_pick_numbers'] ) ) ) {
					update_post_meta( $post_id, '_competition_pick_numbers_random', 'yes' );
				} else {
					update_post_meta( $post_id, '_competition_pick_numbers_random', 'no' );
				}

				if ( isset( $_POST['_competition_pick_number_use_tabs'] ) && ! empty( $_POST['_competition_pick_number_use_tabs'] ) ) {
					update_post_meta( $post_id, '_competition_pick_number_use_tabs', 'yes' );
				} else {
					update_post_meta( $post_id, '_competition_pick_number_use_tabs', 'no' );
				}
				if ( isset( $_POST['_competition_pick_number_alphabet'] ) && ! empty( $_POST['_competition_pick_number_alphabet'] ) ) {
					update_post_meta( $post_id, '_competition_pick_number_alphabet', 'yes' );
				} else {
					update_post_meta( $post_id, '_competition_pick_number_alphabet', 'no' );
				}
				if ( isset( $_POST['_competition_pick_number_tab_qty'] ) ) {
					update_post_meta( $post_id, '_competition_pick_number_tab_qty', intval( $_POST['_competition_pick_number_tab_qty'] ) );
				} else {
					delete_post_meta( $post_id, '_competition_pick_number_tab_qty' );
				}
				if ( isset( $_POST['_competition_use_answers'] ) && ! empty( $_POST['_competition_use_answers'] ) ) {
					update_post_meta( $post_id, '_competition_use_answers', 'yes' );
				} else {
					update_post_meta( $post_id, '_competition_use_answers', 'no' );
				}
				if ( isset( $_POST['_competition_manualy_winners'] ) && ! empty( $_POST['_competition_manualy_winners'] ) ) {
					update_post_meta( $post_id, '_competition_manualy_winners', 'yes' );
				} else {
					update_post_meta( $post_id, '_competition_manualy_winners', 'no' );
				}
				if ( isset( $_POST['_competition_pick_numbers_random'] ) && ! empty( $_POST['_competition_pick_numbers_random'] ) ) {
					update_post_meta( $post_id, '_competition_pick_numbers_random', 'yes' );
				} else {
					update_post_meta( $post_id, '_competition_pick_numbers_random', 'no' );
				}
				if ( isset( $_POST['_competition_only_true_answers'] ) && ! empty( $_POST['_competition_only_true_answers'] ) ) {
					update_post_meta( $post_id, '_competition_only_true_answers', 'yes' );
				} else {
					update_post_meta( $post_id, '_competition_only_true_answers', 'no' );
				}

				if ( 'yes' === get_post_meta( $post_id, '_competition_manualy_winners', true ) && $product->is_closed() ) {

					$old_competition_winners = get_post_meta( $post_id, '_competition_winners' );

					delete_post_meta( $post_id, '_competition_winners' );
					$winners                 = array();
					$competition_num_winners = isset( $_POST['_competition_num_winners'] ) ? intval( $_POST['_competition_num_winners'] ) : 1;

					$i = 1;
					while ( $i <= $competition_num_winners ) {
						if ( isset( $_POST['_competition_manualy_winner_' . $i ] ) && ( ! empty( $_POST['_competition_manualy_winner_' . $i ] ) || '0' === $_POST['_competition_manualy_winner_' . $i ] ) ) {
							if ( 'yes' === get_post_meta( $post->ID, '_competition_pick_number_alphabet', true ) ) {
								update_post_meta( $post_id, '_competition_manualy_winner_' . $i, wc_clean( $_POST[ '_competition_manualy_winner_' . $i ] ) );
								$int_winner = competitions_for_woocommerce_get_int_number_from_alphabet(  wc_clean( $_POST[ '_competition_manualy_winner_' . $i ] ), $product);
								update_post_meta( $post_id, '_competition_manualy_winner_int' . $i, $int_winner );
								$winners [ $i ] = $this->get_log_by_ticket_number( intval( $int_winner ), $post_id );

							} else {
								update_post_meta( $post_id, '_competition_manualy_winner_' . $i, intval( $_POST[ '_competition_manualy_winner_' . $i ] ) );
								$winners [ $i ] = $this->get_log_by_ticket_number( intval( $_POST[ '_competition_manualy_winner_' . $i ] ), $post_id );
							}
						}
						$i++;
					}

					if ( $winners ) {
						update_post_meta( $post_id, '_competition_winners', $winners );
					}

					foreach ( $winners as $key => $userid ) {
						add_user_meta( $userid, '_competition_win', $post_id );
						add_user_meta( $userid, '_competition_win_' . $post_id . '_position', $key );
					}

					if ( get_post_meta( $post_id, '_competition_winners' ) !== $old_competition_winners ) {
						do_action('wc_competition_close', $post_id);
						do_action('wc_competition_won', $post_id);
					}

					if ( isset( $_POST['_competition_manualy_pick_text'] ) && ! empty( $_POST['_competition_manualy_pick_text'] ) ) {
						update_post_meta( $post_id, '_competition_manualy_pick_text', wc_clean(  $_POST['_competition_manualy_pick_text'] ) );
					} else {
						delete_post_meta( $post_id, '_competition_manualy_pick_text' );
					}


				}

				if ( isset( $_POST['_competition_automatic_relist'] ) ) {
					update_post_meta( $post_id, '_competition_automatic_relist', wc_clean( $_POST['_competition_automatic_relist'] ) );
				} else {
					update_post_meta( $post_id, '_competition_automatic_relist', 'no' );
				}
				if ( isset( $_POST['_competition_automatic_relist_fail'] ) ) {
					update_post_meta( $post_id, '_competition_automatic_relist_fail', wc_clean( $_POST['_competition_automatic_relist_fail'] ) );
				} else {
					update_post_meta( $post_id, '_competition_automatic_relist_fail', 'no' );
				}
				if ( isset( $_POST['_competition_automatic_relist_save'] ) ) {
					update_post_meta( $post_id, '_competition_automatic_relist_save', wc_clean( $_POST['_competition_automatic_relist_save'] ) );
				} else {
					update_post_meta( $post_id, '_competition_automatic_relist_save', 'no' );
				}
				if ( isset( $_POST['_competition_relist_time'] ) ) {
					update_post_meta( $post_id, '_competition_relist_time', wc_clean( $_POST['_competition_relist_time'] ) );
				}
				if ( isset( $_POST['_competition_relist_duration'] ) ) {
					update_post_meta( $post_id, '_competition_relist_duration', wc_clean( $_POST['_competition_relist_duration'] ) );
				}


				do_action( 'competition_product_save_data', $post_id, $post);

				if ( isset( $_POST['_relist_competition_dates_from'] ) && isset( $_POST['_relist_competition_dates_to'] ) && ! empty( $_POST['_relist_competition_dates_from'] ) && ! empty( $_POST['_relist_competition_dates_to'] ) ) {
					$this->do_relist( $post_id, wc_clean( $_POST['_relist_competition_dates_from'] ), wc_clean( $_POST['_relist_competition_dates_to'] ) );
				}
				if ( isset( $_POST['_extend_competition_dates_to'] ) && ! empty( $_POST['_extend_competition_dates_to'] ) ) {
					$this->do_extend( $post_id, wc_clean( $_POST['_extend_competition_dates_to'] ) );
				}

				if ( isset( $_POST['clear_on_hold_orders'] ) ) {
					delete_post_meta( $post_id, '_order_hold_on' );
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



				$product->competition_update_lookup_table();
			}
		}
	}


	/**
	 * Relist  competition
	 *
	 * @param int, string, string
	 * @return void
	 *
	 */
	public static function do_relist( $post_id, $relist_from, $relist_to ) {
		global $wpdb;

		update_post_meta( $post_id, '_competition_dates_from', stripslashes( $relist_from ) );
		update_post_meta( $post_id, '_competition_dates_to', stripslashes( $relist_to ) );
		update_post_meta( $post_id, '_competition_relisted', current_time( 'mysql' ) );
		delete_post_meta( $post_id, '_competition_closed' );
		delete_post_meta( $post_id, '_competition_started' );
		delete_post_meta( $post_id, '_competition_has_started' );
		delete_post_meta( $post_id, '_competition_fail_reason' );
		delete_post_meta( $post_id, '_competition_participant_id' );
		delete_post_meta( $post_id, '_competition_participants_count' );
		delete_post_meta( $post_id, '_competition_winners' );
		delete_post_meta( $post_id, '_participant_id' );
		update_post_meta( $post_id, '_competition_relisted', current_time( 'mysql' ) );
		add_post_meta( $post_id, '_competition_relisted_history', current_time( 'mysql' ) );
		delete_post_meta( $post_id, '_order_hold_on' );

		$competition_max_tickets = get_post_meta( $post_id, '_competition_max_tickets', true );
		update_post_meta( $post_id, '_stock', $competition_max_tickets );
		update_post_meta( $post_id, '_stock_status', 'instock' );

		$competition_num_winners = isset( $_POST['_competition_num_winners'] ) ? intval( $_POST['_competition_num_winners'] ) : 1;

		$i = 1;
		while ( $i <= $competition_num_winners ) {
			delete_post_meta( $post_id, '_competition_manualy_winner_' . $i );
			$i++;
		}


		$order_id = get_post_meta( $post_id, '_order_id', true );
		// check if the custom field has a value
		if ( ! empty( $order_id ) ) {
			delete_post_meta( $post_id, '_order_id' );
		}

		$wpdb->delete(
			$wpdb->usermeta, array(
				'meta_key'   => 'my_competitions',
				'meta_value' => $post_id,
			), array( '%s', '%s' )
		);

		$wpdb->delete( $wpdb->prefix . 'cfw_log_reserved', array( 'competition_id' => intval( $post_id ) ) );

		if ( ! empty( $_POST['_competition_delete_log_on_relist'] ) ) {

			if ( ! isset( $_POST['save_competition_data'] ) || ! wp_verify_nonce( sanitize_text_field( $_POST['save_competition_data'] ), 'save_competition_data_' . $post_id ) ) {
				wp_die( esc_html__( 'Action failed. Please refresh the page and retry.', 'woocommerce' ) );
			} else {
				if ( 'yes' === sanitize_text_field( $_POST['_competition_delete_log_on_relist'] ) ) {
					self::del_competition_logs( $post_id );
				}
			}
		}

		do_action( 'woocommerce_competition_do_relist', $post_id, $relist_from, $relist_to );
	}
	/**
	 * Extend  competition
	 *
	 * @param int, string
	 * @return void
	 *
	 */
	public function do_extend( $post_id, $extend_to ) {
		update_post_meta( $post_id, '_competition_dates_to', stripslashes( $extend_to ) );
		update_post_meta( $post_id, '_competition_extended', current_time( 'mysql' ) );
		delete_post_meta( $post_id, '_competition_closed' );
		delete_post_meta( $post_id, '_competition_fail_reason' );

		do_action( 'woocommerce_competition_do_extend', $post_id, $extend_to);
	}

	/**
	 * Add dropdown to filter competition
	 *
	 * @param  (wp_query object) $query
	 *
	 * @return Void
	 */
	public function admin_posts_filter_restrict_manage_posts() {

		//only add filter to post type you want
		if ( isset( $_GET['post_type'] ) && 'product' === $_GET['post_type'] ) {
			$values = array(
				esc_html__( 'Active', 'competitions_for_woocommerce' )   => 'active',
				esc_html__( 'Finished', 'competitions_for_woocommerce' ) => 'finished',
				esc_html__( 'Fail', 'competitions_for_woocommerce' )     => 'fail',
			);
			?>
			<select name="wc_competition_filter">
			<option value=""><?php esc_html_e( 'Competition filter By ', 'competitions_for_woocommerce' ); ?></option>
				<?php
				$current_v = isset( $_GET['wc_competition_filter'] ) ? sanitize_text_field( $_GET['wc_competition_filter'] ) : '';
				foreach ( $values as $label => $value ) {
					printf(
						'<option value="%s"%s>%s</option>',
						 esc_attr( $value ),
						$value === $current_v ? ' selected="selected"' : '',
						esc_html( $label )
					);
				}
				?>
			</select>
			<?php
		}
	}

	/**
	 * If submitted filter by post meta
	 * make sure to change META_KEY to the actual meta key
	 * and POST_TYPE to the name of your custom post type
	 *
	 * @param  (wp_query object) $query
	 * @return Void
	 */
	public function admin_posts_filter( $query ) {
		global $pagenow;

		if ( isset( $_GET['post_type'] ) && 'product' === $_GET['post_type'] && is_admin() &&  'edit.php' === $pagenow && isset( $_GET['wc_competition_filter'] ) && !empty( $_GET['wc_competition_filter'] ) ) {

			switch ( $_GET['wc_competition_filter'] ) {
				case 'active':
					$query->query_vars['meta_query'] = array(

						array(
							'key'     => '_competition_closed',
							'compare' => 'NOT EXISTS',
						),
					);

					$taxquery = $query->get( 'tax_query' );
					if ( ! is_array( $taxquery ) ) {
						$taxquery = array();
					}
					$taxquery [] =
						array(
							'taxonomy' => 'product_type',
							'field'    => 'slug',
							'terms'    => 'competition',

						);

					$query->set( 'tax_query', $taxquery );
					break;
				case 'finished':
					$query->query_vars['meta_query'] = array(

						array(
							'key'     => '_competition_closed',
							'compare' => 'EXISTS',
						),
					);

					break;
				case 'fail':
					$query->query_vars['meta_key']   = '_competition_closed';
					$query->query_vars['meta_value'] = '1';

					break;

			}
		}
	}

	/**
	 *  Add competition setings tab to woocommerce setings page
	 *
	 *
	 */
	public function competition_settings_class( $settings ) {

				$settings[] = include plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-wc-settings-competition.php';
				return $settings;
	}

	/**
	 *  Add meta box to the product editing screen
	 *
	 *
	 */
	public function competition_meta() {

		global $post;

		$product_data = wc_get_product( $post->ID );
		if ( $product_data ) {
			$product_data_type = method_exists( $product_data, 'get_type' ) ? $product_data->get_type() : $product_data->product_type;
			if ( 'competition' === $product_data_type ) {
				add_meta_box( 'competition', __( 'Competition', 'competitions_for_woocommerce' ), array( $this, 'woocommerce_simple_competition_meta_callback' ), 'product', 'normal', 'default' );
			}
		}

	}


	 /**
	 * Competition order hold on
	 *
	 * Checks for competition product in order when order is created on checkout before payment
	 *
	 * @param int, array
	 * @return void
	 */
	public function competition_order_hold_on( $order_id ) {

		$order = new WC_Order( $order_id );
		if ( $order ) {
			$order_items = $order->get_items();
			if ( $order_items ) {
				foreach ( $order_items as $item_id => $item ) {
					if ( function_exists( 'wc_get_order_item_meta' ) ) {
						$item_meta = wc_get_order_item_meta( $item_id, '' );
					} else {
						$item_meta = method_exists( $order, 'wc_get_order_item_meta' ) ? $order->wc_get_order_item_meta( $item_id ) : $order->get_item_meta( $item_id );
					}
					$product_id   = $this->get_main_wpml_product_id( $item_meta['_product_id'][0] );
					$product_data = wc_get_product( $product_id );
					if ( $product_data && 'competition' === $product_data->get_type()  ) {
						update_post_meta( $order_id, '_competition', '1' );
						add_post_meta( $product_id, '_order_hold_on', $order_id );
					}
				}
			}
		}
	}
	 /**
	 * Competition order
	 *
	 * Checks for competition product in order and assign order id to competition product
	 *
	 * @param int, array
	 * @return void
	 */
	public function competition_order( $order_id ) {
		global $wpdb;
		$log = $wpdb->get_row( $wpdb->prepare( 'SELECT 1 FROM ' . $wpdb->prefix . 'cfw_log WHERE orderid=%d', $order_id ) );

		if ( ! is_null( $log ) ) {
			return;
		}

		$order = new WC_Order( $order_id );

		if ( $order ) {
			if ( $order->get_meta('woocommerce_competition_order_proccesed') ) {
				return;
			};
			$order->update_meta_data( 'woocommerce_competition_order_proccesed', time() );
			$order->save();
			$order_items = $order->get_items();

			if ( $order_items ) {
				foreach ( $order_items as $item_id => $item ) {
					if ( function_exists( 'wc_get_order_item_meta' ) ) {
						$item_meta = wc_get_order_item_meta( $item_id, '' );
					} else {
						$item_meta = method_exists( $order, 'wc_get_order_item_meta' ) ? $order->wc_get_order_item_meta( $item_id ) : $order->get_item_meta( $item_id );
					}

					$product_id   = $this->get_main_wpml_product_id( $item_meta['_product_id'][0] );
					$product_data = wc_get_product( $product_id );
					if ( $product_data && 'competition' === $product_data->get_type() ) {
						$competition_relisted = $product_data->get_competition_relisted();
						if ( $competition_relisted &&  $competition_relisted > $order->get_date_created()->date( 'Y-m-d H:i:s' ) ) {
							continue;
						}
						update_post_meta( $order_id, '_competition', '1' );
						add_post_meta( $product_id, '_order_id', $order_id );
						delete_post_meta( $product_id, '_order_hold_on', $order_id );
						$log_ids = array();
						if (apply_filters( 'competition_add_participants_from_order', true , $item, $order_id, $product_id ) ) {
							$qty          = intval($item_meta['_qty'][0]);
							$participants = get_post_meta( $product_id, '_competition_participants_count', true ) ? get_post_meta( $product_id, '_competition_participants_count', true ) : 0;

							update_post_meta( $product_id, '_competition_participants_count', intval( $participants ) + intval( $qty ) );
							$ticket_numbers     = isset( $item_meta[ __( 'Ticket number', 'competitions_for_woocommerce' ) ] ) ? $item_meta[ __( 'Ticket number', 'competitions_for_woocommerce' ) ] : '';
							$answer             = isset( $item_meta[ __( 'Answer', 'competitions_for_woocommerce' ) ] ) ? intval( $item_meta[ __( 'Answer', 'competitions_for_woocommerce' ) ][0] ) : '';
							$use_ticket_numbers = get_post_meta( $product_id, '_competition_use_pick_numbers', true );
							if ( 'yes' === $use_ticket_numbers ) {
								$duplicate_tickets = $this->check_if_tickets_exist( $product_id, $ticket_numbers );
								if ( ! empty( $duplicate_tickets ) ) {
									$order->update_status( 'on-hold', __( 'Order is on-hold because of duplicate ticket number.', 'competitions_for_woocommerce' ) );
									do_action('woocommerce_competition_duplicate_ticket_in_order_found', $order, $duplicate_tickets );
									throw new Exception( __('Duplicate ticket number in order', 'competitions_for_woocommerce') );
								}
							} else {
								$ticket_numbers = false;
							}

							$log_ids = $this->log_participant( $product_id, $order->get_user_id(), $order_id, $item, $qty, $ticket_numbers, $answer );
							$this->delete_reserved_tickets( $product_id, $ticket_numbers );
							do_action( 'wc_competition_participate_added', $product_id, $order->get_user_id(), $order_id, $log_ids, $item, $item_id );

							$max_tickets                    = intval( $product_data->get_max_tickets() );
							$competition_participants_count = intval( $product_data->get_competition_participants_count( 'edit' ) );
							$stock_qty                      = $max_tickets -$competition_participants_count ;
							update_post_meta( $product_id, '_stock', intval( $stock_qty ) );
						} else {
							$max_tickets                    = intval( $product_data->get_max_tickets() );
							$competition_participants_count = intval( $product_data->get_competition_participants_count( 'edit' ) );
							$stock_qty                      = $max_tickets -$competition_participants_count ;
							update_post_meta( $product_id, '_stock', intval( $stock_qty ) );
							do_action( 'wc_competition_participate_not_added', $product_id, $order->get_user_id(), $order_id, $log_ids, $item, $item_id );
						}
						do_action( 'wc_competition_participate', $product_id, $order->get_user_id(), $order_id, $log_ids, $item, $item_id );
					}
				}
			}
		}
	}


	/**
	 * Competition order canceled
	 *
	 * Checks for competition product in order and assign order id to competition product
	 *
	 * @param int, array
	 * @return void
	 */
	public function competition_order_canceled( $order_id ) {
		global $wpdb;
		$log = $wpdb->get_row( $wpdb->prepare( 'SELECT 1 FROM ' . $wpdb->prefix . 'cfw_log WHERE orderid=%d', $order_id ) );

		if ( is_null( $log ) ) {
			return;
		}

		$order = new WC_Order( $order_id );

		if ( $order ) {
			$order_items = $order->get_items();
			if ( $order_items ) {

				foreach ( $order_items as $item_id => $item ) {
					if ( function_exists( 'wc_get_order_item_meta' ) ) {
						$item_meta = wc_get_order_item_meta( $item_id, '' );
					} else {
						$item_meta = method_exists( $order, 'wc_get_order_item_meta' ) ? $order->wc_get_order_item_meta( $item_id ) : $order->get_item_meta( $item_id );
					}
					$product_id   = $this->get_main_wpml_product_id( $item_meta['_product_id'][0] );
					$product_data = wc_get_product( $product_id );
					if ( $product_data ) {
						$product_data_type = method_exists( $product_data, 'get_type' ) ? $product_data->get_type() : $product_data->product_type;
						if ( 'competition' === $product_data_type ) {
							update_post_meta( $order_id, '_competition', '1' );
							add_post_meta( $product_id, '_order_id', $order_id );
							delete_post_meta( $product_id, '_order_hold_on', $order_id );
							$log_ids = array();
							$ticket_numbers     = isset( $item_meta[ __( 'Ticket number', 'competitions_for_woocommerce' ) ] ) ? $item_meta[ __( 'Ticket number', 'competitions_for_woocommerce' ) ] : '';
							if ( ! empty( $ticket_numbers ) && is_array ( $ticket_numbers ) ) {
								$this->delete_reserved_tickets( $product_id, $ticket_numbers );
							}
							if (apply_filters( 'competition_remove_participants_from_order', true , $item, $order_id, $product_id ) ) {
								for ( $i = 0; $i < $item_meta['_qty'][0]; $i++ ) {
									$participants = get_post_meta( $product_id, '_competition_participants_count', true ) ? get_post_meta( $product_id, '_competition_participants_count', true ) : 0;
									if ( $participants > 0 ) {
										update_post_meta( $product_id, '_competition_participants_count', intval( $participants ) - 1 );
									}
									$this->remove_competition_from_user_metafield( $product_id, $order->get_user_id() );
									$log_ids[] = $this->delete_log_participant( $product_id, $order->get_user_id(), $order_id );
								}

								do_action( 'wc_competition_cancel_participation', $product_id, $order->get_user_id(), $order_id, $log_ids, $item, $item_id );
							}
							$max_tickets                    = intval( $product_data->get_max_tickets() );
							$competition_participants_count = intval( $product_data->get_competition_participants_count( 'edit' ) );
							$stock_qty                      = $max_tickets -$competition_participants_count ;
							update_post_meta( $product_id, '_stock', intval( $stock_qty ) );

						}
					}
				}
			}
		}
	}

	/**
	 * Competition order failed
	 *
	 * Checks for competition product in failed order
	 *
	 * @param int, array
	 * @return void
	 */
	public function competition_order_failed( $order_id ) {
		global $wpdb;

		$order = new WC_Order( $order_id );

		if ( $order ) {
			$order_items = $order->get_items();
			if ( $order_items ) {

				foreach ( $order_items as $item_id => $item ) {
					if ( function_exists( 'wc_get_order_item_meta' ) ) {
						$item_meta = wc_get_order_item_meta( $item_id, '' );
					} else {
						$item_meta = method_exists( $order, 'wc_get_order_item_meta' ) ? $order->wc_get_order_item_meta( $item_id ) : $order->get_item_meta( $item_id );
					}
					$product_id   = $this->get_main_wpml_product_id( $item_meta['_product_id'][0] );
					$product_data = wc_get_product( $product_id );
					if ( $product_data ) {
						$product_data_type = method_exists( $product_data, 'get_type' ) ? $product_data->get_type() : $product_data->product_type;
						if ( 'competition' === $product_data_type ) {
							delete_post_meta( $product_id, '_order_hold_on', $order_id );
						}
					}
					do_action( 'wc_competition_cancel_participation_failed', $product_id, $order->get_user_id(), $order_id, $log_ids = null , $item, $item_id );
				}
			}
		}
	}



	/**
	 * Delete logs when competition is deleted
	 *
	 * @param  string
	 * @return void
	 *
	 */
	public static function del_competition_logs( $post_id ) {
		global $wpdb;

		if ( $wpdb->get_var( $wpdb->prepare( 'SELECT competition_id FROM ' . $wpdb->prefix . 'cfw_log WHERE competition_id = %d', $post_id ) ) ) {
			$wpdb->query( $wpdb->prepare( 'DELETE FROM ' . $wpdb->prefix . 'cfw_log WHERE competition_id = %d', $post_id ) );
		}

		return true;
	}

	/**
	 * Delete logs when competition is deleted
	 *
	 * @param  string
	 * @return void
	 *
	 */
	public function get_count_from_competition_logs( $post_id, $user_id ) {
		global $wpdb;

		$relisteddate = get_post_meta( $post_id, '_competition_relisted', true );
		if ( ! empty( $relisteddate ) ) {
			$result = $wpdb->get_var( $wpdb->prepare( 'SELECT COUNT(1)  FROM ' . $wpdb->prefix . 'cfw_log WHERE competition_id = %d AND userid = %d AND CAST(date AS DATETIME) > %s ', $post_id, $user_id, $relisteddate ) );
		} else {
			$result = $wpdb->get_var( $wpdb->prepare( 'SELECT COUNT(1)  FROM ' . $wpdb->prefix . 'cfw_log WHERE competition_id = %d AND userid = %d' , $post_id, $user_id ) );
		}

		if ( $result ) {
			return $result;
		}

		return 0;
	}


	/**
	 * Duplicate post
	 *
	 * Clear metadata when copy competition
	 *
	 * @param  array
	 * @return string
	 *
	 */
	public function woocommerce_duplicate_product( $postid ) {

		$product = wc_get_product( $postid );

		if ( ! $product ) {
			return false;
		}
		if ( 'competition' !== $product->get_type() ) {
			return false;
		}

		delete_post_meta( $postid, '_competition_participants_count' );
		delete_post_meta( $postid, '_competition_closed' );
		delete_post_meta( $postid, '_competition_fail_reason' );
		delete_post_meta( $postid, '_competition_dates_to' );
		delete_post_meta( $postid, '_competition_dates_from' );
		delete_post_meta( $postid, '_order_id' );
		delete_post_meta( $postid, '_competition_winners' );
		delete_post_meta( $postid, '_participant_id' );
		delete_post_meta( $postid, '_competition_started' );
		delete_post_meta( $postid, '_competition_has_started' );
		delete_post_meta( $postid, '_competition_relisted' );

		return true;

	}

	 /**
	 * Log participant
	 *
	 * @param  int, int
	 * @return void
	 *
	 */
	public function log_participant( $product_id, $current_user_id, $order_id, $item, $qty, $ticket_numbers, $answer ) {
		global $wpdb;
		$log_ids = array();
		$override = apply_filters( 'woocommerce_competition_log_participant_override', false, $product_id, $current_user_id, $order_id, $item, $qty, $ticket_numbers, $answer );

		if ( $override ) {
			return $override;
		}

		if ( $qty  ) {

			$i = 0;
			while ( $i < intval($qty) ) {
				if ( ! empty ( $ticket_numbers ) && is_array( $ticket_numbers )  ) {
					$log_ids[] = $wpdb->query(
						$wpdb->prepare(
							'INSERT ' . $wpdb->prefix . 'cfw_log (userid, competition_id, ticket_number, answer_id, orderid, date ) VALUES (%d, %d, %d, %d, %d, %s)',
							$current_user_id,
							$product_id,
							$ticket_numbers[$i],
							$answer,
							$order_id ,
							current_time( 'mysql')
						)
					);
				} else {
					$log_ids[] = $wpdb->query(
						$wpdb->prepare(
							'INSERT ' . $wpdb->prefix . 'cfw_log (userid, competition_id, ticket_number, answer_id, orderid, date ) VALUES (%d, %d, %d, %d, %d, %s)',
							$current_user_id,
							$product_id,
							$ticket_numbers,
							$answer,
							$order_id,
							current_time( 'mysql')
						)
					);
				}

				$i++;
			}
			return $log_ids;

		} else {
			$wpdb->insert(
				$wpdb->prefix . 'cfw_log', array(
					'userid'     => $current_user_id,
					'competition_id' => $product_id,
					'ticket_number' => $ticket_number,
					'answer_id' => $answer_id,
					'orderid'    => $order_id,
					'date'       => current_time( 'mysql' ),
				), array( '%d', '%d', '%d', '%d', '%d', '%s' )
			);

			return $wpdb->insert_id;
		}
	}

	/**
	 * Delete Log competition  participant
	 *
	 * @param  int, int
	 * @return void
	 *
	 */
	public function delete_log_participant( $product_id, $current_user_id, $order_id ) {

		global $wpdb;

		$log_id = $wpdb->get_var( $wpdb->prepare( 'SELECT id FROM ' . $wpdb->prefix . 'cfw_log  WHERE userid= %d AND competition_id=%d AND orderid=%d', $current_user_id, $product_id, $order_id ) );
		if ( $log_id ) {
			$wpdb->query( $wpdb->prepare( 'DELETE FROM ' . $wpdb->prefix . 'cfw_log WHERE userid= %d AND competition_id=%d AND orderid=%d', $current_user_id, $product_id, $order_id ) );
		}
		return $log_id;
	}

	/**
	 * Delete reserved tickets
	 *
	 * @param  int, array
	 * @return void
	 *
	 */
	public function delete_reserved_tickets( $product_id, $tickets ) {
		global $wpdb;
		if ( ! $tickets ) {
			return;
		}
		$array = $tickets;
		array_unshift($array , $product_id );
		$results = $wpdb->query( $wpdb->prepare( 'DELETE FROM ' . $wpdb->prefix . 'cfw_log_reserved WHERE competition_id= %d AND ticket_number IN (' . implode(', ', array_fill( 0, count($tickets), '%s' ) ) . ')' , $array ) ) ;
		return $results;
	}

	/**
	 * Sync meta with wpml
	 *
	 * Sync meta trough translated post
	 *
	 * @param bool $url (default: false)
	 * @return void
	 *
	 */
	public function sync_metadata_wpml( $data ) {

		global $sitepress;

		if ( is_object($sitepress) ) {

			$deflanguage = $sitepress->get_default_language();

			if ( is_array( $data ) ) {
					$product_id = $data['product_id'];
			} else {
					$product_id = $data;
			}

			$meta_values = get_post_meta( $product_id );
			$orginalid   = $sitepress->get_original_element_id( $product_id, 'post_product' );
			$trid        = $sitepress->get_element_trid( $product_id, 'post_product' );
			$all_posts   = $sitepress->get_element_translations( $trid, 'post_product' );

			unset( $all_posts[ $deflanguage ] );

			if ( ! empty( $all_posts ) ) {

				foreach ( $all_posts as $key => $translatedpost ) {

					if ( isset( $meta_values['_competition_max_tickets'][0] ) ) {
							update_post_meta( $translatedpost->element_id, '_competition_max_tickets', $meta_values['_competition_max_tickets'][0] );
					}
					if ( isset( $meta_values['_competition_min_tickets'][0] ) ) {
							update_post_meta( $translatedpost->element_id, '_competition_min_tickets', $meta_values['_competition_min_tickets'][0] );
					}
					if ( isset( $meta_values['_competition_num_winners'][0] ) ) {
							update_post_meta( $translatedpost->element_id, '_competition_num_winners', $meta_values['_competition_num_winners'][0] );
					}
					if ( isset( $meta_values['_competition_dates_from'][0] ) ) {
							update_post_meta( $translatedpost->element_id, '_competition_dates_from', $meta_values['_competition_dates_from'][0] );
					}
					if ( isset( $meta_values['_competition_dates_to'][0] ) ) {
							update_post_meta( $translatedpost->element_id, '_competition_dates_to', $meta_values['_competition_dates_to'][0] );
					}
					if ( isset( $meta_values['_competition_closed'][0] ) ) {
							update_post_meta( $translatedpost->element_id, '_competition_closed', $meta_values['_competition_closed'][0] );
					}
					if ( isset( $meta_values['_competition_fail_reason'][0] ) ) {
							update_post_meta( $translatedpost->element_id, '_competition_fail_reason', $meta_values['_competition_fail_reason'][0] );
					}
					if ( isset( $meta_values['_order_id'][0] ) ) {
							update_post_meta( $translatedpost->element_id, '_order_id', $meta_values['_order_id'][0] );
					}

					if ( isset( $meta_values['_competition_participants_count'][0] ) ) {
							update_post_meta( $translatedpost->element_id, '_competition_participants_count', $meta_values['_competition_participants_count'][0] );
					}
					if ( isset( $meta_values['_competition_winners'][0] ) ) {
							update_post_meta( $translatedpost->element_id, '_competition_winners', $meta_values['_competition_winners'][0] );
					}
					if ( isset( $meta_values['_participant_id'][0] ) ) {
							delete_post_meta( $translatedpost->element_id, '_participant_id' );
						foreach ( $meta_values['_competition_winners'] as $key => $value ) {
								add_post_meta( $translatedpost->element_id, '_participant_id', $value );
						}
					}

					if ( isset( $meta_values['_regular_price'][0] ) ) {
							update_post_meta( $translatedpost->element_id, '_regular_price', $meta_values['_regular_price'][0] );
					}
					if ( isset( $meta_values['_competition_wpml_language'][0] ) ) {
							update_post_meta( $translatedpost->element_id, '_competition_wpml_language', $meta_values['_competition_wpml_language'][0] );
					}
				}
			}
		}
	}
	/**
	 *
	 * Add last language in use to custom meta of competition
	 *
	 * @param int
	 * @return void
	 *
	 */
	public function add_language_wpml_meta( $cart_item_key, $product_id, $quantity, $variation_id, $variation, $cart_item_data ) {

		$language = isset( $_SESSION['wpml_globalcart_language'] ) ? $_SESSION['wpml_globalcart_language'] : ICL_LANGUAGE_CODE;
		update_post_meta( $product_id, '_competition_wpml_language', $language );
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

		$product_id    = isset( $_POST['product_id'] ) ? absint( $_POST['product_id'] ) : '';
		$refund_amount = 0;
		$refund_reason = esc_html__( 'Competition failed. No minimum ticket sold', 'competitions_for_woocommerce' );
		$refund        = false;
		$response_data = array();

		$orders = self::get_product_orders( $product_id );

		$competition_order_refunded = get_post_meta( $product_id, '_competition_order_refunded' );

		foreach ( $orders as $key => $order_id ) {

			if ( in_array( $order_id, $competition_order_refunded, true ) ) {
				$error[ $order_id ] = esc_html__( 'Competition amount allready returned', 'competitions_for_woocommerce' );
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

						if ( function_exists( 'wc_get_order_item_meta' ) ) {
							$item_meta = wc_get_order_item_meta( $item_id, '' );
						} else {
							$item_meta = method_exists( $order, 'wc_get_order_item_meta' ) ? $order->wc_get_order_item_meta( $item_id ) : $order->get_item_meta( $item_id );
						}

						$product_data = wc_get_product( $item_meta['_product_id'][0] );
						if ( 'competition' === $product_data->get_type() && $item_meta['_product_id'][0] === $product_id ) {
							$item_ids[]                            = $product_data->get_id();
							$refund_amount                         = wc_format_decimal( $refund_amount ) + wc_format_decimal( $item_meta['_line_total'] [0] );
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
					throw new exception( __( 'Invalid refund amount', 'competitions_for_woocommerce' ) );
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
						throw new Exception( __( 'Refund failed', 'competitions_for_woocommerce' ) );
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
					$error[ $order_id ] = esc_html__( 'Payment gateway does not support refunds', 'competitions_for_woocommerce' );
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
	 * @since 1.0.1
	 * @param int $id the product ID to get orders for
	 * @param string fields  fields to retrieve
	 * @param string $filter filters to include in response
	 * @param string $status the order status to retrieve
	 * @param $page  $page   page to retrieve
	 * @return array
	 */
	public function get_product_orders( $id ) {
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

	/**
	 * Ouput custom columns for products.
	 *
	 * @param string $column
	 *
	 */
	public function render_product_columns( $column ) {

		global $post, $the_product;

		if ( empty( $the_product ) || $the_product->get_id() !== $post->ID ) {
			$the_product = wc_get_product( $post );
		}

		if ( 'product_type' === $column ) {
			$the_product_type = method_exists( $the_product, 'get_type' ) ? $the_product->get_type() : $the_product->product_type;
			if ( 'competition' === $the_product_type ) {
					$class  = '';
					$closed = $the_product->get_competition_closed();
				if ( '2' === $closed ) {
					$class .= ' finished ';
				}

				if ( '1' === $closed ) {
					$class .= ' fail ';
				}

				echo '<span class="competition-status ' . esc_attr( $class ) . '"></span>';
			}
		}

	}

	/**
	 * Search for [vendor] tag in recipients and replace it with author email
	 *
	 */
	public function add_vendor_to_email_recipients( $recipient, $object ) {
		$key         = false;
		$author_info = false;
		$arrayrec    = explode( ',', $recipient );
		if ( ! $object ) {
			return $recipient;
		}

		$post_id     = method_exists( $object, 'get_id' ) ? $object->get_id() : $object->id;
		$post_author = get_post_field( 'post_author', $post_id );
		if ( ! empty( $post_author ) ) {
			$author_info = get_userdata( $post_author );
			$key         = array_search( $author_info->user_email, $arrayrec, true );
		}

		if ( ! $key && $author_info ) {
			$recipient = str_replace( '[vendor]', $author_info->user_email, $recipient );

		} else {
			$recipient = str_replace( '[vendor]', '', $recipient );
		}

		return $recipient;
	}
	 /**
	 * Get main product id for multilanguage purpose
	 *
	 * @return int
	 *
	 */
	public function get_main_wpml_product_id( $id ) {

		return intval( apply_filters( 'wpml_object_id', $id, 'product', false, apply_filters( 'wpml_default_language', null ) ) );

	}
	/**
	* Add competition to user custom field
	*
	* @return void
	*
	*/
	public function add_competition_to_user_metafield( $product_id, $user_id ) {

		$my_competitions = get_user_meta( $user_id, 'my_competitions', false );
		if ( is_array($my_competitions) && ! in_array( $product_id, $my_competitions, true ) ) {
				add_user_meta( $user_id, 'my_competitions', $product_id, false );
		}
	}
	/**
	* Delete competition from user custom field
	*
	* @return void
	*
	*/
	public function remove_competition_from_user_metafield( $product_id, $user_id ) {
		$my_competitions = get_user_meta( $user_id, 'my_competitions', false );
		if ( in_array( $product_id, $my_competitions, true ) ) {
			delete_user_meta( $user_id, 'my_competitions', $product_id );
		}

	}
	/**
	 * Pick competition winners from array.
	 *
	 */
	public function pick_competition_winers_from_array( $participants, $product ) {
		$i       = 0;
		$winners = array();

		if ( is_array( $participants ) ) {

			$competition_num_winners = $product->get_competition_num_winners() ? $product->get_competition_num_winners() : 1;

			while ( $i <= ( $competition_num_winners - 1 ) ) {
				$winner_id         = '';
				$winners_key[ $i ] = wp_rand( 0, count( $participants ) - 1 );
				$winners[]         = $participants[ $winners_key[ $i ] ];
				$winner_id         = $participants[ $winners_key[ $i ] ]['userid'];
				if ( 'yes' === $product->get_competition_multiple_winner_per_user() ) {
					unset( $participants[ $winners_key[ $i ] ] );
				} else {
					foreach ( $participants as $key => $participant ) {
						if ( intval( $participant['userid'] ) === intval( $winner_id ) ) {
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

	/**
	 * Get user ID from ticket number.
	 *
	 */
	public function get_user_id_by_ticket_number( $ticket_number, $product_id ) {
		global $wpdb;

		$user_id = $wpdb->get_var( $wpdb->prepare( 'SELECT userid FROM ' . $wpdb->prefix . 'cfw_log WHERE competition_id = %d AND ticket_number = %d', $product_id, $ticket_number ) );

		return intval( $user_id );
	}
	/**
	 * Get log from ticker number.
	 *
	 */
	public function get_log_by_ticket_number( $ticket_number, $product_id ) {
		global $wpdb;

		$log = $wpdb->get_row( $wpdb->prepare( 'SELECT * FROM ' . $wpdb->prefix . 'cfw_log WHERE competition_id = %d AND ticket_number = %d', $product_id, $ticket_number ), ARRAY_A );

		return $log;
	}


	/**
	 *  Callback for adding a meta box to the product editing screen used in woocommerce_simple_competition_meta
	 *
	 */
	public function woocommerce_simple_competition_meta_callback() {

		global $post;
		$colspan               = 7;
		$product_data          = wc_get_product( $post->ID );
		$competition_winers    = get_post_meta( $post->ID, '_competition_winners', true );
		$order_hold_on         = get_post_meta( $post->ID, '_order_hold_on' );
		$use_answers           = competitions_for_woocommerce_use_answers( $post->ID );
		$use_ticket_numbers    = get_post_meta( $post->ID , '_competition_use_pick_numbers', true );
		$answers               = maybe_unserialize( get_post_meta( $post->ID, '_competition_answers', true ) );

		if ( $order_hold_on ) {
			$orders_links_on_hold = '';
			echo '<p>';
			esc_html_e( 'Some on hold orders are preventing this competition to end. Can you please check it! ', 'competitions_for_woocommerce' );
			foreach ( array_unique( $order_hold_on ) as $key => $order_hold_on_id ) {
				$orders_links_on_hold .= "<a href='" . admin_url( 'post.php?post=' . $order_hold_on_id . '&action=edit' ) . "'>$order_hold_on_id</a>, ";
			}
			echo wp_kses_post( rtrim( $orders_links_on_hold, ', ' ) );
			echo "<form><input type='hidden' name='clear_on_hold_orders' value='1'>";
			echo " <br><button class='button button-primary clear_orders_on_hold' data-product_id='" . intval( $product_data->get_id() ) . "'>" . esc_html__( 'Clear all on hold orders! ', 'competitions_for_woocommerce' ) . '</button>';
			echo '</form>';
			echo '</p>';
		}

		if ( is_object( $product_data ) ) {
			$competition_relisted = $product_data->get_competition_relisted();
		}

		if ( ! empty( $competition_relisted ) ) {
			?>
			<p><?php esc_html_e( 'competition has been relisted on:', 'competitions_for_woocommerce' ); ?> <?php echo esc_html( date_i18n( get_option( 'date_format' ), strtotime( $competition_relisted ) ) ) . ' ' . esc_html( date_i18n( get_option( 'time_format' ), strtotime( $competition_relisted ) ) ); ?></p>
		<?php
		}
		if ( ( $product_data->is_closed() === true ) && ( $product_data->is_started() === true ) ) :
			?>
			<p><?php esc_html_e( 'Competition has finished', 'competitions_for_woocommerce' ); ?></p>
			<?php
			if ( '1' === $product_data->get_competition_fail_reason() ) {
				echo '<p>';
					esc_html_e( 'Competition failed because there were no participants', 'competitions_for_woocommerce' );
					echo '</p>';
			} elseif ( '2' === $product_data->get_competition_fail_reason() ) {
				echo '<p>';
				esc_html_e( 'Competition failed because there was not enough participants', 'competitions_for_woocommerce' );
				echo " <button class='button button-primary do-api-refund' href='#' id='competition-refund' data-product_id='" . intval( $product_data->get_id() ) . "'>";
				esc_html_e( 'Refund ', 'competitions_for_woocommerce' );
				echo '</button>';
				echo '<div id="refund-status"></div>';
				echo '<//p>';
			}
			if ( ! empty( $competition_winers ) ) {
				if ( count( $competition_winers ) === 1 ) {
					$winner = reset( $competition_winers );
					if ( ! empty( $winner ) ) {

						?>
								<p>
									<?php esc_html_e( 'Competition winner is', 'competitions_for_woocommerce' ); ?>:
									<span><a href='<?php echo esc_url( get_edit_user_link( intval( $winner['userid'] ) ) ); ?>'><?php echo esc_html( get_userdata( intval( $winner['userid'] ) )->display_name ); ?></a></span>,
									<?php esc_html_e( 'Ticket', 'competitions_for_woocommerce' ); ?>:
									<span><?php echo esc_html( $winner['ticket_number'] ); ?></span>,
									<?php esc_html_e( 'Order', 'competitions_for_woocommerce' ); ?>:
									<span><a href='<?php echo esc_url( admin_url( 'post.php?post=' . intval( $winner['orderid'] ) . '&action=edit' ) ); ?>'><?php echo intval( $winner['orderid'] ); ?></a></span>
								</p>
						<?php } ?>
					<?php } else { ?>

					<p><?php esc_html_e( 'Competition winners are', 'competitions_for_woocommerce' ); ?>:
						<ul>
						<?php
						foreach ( $competition_winers as $key => $winner ) {
							if ( $winner ) {
								?>
								<li>
									<?php esc_html_e( 'competition winner is', 'competitions_for_woocommerce' ); ?>:
									<span><a href='<?php echo esc_url( get_edit_user_link( $winner['userid'] ) ); ?>'><?php echo esc_html( get_userdata( $winner['userid'] )->display_name ) ; ?></a></span>,
									<?php esc_html_e( 'Ticket', 'competitions_for_woocommerce' ); ?>:
									<span><?php echo esc_html( $winner['ticket_number'] ); ?></span>,
									<?php esc_html_e( 'Order', 'competitions_for_woocommerce' ); ?>:
									<span><a href='<?php echo esc_url( admin_url( 'post.php?post=' . $winner['orderid'] . '&action=edit' ) ); ?>'><?php echo intval( $winner['orderid'] ); ?></a></span>
								</li>
						<?php
							}
						}
						?>
						</ul>
					</p>

				<?php
					}

			}

		endif;
		?>
		<?php
		if ( get_option( 'competition_history_admin', 'yes' ) === 'yes' ) :
			$competition_history = apply_filters( 'woocommerce_competition_history_data', $product_data->competition_history() );
			$heading             = esc_html( apply_filters( 'woocommerce_competition_history_heading', __( 'Competition History', 'competitions_for_woocommerce' ) ) );
			?>
			<h2 class="old_competition_data"><?php echo esc_html( $heading ); ?></h2>
			<table class="competition-table">
				<thead>
					<tr>
						<th><?php esc_html_e( 'Date', 'competitions_for_woocommerce' ); ?></th>
						<th><?php esc_html_e( 'User', 'competitions_for_woocommerce' ); ?></th>
						<th><?php esc_html_e( 'Email', 'competitions_for_woocommerce' ); ?></th>
						<th><?php esc_html_e( 'First name', 'competitions_for_woocommerce' ); ?></th>
						<th><?php esc_html_e( 'Last name', 'competitions_for_woocommerce' ); ?></th>
						<th><?php esc_html_e( 'Address', 'competitions_for_woocommerce' ); ?></th>
						<th><?php esc_html_e( 'Phone', 'competitions_for_woocommerce' ); ?></th>
						<?php
						if ( 'yes' === $use_ticket_numbers ) :
							$colspan++;
							?>
							<th class="numbers"><?php esc_html_e('Ticket number', 'competitions_for_woocommerce'); ?></th>
						<?php endif; ?>
						<?php
						if (true === $use_answers) :
							$colspan++;
							?>
							<th class="answer"><?php esc_html_e('Answer', 'competitions_for_woocommerce'); ?></th>
						<?php endif; ?>

						<th><?php esc_html_e( 'Order', 'competitions_for_woocommerce' ); ?></th>
						<th class="actions"><?php esc_html_e( 'Actions', 'competitions_for_woocommerce' ); ?></th>
					</tr>
				</thead>

				<?php
				if ( $competition_history ) :
					foreach ( $competition_history as $history_value ) {

						if ( $history_value->date < $product_data->get_competition_relisted() && ! isset( $displayed_relist ) ) {
							echo '<tfoot>';
							echo '<tr>';
							echo '<td class="date">' . esc_html( date_i18n( get_option( 'date_format' ), strtotime( $product_data->get_competition_dates_from() ) ) ) . ' ' . esc_html( date_i18n( get_option( 'time_format' ), strtotime( $product_data->get_competition_dates_from() ) ) ) . '</td>';
							echo '<td colspan="' . intval( $colspan ) . '"  class="relist">';
							echo esc_html__( 'Competition relisted', 'competitions_for_woocommerce' );
							echo '</td>';
							echo '</tr>';
							echo '</tfoot>';
							echo '</table>';
							$displayed_relist = true;
							?>
							<h2 class="old_competition_data"><?php esc_html_e( 'competition Data Prior Relist', 'competitions_for_woocommerce' ); ?> </h2>
							<table class="competition-table">
								<thead>
									<tr>
										<th><?php esc_html_e( 'Date', 'competitions_for_woocommerce' ); ?></th>
										<th><?php esc_html_e( 'User', 'competitions_for_woocommerce' ); ?></th>
										<th><?php esc_html_e( 'Email', 'competitions_for_woocommerce' ); ?></th>
										<th><?php esc_html_e( 'First name', 'competitions_for_woocommerce' ); ?></th>
										<th><?php esc_html_e( 'Last name', 'competitions_for_woocommerce' ); ?></th>
										<th><?php esc_html_e( 'Address', 'competitions_for_woocommerce' ); ?></th>
										<th><?php esc_html_e( 'Phone', 'competitions_for_woocommerce' ); ?></th>
										<?php if ( 'yes' === $use_ticket_numbers ) : ?>
											<th class="numbers"><?php esc_html_e('Ticket number', 'competitions_for_woocommerce'); ?></th>
										<?php endif; ?>
										<?php if ( true === $use_answers ) : ?>
											<th class="answer"><?php esc_html_e('Answer', 'competitions_for_woocommerce'); ?></th>
										<?php endif; ?>
										<th><?php esc_html_e( 'Order', 'competitions_for_woocommerce' ); ?></th>
										<th class="actions"><?php esc_html_e( 'Actions', 'competitions_for_woocommerce' ); ?></th>
									</tr>
								</thead>
						<?php
						}
						echo '<tr>';
						echo '<td class="date">' . esc_html( date_i18n( get_option( 'date_format' ), strtotime( $history_value->date ) ) ) . ' ' . esc_html( date_i18n( get_option( 'time_format' ), strtotime( $history_value->date ) ) ) . '</td>';
						$order     = wc_get_order( $history_value->orderid );
						$user_data = get_userdata( $history_value->userid );
						echo "<td class='username'><a href='" . esc_url( get_edit_user_link( $history_value->userid ) ) . "'>" . esc_html( $user_data ? $user_data->display_name : '' ) . '</a></td>';
						echo "<td class='email'>" . esc_html( $order ? $order->get_billing_email() : '' ) . '</td>';
						echo "<td class='firstname'>" . esc_html( $order ? $order->get_billing_first_name(): '' ) . '</td>';
						echo "<td class='lastname'>" . esc_html( $order ? $order->get_billing_last_name() : '' ) . '</td>';
						echo "<td class='addres'>" . esc_html( $order ? $order->get_formatted_billing_address() : '' ) . '</td>';
						echo "<td class='phone'>" . esc_html( $order ? $order->get_billing_phone() : '' ) . '</td>';
						if ('yes' === $use_ticket_numbers ) {
							echo '<td class="ticket_number">' . esc_html( apply_filters( 'ticket_number_display_html', $history_value->ticket_number, $product_data) ) . '</td>';
						}
						if ( true === $use_answers ) {
							$answer = isset( $answers[$history_value->answer_id] ) ? $answers[$history_value->answer_id] : false;

							echo "<td class='answer'>";

							if ( is_array($answer) ) {
								echo esc_html( $answer['text'] );
							} else {
								echo '';
							}

							echo '</td>';
						}
						echo "<td class='orderid'><a href='" . esc_url( admin_url( 'post.php?post=' . $history_value->orderid . '&action=edit' ) ) . "'>" . intval( $history_value->orderid ) . '</a></td>';
						echo "<td class='action'> <a href='#' data-id='" . intval( $history_value->id ) . "' data-postid='" . intval( $post->ID ) . "'    >" . esc_html__( 'Delete', 'competitions_for_woocommerce' ) . '</a></td>';
						echo '</tr>';
					}
				endif;
				?>
				<tfoot>
					<tr class="start">
						<?php

							echo '<td class="date">' . esc_html( date_i18n( get_option( 'date_format' ), strtotime( $product_data->get_competition_dates_from() ) ) ) . ' ' . esc_html( date_i18n( get_option( 'time_format' ), strtotime( $product_data->get_competition_dates_from() ) ) ) . '</td>';

						if ( $product_data->is_started() === true ) {
							echo '<td colspan="' . intval( $colspan ) . '" class="started">';
							echo esc_html( apply_filters( 'competition_history_started_text', esc_html__( 'competition started', 'competitions_for_woocommerce' ), $product_data ) );
							echo '</td>';

						} else {
							echo '<td colspan="' . intval( $colspan ) . '" class="starting">';
							echo esc_html( apply_filters( 'competition_history_starting_text', esc_html__( 'competition starting', 'competitions_for_woocommerce' ), $product_data ) );
							echo '</td>';
						}
						?>
					</tr>
				</tfoot>
			</table>
		<?php endif; ?>
		</ul>
		<?php
		$history_competition_csv_files = get_post_meta($post->ID, '_history_competition_csv_files');
		if ( $history_competition_csv_files ) {
			$upload_dir = wp_upload_dir();
			?>
			<h2 class="history_competition_csv_files"><?php esc_html_e( 'Exported csv files', 'competitions_for_woocommerce' ); ?></h2>
			<table class="competition-files-table" width="100%">
				<thead>
					<tr>
						<th><?php esc_html_e( 'Date', 'competitions_for_woocommerce' ); ?></th>
						<th><?php esc_html_e( 'File', 'competitions_for_woocommerce' ); ?></th>
						<th><?php esc_html_e( 'Winners', 'competitions_for_woocommerce' ); ?></th>
						<th class="actions"><?php esc_html_e( 'Actions', 'competitions_for_woocommerce' ); ?></th>
					</tr>
				</thead>
				<?php
				foreach ( $history_competition_csv_files as $key => $file ) {
					if ( is_array( $file[3] ) ) {
						foreach ($file[3] as $winner) {
							$winner_string = get_userdata($winner['userid'])->display_name . ', ';
							if ( 'yes' === $use_ticket_numbers ) {
								$winner_string .= "<span class='ticket-number'>";
								$winner_string .= esc_html__( 'Ticket number: ', 'competitions_for_woocommerce' );
								$winner_string .= apply_filters( 'ticket_number_display_html' , $winner['ticket_number'], $product_data ) ;
								$winner_string .= ' </span>';
							}
							if ( true === $use_answers ) {
								$winner_string .= "<span class='ticket-answer'>";
								$winner_string .= esc_html__( 'Answer: ', 'competitions_for_woocommerce' );
								$answer         = isset( $answers[$winner['answer_id']]['text'] ) ? $answers[$winner['answer_id']]['text'] : '';
								$winner_string .= $answer;
								$winner_string .= '</span>';
							}
							echo '<br/>';
						}
					}
					echo '<tr>';
					echo '<td class="date">' . esc_html( date_i18n( get_option( 'date_format' ), intval( $file[2] ) ) ) . ' ' . esc_html( date_i18n( get_option( 'time_format' ), intval( $file[2] ) ) ) . '</td>';
					echo '<td class="path"><a href="' . esc_url( $upload_dir['baseurl'] . $file[0] ) . ' "> ' . esc_html( $file[1] ) . '</td>';
					echo '<td class="path">' . wp_kses_post( $winner_string ) . '</td>';
					echo '<td class="action"> <a href="#"" data-id = "' . intval( $key ) . '" data-file="' . esc_attr( $file[1] ) . '" data-postid="' . intval( $post->ID ) . '" >' . esc_html__( 'Delete', 'competitions_for_woocommerce' ) . '</a></td>';
					echo '</tr>';
				}
				?>
			</table>


		<?php
		}
	}

	public function remove_participants_if_wrong_answer( $data, $item, $order, $product_id ) {
		$ticket_numbers = array();
		$true_answer    = true;

		if ( 'yes' !== get_option( 'competitions_for_woocommerce_remove_ticket_wrong_answer' , 'no' ) ) {
			return $data;
		}

		$meta = $item->get_formatted_meta_data();

		if ( $meta ) {
			foreach ($meta as $key => $value) {

				if ( esc_html__( 'Ticket number', 'competitions_for_woocommerce' ) === $value->key ) {
					$ticket_numbers[] = $value->value;
				}
				if ( esc_html__( 'Answer', 'competitions_for_woocommerce' ) === $value->key ) {
					$true_answers = competitions_for_woocommerce_get_true_answers( $product_id );
					$answers_ids  = array_keys( $true_answers );
					$true_answer  = in_array( intval( $value->value ), $answers_ids, true);
				}
			}
			if ( ! $true_answer ) {
				if ( ! empty( $ticket_numbers ) ) {
					global $wpdb;
					$override = apply_filters( 'woocommerce_competition_remove_participants_if_wrong_answer_override', false, $ticket_numbers, $product_id);
					if ( ! $override ) {
						foreach ( $ticket_numbers as $ticket_number ) {
							$wpdb->query( $wpdb->prepare( 'DELETE FROM ' . $wpdb->prefix . 'cfw_log_reserved WHERE competition_id = %d AND ticket_number = %d ', $product_id, $ticket_number  ) );
						}
					}
					if ( get_post_meta( $product_id, '_competition_max_tickets', true ) ) {
						if ( get_post_meta( $product_id, '_competition_participants_count', true ) ) {
							update_post_meta( $product_id, '_stock', intval( get_post_meta( $product_id, '_competition_max_tickets', true ) ) - intval( get_post_meta( $product_id, '_competition_participants_count', true ) ) );
						} else {
							update_post_meta( $product_id, '_stock', wc_clean( get_post_meta( $product_id, '_competition_max_tickets', true ) ) );
						}
					}
				}

			}

			do_action( 'remove_participants_if_wrong_answer', $true_answer, $ticket_numbers, $order , $product_id);
			return $true_answer;
		}
		return $data;
	}


	public function check_for_duplicate_tickets_in_order( $order_id, $data ) {
		$error   = false;
		$tickets = array();
		$order   = new WC_Order( $order_id );
		if ( $order ) {
			$order_items = $order->get_items();
			if ( $order_items ) {
				foreach ( $order_items as $item_id => $item ) {
					$product_id   = $this->get_main_wpml_product_id(  $item->get_product_id() );
					$product_data = wc_get_product( $product_id );
					if ( $product_data && 'competition' === $product_data->get_type() ) {
						$item_meta        = function_exists( 'wc_get_order_item_meta' ) ? wc_get_order_item_meta( $item_id, '' ) : $order->get_item_meta( $item_id );
						$ticket_numbers   = isset( $item_meta[ __( 'Ticket number', 'competitions_for_woocommerce' ) ] ) ? $item_meta[ __( 'Ticket number', 'competitions_for_woocommerce' ) ] : array();
						$session_key      = WC()->session->get_customer_id();
						$reserved_numbers = competitions_for_woocommerce_get_reserved_numbers($product_id, $session_key);

						if ( is_array($ticket_numbers ) ) {
							if ( ! empty( array_intersect($ticket_numbers, wc_competition_pn_get_taken_numbers($product_id ) ) ) ) {
							$error   = true;
							$message = esc_html__( 'Order cancelled because of duplicate ticket number.', 'competitions_for_woocommerce' );
							}
							if ( ! empty( array_intersect($ticket_numbers, $reserved_numbers) ) ) {
							$error   = true;
							$message = esc_html__( 'Order cancelled because someone has reserved that ticket number.', 'competitions_for_woocommerce' );
							}
						}

						if ( !isset( $tickets[$product_id] ) ) {
							$tickets[$product_id] = $ticket_numbers;
						} else {
							$tickets[$product_id] = array_merge($tickets[$product_id], $ticket_numbers) ;
						}
					}
				}
			}
		}

		if ( $tickets ) {
			foreach ($tickets as $product_id => $value) {
				if ( count(array_unique($value))<count($value)) {
					$error = true;
				}
				if ( false === $error ) {
					wc_competition_reserve_ticket( $product_id, $value, WC()->session->get_customer_id() );
				}
			}
		}

		if ( true === $error ) {
			$order->update_status( 'cancelled', $message );
			throw new Exception( $message  );
		}
	}

	public function filter_duplicate_ticket_in_order( $data, $item, $order_id, $product_id ) {
		global $wpdb;
		$tickets = array();
		$order   = wc_get_order( $order_id );
		$meta    = $item->get_formatted_meta_data();

		if ( 'yes' !== get_post_meta( $product_id, '_competition_use_pick_numbers', true ) ) {
			return $data;
		}

		if ( $meta ) {
			foreach ($meta as $key => $value) {
				if ( esc_html__( 'Ticket number', 'competitions_for_woocommerce' ) === $value->key ) {
					$tickets[] = $value->value;

				}

			}
		}
		if ( ! empty( $tickets ) ) {
			$duplicat_ticket = $this->check_if_tickets_exist($product_id, $tickets );
			if ( $duplicat_ticket ) {
				$order->update_status( 'on-hold', esc_html__( 'Order is on-hold because of duplicate ticket number.', 'competitions_for_woocommerce' ) );
				do_action('woocommerce_competition_duplicate_ticket_in_order_found', $order, $duplicat_ticket );
				throw new Exception( __('Duplicate ticket number in order', 'competitions_for_woocommerce') );
			}
		}
		return $data;
	}


	public function check_if_tickets_exist( $competition_id, $tickets ) {
		global $wpdb;

		if ( empty( $tickets ) ) {
			return false;
		}

		$duplicate_tickets = array();

		$relisteddate        = get_post_meta( $competition_id, '_competition_relisted', true );
		$tickets_count       = count($tickets);
		$stringPlaceholders  = array_fill(0, $tickets_count, '%d');
		$placeholders_ticket = implode(', ', $stringPlaceholders);
		$values              =  array_merge($tickets, array( $competition_id ) );
		$values[]            = $relisteddate;

		$override = apply_filters( 'woocommerce_competition_check_if_tickets_exist_override', false, $competition_id, $tickets);

		if ( $override ) {
			return $override;
		}
		if ( $relisteddate ) {
			foreach ( $tickets as $ticketnumber ) {
				$results = $wpdb->get_var( $wpdb->prepare( 'SELECT ticket_number FROM ' . $wpdb->prefix . 'cfw_log WHERE `ticket_number` = %d and competition_id= %d AND CAST(date AS DATETIME) > %s', $ticketnumber, $competition_id, $relisteddate ) );
				if ( $results ) {
					$duplicate_tickets[] = $results;
				}
			}

		} else {

			foreach ( $tickets as $ticketnumber ) {
				$results = $wpdb->get_var( $wpdb->prepare( 'SELECT ticket_number FROM ' . $wpdb->prefix . 'cfw_log WHERE `ticket_number` = %d and competition_id= %d', $ticketnumber, $competition_id ) );
				if ( $results ) {
					$duplicate_tickets[] = $results;
				}
			}

		}


		return $duplicate_tickets;
	}

	/**
	 *  Add competition relist meta box to the product editing screen
	 *
	 */
	public function automatic_relist_meta_boxes() {

		add_meta_box( 'Automatic_relist_competition', esc_html__( 'Automatic relist competition', 'competitions_for_woocommerce' ), array( $this, 'automatic_relist_meta_boxes_callback' ), 'product', 'normal' );

	}
	/**
	 *  Callback for adding a meta box to the product editing screen used for automatic relist
	 *
	 */
	public function automatic_relist_meta_boxes_callback() {

		global $post;

		$product_data = wc_get_product( $post->ID );
		$heading      = esc_html( apply_filters( 'woocommerce_competition_history_heading', esc_html__( 'competition automatic relist', 'competitions_for_woocommerce' ) ) );

		echo '<div class="woocommerce_options_panel ">';
		woocommerce_wp_checkbox(
			array(
				'id'            => '_competition_automatic_relist',
				'wrapper_class' => '',
				'label'         => esc_html__( 'Automatic relist competition', 'competitions_for_woocommerce' ),
				'description'   => esc_html__(
					'Enable automatic relisting',
					'competitions_for_woocommerce'
				),
			)
		);
		woocommerce_wp_checkbox(
			array(
				'id'            => '_competition_automatic_relist_fail',
				'wrapper_class' => '',
				'label'         => esc_html__( 'Relist competition only if failed', 'competitions_for_woocommerce' ),
				'description'   => esc_html__(
					'Relist competition only if failed',
					'competitions_for_woocommerce'
				),
			)
		);
		woocommerce_wp_checkbox(
			array(
				'id'            => '_competition_automatic_relist_save',
				'wrapper_class' => '',
				'label'         => esc_html__( 'Save competition participants to csv file for export', 'competitions_for_woocommerce' ),
				'description'   => esc_html__(
					'Save competition participants to csv file for export',
					'competitions_for_woocommerce'
				),
			)
		);
		woocommerce_wp_text_input(
			array(
				'id'                => '_competition_relist_time',
				'class'             => 'wc_input_price short',
				'label'             => esc_html__( 'Relist after n hours', 'competitions_for_woocommerce' ),
				'type'              => 'number',
				'custom_attributes' => array(
					'step' => 'any',
					'min'  => '0',
				),
			)
		);

		woocommerce_wp_text_input(
			array(
				'id'                => '_competition_relist_duration',
				'class'             => 'wc_input_price short',
				'label'             => esc_html__( 'Relist competition duration in h', 'competitions_for_woocommerce' ),
				'type'              => 'number',
				'custom_attributes' => array(
					'step' => 'any',
					'min'  => '0',
				),
			)
		);

		echo '</div>';
	}

	/**
	 * Get all lotteries that need to be relisted depending on parameter set
	 *
	 * @param int
	 * @return void
	 *
	 */
	public static function automatic_relist_competition( $post_id ) {


		$product                      = wc_get_product( $post_id );
		$competition_relist_duration  = get_post_meta( $post_id, '_competition_relist_duration', true );
		$competition_automatic_relist = get_post_meta( $post_id, '_competition_automatic_relist', true );

		if ( 'yes' === $competition_automatic_relist && $product->is_finished() && $competition_relist_duration ) {

			$competition_relist_time           = intval( get_post_meta( $post_id, '_competition_relist_time', true ) );
			$competition_automatic_relist_fail = intval( get_post_meta( $post_id, '_competition_automatic_relist_fail', true ) );

			$current_datetime = current_datetime();
			$localtime        = $current_datetime->getTimestamp() + $current_datetime->getOffset();

			$from_time = gmdate( 'Y-m-d H:i', $localtime );
			$to_time   = gmdate( 'Y-m-d H:i', $localtime + ( $competition_relist_duration * 3600 ) );

			if ( $product->get_competition_closed() && $competition_relist_time ) {
				if ( 'yes' === $competition_automatic_relist_fail && '1' !==$product->get_competition_closed() ) {
					return;
				}
				if ( $localtime > ( strtotime( $product->get_competition_dates_to() ) + ( intval( $competition_relist_time ) * 3600 ) ) ) {
					do_action( 'woocomerce_before_relist_competition', $post_id );
					self::export_to_csv($post_id);
					self::do_relist( $post_id, $from_time, $to_time );
					do_action( 'woocomerce_after_relist_competition', $post_id );
					return;
				}
			}
		}

	}

	public static function export_to_csv( $post_id ) {

		$product_data           = wc_get_product( $post_id );
		$relisteddate           = get_post_meta( $post_id, '_competition_relisted', true );
		$competition_history    = apply_filters( 'woocommerce_competition_history_data', $product_data->competition_history($relisteddate) );
		$path                   = apply_filters( 'woocommerce_competition_export_dir_path', wp_upload_dir());
		$current_datetime       = current_datetime();
		$timestamp              = $current_datetime->getTimestamp() + $current_datetime->getOffset();
		$filename               = $product_data->get_slug() . '-' . $timestamp . '.csv';
		$filename               = apply_filters( 'woocommerce_competition_export_filename', $filename , $product_data );
		$competition_upload_dir = apply_filters( 'woocommerce_competition_export_dir_path', '/wc-competition-export/');
		$upload_dir             =  $path['basedir'] . $competition_upload_dir;

		if (! is_dir($upload_dir)) {
			mkdir( $upload_dir, 0700 );
		}
		$outstream = fopen( $upload_dir . '/' . $filename, 'w' );

		$use_answers        = competitions_for_woocommerce_use_answers( $post_id );
		$use_ticket_numbers = get_post_meta( $post_id , '_competition_use_pick_numbers', true );
		$answers            = maybe_unserialize( get_post_meta( $post_id, '_competition_pn_answers', true ) );
		$fields = array(
			esc_html__( 'Date', 'competitions_for_woocommerce' ),
			esc_html__( 'User', 'competitions_for_woocommerce' ),
			esc_html__( 'Email', 'competitions_for_woocommerce' ),
			esc_html__( 'First name', 'competitions_for_woocommerce' ),
			esc_html__( 'Last name', 'competitions_for_woocommerce' ),
			esc_html__( 'Address', 'competitions_for_woocommerce' ),
			esc_html__( 'Phone', 'competitions_for_woocommerce' )
		);
		if ('yes' === $use_ticket_numbers ) {
			$fields[] = esc_html__( 'Ticket number', 'competitions_for_woocommerce' );
		}
		if (true === $use_answers ) {
			$fields[] = esc_html__( 'Answer number', 'competitions_for_woocommerce' );
		}
		$fields[] = esc_html__( 'Order', 'competitions_for_woocommerce' );

		$fields = apply_filters( 'woocommerce_competition_export_fields', $fields, $product_data );

		fputcsv($outstream, $fields);

		$values = array();    // initialize the array


		foreach ( $competition_history as $history_value ) {
			$user_data = get_userdata( $history_value->userid );
			$order     = wc_get_order( $history_value->orderid );

			$values = array(
			date_i18n( get_option( 'date_format' ), strtotime( $history_value->date )) . ' ' . date_i18n( get_option( 'time_format' ), strtotime( $history_value->date )),
			$user_data ? $user_data->display_name : $history_value->userid,
			$order ? $order->get_billing_email() : '',
			$order ? $order->get_billing_first_name(): '',
			$order ? $order->get_billing_last_name() : '',
			$order ? $order->get_formatted_billing_address() : '',
			$order ? $order->get_billing_phone() : '',
			);
			if ( 'yes' === $use_ticket_numbers ) {
				$values[] = apply_filters( 'ticket_number_display_html', $history_value->ticket_number, $product_data );
			}
			if ( true === $use_answers ) {
				$answer   = isset( $answers[$history_value->answer_id] ) ? $answers[$history_value->answer_id] : false;
				$values[] = esc_html( $answer['text'] );
			}
			$values[] = $history_value->orderid;
			fputcsv($outstream, $values);  //output the user info line to the csv file
		}
		fclose($outstream);

		$history_winners = get_post_meta($post_id, '_competition_winners', true);

		add_post_meta($post_id, '_history_competition_csv_files' , array( $competition_upload_dir . $filename, $filename, $timestamp, $history_winners ) );

	}

	public function add_ticket_numbers_to_order_items( $item, $cart_item_key, $values, $order ) {
		$product = $values['data'];
		if ( 'yes' === get_post_meta( $product->get_id() , '_competition_pick_numbers_random', true ) ) {
			$values['competition_tickets_number'] = competitions_for_woocommerce_generate_random_ticket_numbers( $product->get_id(), $values['quantity'] );
			if ( false === $values['competition_tickets_number'] ) {
				/* translators: 1) product name 2) stock number remaining */
				throw new Exception( sprintf( __( 'You cannot add that amount of &quot;%1$s&quot; to the cart because there is not enough stock (%2$s remaining).', 'competitions_for_woocommerce' ), $product->get_name(), wc_format_stock_quantity_for_display( $product->get_stock_quantity(), $product ) ) );
			}
		}
		if ( empty( $values['competition_tickets_number'] ) ) {
				return;
		}

		foreach ( $values['competition_tickets_number'] as $key => $ticket_number ) {
			$item->add_meta_data( __( 'Ticket number', 'competitions_for_woocommerce' ), $ticket_number );
		}


	}


	public function add_ticket_answer_to_order_items( $item, $cart_item_key, $values, $order ) {
		if ( empty( $values['competition_answer'] ) ) {
				return;
		}

		$item->add_meta_data( __( 'Answer', 'competitions_for_woocommerce' ), $values['competition_answer'] );

	}

}
