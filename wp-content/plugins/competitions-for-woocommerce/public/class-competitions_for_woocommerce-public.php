<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://wpinstitut.com/
 * @since      1.0.0
 *
 * @package    Competitions_for_woocommerce
 * @subpackage Competitions_for_woocommerce/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Competitions_for_woocommerce
 * @subpackage Competitions_for_woocommerce/public
 */
class Competitions_For_Woocommerce_Public {


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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		wp_enqueue_style($this->plugin_name . 'alertable', plugin_dir_url(__FILE__) . 'css/jquery.alertable.css', array(), $this->version, 'all');
		wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/competitions_for_woocommerce-public.css', array($this->plugin_name . 'alertable', 'dashicons'), $this->version, 'all');
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_register_script( $this->plugin_name, CFW()->plugin_url() . '/public/js/competitions_for_woocommerce-public.js', array( 'jquery', 'competition-countdown', 'jquery-alertable'), $this->version, false );

		wp_register_script( 'competition-jquery-plugin', CFW()->plugin_url() . '/public/js/jquery.plugin.min.js', array( 'jquery' ), $this->version, false );

		wp_register_script( 'competition-countdown', CFW()->plugin_url() . '/public/js/jquery.countdown.min.js', array( 'competition-jquery-plugin' ), $this->version, false );

		wp_register_script( 'competition-countdown-language', CFW()->plugin_url() . '/public/js/jquery.countdown.language.js', array( 'jquery', 'competition-countdown' ), $this->version, false );

		wp_register_script( 'jquery-alertable', CFW()->plugin_url() . '/public/js/jquery.alertable.min.js', array( 'jquery' ) , $this->version , false );

		$language_data = array(
			'labels'        => array(
				'Years'   =>  esc_js( __( 'Years', 'competitions_for_woocommerce' ) ),
				'Months'  =>  esc_js( __( 'Months', 'competitions_for_woocommerce' ) ),
				'Weeks'   =>  esc_js( __( 'Weeks', 'competitions_for_woocommerce' ) ),
				'Days'    =>  esc_js( __( 'Days', 'competitions_for_woocommerce' ) ),
				'Hours'   =>  esc_js( __( 'Hours', 'competitions_for_woocommerce' ) ),
				'Minutes' =>  esc_js( __( 'Minutes', 'competitions_for_woocommerce' ) ),
				'Seconds' =>  esc_js( __( 'Seconds', 'competitions_for_woocommerce' ) ),
			),
			'labels1'       => array(
				'Year'   =>  esc_js( __( 'Year', 'competitions_for_woocommerce' ) ),
				'Month'  =>  esc_js( __( 'Month', 'competitions_for_woocommerce' ) ),
				'Week'   =>  esc_js( __( 'Week', 'competitions_for_woocommerce' ) ),
				'Day'    =>  esc_js( __( 'Day', 'competitions_for_woocommerce' ) ),
				'Hour'   =>  esc_js( __( 'Hour', 'competitions_for_woocommerce' ) ),
				'Minute' =>  esc_js( __( 'Minute', 'competitions_for_woocommerce' ) ),
				'Second' =>  esc_js( __( 'Second', 'competitions_for_woocommerce' ) ),
			),
			'compactLabels' => array(
				'y' =>  esc_js( __( 'y', 'competitions_for_woocommerce' ) ),
				'm' =>  esc_js( __( 'm', 'competitions_for_woocommerce' ) ),
				'w' =>  esc_js( __( 'w', 'competitions_for_woocommerce' ) ),
				'd' =>  esc_js( __( 'd', 'competitions_for_woocommerce' ) ),
				'h' =>  esc_js( __( 'h', 'competitions_for_woocommerce' ) ),
				'min' =>  esc_js( __( 'min', 'competitions_for_woocommerce' ) ),
				's' =>  esc_js( __( 's', 'competitions_for_woocommerce' ) ),
			),
		);

		wp_localize_script( 'competition-countdown-language', 'competitions_for_woocommerce_language_data', $language_data );

		$custom_data = array(
			'finished'                 => esc_js( __( 'Competition hCs finished! Please refresh page to see winners.', 'competitions_for_woocommerce' ) ),
			'gtm_offset'               => get_option( 'gmt_offset' ),
			'started'                  => esc_js( __( 'Competition hCs started! Please refresh page.', 'competitions_for_woocommerce' ) ),
			'compact_counter'          => get_option( 'competitions_for_woocommerce_compact_countdown', 'no' ),
			'price_decimals'           =>  esc_js( wc_get_price_decimals() ),
			'price_decimal_separator'  =>  esc_js( wc_get_price_decimal_separator() ),
			'price_thousand_separator' =>  esc_js( wc_get_price_thousand_separator() ),
			'maximum_text'             =>  esc_js( __('You already have selected maximum number of tickets!' , 'competitions_for_woocommerce') ),
			'maximum_add_text'         =>  esc_js( __('Max tickets qty is:' , 'competitions_for_woocommerce') ),
			'sold_text'                =>  esc_js( __('Ticket sold!' , 'competitions_for_woocommerce') ),
			'in_cart_text'             =>  esc_js( __('You have already this ticket in your cart!' , 'competitions_for_woocommerce') ),
			/* translators: 1) my account link*/
			'logintext'                =>  sprintf( __('Sorry, you must be logged in to participate in competition. <a href="%s" class="button">Login &rarr;</a>', 'competitions_for_woocommerce'), get_permalink(wc_get_page_id('myaccount') ) ),
			'please_pick'              =>  esc_js( __('Please pick a number. ' , 'competitions_for_woocommerce') ),
			'please_answer'            =>  esc_js( __('Please answer the question.' , 'competitions_for_woocommerce') ),
			'please_true_answer'       =>  esc_js( __('You must pick correct answer.' , 'competitions_for_woocommerce') ),
			'reserve_ticket'           =>  esc_js( get_option('competitions_for_woocommerce_tickets_reserved', 'no') ),
			'ajax_nonce'               => wp_create_nonce( 'competition_for_woocommerce_nonce' ),
			'ajax_url'                 => Competitions_For_Woocommerce_Ajax::get_endpoint( '%%endpoint%%' ),
		);


		wp_localize_script( $this->plugin_name, 'competitions_for_woocommerce_data', $custom_data );

		wp_enqueue_script( 'competition-countdown-language' );

