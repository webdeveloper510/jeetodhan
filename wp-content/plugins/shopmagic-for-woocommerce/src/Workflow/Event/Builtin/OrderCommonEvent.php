<?php

declare( strict_types=1 );

namespace WPDesk\ShopMagic\Workflow\Event\Builtin;

use WC_Order;
use WPDesk\ShopMagic\Customer\Customer;
use WPDesk\ShopMagic\Exception\ReferenceNoLongerAvailableException;
use WPDesk\ShopMagic\Workflow\Components\Groups;
use WPDesk\ShopMagic\Workflow\Event\CustomerAwareInterface;
use WPDesk\ShopMagic\Workflow\Event\CustomerAwareTrait;
use WPDesk\ShopMagic\Workflow\Event\Event;

abstract class OrderCommonEvent extends Event implements CustomerAwareInterface {
	use CustomerAwareTrait;

	/** @var int */
	public const PRIORITY_AFTER_DEFAULT = 100;
	/** @var string */
	private const ORDER_ID = 'order_id';

	/** @var \WC_Order|\WC_Order_Refund */
	protected $order;

	public function get_group_slug(): string {
		return Groups::ORDER;
	}

	public function get_provided_data_domains(): array {
		return array_merge(
			parent::get_provided_data_domains(),
			[ \WC_Order::class, Customer::class ]
		);
	}

	/**
	 * @param mixed                                         $_
	 * @param \WC_Order|\WC_Order_Refund|\WC_Abstract_Order $order
	 *
	 * @internal
	 */
	protected function process_event( $_, $order ): void {
		if ( $order instanceof WC_Order ) {
			$this->resources->set( WC_Order::class, $order );
		} elseif ($order instanceof \WC_Order_Refund) {
			$this->resources->set( \WC_Order_Refund::class, $order );
		}

		$this->resources->set(
			Customer::class,
			$this->customer_repository->find_by_email( $this->get_order()->get_billing_email() )
		);
		$this->trigger_automation();
	}

	protected function get_order(): WC_Order {
		return $this->resources->get( WC_Order::class );
	}

	/**
	 * @return array{order_id: numeric-string|int} Normalized event data required for Queue serialization.
	 */
	public function jsonSerialize(): array {
		return [
			self::ORDER_ID => $this->get_order()->get_id(),
			'customer_id'  => $this->resources->get( Customer::class )->get_id(),
		];
	}

	/**
	 * @param array{order_id: numeric-string} $serialized_json
	 *
	 * @throws ReferenceNoLongerAvailableException When serialized object reference is no longer valid. i.e. order no
	 *                                             longer exists.
	 */
	public function set_from_json( array $serialized_json ): void {
		try {
			$order = wc_get_order( $serialized_json[ self::ORDER_ID ] );
			if ( $order instanceof \WC_Order ) {
				$this->resources->set( \WC_Order::class, $order );
			} elseif ( $order instanceof \WC_Order_Refund ) {
				$this->resources->set( \WC_Order_Refund::class, $order );
			}
			$this->resources->set(
				Customer::class,
				$this->customer_repository->find_by_email( $order->get_billing_email() )
			);
		} catch ( \InvalidArgumentException $invalidArgumentException ) {
			// translators: %d: ID of an order.
			throw new ReferenceNoLongerAvailableException( sprintf( __( 'Order %d no longer exists.',
				'shopmagic-for-woocommerce' ),
				$serialized_json[ self::ORDER_ID ] ) );
		}
	}
}
