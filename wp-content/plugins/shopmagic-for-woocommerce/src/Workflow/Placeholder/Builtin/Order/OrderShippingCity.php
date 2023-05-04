<?php
declare( strict_types=1 );

namespace WPDesk\ShopMagic\Workflow\Placeholder\Builtin\Order;

use WPDesk\ShopMagic\Workflow\Placeholder\Builtin\WooCommerceOrderBasedPlaceholder;

final class OrderShippingCity extends WooCommerceOrderBasedPlaceholder {

	public function get_slug(): string {
		return 'shipping_city';
	}

	public function get_description(): string {
		return esc_html__( 'Display the shipping city of current order.', 'shopmagic-for-woocommerce' );
	}

	public function value( array $parameters ): string {
		return $this->get_order()->get_shipping_city();
	}
}
