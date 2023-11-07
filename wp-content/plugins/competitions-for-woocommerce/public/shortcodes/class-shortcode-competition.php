<?php
/**
 * Products shortcode
 *
 * @package  WooCommerce/Shortcodes
 * @version  3.2.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Products shortcode class.
 */
class Shortcode_Competition extends WC_Shortcode_Products {

	/**
	 * Shortcode type.
	 *
	 * @since 3.2.0
	 * @var   string
	 */
	protected $type = 'products';

	/**
	 * Attributes.
	 *
	 * @since 3.2.0
	 * @var   array
	 */
	protected $attributes = array();

	/**
	 * Query args.
	 *
	 * @since 3.2.0
	 * @var   array
	 */
	protected $query_args = array();

	/**
	 * Set custom visibility.
	 *
	 * @since 3.2.0
	 * @var   bool
	 */
	protected $custom_visibility = false;

	/**
	 * Initialize shortcode.
	 *
	 * @since 3.2.0
	 * @param array  $attributes Shortcode attributes.
	 * @param string $type       Shortcode type.
	 */
	public function __construct( $attributes = array(), $type = 'competition' ) {
		$this->type       = $type;
		$this->attributes = $this->parse_attributes( $attributes );
		$this->query_args = $this->parse_query_args();
	}

	/**
	 * Get shortcode attributes.
	 *
	 * @since  3.2.0
	 * @return array
	 */
	public function get_attributes() {
		return $this->attributes;
	}

	/**
	 * Get query args.
	 *
	 * @since  3.2.0
	 * @return array
	 */
	public function get_query_args() {
		return $this->query_args;
	}

	/**
	 * Get shortcode type.
	 *
	 * @since  3.2.0
	 * @return array
	 */
	public function get_type() {
		return $this->type;
	}

	/**
	 * Get shortcode content.
	 *
	 * @since  3.2.0
	 * @return string
	 */
	public function get_content() {
		return $this->product_loop();
	}
	/**
	 * Get shortcode content.
	 *
	 * @since  3.2.0
	 * @return string
	 */
	public function get_content_competition_winners() {
		return $this->product_loop_competition_winners();
	}

	/**
	 * Parse attributes.
	 *
	 * @since  3.2.0
	 * @param  array $attributes Shortcode attributes.
	 * @return array
	 */
	protected function parse_attributes( $attributes ) {
		$attributes = $this->parse_legacy_attributes( $attributes );

		$attributes = shortcode_atts(
			array(
				'limit'          => '-1',      // Results limit.
				'columns'        => '',        // Number of columns.
				'rows'           => '',        // Number of rows. If defined, limit will be ignored.
				'orderby'        => '',        // menu_order, title, date, rand, price, popularity, rating, or id.
				'order'          => '',        // ASC or DESC.
				'ids'            => '',        // Comma separated IDs.
				'skus'           => '',        // Comma separated SKUs.
				'category'       => '',        // Comma separated category slugs or ids.
				'cat_operator'   => 'IN',      // Operator to compare categories. Possible values are 'IN', 'NOT IN', 'AND'.
				'attribute'      => '',        // Single attribute slug.
				'terms'          => '',        // Comma separated term slugs or ids.
				'terms_operator' => 'IN',      // Operator to compare terms. Possible values are 'IN', 'NOT IN', 'AND'.
				'tag'            => '',        // Comma separated tag slugs.
				'tag_operator'   => 'IN',      // Operator to compare tags. Possible values are 'IN', 'NOT IN', 'AND'.
				'visibility'     => 'visible', // Product visibility setting. Possible values are 'visible', 'catalog', 'search', 'hidden'.
				'class'          => '',        // HTML class.
				'page'           => 1,         // Page for pagination.
				'paginate'       => false,     // Should results be paginated.
				'cache'          => true,      // Should shortcode output be cached.
				'competition_status' => '',
				'future'         => '',
				'meta_key'       => '',
			),
			$attributes,
			$this->type
		);

		if ( ! absint( $attributes['columns'] ) ) {
			$attributes['columns'] = wc_get_default_products_per_row();
		}
		return $attributes;
	}

	/**
	 * Parse legacy attributes.
	 *
	 * @since  3.2.0
	 * @param  array $attributes Attributes.
	 * @return array
	 */
	protected function parse_legacy_attributes( $attributes ) {

		$mapping = array(
			'per_page' => 'limit',
			'operator' => 'cat_operator',
			'filter'   => 'terms',
		);

		foreach ( $mapping as $old => $new ) {
			if ( isset( $attributes[ $old ] ) ) {
				$attributes[ $new ] = $attributes[ $old ];
				unset( $attributes[ $old ] );
			}
		}

		return $attributes;
	}

