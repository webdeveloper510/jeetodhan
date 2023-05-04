<?php

declare( strict_types=1 );

namespace WPDesk\ShopMagic\Workflow\Event\Builtin\Order;

use WPDesk\ShopMagic\Customer\Customer;
use WPDesk\ShopMagic\Workflow\Event\Builtin\OrderCommonEvent;
use WPDesk\ShopMagic\Workflow\Event\DeferredStateCheck\DefferedCheckField;
use WPDesk\ShopMagic\Workflow\Event\DeferredStateCheck\SupportsDeferredCheck;

final class OrderPaid extends OrderCommonEvent implements SupportsDeferredCheck {
	public function get_id(): string {
		return 'shopmagic_order_status_paid';
	}

	public function get_name(): string {
		return __( 'Order Paid', 'shopmagic-for-woocommerce' );
	}

	public function get_description(): string {
		return __(
			'Run automation when an order is considered to be paid. By default, it runs for order status "processing" and "completed".',
			'shopmagic-for-woocommerce'
		);
	}

	public function initialize(): void {
		add_action(
			'woocommerce_order_status_changed',
			function ( $order_id, $old_status, $new_status, $order ) {
				$this->status_changed( $order_id, $old_status, $new_status, $order );
			},
			10,
			4
		);
	}

	/**
	 * @internal
	 */
	public function status_changed( $_, $old_status, $new_status, $order ): void {
		$this->resources->set( \WC_Order::class, $order );
		$this->resources->set(
			Customer::class,
			$this->customer_repository->find_by_email( $this->get_order()->get_billing_email() )
		);

		if ( \in_array( $old_status, wc_get_is_paid_statuses(), true ) ) {
			return;
		}

		if ( ! \in_array( $new_status, wc_get_is_paid_statuses(), true ) ) {
			return;
		}

		$this->trigger_automation();
	}

	/**
	 * @return \WPDesk\ShopMagic\Workflow\Event\DeferredStateCheck\DefferedCheckField[]
	 */
	public function get_fields(): array {
		return [ new DefferedCheckField() ];
	}

	public function is_event_still_valid(): bool {
		return \in_array( $this->get_order()->get_status(), wc_get_is_paid_statuses(), true );
	}
}
