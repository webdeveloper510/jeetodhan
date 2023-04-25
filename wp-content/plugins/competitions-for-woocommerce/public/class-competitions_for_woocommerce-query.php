<?php
/**
 * Contains the query functions for competitions for WooCommerce which alter the front-end post queries and loops
 *
 * @version 2.0.0
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * WC_Query Class.
 *
 */
class Competitions_For_Woocommerce_Query {

	/**
	 * Stores coption for out of stock item
	 *
	 * @var string
	 */
	private $hide_out_of_stock_items;

	/**
	 * Constructor for the query class. Hooks in methods.
	 *
	 */
	public function __construct() {
		if ( ! is_admin() ) {
			add_filter( 'query_vars', array( $this, 'add_query_vars' ), 0 );
			add_action( 'woocommerce_product_query', array( $this, 'remove_competitions_from_woocommerce_product_query' ), 2 );
			add_action( 'woocommerce_product_query', array( $this, 'pre_get_posts' ), 99, 2 );
			add_filter( 'pre_get_posts', array( $this, 'competition_arhive_pre_get_posts') , 1 );
			add_action( 'pre_get_posts', array( $this, 'query_competition_archive' ), 1 );
			$this->hide_out_of_stock_items = get_option( 'woocommerce_hide_out_of_stock_items' );
		}
	}

	/**
	 * Add query vars.
	 *
	 * @param array $vars Query vars.
	 * @return array
	 *
	 */
	public function add_query_vars( $vars ) {
		$qvars[] = 'search_competitions';
		return $vars;
	}

	/**
	 * Modify product query based on settings
	 *
	 * @param object
	 * @return object
	 *
	 */
	public function remove_competitions_from_woocommerce_product_query( $q ) {

		// We only want to affect the main query
		if ( ! $q->is_main_query() ) {
			return;
		}

		if ( apply_filters( 'remove_competitions_from_woocommerce_product_query', false, $q ) === true ) {
			return;
		}

		if ( ! $q->is_post_type_archive( 'product' ) && ! $q->is_tax( get_object_taxonomies( 'product' ) ) ) {
			return;
		}

		$competitions_for_woocommerce_dont_mix_shop = get_option( 'competitions_for_woocommerce_dont_mix_shop' );
		$competitions_for_woocommerce_dont_mix_cat  = get_option( 'competitions_for_woocommerce_dont_mix_cat' );

		if ( 'yes' !== $competitions_for_woocommerce_dont_mix_cat && is_product_category() ) {
			return;
		}

		$competitions_for_woocommerce_dont_mix_tag = get_option( 'competitions_for_woocommerce_dont_mix_tag' );
		if ( 'yes' !== $competitions_for_woocommerce_dont_mix_tag && is_product_tag() ) {
			return;
		}

		$competitions_for_woocommerce_dont_mix_search = get_option( 'competitions_for_woocommerce_dont_mix_search' );

		if ( $q->is_main_query() && $q->is_search() && ! is_admin() ) {

			if ( isset( $q->query['search_competitions'] ) && true === $q->query['search_competitions'] ) {
				$taxquery = $this->add_outofstock_items( $q->get( 'tax_query' ) );
				if ( ! is_array( $taxquery ) ) {
					$taxquery = array();
				}

				$taxquery[] =
				array(
					'taxonomy' => 'product_type',
					'field'    => 'slug',
					'terms'    => 'competition',
				);

				$q->set( 'tax_query', $taxquery );
				$q->query['competition_arhive'] = true;

			} elseif ( 'yes' === $competitions_for_woocommerce_dont_mix_search ) {

				$taxquery = $this->add_outofstock_items( $q->get( 'tax_query' ) );
				if ( ! is_array( $taxquery ) ) {
					$taxquery = array();
				}
				$taxquery[] =
				array(
					'taxonomy' => 'product_type',
					'field'    => 'slug',
					'terms'    => 'competition',
					'operator' => 'NOT IN',
				);

				$q->set( 'tax_query', $taxquery );
			}

			return;

		}

		if ( 'yes' === $competitions_for_woocommerce_dont_mix_shop && ( ! isset( $q->query_vars['is_competition_archive'] ) || 'true' !== $q->query_vars['is_competition_archive'] ) && ( ! isset( $q->query_vars['competition_entry'] ) || 'true' !== $q->query_vars['competition_entry'] ) ) {
			$taxquery = $this->add_outofstock_items( $q->get( 'tax_query' ) );
			if ( ! is_array( $taxquery ) ) {
				$taxquery = array();
			}
			$taxquery[] =
			array(
				'taxonomy' => 'product_type',
				'field'    => 'slug',
				'terms'    => 'competition',
				'operator' => 'NOT IN',
			);
			$q->set( 'tax_query', $taxquery );
		}

	}

