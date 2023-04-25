<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Competition Search Widget
 *
  * @extends  WC_Widget
 */
class Competitions_For_Woocommerce_Widget_Competitions_Search extends WC_Widget {

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->widget_cssclass    = 'woocommerce widget_Competition_search';
		$this->widget_description = __( 'A Search box for competitions only.', 'competitions_for_woocommerce' );
		$this->widget_id          = 'competitions_search';
		$this->widget_name        = __( 'Competitions Search', 'competitions_for_woocommerce' );
		$this->settings           = array(
			'title'  => array(
				'type'  => 'text',
				'std'   => '',
				'label' => __( 'Title', 'competitions_for_woocommerce' )
			)
		);

		parent::__construct();
	}

	/**
	 * Widget function.
	 *
	 * @see WP_Widget
	 *
	 * @param array $args
	 * @param array $instance
	 *
	 * @return void
	 */
	public function widget( $args, $instance ) {
		$this->widget_start( $args, $instance );

		do_action( 'pre_get_competition_search_form'  );

		wc_get_template( 'competitions-searchform.php' );

		$this->widget_end( $args );
	}
}