	/**
	 * Parse query args.
	 *
	 * @since  3.2.0
	 * @return array
	 */
	protected function parse_query_args() {

		$query_args = array(
			'post_type'           => 'product',
			'post_status'         => 'publish',
			'ignore_sticky_posts' => true,
			'no_found_rows'       => false === wc_string_to_bool( $this->attributes['paginate'] ),
			'orderby'             => empty( $_GET['orderby'] ) ? $this->attributes['orderby'] : wc_clean( wp_unslash( $_GET['orderby'] ) ), // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		);

		$orderby_value         = explode( '-', $query_args['orderby'] );
		$orderby               = esc_attr( $orderby_value[0] );
		$order                 = ! empty( $orderby_value[1] ) ? $orderby_value[1] : strtoupper( $this->attributes['order'] );
		$query_args['orderby'] = $orderby;
		$query_args['order']   = $order;

		if ( wc_string_to_bool( $this->attributes['paginate'] ) ) {
			$this->attributes['page'] = absint( empty( $_GET['product-page'] ) ? 1 : $_GET['product-page'] ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		}

		if ( ! empty( $this->attributes['rows'] ) ) {
			$this->attributes['limit'] = $this->attributes['columns'] * $this->attributes['rows'];
		}

		$ordering_args = WC()->query->get_catalog_ordering_args( $query_args['orderby'], $query_args['order'] );

		$query_args['orderby'] = $ordering_args['orderby'];
		$query_args['order']   = $ordering_args['order'];
		if ( $this->attributes['meta_key'] ) {
			$query_args['meta_key'] = $this->attributes['meta_key']; // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key
		}
		if ( $ordering_args['meta_key'] ) {
			$query_args['meta_key'] = $ordering_args['meta_key']; // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key
		}

		$query_args['posts_per_page'] = intval( $this->attributes['limit'] );

		if ( 1 < $this->attributes['page'] ) {
			$query_args['paged'] = absint( $this->attributes['page'] );
		}
		$query_args['meta_query'] = WC()->query->get_meta_query(); // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query
		$query_args['tax_query']  = array(); // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query

		// Visibility.
		$this->set_visibility_query_args( $query_args );

		// SKUs.
		$this->set_skus_query_args( $query_args );

		// IDs.
		$this->set_ids_query_args( $query_args );

		// Set specific types query args.
		if ( method_exists( $this, "set_{$this->type}_query_args" ) ) {
			$this->{"set_{$this->type}_query_args"}( $query_args );
		}

		// Attributes.
		$this->set_attributes_query_args( $query_args );

		// Categories.
		$this->set_categories_query_args( $query_args );

		// Tags.
		$this->set_tags_query_args( $query_args );


		$this->set_competition_query_args( $query_args );
		$this->set_competition_status_query_args( $query_args );
		$this->set_competition_future_query_args( $query_args );
		$query_args['is_competition_archive'] = true;

		$query_args = apply_filters( 'woocommerce_shortcode_competition_query', $query_args, $this->attributes, $this->type );

		// Always query only IDs.
		$query_args['fields'] = 'ids';
		return $query_args;
	}

	/**
	 * Set ids query args.
	 *
	 * @since 3.2.0
	 * @param array $query_args Query args.
	 */
	protected function set_competition_winners_query_args( &$query_args ) {
		$query_args['meta_query'][] = array(
			'key'     => '_competition_closed',
			'value'   => '2'
		);
	}

	/**
	 * Set competition query args.
	 *
	 * @since 3.2.0
	 * @param array $query_args Query args.
	 */
	protected function set_competition_query_args( &$query_args ) {

		$query_args['tax_query'][] = array(
			'taxonomy'         => 'product_type',
			'terms'            => 'competition',
			'field'            => 'slug',
		);

	}

	/**
	 * Set competition query args.
	 *
	 * @since 3.2.0
	 * @param array $query_args Query args.
	 */
	protected function set_competition_status_query_args( &$query_args ) {

		if ( ! empty( $this->attributes['competition_status'] ) ) {

			if ( 'all' === $this->attributes['competition_status'] ) {

				$query_args['show_past_competitions'] = true;
				$query_args['show_future_competitions'] = true;

			} elseif ( 'finished'  === $this->attributes['competition_status'] ) {

				$query_args['meta_query' ][]= array(
					'key'     => '_competition_closed',
					'compare' => 'EXISTS',
				);

				$query_args['meta_query'][]=  array(
					'key' => '_competition_started',
					'compare' => 'NOT EXISTS',
				);
				$query_args['show_past_competitions'] = true;

			} elseif ( 'future' === $this->attributes['competition_status'] ) {

				$query_args['meta_query'] [] =   array(
									'key'     => '_competition_closed',
									'compare' => 'NOT EXISTS',
									);

				$query_args['meta_query'] [] =  array(
										'key' => '_competition_started',
										'value'=> '0',
									);

			$query_args['show_future_competitions'] = true;

			} elseif ( 'active' === $this->attributes['competition_status'] ) {
				$query_args['show_future_competitions'] = false;
				$query_args['show_past_competitions']   = false;
			}

		}

	}

	/**
	 * Set competition query args.
	 *
	 * @since 3.2.0
	 * @param array $query_args Query args.
	 */
	protected function set_competition_future_query_args( &$query_args ) {

		if ( ! empty( $this->attributes['future'] ) ) {

			if ( 'yes' === $this->attributes['future'] || 'true' === $this->attributes['future'] ) {

				$query_args['show_future_competitions'] = true;

			} elseif ( 'false' === $this->attributes['future'] ) {

				$query_args['show_future_competitions'] = false;

			}
		}
	}

	/**
	 * Set top rated products query args.
	 *
	 * @since 3.6.5
	 * @param array $query_args Query args.
	 */
	protected function set_my_won_competitions_query_args( &$query_args ) {
		$query_args['meta_query'] = array( array(
			   'key' => '_competition_winners',
			   'value' => 's:6:"userid";s:' . strlen( get_current_user_id() ) . ':"' . get_current_user_id() . '"',
			   'compare' => 'LIKE'
		   ),
		   array(
			   'key' => '_competition_closed',
			   'value' => 2,
		   ));

	}


	/**
	 * Loop over found products.
	 *
	 * @since  3.2.0
	 * @return string
	 */
	protected function product_loop_competition_winners() {
		$columns  = absint( $this->attributes['columns'] );
		$classes  = $this->get_wrapper_classes( $columns );
		$products = $this->get_query_results();

		ob_start();

		if ( $products && $products->ids ) {
			// Prime caches to reduce future queries.
			if ( is_callable( '_prime_post_caches' ) ) {
				_prime_post_caches( $products->ids );
			}
			// Setup the loop.
			wc_setup_loop(
				array(
					'columns'      => $columns,
					'name'         => $this->type,
					'is_shortcode' => true,
					'is_search'    => false,
					'is_paginated' => wc_string_to_bool( $this->attributes['paginate'] ),
					'total'        => $products->total,
					'total_pages'  => $products->total_pages,
					'per_page'     => $products->per_page,
					'current_page' => $products->current_page,
				)
			);
			remove_action( 'woocommerce_after_shop_loop', 'woocommerce_catalog_ordering', 10 );
			remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 10 );
			remove_action( 'woocommerce_after_shop_loop', 'woocommerce_catalog_ordering', 30 );
			remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );

			do_action( "woocommerce_shortcode_before_{$this->type}_loop", $this->attributes );
			// Fire standard shop loop hooks when paginating results so we can show result counts and so on.
			if ( wc_string_to_bool( $this->attributes['paginate'] ) ) {
				do_action( 'woocommerce_before_shop_loop' );
			}
			woocommerce_product_loop_start();
			?>
			<table style="width:100%">
				<tr>
					<th><?php esc_html_e('Date', 'competitions_for_woocommerce'); ?></th>
					<th><?php esc_html_e('Competition', 'competitions_for_woocommerce'); ?></th>
					<th><?php esc_html_e('Winner', 'competitions_for_woocommerce'); ?></th>
				</tr>
			<?php
			foreach ( $products->ids as $product_id ) {
				$product = wc_get_product( $product_id );
				if ( $product ) {
					?>
					<tr>
						<td><?php echo esc_html( $product->get_competition_dates_to() ); ?> </td>
						<td><a href="<?php echo esc_url( get_permalink( $product_id ) ); ?>" rel="bookmark"><?php echo esc_html( get_the_title( $product_id ) ); ?></a></td>
						<td>
							<?php $competition_winers = get_post_meta($product_id, '_competition_winners', true); ?>
							<?php
							if ( ! empty($competition_winers) && ! empty( $competition_winers[0] ) ) {
								if ( count( $competition_winers) > 1) {

									?>
							<?php
								$winners = '';
									foreach ( $competition_winers as $winner_id ) {
											$winners .=  get_userdata($winner_id['userid'])->display_name . ', ';

									}
								echo esc_html( rtrim ($winners, ', ') );
									?>

							<?php
								} else {

									?>
								<?php
									if ( get_userdata($competition_winers[0]['userid']) ) {
										echo esc_html( get_userdata($competition_winers[0])->display_name );
									}
									?>
							<?php } ?>
						<?php
							} else {
								esc_html_e('None', 'competitions_for_woocommerce');
							}

							?>

						</td>
					</tr>
			<?php
				} // end if
			} //end foreach
			echo '</table>';
			woocommerce_product_loop_end();

			// Fire standard shop loop hooks when paginating results so we can show result counts and so on.
			if ( wc_string_to_bool( $this->attributes['paginate'] ) ) {
				do_action( 'woocommerce_after_shop_loop' );
			}

			do_action( "woocommerce_shortcode_after_{$this->type}_loop", $this->attributes );

			wp_reset_postdata();
			wc_reset_loop();
		} else {
			wc_get_template( 'loop/no-competition-winners-found.php' );
		}

		return '<div class="' . esc_attr( implode( ' ', $classes ) ) . '">' . ob_get_clean() . '</div>';
	}

}
