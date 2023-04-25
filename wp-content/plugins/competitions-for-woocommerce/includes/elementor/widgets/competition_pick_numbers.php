<?php
namespace ElementorPro\Modules\Woocommerce\Widgets;

use Elementor\Controls_Manager;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Group_Control_Typography;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Competition_Pick_Numbers extends Base_Widget {

	public function get_name() {
		return 'woocommerce-competition-pick-numbers';
	}

	public function get_title() {
		return __( 'Competition Tickets Numbers', 'competitions_for_woocommerce' );
	}

	public function get_icon() {
		return 'eicon-competition-pick-numbers';
	}

	public function get_keywords() {
		return [ 'woocommerce', 'shop', 'store', 'competition', 'pick-numbers' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_competition_pick-numbers_style',
			[
				'label' => __( 'Competition Ticket Numbers', 'elementor-pro' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'wc_style_warning',
			[
				'type' => Controls_Manager::RAW_HTML,
				'raw' => __( 'The style of this widget is often affected by your theme and plugins. If you experience any such issue, try to switch to a basic theme and deactivate related plugins.', 'elementor-pro' ),
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
			]
		);

		$this->add_responsive_control(
			'text_align',
			[
				'label' => __( 'Alignment', 'elementor-pro' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'elementor-pro' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'elementor-pro' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'elementor-pro' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'selectors' => [
					'{{WRAPPER}}' => 'text-align: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'competition_pick-numbers_text_color',
			[
				'label' => __( 'Text Color', 'elementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'global' => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'.woocommerce {{WRAPPER}} ' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'typography',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
				'selector' => '.woocommerce {{WRAPPER}}',
			]
		);

		$this->add_control(
			'Competition_pick-numbers_heading',
			[
				'label' => __( 'Competition pick-numbers', 'elementor-pro' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'competition_pick-numbers_activecolor',
			[
				'label' => __( 'Selected number Color', 'elementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.woocommerce {{WRAPPER}} ul.tickets_numbers li.selected' => 'background-color: {{VALUE}} !important;',
				],
			]
		);
		$this->add_control(
			'competition_pick-numbers_hovercolor',
			[
				'label' => __( 'Hoover number Color', 'elementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.woocommerce {{WRAPPER}} ul.tickets_numbers li:hover' => 'background-color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'competition_pick-numbers_reservedcolor',
			[
				'label' => __( 'Reserved number color', 'elementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.woocommerce {{WRAPPER}} ul.tickets_numbers li.reserved' => 'background-color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'competition_pick-numbers_takennumber',
			[
				'label' => __( 'Taken number color', 'elementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.woocommerce {{WRAPPER}} ul.tickets_numbers li.taken' => 'background-color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'competition_pick-numbers_incartnumber',
			[
				'label' => __( 'In cart number color', 'elementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.woocommerce {{WRAPPER}} ul.tickets_numbers li.in_cart' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'competition_pick-numbers_spacing',
			[
				'label' => __( 'Spacing', 'elementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range' => [
					'em' => [
						'min' => 0,
						'max' => 5,
						'step' => 0.1,
					],
				],
				'selectors' => [
					'body:not(.rtl) {{WRAPPER}}:not(.elementor-competition-pick-numbers-block-yes)' => 'margin-right: {{SIZE}}{{UNIT}}',
					'body.rtl {{WRAPPER}}:not(.elementor-competition-pick-numbers-block-yes)' => 'margin-left: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}}.elementor-competition-pick-numbers-block-yes' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {

		global $product;
		$product = wc_get_product();

		if ( empty( $product ) || $product->get_type() !== 'competition' || $product->is_closed() ) {
			return;
		}
		wc_get_template( '/single-product/add-to-cart/ticket-numbers.php' );
	}

	public function render_plain_content() {}
}
