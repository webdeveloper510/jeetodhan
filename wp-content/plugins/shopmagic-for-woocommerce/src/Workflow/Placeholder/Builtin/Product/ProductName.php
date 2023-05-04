<?php
declare( strict_types=1 );

namespace WPDesk\ShopMagic\Workflow\Placeholder\Builtin\Product;

use WPDesk\ShopMagic\Workflow\Placeholder\Builtin\WooCommerceProductBasedPlaceholder;

final class ProductName extends WooCommerceProductBasedPlaceholder {

	public function get_slug(): string {
		return 'name';
	}

	public function get_description(): string {
		return esc_html__( 'Display name of current product.', 'shopmagic-for-woocommerce' );
	}

	public function value( array $parameters ): string {
		return $this->get_product()->get_name();
	}
}
