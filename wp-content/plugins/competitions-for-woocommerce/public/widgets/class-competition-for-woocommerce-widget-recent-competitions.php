<?php
/**
 * Recent competitions Widget
 *
 * @version 	1.0.0
 * @extends 	WP_Widget
 *
 */

defined( 'ABSPATH' ) || exit;

class Competitions_For_Woocommerce_Widget_Recent_Competitions extends WC_Widget {

	/**
	 * Constructor
	 *
	 * @return void
	 *
	 */
	public function __construct() {


		/* Widget variable settings. */
		$this->widget_cssclass    = 'woocommerce widget_recent_competitions';
		$this->widget_description = __( 'Display a list of your most recent competitions on your site.', 'competitions_for_woocommerce' );
		$this->widget_id          = 'competitions_recent_competitions';
		$this->widget_name        = __( 'Competitions Recent Competitions', 'competitions_for_woocommerce' );

		$this->settings           = array(
			'title'  => array(
				'type'  => 'text',
				'std'   => __( 'Recent competitions', 'competitions_for_woocommerce' ),
				'label' => __( 'Title', 'woocommerce' ),
			),
			'number' => array(
				'type'  => 'number',
				'step'  => 1,
				'min'   => 1,
				'max'   => '',
				'std'   => 5,
				'label' => esc_html__( 'Number of competitions to show:', 'competitions_for_woocommerce' ),
			),
			'hide_time' => array(
				'type'  => 'checkbox',
				'std'   => 0,
				'label' => esc_html__( 'Hide time left', 'competitions_for_woocommerce' ),
			),
			'furure_competitions' => array(
				'type'  => 'checkbox',
				'std'   => 0,
				'label' => esc_html__( 'Show future competitions', 'competitions_for_woocommerce' ),
			),
		);

		parent::__construct();
	}

	/* Output widget.
	 *
	 * @see WP_Widget
	 * @param array $args     Arguments.
	 * @param array $instance Widget instance.
	 */
	public function widget( $args, $instance ) {
		if ( $this->get_cached_widget( $args ) ) {
			return;
		}

		ob_start();

		$number = ! empty( $instance['number'] ) ? absint( $instance['number'] ) : $this->settings['number']['std'];

		$query_args = array(
			'posts_per_page' => $number,
			'no_found_rows'  => 1,
			'post_status'    => 'publish',
			'post_type'      => 'product',
		);

		$query_args['meta_query']   = array();
		$query_args['meta_query'][] = WC()->query->stock_status_meta_query();

		$query_args['meta_query'] = array_filter( $query_args['meta_query'] );
		$query_args['tax_query']  = array(
			array(
				'taxonomy' => 'product_type',
				'field'    => 'slug',
				'terms'    => 'competition',
			),
		);
		if ( empty( $instance['furure_competitions'] ) ) {
			$query_args['show_future_competitions'] = true;
		} else {
			$query_args['show_future_competitions'] = false;
		}
		$query_args['is_competition_archive'] = true;
		$query_args['competition_arhive']     = true;
		$query_args['meta_query'][]           = array(
			'key'     => '_competition_closed',
			'compare' => 'NOT EXISTS',
		);
		$query_args['meta_query']             = array_filter( $query_args['meta_query'] );

		$r = new WP_Query( $query_args );

		if ( $r->have_posts() ) {

			$this->widget_start( $args, $instance );

			echo wp_kses_post( apply_filters( 'woocommerce_before_widget_product_list', '<ul class="product_list_widget">' ) );

			$template_args = array(
				'widget_id'   => $args['widget_id'],
				'hide_time' => empty( $instance['hide_time'] ) ? 0 : 1,
			);

			while ( $r->have_posts() ) {
				$r->the_post();
				wc_get_template( 'content-widget-competition-product.php', $template_args );
			}

			echo wp_kses_post( apply_filters( 'woocommerce_after_widget_product_list', '</ul>' ) );

			$this->widget_end( $args );
		}

		wp_reset_postdata();

		$content = ob_get_clean();

		echo wp_kses_post( $content );

		$this->cache_widget( $args, $content );
	}

}
