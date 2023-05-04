<?php
declare( strict_types=1 );

namespace WPDesk\ShopMagic\Workflow\Placeholder\Builtin\Order;

use WPDesk\ShopMagic\Helper\WooCommerceFormatHelper;
use WPDesk\ShopMagic\Workflow\Placeholder\Builtin\WooCommerceOrderBasedPlaceholder;

final class OrderBillingCountry extends WooCommerceOrderBasedPlaceholder {

	public function get_slug(): string {
		return 'billing_country';
	}

	public function get_description(): string {
		return esc_html__( 'Display the billing country of current order.', 'shopmagic-for-woocommerce' );
	}

	public function value( array $parameters ): string {
		return WooCommerceFormatHelper::country_full_name( $this->get_order()->get_billing_country() );
	}
}
