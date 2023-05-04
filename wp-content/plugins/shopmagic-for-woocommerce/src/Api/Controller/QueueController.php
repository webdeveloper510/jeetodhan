<?php

declare( strict_types=1 );

namespace WPDesk\ShopMagic\Api\Controller;

use WPDesk\ShopMagic\Components\Routing\HttpProblemException;
use WPDesk\ShopMagic\Customer\CustomerRepository;
use WPDesk\ShopMagic\Exception\CustomerNotFound;
use WPDesk\ShopMagic\Workflow\Automation\AutomationRepository;
use WPDesk\ShopMagic\Workflow\Queue\ActionSchedulerQueue;
use WPDesk\ShopMagic\Workflow\Queue\Queue;

class QueueController {

	/** @var Queue */
	private $queue;

	/** @var CustomerRepository */
	private $customer_repository;

	public function __construct( Queue $queue, CustomerRepository $customer_repository ) {
		$this->queue               = $queue;
		$this->customer_repository = $customer_repository;
	}

	public function index(
		\WP_REST_Request $request,
		AutomationRepository $repository
	): \WP_REST_Response {
		$search = $this->queue->search(
			[
				'group'    => ActionSchedulerQueue::GROUP,
				'status'   => \ActionScheduler_Store::STATUS_PENDING,
				'per_page' => $request->get_param( 'pageSize' ),
				'offset'   => ( $request->get_param( 'page' ) - 1 ) * $request->get_param( 'pageSize' ),
				//'order'    => 'DESC',
			]
		);

		return new \WP_REST_Response(
			array_map( function ( \ActionScheduler_Action $queue_action, int $index ) use (
				$repository
			) {
				[
					$automation_data,
					$event_params,
					, // Unused serialized action.
					$action_index,
					$execution_id,
				] = $queue_action->get_args();

				$schedule = $queue_action->get_schedule();
				if ( $schedule instanceof \ActionScheduler_Abstract_Schedule ) {
					$timezone     = wp_timezone();
					$set_timezone = $schedule->get_date()->setTimezone( $timezone );
					$schedule     = $set_timezone->format( \DateTimeInterface::ATOM );
				} else {
					$schedule = null;
				}

				try {
					$customer = $this->get_customer( $event_params );
				} catch ( \Throwable $e ) {
					$customer = null;
				}

				try {
					$automation_object = $repository->find( $automation_data['id'] );
					$automation        = [
						'id'      => $automation_object->get_id(),
						'name'    => $automation_object->get_name(),
						'actions' => [
							$action_index => $automation_object->has_action( $action_index ) ? $automation_object->get_action( $action_index )->get_name() : null,
						],
					];
				} catch ( \Throwable $e ) {
					$automation = null;
				}

				return [
					'id'           => $index,
					'execution_id' => $execution_id ?? $index,
					'automation'   => $automation,
					'customer'     => $customer,
					'schedule'     => $schedule,
				];
			}, $search, array_keys( $search ) )
		);
	}

	private function get_customer( array $event_data ): array {
		if ( ! isset( $event_data['customer_id'], $event_data['user_id'] ) && isset( $event_data['order_id'] ) ) {
			$customer_object = $this->get_customer_from_order( $event_data['order_id'] );
		} else {
			$customer_object = $this->customer_repository->find( $event_data['customer_id'] ?? $event_data['user_id'] );
		}

		return [
			'id'    => $customer_object->get_id(),
			'guest' => $customer_object->is_guest(),
			'email' => $customer_object->get_email(),
		];
	}

	private function get_customer_from_order( int $order_id ): \WPDesk\ShopMagic\Customer\Customer {
		$order = wc_get_order( $order_id );
		if ( $order instanceof \WC_Abstract_Order ) {
			return $this->customer_repository->find_by_email( $order->get_billing_email() );
		}

		throw new CustomerNotFound( sprintf( 'Failed to fetch customer from order `%d`.', $order_id ) );
	}

	public function count(): \WP_REST_Response {
		$count = \ActionScheduler::store()->query_actions( [
			'group'    => ActionSchedulerQueue::GROUP,
			'status'   => \ActionScheduler_Store::STATUS_PENDING,
			'per_page' => - 1,
		], 'count' );

		return new \WP_REST_Response( $count );
	}

	public function cancel( int $id ): \WP_REST_Response {
		$action = \ActionScheduler::store()->fetch_action( $id );
		if ( $action->get_group() !== ActionSchedulerQueue::GROUP ) {
			throw new HttpProblemException( [
				"title" => esc_html__( "Cannot cancel action outside ShopMagic group.", 'shopmagic-for-woocommerce' ),
			] );
		}

		$this->queue->cancel( $id );

		return new \WP_REST_Response( null, \WP_Http::NO_CONTENT );
	}
}
