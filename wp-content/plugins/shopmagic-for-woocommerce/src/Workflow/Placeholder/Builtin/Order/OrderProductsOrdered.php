<?php
declare( strict_types=1 );

namespace WPDesk\ShopMagic\Workflow\Placeholder\Builtin\Order;

use WPDesk\ShopMagic\Workflow\Placeholder\Builtin\WooCommerceOrderBasedPlaceholder;
use WPDesk\ShopMagic\Workflow\Placeholder\Helper\PlaceholderUTMBuilder;
use WPDesk\ShopMagic\Workflow\Placeholder\TemplateRendererForPlaceholders;

class OrderProductsOrdered extends WooCommerceOrderBasedPlaceholder {

	/** @var TemplateRendererForPlaceholders */
	private $renderer;

	/** @var PlaceholderUTMBuilder */
	private $utm_builder;

	public function __construct( TemplateRendererForPlaceholders $renderer, PlaceholderUTMBuilder $utm_builder ) {
		$this->renderer    = $renderer;
		$this->utm_builder = $utm_builder;
	}

	public function get_description(): string {
		return esc_html__( 'Display current ordered products.', 'shopmagic-for-woocommerce' ) . '\n' .
		$this->utm_builder->get_description();
	}

	public function get_slug(): string {
		return 'products_ordered';
	}

	/**
	 * @return mixed[]
	 */
	public function get_supported_parameters( $values = null ): array {
		return array_merge( $this->utm_builder->get_utm_fields(), $this->renderer->get_template_selector_field() );
	}

	public function value( array $parameters ): string {
		$items         = $this->resources->has( \WC_Order::class ) ? $this->get_order()->get_items() : [];
		$products      = [];
		$product_names = [];

		foreach ( $items as $item ) {
			if ( $item instanceof \WC_Order_Item_Product ) {
				$product = $item->get_product();
				if ( $product instanceof \WC_Product ) {
					$products[]      = $product;
					$product_names[] = $product->get_name();
				}
			}
		}

		return $this->renderer->render(
			$parameters['template'],
			[
				'order_items'   => $items,
				'products'      => $products,
				'product_names' => $product_names,
				'parameters'    => $parameters,
				'utm_builder'   => $this->utm_builder,
			]
		);
	}
}
