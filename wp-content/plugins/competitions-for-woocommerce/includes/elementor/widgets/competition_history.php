<?php
namespace ElementorPro\Modules\Woocommerce\Widgets;

use Elementor\Controls_Manager;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Group_Control_Typography;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Competition_History extends Base_Widget {

	public function get_name() {
		return 'woocommerce-competition-history';
	}

	public function get_title() {
		return __( 'Competition History', 'competitions_for_woocommerce' );
	}

	public function get_icon() {
		return 'eicon-competition-history';
	}

	public function get_keywords() {
		return [ 'woocommerce', 'shop', 'store', 'competition', 'history' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_competition_history_style',
			[
				'label' => __( 'Competition History', 'elementor-pro' ),
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
			'competition_history_heding_color',
			[
				'label' => __( 'Heding Color', 'elementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'global' => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'.woocommerce {{WRAPPER}} h2' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'competition_history_text_color',
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

		$this->add_responsive_control(
			'competition_history_spacing',
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
					'body:not(.rtl) {{WRAPPER}}:not(.elementor-competition-history-block-yes)' => 'margin-right: {{SIZE}}{{UNIT}}',
					'body.rtl {{WRAPPER}}:not(.elementor-competition-history-block-yes)' => 'margin-left: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}}.elementor-competition-history-block-yes' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {

		global $product;
		$product = wc_get_product();

		if ( empty( $product ) || $product->get_type() !== 'competition' ) {
			return;
		}
		wc_get_template( '/single-product/tabs/competition-history.php' );
	}

	public function render_plain_content() {}
}