	/**
	 * Modify query based on settings
	 *
	 * @param object
	 * @return object
	 *
	 */
	public function pre_get_posts( $q ) {

		$competition_visibility_not_in                 = array();
		$competitions_for_woocommerce_finished_enabled = get_option( 'competitions_for_woocommerce_finished_enabled' );
		$competitions_for_woocommerce_future_enabled   = get_option( 'competitions_for_woocommerce_future_enabled' );
		$competitions_for_woocommerce_dont_mix_shop    = get_option( 'competitions_for_woocommerce_dont_mix_shop' );
		$competitions_for_woocommerce_dont_mix_cat     = get_option( 'competitions_for_woocommerce_dont_mix_cat' );
		$competitions_for_woocommerce_dont_mix_tag     = get_option( 'competitions_for_woocommerce_dont_mix_tag' );
		$competitions_for_woocommerce_sealed_on        = get_option( 'competitions_for_woocommerce_sealed_on', 'no' );

		if ( ( isset( $q->query_vars['is_competition_archive'] ) && 'true' === $q->query_vars['is_competition_archive'] ) || ( isset( $q->query_vars['competition_entry'] ) && 'true' === $q->query_vars['competition_entry'] ) ) {
			$q->set( 'post_type', 'product' );
			$taxquery = $this->add_outofstock_items( $q->get( 'tax_query' ) );
			if ( ! is_array( $taxquery ) ) {
					$taxquery = array();
			}
			$taxquery[] =
			array(
				'taxonomy' => 'product_type',
				'field'    => 'slug',
				'terms'    => 'competition',
			);

			$q->set( 'tax_query', $taxquery );
			add_filter( 'woocommerce_is_filtered', array( $this, 'add_is_filtered' ), 99 ); // hack for displaying competitions when Shop Page Display is set to show categories
		}

		if (
			(
				( 'yes' !== $competitions_for_woocommerce_future_enabled && ( ! isset( $q->query['show_future_competitions'] ) || ! $q->query['show_future_competitions'] ) )
				|| ( isset( $q->query['show_future_competitions'] ) && false === $q->query['show_future_competitions'] )

			)

		) {

			$metaquery = $q->get( 'meta_query' );

			if ( ! is_array( $metaquery ) ) {
				 $metaquery = array();
			}

			$metaquery [] =	array(
				'key'     => '_competition_started',
				'compare' => 'NOT EXISTS',
			);
			$q->set( 'meta_query', $metaquery );
		}

		if (

			( 'yes' !== $competitions_for_woocommerce_finished_enabled && ( ! isset( $q->query['show_past_competitions'] ) || ! $q->query['show_past_competitions'] )
				|| ( isset( $q->query['show_past_competitions'] ) && false === $q->query['show_past_competitions'] )
			)
		) {

			$metaquery = $q->get( 'meta_query' );
			if ( ! is_array( $metaquery ) ) {
				$metaquery = array();
			}
			$metaquery [] = array(
				'key'     => '_competition_closed',
				'compare' => 'NOT EXISTS',
			);
			$q->set( 'meta_query', $metaquery );

		}

		//var_dump($q); die();

		if ( 'yes' !== $competitions_for_woocommerce_dont_mix_cat && is_product_category() ) {
			return $q;
		}

		if ( 'yes' !== $competitions_for_woocommerce_dont_mix_tag && is_product_tag() ) {
			return $q;
		}

		if ( ! isset( $q->query_vars['competition_arhive'] ) && ! $q->is_main_query() ) {

			if ( 'yes' === $competitions_for_woocommerce_dont_mix_shop ) {

				$taxquery = $this->add_outofstock_items( $q->get( 'tax_query' ) );
				if ( ! is_array( $taxquery ) ) {
					$taxquery = array();
				}
				$taxquery[] =
				array(
					'taxonomy' => 'product_type',
					'field'    => 'slug',
					'terms'    => 'competition',
					'operator' => 'NOT IN',
				);

				$q->set( 'tax_query', $taxquery );
				return $q;
			}
			return $q;

		}

	}
	/**
	 * Pre_get_post for competition product archive
	 *
	 * @param object
	 * @return void
	 *
	 */
	public function competition_arhive_pre_get_posts( $q ) {

		if ( isset( $q->query['competition_arhive'] ) || ( ! isset( $q->query['competition_arhive'] ) && ( isset( $q->query['post_type'] ) && 'product' === $q->query['post_type'] && ! $q->is_main_query() ) ) ) {
			$this->pre_get_posts( $q );
		}
		return $q;
	}

