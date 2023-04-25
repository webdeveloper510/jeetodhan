<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://wpinstitut.com/
 * @since      1.0.0
 *
 * @package    Competitions_For_Woocommerce
 * @subpackage Competitions_For_Woocommerce/includes
 */
class Competitions_For_Woocommerce {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @var      Competitions_For_Woocommerce_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * The single instance of the class.
	 *
	 * @var WooCommerce
	 * @since 2.1
	 */
	protected static $instance = null;

	/**
	 * The admin plugin object
	 *
	 * @since    2.0.0
	 * @var      object
	 */
	public $plugin_admin;

	/**
	 * The public plugin object
	 *
	 * @since    2.0.0
	 * @var      object
	 */
	public $plugin_public;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->define_constants();

		$this->version     = COMPETITIONS_FOR_WOOCOMMERCE_VERSION;
		$this->plugin_name = 'competitions_for_woocommerce';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}
	/**
	 * Define CFW Constants.
	 */
	private function define_constants() {
		if ( ! defined( 'COMPETITIONS_FOR_WOOCOMMERCE_PLUGIN_BASENAME' ) ) {
			define( 'COMPETITIONS_FOR_WOOCOMMERCE_PLUGIN_BASENAME', plugin_basename( COMPETITIONS_FOR_WOOCOMMERCE_PLUGIN_FILE ) );
		}
		if ( ! defined( 'COMPETITIONS_FOR_WOOCOMMERCE_ABSPATH' ) ) {
			define( 'COMPETITIONS_FOR_WOOCOMMERCE_ABSPATH', dirname( COMPETITIONS_FOR_WOOCOMMERCE_PLUGIN_FILE ) . '/' );
		}
	}

	/**
	 * Main Plugin Instance.
	 *
	 * Ensures only one instance of plugin is loaded or can be loaded.
	 *
	 * @since 2.0.0
	 * @return Main instance.
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}


	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Competitions_for_woocommerce_Loader. Orchestrates the hooks of the plugin.
	 * - Competitions_For_Woocommerce_I18n. Defines internationalization functionality.
	 * - Competitions_for_woocommerce_Admin. Defines all hooks for the admin area.
	 * - Competitions_for_woocommerce_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @a1ccess   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once COMPETITIONS_FOR_WOOCOMMERCE_ABSPATH . 'includes/class-competitions_for_woocommerce-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once COMPETITIONS_FOR_WOOCOMMERCE_ABSPATH . 'includes/class-competitions_for_woocommerce-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once COMPETITIONS_FOR_WOOCOMMERCE_ABSPATH . 'admin/class-competitions_for_woocommerce-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once COMPETITIONS_FOR_WOOCOMMERCE_ABSPATH . 'public/class-competitions_for_woocommerce-public.php';

		$this->loader = new Competitions_For_Woocommerce_Loader();

		require_once COMPETITIONS_FOR_WOOCOMMERCE_ABSPATH . 'includes/competitions_for_woocommerce-functions.php';


		require_once COMPETITIONS_FOR_WOOCOMMERCE_ABSPATH . 'includes/class-wc-product-competition.php' ;

		require_once COMPETITIONS_FOR_WOOCOMMERCE_ABSPATH . 'includes/class-competitions_for_woocommerce-ajax.php';

		/**
		 * The class responsible for cronjobs.
		 */
		require_once COMPETITIONS_FOR_WOOCOMMERCE_ABSPATH . 'includes/class-competitions_for_woocommerce-cronjobs.php';

		if ( ! is_admin() ) {
			/**
			 * The class responsible for modifiying query
			 */
			require_once COMPETITIONS_FOR_WOOCOMMERCE_ABSPATH . 'public/class-competitions_for_woocommerce-query.php';

			/**
			 * The class responsible for shortcodes
			 */
			//require_once COMPETITIONS_FOR_WOOCOMMERCE_ABSPATH . 'public/class-competitions_for_woocommerce-shortcodes.php';
		}

		require_once COMPETITIONS_FOR_WOOCOMMERCE_ABSPATH . 'public/class-competitions_for_woocommerce-entry-list-tables.php';

		require_once COMPETITIONS_FOR_WOOCOMMERCE_ABSPATH . 'public/competitions_for_woocommerce-template-functions.php';

		/**
		 * Shortcodes
		 */
		require_once COMPETITIONS_FOR_WOOCOMMERCE_ABSPATH . 'public/shortcodes/class-competitions_for_woocommerce-shortcodes.php' ;
		require_once COMPETITIONS_FOR_WOOCOMMERCE_ABSPATH . 'public/shortcodes/class-shortcode-competition.php' ;

		$this->shortcodes = new Competitions_For_Woocommerce_Shortcodes();



	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Competitions_For_Woocommerce_I18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 */
	private function set_locale() {

		$plugin_i18n = new Competitions_For_Woocommerce_I18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 */
	private function define_admin_hooks() {

		$this->plugin_admin = new Competitions_For_Woocommerce_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $this->plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $this->plugin_admin, 'enqueue_scripts' );

		$this->loader->add_action( 'admin_init', $this->plugin_admin, 'check_environment' );
		$this->loader->add_action( 'admin_notices', $this->plugin_admin, 'admin_notices' );
		$this->loader->add_action( 'wp_loaded', $this->plugin_admin, 'hide_notices' );
		$this->loader->add_action( 'restrict_manage_posts', $this->plugin_admin, 'admin_posts_filter_restrict_manage_posts', 50 );
		$this->loader->add_filter( 'parse_query', $this->plugin_admin, 'admin_posts_filter', 20 );

		$this->loader->add_filter( 'product_type_selector', $this->plugin_admin, 'add_product_type', 10, 2 );
		$this->loader->add_filter( 'woocommerce_product_data_tabs', $this->plugin_admin, 'product_write_panel_tab', 1 );
		$this->loader->add_action( 'woocommerce_product_data_panels', $this->plugin_admin, 'product_write_panel' );
		$this->loader->add_action( 'woocommerce_process_product_meta', $this->plugin_admin, 'product_save_data', 80, 2 );
		$this->loader->add_action( 'add_meta_boxes', $this->plugin_admin, 'competition_meta' );
		$this->loader->add_filter( 'add_meta_boxes', $this->plugin_admin, 'automatic_relist_meta_boxes', 10);

		$this->loader->add_filter( 'woocommerce_get_settings_pages', $this->plugin_admin, 'competitions_settings_class', 20 );

		$this->loader->add_action( 'woocommerce_checkout_create_order_line_item', $this->plugin_admin, 'add_ticket_numbers_to_order_items', 10, 4 );
		$this->loader->add_action( 'woocommerce_checkout_create_order_line_item', $this->plugin_admin, 'add_ticket_answer_to_order_items', 10, 4 );

		//order
		$this->loader->add_action( 'woocommerce_checkout_update_order_meta', $this->plugin_admin, 'competition_order_hold_on', 10  );
		$this->loader->add_action( 'woocommerce_order_status_processing', $this->plugin_admin, 'competition_order', 10, 1 );
		$this->loader->add_action( 'woocommerce_order_status_completed', $this->plugin_admin, 'competition_order', 10, 1 );
		$this->loader->add_action( 'woocommerce_order_status_cancelled', $this->plugin_admin, 'competition_order_canceled', 10, 1 );
		$this->loader->add_action( 'woocommerce_order_status_refunded', $this->plugin_admin, 'competition_order_canceled', 10 , 1 );
		$this->loader->add_action( 'woocommerce_order_status_cancelled', $this->plugin_admin, 'competition_order_failed', 10 , 1 );
		$this->loader->add_action( 'woocommerce_order_status_failed', $this->plugin_admin, 'competition_order_failed', 10, 1 );


		$this->loader->add_filter( 'competition_add_participants_from_order', $this->plugin_admin, 'remove_participants_if_wrong_answer', 90, 4 );
		$this->loader->add_filter( 'competition_remove_participants_from_order', $this->plugin_admin, 'remove_participants_if_wrong_answer', 90, 4 );

		$this->loader->add_action( 'woocommerce_email', $this->plugin_admin, 'add_to_mail_class' );

		/* emails hooks */
		$email_actions = array( 'wc_competition_won', 'wc_competition_fail', 'wc_competition_close', 'woocommerce_competition_do_extend');
		foreach ( $email_actions as $action ) {
			$this->loader->add_action( $action, 'WC_Emails' , 'send_transactional_email') ;
		}

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 */
	private function define_public_hooks() {


		$this->plugin_public = new Competitions_For_Woocommerce_Public( $this->get_plugin_name(), $this->get_version() );


		$this->loader->add_action( 'wp_enqueue_scripts', $this->plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $this->plugin_public, 'enqueue_scripts' );
		$this->loader->add_action( 'widgets_init', $this->plugin_public, 'register_widgets');

		$this->loader->add_filter( 'woocommerce_locate_template', $this->plugin_public, 'woocommerce_locate_template', 10, 3 );
		$this->loader->add_filter( 'template_include', $this->plugin_public, 'competition_page_template', 99 );
		$this->loader->add_filter( 'woocommerce_product_related_posts_query', $this->plugin_public, 'remove_finished_competitions_from_related_products', 10 );

		$this->loader->add_action( 'woocommerce_before_shop_loop_item_title', $this->plugin_public, 'add_competition_bage', 60 );
		$this->loader->add_filter( 'woocommerce_is_purchasable', $this->plugin_public, 'is_purchasable', 99, 2 );
		$this->loader->add_filter( 'post_class', $this->plugin_public, 'add_post_class' );
		$this->loader->add_action( 'woocommerce_before_single_product', $this->plugin_public, 'participating_message', 1 );
		$this->loader->add_action( 'template_redirect', $this->plugin_public, 'track_competition_view', 1 );
		$this->loader->add_filter( 'pre_get_document_title', $this->plugin_public, 'competition_filter_wp_title', 10 );
		$this->loader->add_filter( 'pre_get_document_title', $this->plugin_public, 'competition_entry_filter_wp_title', 10 );
		$this->loader->add_filter( 'woocommerce_page_title', $this->plugin_public, 'competition_page_title', 10 );
		$this->loader->add_filter( 'woocommerce_page_title', $this->plugin_public, 'competition_entry_page_title', 10 );
		$this->loader->add_action( 'woocommerce_login_form_end', $this->plugin_public, 'add_redirect_previous_page');
		$this->loader->add_filter( 'woocommerce_quantity_input_max', $this->plugin_public, 'reduce_quantity_input_max_for_reserved_tickets', 90, 2 );
		//entry page
		$this->loader->add_filter( 'query_vars', $this->plugin_public, 'add_query_vars', 10 );
		$this->loader->add_filter( 'woocommerce_before_shop_loop', $this->plugin_public, 'competition_add_get_permalink', 99 );
		$this->loader->add_filter( 'woocommerce_after_shop_loop', $this->plugin_public, 'competition_remove_get_permalink', 99 );
		//menu and breadcrumbs
		$this->loader->add_filter( 'wp_nav_menu_objects', $this->plugin_public, 'competition_nav_menu_item_classes' );
		$this->loader->add_filter( 'woocommerce_get_breadcrumb', $this->plugin_public, 'competition_get_breadcrumb', 1, 2 );


		//wpml
		$this->loader->add_filter( 'icl_ls_languages', $this->plugin_public, 'translate_ls_competition_url', 99 );
		$this->loader->add_filter( 'woocommerce_get_competition_page_id', $this->plugin_public, 'competition_page_wpml', 99 );



		add_action( 'wc_competition_before_ticket_numbers', 'woocommerce_competition_lucky_dip_button_template', 10 );

		//dupicate ticket check
		$this->loader->add_action( 'woocommerce_before_pay_action', $this->plugin_public, 'check_ticket_numbers_before_pay_action', 99 );


		$this->loader->add_action( 'woocommerce_order_item_meta_start', $this->plugin_public, 'add_wrong_answer_notice_in_emails', 1, 4 );

		//cart
		$this->loader->add_filter( 'woocommerce_get_cart_item_from_session', $this->plugin_public , 'check_cart_ticket_numbers', 10, 4 );
		$this->loader->add_filter( 'woocommerce_cart_loaded_from_session', $this->plugin_public , 'check_cart_for_dupicate_ticket_numbers', 10 );
		$this->loader->add_action( 'woocommerce_check_cart_items', $this->plugin_public, 'check_cart_items' );
		$this->loader->add_filter( 'woocommerce_add_to_cart_validation', $this->plugin_public, 'add_to_cart_validation', 10, 3 );
		$this->loader->add_filter( 'woocommerce_add_cart_item_data', $this->plugin_public, 'add_ticket_number_to_cart_item', 10, 3 );
		$this->loader->add_filter( 'woocommerce_add_cart_item_data', $this->plugin_public, 'add_ticket_answer_to_cart_item', 10, 3 );
		$this->loader->add_filter( 'woocommerce_get_item_data', $this->plugin_public, 'display_ticket_numbers_cart', 10, 2 );
		$this->loader->add_filter( 'woocommerce_get_item_data', $this->plugin_public, 'display_ticket_answer_cart', 10, 2 );
		$this->loader->add_action( 'woocommerce_add_to_cart', $this->plugin_public, 'reserve_tickets', 10, 6 );
		$this->loader->add_action( 'woocommerce_remove_cart_item', $this->plugin_public, 'delete_ticket_reservations', 10, 2 );


		//change ticket to alphabet
		add_action( 'template_redirect', 'competitions_for_woocommerce_use_alphabet' );
		add_action( 'woocommerce_product_options_competition', 'competitions_for_woocommerce_use_alphabet', 99 );
		add_action( 'export_competition_history_with_extra_info', 'competitions_for_woocommerce_use_alphabet', 99 );
		$this->loader->add_filter( 'woocommerce_get_item_data', $this->plugin_public, 'change_cart_ticket_number_to_alphabet', 10, 2 );
		$this->loader->add_filter( 'woocommerce_display_item_meta', $this->plugin_public, 'change_order_ticket_number_to_alphabet', 90, 3 );
		$this->loader->add_filter( 'woocommerce_order_item_display_meta_value', $this->plugin_public, 'woocommerce_order_item_display_meta_value_aplhabet', 90, 3 );
		$this->loader->add_filter( 'woocommerce_order_item_display_meta_value', $this->plugin_public, 'order_item_display_meta_value', 10, 3 );

		$this->loader->add_action( 'wp_login', $this->plugin_public, 'sync_seesion_key', 99, 2 );
		$this->loader->add_action( 'user_register', $this->plugin_public, 'sync_session_key_register', 99, 1 );

		//my tickets end point
		$this->loader->add_filter( 'woocommerce_account_menu_items', $this->plugin_public, 'add_my_account_menu_items', 100, 1 );
		$this->loader->add_action( 'init', $this->plugin_public, 'woocommerce_competition_my_tickets_mytickets_endpoint' );
		$this->loader->add_action( 'init', $this->plugin_public, 'woocommerce_competition_my_tickets_mytickets_past_endpoint' );
		$this->loader->add_action( 'woocommerce_account_comp-tickets_endpoint', $this->plugin_public, 'woocommerce_competition_my_tickets_endpoint_content' );
		$this->loader->add_action( 'woocommerce_account_comp-tickets-past_endpoint', $this->plugin_public, 'woocommerce_competition_my_tickets_past_endpoint_content' );

		//entry page
		$this->loader->add_filter( 'query_vars', $this->plugin_public, 'add_query_vars', 10 );
		$this->loader->add_filter( 'woocommerce_before_shop_loop', $this->plugin_public, 'competition_add_get_permalink', 99 );
		$this->loader->add_filter( 'woocommerce_after_shop_loop', $this->plugin_public, 'competition_remove_get_permalink', 99 );
		$this->loader->add_action( 'init', $this->plugin_public, 'rewrite_rules' );
		$this->loader->add_action( 'template_redirect', $this->plugin_public, 'add_tables_to_frontend', 100 );

		add_action( 'init', array( 'Competitions_For_Woocommerce_Shortcodes', 'init' ) );

		//templates
		$this->loader->add_action( 'woocommerce_product_tabs', $this->plugin_public, 'competition_tab' );
		$this->loader->add_action( 'woocommerce_product_tab_panels', $this->plugin_public, 'competition_tab_panel' );
		add_action( 'woocommerce_single_product_summary', 'woocommerce_competition_participate_template', 25 );
		add_action( 'woocommerce_single_product_summary', 'woocommerce_competition_winners_template', 25 );
		add_action( 'woocommerce_competition_add_to_cart', 'woocommerce_competition_add_to_cart_template' );
		add_action( 'woocommerce_competition_before_participate', 'woocommerce_competition_countdown_template' );
		add_action( 'woocommerce_competition_ajax_change_participate', 'woocommerce_competition_info_template', 10 );
		add_action( 'woocommerce_competition_ajax_change_participate', 'woocommerce_competition_progressbar_template', 15 );
		add_action( 'woocommerce_competition_participate_future', 'woocommerce_competition_countdown_template' );
		add_action( 'woocommerce_competition_participate_future', 'woocommerce_competition_info_future_template' );
		add_action( 'woocommerce_single_entry', 'woocommerce_template_single_title', 5 );
		add_action( 'woocommerce_single_entry', 'woocommerce_competition_entry_info_template', 10 );
		add_action( 'woocommerce_single_entry', 'woocommerce_competition_entry_table_template', 15 );
		add_action( 'woocommerce_competition_single_entry_table', 'woocommerce_competition_entry_table_list', 15 );
		add_action( 'woocommerce_before_add_to_cart_button', 'competition_ticket_numbers_add_to_cart_button', 5 );
		add_action( 'woocommerce_before_add_to_cart_button', 'competition_questions_add_to_cart_button', 7 );
		add_action( 'woocommerce_before_single_entry', 'remove_added_to_cart_notice_entry_table', 1);
		add_action( 'woocommerce_competition_single_entry_table', 'woocommerce_competition_entry_table_list', 15 );


		// Fix WP SEO
		$this->loader->add_filter( 'wpseo_canonical', $this->plugin_public, 'wpseo_canonical_and_og_url', 20, 1 );
		$this->loader->add_filter( 'wpseo_opengraph_url', $this->plugin_public, 'wpseo_canonical_and_og_url', 20, 1 );
		$this->loader->add_filter( 'wpseo_frontend_page_type_simple_page_id', $this->plugin_public, 'wpseo_get_page_id', 30 );
		// Fix rank_math
		$this->loader->add_filter( 'rank_math/frontend/canonical', $this->plugin_public, 'wpseo_canonical_and_og_url', 20, 1 );
		$this->loader->add_filter( 'rank_math/pre_simple_page_id', $this->plugin_public, 'wpseo_get_page_id', 20, 1 );
		$this->loader->add_filter( 'rank_math/paper/hash', $this->plugin_public, 'rank_math_paper_hash', 20, 1 );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Competitions_For_Woocommerce_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

	/**
	 * Get the plugin url.
	 *
	 * @return string
	 */
	public function plugin_url() {
		return untrailingslashit( plugins_url( '/', COMPETITIONS_FOR_WOOCOMMERCE_PLUGIN_FILE ) );
	}

	public function remove_from_tax_query( $type ) {
		$tax_query                     = array();
		$competition_visibility_not_in = array();
		$competition_visibility_terms  = competitions_for_woocommerce_get_competition_visibility_term_ids();
		if ( is_array( $type ) ) {
			foreach ( $type as $value ) {
				$competition_visibility_not_in[] = $competition_visibility_terms[ $value ];
			}
		} else {
			$competition_visibility_not_in = array( $competition_visibility_terms[ $type ] );
		}

		if ( ! empty( $competition_visibility_not_in ) ) {
			$tax_query[] = array(
				'taxonomy' => 'competition_visibility',
				'field'    => 'term_taxonomy_id',
				'terms'    => $competition_visibility_not_in,
				'operator' => 'NOT IN',
			);
		}
		return $tax_query;
	}
	public function show_only_tax_query( $type ) {
		$tax_query                    = array();
		$competition_visibility_in    = array();
		$competition_visibility_terms = competitions_for_woocommerce_get_competition_visibility_term_ids();
		if ( is_array( $type ) ) {
			foreach ( $type as $value ) {
				$competition_visibility_in[] = $competition_visibility_terms[ $value ];
			}
		} else {
			$competition_visibility_in = array( $competition_visibility_terms[ $type ] );
		}

		if ( ! empty( $competition_visibility_in ) ) {
			$tax_query[] = array(
				'taxonomy' => 'competition_visibility',
				'field'    => 'term_taxonomy_id',
				'terms'    => $competition_visibility_in,
				'operator' => 'IN',
			);
		}
		return $tax_query;
	}
}