		wp_enqueue_script( $this->plugin_name );
	}

	/**
	 * Register_widgets function
	 *
	 * @return void
	 *
	 */
	public function register_widgets() {

		// Include - no need to use autoload as WP loads them anyway
		include_once 'widgets/class-competition-for-woocommerce-widget-featured-competitions.php';
		include_once 'widgets/class-competition-for-woocommerce-widget-random-competitions.php';
		include_once 'widgets/class-competition-for-woocommerce-widget-recent-competitions.php';
		include_once 'widgets/class-competition-for-woocommerce-widget-recently-competitions.php';
		include_once 'widgets/class-competition-for-woocommerce-widget-ending-soon-competitions.php';
		include_once 'widgets/class-competition-for-woocommerce-widget-search.php';
		include_once 'widgets/class-competition-for-woocommerce-widget-future-competitions.php';

		// Register widgets
		register_widget( 'Competitions_For_Woocommerce_Widget_Ending_Soon_Competitions' );
		register_widget( 'Competitions_For_Woocommerce_Widget_Featured_Competitions' );
		register_widget( 'Competitions_For_Woocommerce_Widget_Future_Competitions' );
		register_widget( 'Competitions_For_Woocommerce_Widget_Random_Competitions' );
		register_widget( 'Competitions_For_Woocommerce_Widget_Recent_Competitions' );
		register_widget( 'Competitions_For_Woocommerce_Widget_Recently_Viewed_Competitions' );
		register_widget( 'Competitions_For_Woocommerce_Widget_Competitions_Search' );
	}

	/**
	 * Templating with plugin folder
	 *
	 */
	public function woocommerce_locate_template( $template, $template_name, $template_path ) {

		if ( ! $template_path ) {
			$template_path = WC()->template_path();
		}

		$plugin_path     = COMPETITIONS_FOR_WOOCOMMERCE_ABSPATH . 'templates/';
		$template_locate = locate_template( array( $template_path . $template_name, $template_name ) );

		if ( ! $template_locate && file_exists( $plugin_path . $template_name ) ) {
			return $plugin_path . $template_name;
		} else {
			return $template;
		}
	}

	/**
	 * Get template for competition archive page
	 *
	 * @param string
	 * @return string
	 *
	 */
	public function competition_page_template( $template ) {
		if ( get_query_var( 'is_competition_archive', false ) ) {
			$template = locate_template( WC()->template_path() . 'archive-product-competition.php' );
			if ( $template ) {
				wc_get_template( 'archive-product-competition.php' );
			} else {
				wc_get_template( 'archive-product.php' );
			}
			return false;
		}
		if ( get_query_var( 'competition_single_entry', false ) ) {
			global $product;

			$product_obj = get_page_by_path( get_query_var( 'competition_single_entry', false ) , OBJECT, 'product' );
			$post_data   = get_post($product_obj->ID );
			$product     = wc_get_product($product_obj->ID );
			$template    = locate_template( WC()->template_path() . 'single-entry.php' );

			wc_get_template( 'single-entry.php', array('product' => $product, 'post_data' => $post_data) );
		}
		return $template;
	}

	/**
	 * Output body classes for competition archive page
	 *
	 * @param array
	 * @return array
	 *
	 */
	public function output_body_class( $classes ) {
		if ( is_page( get_option( 'competitions_for_woocommerce_competitions_page_id' ) ) ) {
				$classes [] = 'woocommerce competitions-page';
		}
		return $classes;
	}

	/**
	 *  Add competition badge for competition product
	 *
	 */
	public function add_competition_bage() {

		if ( 'yes' === get_option( 'competitions_for_woocommerce_bage', 'yes' ) ) {
			wc_get_template( 'loop/competition-bage.php' );
		}

	}

	/**
	 * Make product not purchasable if competition is full
	 *
	 * @return bolean
	 */
	public function is_purchasable( $purchasable, $product ) {

		if ( method_exists( $product, 'get_type' ) && 'competition' === $product->get_type() && true === $purchasable ) {

			if ( ! $product->is_started() || $product->is_closed() ) {
				return false;
			}

			return ! $product->is_max_tickets_met();
		}

		return $purchasable;

	}
	/**
	 * Add some classes to post_class()
	 *
	 * @return array
	 */
	public function add_post_class( $classes ) {

		global $post,$product;

		if ( is_object($product) && 'comppetition' === $product->get_type() ) {

			if ( $product->is_max_tickets_met() ) {
				$classes[] = 'competition-full';
			}
		}

		return $classes;

	}

	/**
	 * Add particpate message before single product
	 *
	 * @return void
	 */
	public function participating_message( $product_id ) {

		global $product;

		if ( ! $product ) {
			return false;
		}

		if ( method_exists( $product, 'get_type' ) && 'competition' !== $product->get_type() ) {
					return false;
		}
		if ( $product->is_closed() ) {
					return false;
		}
		$current_user = wp_get_current_user();

		if ( ! $current_user->ID ) {
					return false;
		}

		if ( false === $product->is_user_participating() ) {
					return false;
		}

		$ticket_count = $product->count_user_tickets();
		/* translators: number of tickets */
		$message = sprintf( _n( 'You have bought a %d ticket for this competition!', 'You have bought %d tickets for this competition!', $ticket_count, 'competitions-for-woocommerce' ), $ticket_count );

		wc_add_notice( apply_filters( 'woocommerce_competition_participating_message', $message ) );

	}

	/**
	* Translate competitions page url
	*/
	public function translate_ls_competition_url( $languages, $debug_mode = false ) {
		global $sitepress;
		global $wp_query;

		$competition_page = (int) get_option( 'competitions_for_woocommerce_competitions_page_id' );

		foreach ( $languages as $language ) {
			if ( get_query_var( 'competition_archive', false ) || $debug_mode ) {
					$sitepress->switch_lang( $language['language_code'] );
					$url = get_permalink( apply_filters( 'translate_object_id', $competition_page, 'page', true, $language['language_code'] ) );
					$sitepress->switch_lang();
					$languages[ $language['language_code'] ]['url'] = $url;
			}
		}
		return $languages;
	}

	/**
	 *
	 * Add wpml support for competition base page
	 *
	 * @param int
	 * @return int
	 *
	 */
	public function competition_page_wpml( $page_id ) {

		if ( function_exists( 'icl_object_id' ) ) {
			$id = icl_object_id( $page_id, 'page', false );
		} else {
			$id = $page_id;
		}
		return $id;

	}


	/**
	 *
	 * Track competition views
	 *
	 * @param void
	 * @return int
	 *
	 */
	public function track_competition_view() {
		if ( ! is_singular( 'product' ) || ! is_active_widget( false, false, 'competitions_recently_viewed_competitions', false ) ) {
			return;
		}

		global $post;

		if ( empty( $_COOKIE['cfw_recently_viewed_competitions'] ) ) {
			$viewed_products = array();
		} else {
			$viewed_products = (array) explode( '|', sanitize_text_field( $_COOKIE['cfw_recently_viewed_competitions'] ) );
		}

		if ( ! in_array( strval( $post->ID ), $viewed_products , true ) ) {
			$viewed_products[] = $post->ID;
		}

		if ( count( $viewed_products ) > 15 ) {
			array_shift( $viewed_products );
		}

		// Store for session only
		wc_setcookie( 'cfw_recently_viewed_competitions', implode( '|', $viewed_products ) );
	}

	/**
	*
	* Fix active class in nav for competition page.
	*
	* @param array $menu_items
	* @return array
	*
	*/
	public function competition_nav_menu_item_classes( $menu_items ) {

		if ( get_query_var( 'is_competition_archive', false ) || get_query_var( 'competition_entry', false ) ) {
			if ( get_query_var( 'is_competition_archive', false ) ) {
				$menu_page = (int) get_option( 'competitions_for_woocommerce_competitions_page_id' );
			} elseif ( get_query_var( 'competition_entry', false ) ) {
				$menu_page = (int) get_option( 'competitions_for_woocommerce_competition_entry_page_id' );
			}

			foreach ( (array) $menu_items as $key => $menu_item ) {

				$classes = (array) $menu_item->classes;

				// Unset active class

				$menu_items[ $key ]->current = false;

				if ( in_array( 'current_page_parent', $classes ) ) {
					unset( $classes[ array_search( 'current_page_parent', $classes ) ] );
				}

				if ( in_array( 'current-menu-item', $classes ) ) {
					unset( $classes[ array_search( 'current-menu-item', $classes ) ] );
				}

				if ( in_array( 'current_page_item', $classes ) ) {
					unset( $classes[ array_search( 'current_page_item', $classes ) ] );
				}

				// Set active state if this is the shop page link
				if ( $menu_page === $menu_item->object_id && 'page' === $menu_item->object ) {
					$menu_items[ $key ]->current = true;
					$classes[]                   = 'current-menu-item';
					$classes[]                   = 'current_page_item';

				}

				$menu_items[ $key ]->classes = array_unique( $classes );

			}
		}

		return $menu_items;
	}


	/**
	 *
	 * Fix for competition base page breadcrumbs
	 *
	 * @param string
	 * @return string
	 *
	 */
	public function competition_get_breadcrumb( $crumbs, $WC_Breadcrumb ) {

		if ( 'true' ===get_query_var( 'is_competition_archive', false ) ) {

			$competition_page_id = get_option( 'competitions_for_woocommerce_competitions_page_id' );
			$crumbs[1]           = array( get_the_title( $competition_page_id ), get_permalink( $competition_page_id ) );
		}
		if ( 'true' === get_query_var( 'competition_entry', false ) ) {
			$competition_entry_page_id = get_option( 'competitions_for_woocommerce_competition_entry_page_id' );
			$crumbs[1]                 = array( get_the_title( $competition_entry_page_id ), get_permalink( $competition_entry_page_id ) );
			if ( get_query_var( 'competition_single_entry', false ) ) {
				$product_obj = get_page_by_path( get_query_var( 'competition_single_entry', false ) , OBJECT, 'product' );
				$crumbs[2]   = array( $product_obj->post_title );
			}
		}

		return $crumbs;
	}


	public function competition_filter_wp_title( $title ) {

		global $paged, $page;

		if ( ! get_query_var( 'is_competition_archive', false ) ) {
			return $title;
		}

		$competition_page_id = get_option( 'competitions_for_woocommerce_competitions_page_id' );
		$title               = get_the_title( $competition_page_id );

		return $title;
	}

	public function competition_entry_filter_wp_title( $title ) {

		global $paged, $page;

		if ( ! get_query_var( 'competition_entry', false ) ) {
			return $title;
		}

		$competition_entry_page_id = get_option( 'competitions_for_woocommerce_competition_entry_page_id' );
		$title                     = get_the_title( $competition_entry_page_id );

		return $title;
	}
	/**
	*
	* Fix for competition base page title
	*
	* @param string
	* @return string
	*
	*/
	public function competition_page_title( $title ) {

		if ( 'true' === get_query_var( 'is_competition_archive', false ) ) {
			$competition_page_id = get_option( 'competitions_for_woocommerce_competitions_page_id' );
			$title               = get_the_title( $competition_page_id );
		}

		return $title;

	}
	/**
	*
	* Fix for competition base page title
	*
	* @param string
	* @return string
	*
	*/
	public function competition_entry_page_title( $title ) {

		if ( 'true' === get_query_var( 'competition_entry', false ) ) {

			$competition_entry_page_id = get_option( 'competitions_for_woocommerce_competition_entry_page_id' );

			$title = get_the_title( $competition_entry_page_id );

		}

		return $title;

	}

	public function add_redirect_previous_page() {
		if ( isset( $_SERVER['HTTP_REFERER'] ) && ( isset( $_GET[ 'password-reset' ]) && 'true' !== $_GET[ 'password-reset' ] ) &&  ! is_checkout() ) {
			echo '<input type="hidden" name="redirect" value="' . esc_url( sanitize_text_field( $_SERVER['HTTP_REFERER'] ) ) . ' " >';
		}
	}

	/**
	 * Remove finished competitions from related products
	 *
	 * @return var
	 *
	 */

	public function remove_finished_competitions_from_related_products( $query ) {


		$competitions_for_woocommerce_finished_enabled = get_option( 'competitions_for_woocommerce_finished_enabled', 'no' );
		$competitions_for_woocommerce_future_enabled   = get_option( 'competitions_for_woocommerce_future_enabled', 'yes' );

		if ( 'no' === $competitions_for_woocommerce_finished_enabled ) {
			$finished_competitions = competitions_for_woocommerce_get_finished_competitions_id();
		}
		if ( 'no' === $competitions_for_woocommerce_future_enabled ) {
			$future_competitions = competitions_for_woocommerce_get_future_competitions_id();
		}

		if ( 'no' === $competitions_for_woocommerce_finished_enabled && count( $finished_competitions ) ) {
				$query['where'] .= ' AND p.ID NOT IN ( ' . implode( ',', array_map( 'absint', $finished_competitions ) ) . ' )';
		}

		if ( 'no' === $competitions_for_woocommerce_future_enabled && count( $future_competitions ) ) {
				$query['where'] .= ' AND p.ID NOT IN ( ' . implode( ',', array_map( 'absint', $future_competitions ) ) . ' )';
		}

		return $query;
	}

	public function add_query_vars ( $vars ) {
		$vars[] = 'competition_single_entry';
		$vars[] = 'competition_entry';
		return $vars;
	}

	public function rewrite_rules() {

		$page_id = get_option( 'competitions_for_woocommerce_competition_entry_page_id' );
		$slug    = get_post_field( 'post_name', $page_id );
		add_rewrite_rule( '^' . get_page_uri( $page_id ) . '/([^/]*)/?$', 'index.php?pagename=' . $slug . '&competition_entry=true&competition_single_entry=$matches[1]', 'top' );
		add_rewrite_rule( '^' . get_page_uri( $page_id ) . '/([^/]*)/page/([0-9]{1,})/?$', 'index.php?pagename=' . $slug . '&competition_entry=true&competition_single_entry=$matches[1]&paged=$matches[2]', 'top' );
		add_rewrite_rule( '^' . get_page_uri( $page_id ) . '/page/([0-9]{1,})/?$', 'index.php?pagename=' . $slug . '&competition_entry=true&paged=$matches[1]', 'top' );
	}

	public function competition_add_get_permalink() {
		global $wp_query;

		if ( 'true' === get_query_var('competition_entry') ) {
			add_filter( 'post_type_link', array( $this, 'competition_get_permalink_mod' ), 100, 3);
			add_filter( 'woocommerce_product_add_to_cart_text', array( $this, 'competition_button_text_mod' ), 100, 2);
		}
	}
	public function competition_remove_get_permalink() {
		remove_filter( 'post_type_link', array( $this, 'competition_get_permalink_mod' ), 10);
		remove_filter( 'woocommerce_product_add_to_cart_text', array( $this, 'competition_button_text_mod' ), 100);
	}

	public function competition_get_permalink_mod( $url, $post, $leavename = false ) {
		return get_page_link( get_option( 'competitions_for_woocommerce_competition_entry_page_id' ) ) . $post->post_name;
	}

	public function competition_button_text_mod( $text, $product) {
		if ( 'competition' === $product->get_type() ) {
			$text = esc_html__( 'View participants', 'competitions_for_woocommerce' );
		}
		return $text ;
	}

	public function add_tables_to_frontend() {

		if ( ! is_admin() && get_query_var('competition_single_entry')  ) {
			require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
			require_once ABSPATH . 'wp-admin/includes/screen.php';
			require_once ABSPATH . 'wp-admin/includes/class-wp-screen.php';
			require_once ABSPATH . 'wp-admin/includes/template.php';
		}
	}

	/**
	 * Write the competition tab on the product view page for WooCommerce v2.0+
	 * In WooCommerce these are handled by templates.
	 *
	 * @param  array
	 * @return array
	 *
	 */
	public function competition_tab( $tabs ) {

		global $product;

		if ( is_object($product) && 'competition' === $product->get_type() ) {

			$competitions_for_woocommerce_history = get_option( 'competitions_for_woocommerce_history', 'yes' );

			if ( 'yes' !==$competitions_for_woocommerce_history) {
					return $tabs;
			}

			$tabs['competition_history'] = array(
				'title'    => esc_html__( 'Competition history', 'competitions_for_woocommerce' ),
				'priority' => 25,
				'callback' => array( $this, 'competition_tab_callback' ),
				'content'  => 'competition-history',
			);
		}
		return $tabs;
	}
	/**
	 * Competition call back from competition_tab
	 *
	 * @param  array
	 * @return void
	 *
	 */
	public function competition_tab_callback( $tabs ) {
		wc_get_template( 'single-product/tabs/competition-history.php' );
	}


	public function add_ticket_number_to_cart_item( $cart_item_data, $product_id, $variation_id ) {
		$ticket_numbers = filter_input( INPUT_POST, 'competition_tickets_number' );

		if ( 0 === strlen( $ticket_numbers ) ) {
			return $cart_item_data;
		}
		$ticket_numbers = explode( ',', $ticket_numbers );

		$cart_item_data['competition_tickets_number'] = $ticket_numbers;

		return $cart_item_data;
	}

	public function add_ticket_answer_to_cart_item( $cart_item_data, $product_id, $variation_id ) {
		$competition_tickets_answer = filter_input( INPUT_POST, 'competition_answer' );

		if ( 0 === strlen( $competition_tickets_answer ) ) {
			return $cart_item_data;
		}

		$cart_item_data['competition_answer'] = $competition_tickets_answer;

		return $cart_item_data;
	}

	public function display_ticket_numbers_cart( $item_data, $cart_item ) {

		if ( empty( $cart_item['competition_tickets_number'] ) ) {
			return $item_data;
		}
		if ( is_array($cart_item['competition_tickets_number'] ) ) {
			foreach ($cart_item['competition_tickets_number'] as $ticket_number) {
				$item_data[] = array(
				'key'     => esc_html__( 'Ticket number', 'competitions-for-woocommerce' ),
				'value'   => wc_clean( $ticket_number ),
				'display' => '',
				);
			}
		}

		return $item_data;
	}

	public function display_ticket_answer_cart( $item_data, $cart_item ) {

		if ( empty( $cart_item['competition_answer'] ) ) {
			return $item_data;
		}
		$answers = maybe_unserialize( get_post_meta( $cart_item['product_id'], '_competition_answers', true ) );

		$item_data[] = array(
			'key'     => esc_html__( 'Answer', 'competitions-for-woocommerce' ),
			'value'   => wc_clean( $cart_item['competition_answer'] ),
			'display' => isset( $answers[ $cart_item['competition_answer'] ] ['text'] ) ? $answers[ $cart_item['competition_answer'] ]['text']  : '',
		);
		return $item_data;
	}

	public function order_item_display_meta_value( $display_value, $meta, $order ) {

		if ( esc_html__( 'Answer', 'competitions-for-woocommerce' ) !== rawurldecode( (string) $meta->key ) ) {
			return $display_value;
		}

		$product = is_callable( array( $order, 'get_product' ) ) ? $order->get_product() : false;

		if ( ! $product ) {
			return $display_value;
		}

		$answers = maybe_unserialize( get_post_meta( $product->get_id(), '_competition_answers', true ) );

		return isset( $answers[ $display_value ] ['text'] ) ? $answers[ $display_value ]['text']  : $display_value;

	}

	public function check_cart_ticket_numbers( $session_data, $values, $key) {
		if ( $session_data['data']->get_type() !== 'competition' ) {
			return $session_data;
		}
		if ( 'yes' === get_post_meta( $session_data['product_id'], '_competition_use_pick_numbers', true ) ) {
			if (  ! empty( $session_data['competition_tickets_number'] ) ) {
				$product          = wc_get_product( $session_data['product_id'] );
				$ticket_numbers   = $session_data['competition_tickets_number'];
				$session_key      = WC()->session->get_customer_id();
				$reserved_numbers = competitions_for_woocommerce_get_reserved_numbers($session_data['product_id'], $session_key);
				$taken_numbers    = competitions_for_woocommerce_get_taken_numbers($session_data['product_id']);

				if ( ! empty( $taken_numbers ) && ! empty( $ticket_numbers ) && ! empty( array_intersect( $ticket_numbers, $taken_numbers ) )   ) {
					/* translators: 1) product title 2) product link */
					wc_add_notice( sprintf( __( 'Product %1$s has been removed from your cart because someone purchase that ticket number. Please add it to your cart again by <a href="%2$s">clicking here</a>.', 'competitions-for-woocommerce' ), $product->get_name(), $product->get_permalink() ), 'error' );
					return false;
				}
				if ( ! empty( $reserved_numbers ) && ! empty($ticket_numbers) && ! empty( array_intersect( $ticket_numbers, $reserved_numbers ) )   ) {
					/* translators: 1) product title 2) product link */
					wc_add_notice( sprintf( __( 'Product %1$s has been removed from your cart because someone reserved that ticket number. Please add it to your cart again by <a href="%2$s">clicking here</a>.', 'competitions-for-woocommerce' ), $product->get_name(), $product->get_permalink() ), 'error' );
					return false;
				}

			} elseif ( 'yes' !== get_post_meta( $session_data['product_id'] , '_competition_pick_numbers_random', true ) ) {
				/* translators: 1) product title 2) product link */
				wc_add_notice( sprintf( __( 'Product %1$s has been removed from your cart because you have not selected ticket number. Please add it to your cart again by <a href="%2$s">clicking here</a>.', 'competitions-for-woocommerce' ), $session_data['data']->get_name(), $session_data['data']->get_permalink() ), 'error' );
				return false;
			}
		}
		return $session_data;
	}

	public function check_cart_for_dupicate_ticket_numbers( $cart_object) {
		$cart    = WC()->session->get( 'cart', null );
		$tickets = array();
		if ( ! empty( $cart ) ) {
			foreach ( $cart as $key => $cart_item ) {
				if ( isset( $cart_item['competition_tickets_number'] ) &&  $cart_item['competition_tickets_number'] ) {
					if ( !isset( $tickets[$cart_item['product_id']] ) ) {
						$tickets[$cart_item['product_id']] = $cart_item['competition_tickets_number'];
					} else {
						$tickets[$cart_item['product_id']] = array_merge($tickets[$cart_item['product_id']], $cart_item['competition_tickets_number']) ;
					}

				}
			}
			if (  ! empty( $tickets ) ) {
				foreach ($tickets as $key => $value) {
					if ( count( array_unique($value) ) < count( $value ) ) {
						wc_add_notice(  __( 'Please check cart for duplicate ticket numbers.', 'competitions-for-woocommerce' ), 'error' );
					}
				}
			}


		}

	}
	/**
	 * Validate cart items against set rules
	 *
	 * @return void
	 */
	public function check_cart_items() {

		$checked_ids        = array();
		$product_quantities = array();

		foreach ( wc()->cart->get_cart() as $cart_item_key => $values ) {

			if ( ! isset( $product_quantities[ $values['product_id'] ] ) ) {
				$product_quantities[ $values['product_id'] ] = 0;
			}

			$product_quantities[ $values['product_id'] ] += $values['quantity'];

		}

		foreach ( wc()->cart->get_cart() as $cart_item_key => $values ) {

			$product = wc_get_product( $values['product_id'] );

			if ( method_exists( $product, 'get_type' ) && $product->get_type() == 'competition' ) {

				$max_tickets_per_user = $product->get_max_tickets_per_user() ? $product->get_max_tickets_per_user() : false;
				if ( false === $max_tickets_per_user  || $max_tickets_per_user === $product->get_max_tickets() ) {
					return true;
				}

				if ( ! is_user_logged_in() && 'yes' !== get_option( 'competitions_for_woocommerce_alow_non_login', 'yes' ) ) {
					/* translators: 1) product link */
					wc_add_notice( sprintf( __( 'Sorry, you must be logged in to participate in competition. <a href="%s" class="button">Login &rarr;</a>', 'competition-for-woocommerce-cart' ), get_permalink( wc_get_page_id( 'myaccount' ) ) ), 'error' );

					return false;
				}

				$user_ID              = get_current_user_id();
				$max_tickets_per_user = $product->get_max_tickets_per_user() ? $product->get_max_tickets_per_user() : false;

				if ( ! $max_tickets_per_user && $product->is_sold_individually() ) {
					$max_tickets_per_user = 1;
				}

				if ( false !==$max_tickets_per_user ) {

					$users_qty        = array_count_values( $product->get_competition_participants() );
					$current_user_qty = isset( $users_qty[ $user_ID ] ) ? intval( $users_qty[ $user_ID ] ) : 0;
					$qty              = $current_user_qty + intval( $product_quantities[ $values['product_id'] ] );

					if ( ( $current_user_qty > 0 ) && ( $qty > $max_tickets_per_user ) ) {
						/* translators: 1) product title 2) max ticket per user 3) curent user qty */
						wc_add_notice( sprintf( __( 'The maximum allowed number of entries per user for %1$s is %2$d . You already have %3$d, so you can not add %4$d more.', 'competition-for-woocommerce-cart' ), $product->get_title(), $max_tickets_per_user, $current_user_qty, intval( $product_quantities[ $values['product_id'] ] ) ), 'error' );

					}

					if ( ( 0 === $current_user_qty ) && ( $qty > $max_tickets_per_user ) ) {
						/* translators: 1) product title 2) max ticket per user 3) curent user qty */
						wc_add_notice( sprintf( __( 'The maximum allowed number of entries per user for %1$s is %2$d . So you can not add %3$d to your cart.', 'competition-for-woocommerce-cart' ), $product->get_title(), $max_tickets_per_user, $qty ), 'error' );

					}
				}
			}
		}
	}
	/**
	 * Add to cart validation
	 *
	 */
	public function add_to_cart_validation( $pass, $product_id, $quantity ) {

		$checked_ids        = array();
		$product_quantities = array();

		if ( isset( $_POST['competition-for-woocommerce-cart-nonce'] ) ) {
			wp_verify_nonce( sanitize_key( $_POST['competition-for-woocommerce-cart-nonce'] ), 'competition-for-woocommerce-cart' );
		}

		if ( false === $pass ) {
			return $pass;
		}

		foreach ( wc()->cart->get_cart() as $cart_item_key => $values ) {

			if ( ! isset( $product_quantities[ $values['product_id'] ] ) ) {
				$product_quantities[ $values['product_id'] ] = 0;
			}

			$product_quantities[ $values['product_id'] ] += $values['quantity'];

		}

		$product = wc_get_product($product_id);

		if ( $product && $product->get_type() !== 'competition' ) {
			return $pass;
		}

		$use_ticket_numbers    = get_post_meta( $product_id , '_competition_use_pick_numbers', true );
		$random_ticket_numbers = get_post_meta( $product_id , '_competition_pick_numbers_random', true );
		$use_answers           = competitions_for_woocommerce_use_answers( $product_id );
		$max_tickets_per_user = $product->get_max_tickets_per_user() ? $product->get_max_tickets_per_user() : false;

		if ( false === $max_tickets_per_user || $max_tickets_per_user === $product->get_max_tickets() ) {
			$pass = true;
		}

		if ( ! is_user_logged_in() && 'yes' !== get_option( 'competitions_for_woocommerce_alow_non_login', 'yes' )  ) {
			/* translators: 1)login link */
			wc_add_notice( sprintf( __( 'Sorry, you must be logged in to participate in competition. <a href="%s" class="button">Login &rarr;</a>', 'competitions-for-woocommerce' ), get_permalink( wc_get_page_id( 'myaccount' ) ) ), 'error' );
			$pass = false;
		}
		$user_ID = get_current_user_id();
		$max_tickets_per_user = $product->get_max_tickets_per_user() ? $product->get_max_tickets_per_user() : false;
		if ( ! $max_tickets_per_user && $product->is_sold_individually() ) {
			$max_tickets_per_user = 1;
		}
		if ( false !== $max_tickets_per_user ) {
			$users_qty = array_count_values( $product->get_competition_participants() );
			$current_user_qty = isset( $users_qty[ $user_ID ] ) ? intval( $users_qty[ $user_ID ] ) : 0;
			$product_qty_in_cart = isset( $product_quantities[ $product_id ] ) ? intval( $product_quantities[ $product_id ] ) : 0;
			$qty = $current_user_qty + intval( $quantity ) + $product_qty_in_cart;
			if ( ( $current_user_qty > 0 ) && ( $qty > $max_tickets_per_user ) ) {
				/* translators: 1) product title 2) max ticket per user 3) curent user qty */
				wc_add_notice( sprintf( __( 'The maximum allowed number of entries per user for %1$s is %2$d . You already have %3$d, so you can not add %4$d more.', 'competitions-for-woocommerce' ), $product->get_title(), $max_tickets_per_user, $current_user_qty, $quantity ), 'error' );
				$pass = false;
			}

			if ( ( 0 === $current_user_qty ) && ( $qty > $max_tickets_per_user ) ) {
				/* translators: 1) product title 2) max ticket per user 3) curent user qty */
				wc_add_notice( sprintf( __( 'The maximum allowed number of entries per user for %1$s is %2$d . So you can not add %3$d to your cart.', 'competitions-for-woocommerce' ), $product->get_title(), $max_tickets_per_user, $qty ), 'error' );
				$pass = false;
			}
		}

		if ( 'yes' === $use_ticket_numbers  ) {
			if ( isset( $_POST['competition_tickets_number'] ) && strlen ( wc_clean( $_POST['competition_tickets_number'] ) ) > 0 ) {
				$taken_numbers    = competitions_for_woocommerce_get_taken_numbers();
				$session_key      = WC()->session->get_customer_id();
				$reserved_numbers = competitions_for_woocommerce_get_reserved_numbers($product_id, $session_key);
				$tickets_in_cart  = competitions_for_woocommerce_get_ticket_numbers_from_cart($product_id);
				$ticket_numbers   = explode( ',', wc_clean( $_POST['competition_tickets_number'] ) );

				if ( count( $ticket_numbers ) !== $quantity) {
					/* translators: 1) product title */
					wc_add_notice( sprintf( __( 'Product %1$s has not been added to your cart. Please add it to your cart again.', 'competitions-for-woocommerce' ), $product->get_name() ), 'error' );
					$pass = false;
				}

				if ( ! empty($taken_numbers) && ! empty($ticket_numbers) && ! empty( array_intersect( $ticket_numbers, $taken_numbers ) ) ) {
					/* translators: 1) product title */
					wc_add_notice( sprintf( __( 'Product %1$s has not been added to your cart because someone puchased that ticket number. Please add it to your cart again.', 'competitions-for-woocommerce' ), $product->get_name() ), 'error' );
					$pass = false;
				}
				if ( ! empty($reserved_numbers) && ! empty($ticket_numbers) && ! empty( array_intersect( $ticket_numbers, $reserved_numbers ) ) ) {
					/* translators: 1) product title */
					wc_add_notice( sprintf( __( 'Product %1$s has not been added to your cart because someone reserved that ticket number. Please add it to your cart again.', 'competitions-for-woocommerce' ), $product->get_name() ), 'error' );
					$pass = false;
				}
				if ( ! empty($tickets_in_cart) && ! empty($ticket_numbers) && ! empty( array_intersect( $ticket_numbers, $tickets_in_cart ) ) ) {
					/* translators: 1) product title */
					wc_add_notice( sprintf( __( 'Product %1$s has not been added to your cart because there is already that product with same ticket number in cart.', 'competitions-for-woocommerce' ), $product->get_name() ), 'error' );
					$pass = false;
				}
				if ( 'yes' === get_option('competition_answers_reserved', 'no') ) {
					$reserved = competitions_for_woocommerce_get_reserved_numbers( $product_id );
					if ( ! empty($reserved) && ! empty($ticket_numbers) && ! empty( array_intersect( $ticket_numbers, $reserved ) ) ) {
						/* translators: 1) product title */
						wc_add_notice( sprintf( __( 'Product %1$s has not been added to your cart because someone reserved that ticket number. Please add it to your cart again.', 'competitions-for-woocommerce' ), $product->get_name() ), 'error' );
						$pass = false;
					}
				}
			} elseif ( empty( $_POST['competition_tickets_number'] ) && 'yes' === $random_ticket_numbers) {
				$pass = $pass;
			} elseif (  ! is_user_logged_in() && 'yes' !== get_option( 'competitions_for_woocommerce_alow_non_login', 'yes' ) ) {
				/* translators: 1) login link */
				wc_add_notice(sprintf(__('Sorry, you must be logged in to participate in competition. <a href="%s" class="button">Login &rarr;</a>', 'competitions-for-woocommerce'), get_permalink(wc_get_page_id('myaccount'))), 'error');
				$pass = false;
			} else {
				/* translators: 1) product title */
				wc_add_notice( sprintf( esc_html__( 'Product %1$s has not been added to your cart because you have to select ticket number!', 'competitions-for-woocommerce' ), $product->get_name()), 'error' );
				$pass = false;
			}
		}

		if ( true === $use_answers ) {

			if ( ! empty( $_REQUEST['competition_answer'] ) ) {
				$answers = maybe_unserialize( get_post_meta( $product_id, '_competition_answers', true ) );
				if ( is_array( $answers ) ) {
					if ( ! array_key_exists( intval($_REQUEST['competition_answer']), $answers) ) {
						/* translators: 1) product title */
						wc_add_notice( sprintf( esc_html__( 'Product %1$s has not been added to your cart because of problem with your answer!', 'competitions-for-woocommerce' ), $product->get_name()), 'error' );
						$pass = false;
					}
					$competition_only_true_answers = get_post_meta( $product_id , '_competition_only_true_answers', true );
					if ( 'yes' === $competition_only_true_answers ) {
						$true_answers     = competitions_for_woocommerce_get_true_answers( $product_id );
						$true_answers_ids = array_keys( $true_answers );
						if ( is_array( $true_answers_ids ) && ! in_array( intval( $_REQUEST['competition_answer'] ), $true_answers_ids, true) ) {
							/* translators: 1) product title */
							wc_add_notice( sprintf( esc_html__( 'Product %1$s has not been added to your cart because your answer is not correct. Please try it again!!', 'competitions-for-woocommerce' ), $product->get_name()), 'error' );
							$pass = false;
						}
					}
				} else {
					/* translators: 1) product title */
					wc_add_notice( sprintf( esc_html__( 'Product %1$s has not been added to your cart because there is some problem with answers. Please contact us!', 'competitions-for-woocommerce' ), $product->get_name()), 'error' );
					$pass = false;
				}

			} elseif (  ! is_user_logged_in() && 'yes' !== get_option( 'competitions_for_woocommerce_alow_non_login', 'yes' ) ) {
				/* translators: 1) login link */
				wc_add_notice(sprintf(__('Sorry, you must be logged in to participate in competition. <a href="%s" class="button">Login &rarr;</a>', 'competitions-for-woocommerce'), get_permalink(wc_get_page_id('myaccount'))), 'error');
				$pass = false;
			} else {
				/* translators: 1) product title */
				wc_add_notice( sprintf( esc_html__( 'Product %1$s has not been added to your cart because you have to answer question!', 'competitions-for-woocommerce' ), $product->get_name()), 'error' );
				$pass = false;
			}
		}



		return $pass;
	}


	/**
	 * Make reservation for ticket when adding to cart
	 *
	 */
	public function reserve_tickets( $cart_item_key, $product_id, $quantity, $variation_id, $variation, $cart_item_data ) {

		if ( 'yes' === get_option('competitions_for_woocommerce_tickets_reserved', 'no') ) {
			if ( ! is_user_logged_in() ) {
				WC()->session->set( 'customer_session_key' , WC()->session->get_customer_id() );
			}
			if ( isset( $cart_item_data['competition_tickets_number'] ) ) {
				foreach ($cart_item_data['competition_tickets_number'] as $ticket_number) {
					$this->save_reserved_ticket( $product_id, $ticket_number, WC()->session->get_customer_id() );
				}
				$minutes = get_option('competitions_for_woocommerce_tickets_reserved_minutes', '5');
				/* translators: 1) number of minutes */
				$message = sprintf( esc_html__( 'Ticket numbers will be reserved for %d minutes. After that someone else could reserve or buy the same ticket!' , 'competitions-for-woocommerce'  ), $minutes );
				if ( ! wc_has_notice( $message, 'notice') && 'yes' === get_option('competitions_for_woocommerce_tickets_reserved_notice', 'yes') ) {
					wc_add_notice( $message, 'notice');
				}
			}
		}

	}

	public function delete_ticket_reservations( $cart_item_key, $cart ) {

		if ( 'yes' === get_option('competitions_for_woocommerce_tickets_reserved', 'no') ) {
			$cart_item_data = $cart->get_cart_item( $cart_item_key );
			if ( $cart_item_data ) {
				if ( isset( $cart_item_data['competition_tickets_number'] ) ) {
					$product_id = $cart_item_data['product_id'];
					foreach ($cart_item_data['competition_tickets_number'] as $ticket_number) {
						$this->delete_reserved_ticket( $product_id, $ticket_number, WC()->session->get_customer_id() );
					}
				}
			}
		}
	}

	/**
	* Save reserved ticket
	*
	* @param  int, int
	* @return void
	*
	*/
	public function save_reserved_ticket( $competition_id, $ticket_number, $session_key ) {
		global $wpdb;
		$log = $wpdb->get_row( $wpdb->prepare( 'SELECT 1 FROM ' . $wpdb->prefix . 'cfw_log_reserved WHERE competition_id=%d AND ticket_number=%d', $competition_id, $ticket_number ) );
		if ( ! is_null( $log ) ) {
			return;
		}
		$log_bid = $wpdb -> insert($wpdb -> prefix . 'cfw_log_reserved', array('competition_id' => $competition_id, 'ticket_number' => $ticket_number, 'session_key' => $session_key ), array('%d', '%d', '%s'));
		return $log_bid;
	}
	/**
	* Delete reserved ticket
	*
	* @param  int, int
	* @return void
	*
	*/
	public function delete_reserved_ticket( $competition_id, $ticket_number) {
		global $wpdb;
		$result = $wpdb->query( $wpdb->prepare( 'DELETE FROM ' . $wpdb -> prefix . 'cfw_log_reserved WHERE competition_id = %d AND ticket_number = %d ', $competition_id, $ticket_number ) );
		return $result;
	}

	public function remove_notification_from_order_recieved_page() {
		global $wp;
		if ( ! empty( $wp->query_vars['order-received'] ) ) {
			wc_clear_notices();
		}
	}

	public function change_cart_ticket_number_to_alphabet( $item_data, $cart_item ) {
		// Format item data ready to display.
		foreach ( $item_data as $key => $data ) {
			if ( isset( $data['key'] ) && 'Ticket number' === $data['key'] ) {
				$product = wc_get_product( $cart_item['product_id'] );
				if ( 'yes' === get_post_meta( $cart_item['product_id'] , '_competition_pick_number_alphabet', true ) ) {
					$item_data[ $key ]['display'] = competitions_for_woocommerce_change_ticket_numbers_to_alphabet($data['value'], $product );
				}
			}
		}
		return $item_data;
	}

	public function change_order_ticket_number_to_alphabet( $html, $item, $args ) {

		$strings    = false;
		$product_id = $item->get_product_id();
		$product    =  wc_get_product( $product_id );

		if ( ! $product || 'yes' !== get_post_meta( $product_id , '_competition_pick_number_alphabet', true ) ) {
			return $html;
		}
		foreach ( $item->get_formatted_meta_data() as $meta_id => $meta ) {
			if ( 'Ticket number' === $meta->key ) {
				$value     = $args['autop'] ? wp_kses_post( $meta->display_value ) : wp_kses_post( make_clickable( competitions_for_woocommerce_change_ticket_numbers_to_alphabet(intval( $meta->value ), $product )) );
				$strings[] = $args['label_before'] . wp_kses_post( $meta->display_key ) . $args['label_after'] . $value;
			} else {
				$value     = $args['autop'] ? wp_kses_post( $meta->display_value ) : wp_kses_post( make_clickable( trim( $meta->display_value ) ) );
				$strings[] = $args['label_before'] . wp_kses_post( $meta->display_key ) . $args['label_after'] . $value;
			}
		}

		if ( $strings ) {
			$html = $args['before'] . implode( $args['separator'], $strings ) . $args['after'];
		}

		return $html;
	}

	public function woocommerce_order_item_display_meta_value_aplhabet( $meta_value, $meta, $item ) {

		if ( is_a($item, 'WC_Order_Item_Product') ) {

			$product_id = $item->get_product_id();
			$product    =  wc_get_product( $product_id );

			if ( ! $product || 'yes' !== get_post_meta( $product_id , '_competition_pick_number_alphabet', true ) ) {
				return $meta_value;
			}
			if ( 'Ticket number' ===  $meta->key ) {
				$meta_value =  competitions_for_woocommerce_change_ticket_numbers_to_alphabet( intval( $meta_value ), $product );
			}
		}
		return $meta_value;
	}

	public function check_ticket_numbers_before_pay_action( $order ) {
		if ( $order ) {
			$order_items = $order->get_items();
			if ( $order_items ) {
				try {
					foreach ( $order_items as $item_id => $item ) {
						if ( function_exists( 'wc_get_order_item_meta' ) ) {
							$item_meta = wc_get_order_item_meta( $item_id, '' );
						} else {
							$item_meta = method_exists( $order, 'wc_get_order_item_meta' ) ? $order->wc_get_order_item_meta( $item_id ) : $order->get_item_meta( $item_id );
						}

						$product_id   = competitions_for_woocommerce_get_main_wpml_product_id( $item_meta['_product_id'][0] );
						$product_data = wc_get_product( $product_id );

						if ( $product_data && 'competition' === $product_data->get_type() ) {

							$competition_relisted = $product_data->get_competition_relisted();

							if ( $competition_relisted &&  $competition_relisted > $order->get_date_created()->date( 'Y-m-d H:i:s' ) ) {
								continue;
							}

							$use_ticket_numbers = get_post_meta( $product_id , '_competition_use_pick_numbers', true );

							if ( 'yes' === $use_ticket_numbers  ) {
								$available_tickets = competitions_for_woocommerce_get_available_ticket( $product_id );
								$ticket_numbers    = isset( $item_meta[ __( 'Ticket number', 'competitions_for_woocommerce' ) ] ) ? $item_meta[ __( 'Ticket number', 'competitions_for_woocommerce' ) ] : '';
								foreach ($ticket_numbers as $key => $value) {
									if (! in_array($value, $available_tickets, true) || empty( $ticket_numbers ) ) {
										throw new Exception( __( 'Invalid ticket number.', 'competitions_for_woocommerce' ) );
									}
								}
							}
						}
					}
				} catch ( Exception $e ) {
					wc_add_notice( $e->getMessage(), 'error' );
				}
			}
		}
	}

	public function reduce_quantity_input_max_for_reserved_tickets( $qty, $product ) {
		if ( 'competition' === $product->get_type( ) ) {
			$reserved = competitions_for_woocommerce_get_reserved_numbers( $product->get_id() );
			$qty      = $qty - count( $reserved );
		}

		return $qty;
	}

	public function add_wrong_answer_notice_in_emails( $item_id, $item, $order, $plain_text ) {

		if ( 'yes' !== get_option( 'competitions_for_woocommerce_wrong_answers_email_notice', 'yes' ) ) {
			return;
		}

		$product = $item->get_product();

		if ( $product && 'competition' === $product->get_type() && competitions_for_woocommerce_use_answers( $product->get_id() ) ) {
			foreach ( $item->get_formatted_meta_data() as $meta_id => $meta ) {
				if ( __( 'Answer', 'competitions_for_woocommerce' ) === $meta->display_key ) {
					$true_answers = competitions_for_woocommerce_get_true_answers( $product->get_id() );
					$answers_ids  = array_keys( $true_answers );
					if (! in_array( intval( $meta->value ), $answers_ids, true) ) {
						$message  = '<div class="wc-item-meta wrong-answer" style="font-size: small; margin: 1em 0 0; padding: 0;" >';
						$message .= wp_kses_post(  __('Your answer is not correct. In order to participate you will need to select right answer, pick your ticket(s) and checkout again.', 'competitions_for_woocommerce' ) );
						$message .= '</div>';

						$html = apply_filters( 'wrong_answer_display_item_meta', $message, $item );

						if ( 'yes' === get_option( 'competitions_for_woocommerce_remove_ticket_wrong_answer' , 'no' ) ) {
							add_filter( 'woocommerce_display_item_meta', array($this, 'remove_ticket_numbers_from_display_item_meta' ), 10, 3 );
						}
						echo wp_kses_post( $html );
					} else {
						remove_filter( 'woocommerce_display_item_meta', array($this, 'remove_ticket_numbers_from_display_item_meta' ), 10, 3 );
					}
				}
			}

		}
	}

	public function remove_ticket_numbers_from_display_item_meta( $html, $item, $args ) {
		return '';
	}

	public function sync_seesion_key( $user_login, $user ) {

		if ( 'yes' === get_option('competitions_for_woocommerce_tickets_reserved', 'no') ) {
			global $wpdb;
			$customer_session_key = WC()->session->get( 'customer_session_key');
			if ( $customer_session_key ) {
				$wpdb -> update($wpdb -> prefix . 'cfw_log_reserved', array('session_key' =>$user->ID ), array('session_key' => $customer_session_key ) );
			}
		}

	}

	public function sync_session_key_register( $user_id ) {

		if ( is_admin() ) {
			return;
		}

		if ( 'yes' === get_option('competitions_for_woocommerce_tickets_reserved', 'no') ) {
			global $wpdb;
			if ( WC()->session ) {
				$customer_session_key = WC()->session->get( 'customer_session_key');
				if ( $customer_session_key ) {
					$wpdb -> update($wpdb -> prefix . 'cfw_log_reserved', array('session_key' =>$user_id ), array('session_key' => $customer_session_key ) );
				}
			}
		}
	}

	// Go to Settings -> Permalinks and save permalinks
	public function woocommerce_competition_my_tickets_mytickets_endpoint() {
		add_rewrite_endpoint( 'comp-tickets', EP_ROOT | EP_PAGES );
	}

	public function woocommerce_competition_my_tickets_mytickets_past_endpoint() {
		add_rewrite_endpoint( 'comp-tickets-past', EP_ROOT | EP_PAGES );
	}

	public function woocommerce_competition_my_tickets_endpoint_content() {

		global $wpdb;

		$current_user_id = get_current_user_id();
		$postids         = competitions_for_woocommerce_get_user_competitions();
		$posts_ids       = array();

		if ( count($postids)>0 ) {

			$args = array(
				'fields' => 'ids',
				'post_type'=> 'product',
				'post__in' => $postids,
				'show_past_competitions' => false,
				'tax_query' => array( array('taxonomy' => 'product_type' , 'field' => 'slug', 'terms' => 'competition') ),
			);

			$the_query = new WP_Query( $args );
			$posts_ids = $the_query->posts;
		}

		wc_get_template( 'myaccount/active-tickets.php', array( 'posts_ids' => $posts_ids) );
	}

	public function woocommerce_competition_my_tickets_past_endpoint_content() {

		global $wpdb;

		$current_user_id = get_current_user_id();
		$postids         = competitions_for_woocommerce_get_user_competitions();
		$posts_ids       = array();

		if ( count( $postids ) > 0 ) {
			// Return past user's competition products.
			$args = array(
				'fields' => 'ids',
				'post_type'=> 'product',
				'post__in' => $postids,
				'show_past_competitions' => true,
				'meta_query' => array(
					array(
							'key' => '_competition_closed',
							'operator' => 'EXISTS',
						),
					),
			);

			$the_query = new WP_Query( $args );
			$posts_ids = $the_query->posts;
		}
		wc_get_template( 'myaccount/past-tickets.php', array( 'posts_ids' => $posts_ids) );
	}

	public function add_my_account_menu_items( $items ) {

		$ordered_items = array();

		$subscription_item = array( 'comp-tickets' => esc_html__( 'My Tickets', 'competitions_for_woocommerce' ) );
		unset( $items['comp-tickets'] );
		$items = array_merge( $subscription_item, $items );

		return $items;
	}


	public function wpseo_get_page_id( $page_id ) {

		$competition_single_entry = get_query_var( 'competition_single_entry', false );

		if ( $competition_single_entry ) {
			$product_obj = get_page_by_path( $competition_single_entry , OBJECT, 'product' );
			return intval( $product_obj->ID  );
		}

		if (  'true' === get_query_var( 'competition_entry', false ) ) {
			return  get_option( 'competitions_for_woocommerce_competition_entry_page_id' );
		}

		if ( 'true' === get_query_var( 'competition_arhive', false ) ) {
			return get_option( 'competitions_for_woocommerce_competitions_page_id' );
		}

		return $page_id;
	}
	public function wpseo_canonical_and_og_url( $canonical ) {

		if ( get_query_var( 'competition_single_entry', false ) ) {
			global $post;
			if ( isset( $post->post_name ) ) {
				return get_page_link( get_option( 'competitions_for_woocommerce_competition_entry_page_id' ) ) . $post->post_name;
			} else {
				$fullurl   = isset( $_SERVER['REQUEST_URI'] ) ?  sanitize_text_field( $_SERVER['REQUEST_URI'] ) : '';
				$trimmed   = trim($fullurl, '.php');
				$canonical = rtrim($trimmed, '/') . '/';
				return get_home_url() . $canonical;
			}
		}

		return $canonical;
	}

	public function rank_math_paper_hash( $data ) {

		if ( get_query_var( 'competition_single_entry', false ) ) {
			$data['Error_404'] = false;
		}
		if ( 'true' === get_query_var( 'competition_entry', false ) ) {
			$data['Shop'] = false;
		}
		if ( 'true' === get_query_var( 'competition_arhive', false ) ) {
			$data['Shop'] = false;
		}

		return $data;
	}




}