	/**
	 * Query for competition product archive
	 *
	 * @param object
	 * @return void
	 *
	 */
	public function query_competition_archive( $q ) {

		if ( ! $q->is_main_query() ) {
			return;
		}

		$competitions_base_page_id  = intval( get_option( 'competitions_for_woocommerce_competitions_page_id' ) );
		$competitions_entry_page_id = intval( get_option( 'competitions_for_woocommerce_competition_entry_page_id' ) );

		if ( ( isset( $q->queried_object->ID ) && $competitions_base_page_id === $q->queried_object->ID ) || ( ! empty( $competitions_base_page_id ) && get_query_var( 'page_id' ) === $competitions_base_page_id ) ) {
			$q->set( 'post_type', 'product' );
			$q->set( 'page', '' );
			$q->set( 'page_id', '' );
			$q->set( 'pagename', '' );
			$q->set( 'competition_arhive', 'true' );
			$q->set( 'is_competition_archive', 'true' );
			// Fix conditional Functions
			$q->is_archive           = true;
			$q->is_post_type_archive = true;
			$q->is_singular          = false;
			$q->is_page              = false;

		}
		if ( isset( $q->queried_object->ID ) && $q->queried_object->ID === $competitions_entry_page_id && ! isset( $q->query_vars['competition_single_entry'] ) ) {

			$q->set( 'post_type', 'product' );
			$q->set( 'page', '' );
			$q->set( 'pagename', '' );
			$q->set( 'competition_arhive', 'true' );
			$q->set( 'competition_entry', 'true' );
			$q->set( 'show_future_lotteries', false );

			//$q->set( 'is_competition_archive', 'true' );
			// Fix conditional Functions
			$q->is_archive           = true;
			$q->is_post_type_archive = true;
			$q->is_singular          = false;
			$q->is_page              = false;

		}
		if ( isset( $q->query_vars['competition_single_entry'] ) ) {
			$q->set( 'post_type', 'product' );
			$q->set( 'name', $q->query_vars['competition_single_entry'] );
		}

		// When orderby is set, WordPress shows posts. Get around that here.
		if ( ( $q->is_home() && 'page' === get_option( 'show_on_front' ) ) && ( absint( get_option( 'page_on_front' ) ) === absint( get_option( 'competitions_for_woocommerce_competitions_page_id' ) ) ) ) {
			$_query = wp_parse_args( $q->query );
			if ( empty( $_query ) || ! array_diff( array_keys( $_query ), array( 'preview', 'page', 'paged', 'cpage', 'orderby' ) ) ) {
				$q->is_page = true;
				$q->is_home = false;
				$q->set( 'page_id', (int) get_option( 'page_on_front' ) );
				$q->set( 'post_type', 'product' );
			}
		}

		if ( $q->is_page() && 'page' === get_option( 'show_on_front' ) && absint( $q->get( 'page_id' ) ) === get_option( 'competitions_for_woocommerce_competitions_page_id' ) ) {

			$q->set( 'post_type', 'product' );

			// This is a front-page shop
			$q->set( 'post_type', 'product' );
			$q->set( 'page_id', '' );
			$q->set( 'competition_arhive', 'true' );
			$q->set( 'is_competition_archive', 'true' );

			if ( isset( $q->query['paged'] ) ) {
				$q->set( 'paged', $q->query['paged'] );
			}

			// Define a variable so we know this is the front page shop later on
			define( 'COMPETITIONS_IS_ON_FRONT', true );

			// Get the actual WP page to avoid errors and let us use is_front_page()
			// This is hacky but works. Awaiting https://core.trac.wordpress.org/ticket/21096
			global $wp_post_types;

			$competition_page = get_post( get_option( 'competitions_for_woocommerce_competitions_page_id' ) );

			$wp_post_types['product']->ID         = $competition_page->ID;
			$wp_post_types['product']->post_title = $competition_page->post_title;
			$wp_post_types['product']->post_name  = $competition_page->post_name;
			$wp_post_types['product']->post_type  = $competition_page->post_type;
			$wp_post_types['product']->ancestors  = get_ancestors( $competition_page->ID, $competition_page->post_type );

			// Fix conditional Functions like is_front_page
			$q->is_singular          = false;
			$q->is_post_type_archive = true;
			$q->is_archive           = true;
			$q->is_page              = true;

			// Remove post type archive name from front page title tag
			add_filter( 'post_type_archive_title', '__return_empty_string', 5 );

			// Fix WP SEO
			if ( class_exists( 'WPSEO_Meta' ) ) {
				add_filter( 'wpseo_metadesc', array( $this, 'wpseo_metadesc' ) );
				add_filter( 'wpseo_metakey', array( $this, 'wpseo_metakey' ) );
				add_filter( 'wpseo_title', array( $this, 'wpseo_title' ) );
			}
		}

	}

