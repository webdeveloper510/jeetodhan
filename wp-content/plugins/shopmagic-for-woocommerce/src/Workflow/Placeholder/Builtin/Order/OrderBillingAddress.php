<?php
declare( strict_types=1 );

namespace WPDesk\ShopMagic\Workflow\Placeholder\Builtin\Order;

use WPDesk\ShopMagic\Workflow\Placeholder\Builtin\WooCommerceOrderBasedPlaceholder;


final class OrderBillingAddress extends WooCommerceOrderBasedPlaceholder {
	public function get_slug(): string {
		return 'billing_address';
	}

	public function get_description(): string {
		return esc_html__( 'Display the billing address of current order.', 'shopmagic-for-woocommerce' );
	}

	public function value( array $parameters ): string {
		return $this->get_order()->get_billing_address_1();
	}
}