	/**
	 * WP SEO meta description.
	 *
	 * Hooked into wpseo_ hook already, so no need for function_exist.
	 *
	 * @return string
	 *
	 */
	public function wpseo_metadesc() {
		return WPSEO_Meta::get_value( 'metadesc', get_option( 'competitions_for_woocommerce_competitions_page_id' ) );
	}

	/**
	 * WP SEO meta key.
	 *
	 * Hooked into wpseo_ hook already, so no need for function_exist.
	 *
	 * @return string
	 *
	 */
	public function wpseo_metakey() {
		return WPSEO_Meta::get_value( 'metakey', get_option( 'competitions_for_woocommerce_competitions_page_id' ) );
	}

	/**
	 * WP SEO title.
	 *
	 * Hooked into wpseo_ hook already, so no need for function_exist.
	 *
	 * @return string
	 *
	 */
	public function wpseo_title() {
		return WPSEO_Meta::get_value( 'title', get_option( 'competitions_for_woocommerce_competitions_page_id' ) );
	}

	/**
	 * Set is filtered is true to skip displaying categories only on page
	 *
	 * @return bolean
	 *
	 */
	public function add_is_filtered( $id ) {

		return true;

	}

	/**
	 * Appends tax queries to an array.
	 *
	 * @param  bool  $main_query If is main query.
	 * @param  array competition visibility terms
	 * @return void
	 *
	 */
	public function remove_finished_and_future_competition( $q ) {

		$metaquery = $q->get( 'meta_query' );

		if ( ! is_array( $metaquery ) ) {
				 $metaquery = array();
		}

		$metaquery [] = array(
				'key'     => '_lottery_started',
				'compare' => 'NOT EXISTS',
			);
		$metaquery [] = array(
				'key'     => '_lottery_closed',
				'compare' => 'NOT EXISTS',
			);
		$q->set( 'meta_query', $metaquery );
	}



	public function add_outofstock_items( $taxquery ) {

		if ( 'yes' !== $this->hide_out_of_stock_items ) {
			return $taxquery;
		}
		if ( is_array( $taxquery ) ) {

			$product_visibility_terms = wc_get_product_visibility_term_ids();

			foreach ( $taxquery as $key => $value ) {
				if ( isset( $value['taxonomy'] ) && 'product_visibility' === $value['taxonomy'] ) {
					$key2 = array_search( intval( $product_visibility_terms['outofstock'] ), $value['terms'], true );
					if ( false !== $key2 ) {
						unset( $taxquery[ $key ]['terms'][ $key2 ] );
						break;
					}
				}
			}
		}
		return $taxquery;
	}

}

new competitions_For_Woocommerce_Query();
