<?php

declare( strict_types=1 );

namespace WPDesk\ShopMagic\Workflow\Event\Builtin;

use WPDesk\ShopMagic\Components\HookProvider\HookTrait;
use WPDesk\ShopMagic\Customer\Customer;
use WPDesk\ShopMagic\FormField\Field\SelectField;
use WPDesk\ShopMagic\Marketing\Subscribers\AudienceList\CommunicationListRepository;
use WPDesk\ShopMagic\Marketing\Subscribers\ListSubscriber\SingleListSubscriber;
use WPDesk\ShopMagic\Workflow\Event\ManualGlobalEvent;


abstract class OptCommonEvent extends UserCommonEvent implements ManualGlobalEvent {
	use HookTrait;

	/** @var string */
	private const PARAM_COMMUNICATION_TYPE = 'communication_type';

	public static function trigger( array $args ): void {
	}

	public function get_fields(): array {
		return [
			( new SelectField() )
				->set_label( __( 'List', 'shopmagic-for-woocommerce' ) )
				->set_name( self::PARAM_COMMUNICATION_TYPE )
				->set_placeholder( __( 'Any list', 'shopmagic-for-woocommerce' ) )
				->set_options( CommunicationListRepository::get_lists_as_select_options() )
				->set_description_tip(
					__(
						'Choose the list to which the customer opted in, or from which he opted out.',
						'shopmagic-for-woocommerce'
					)
				),
		];
	}

	/**
	 * Save params and run actions.
	 *
	 * @param SingleListSubscriber $subscriber
	 */
	public function process_event( SingleListSubscriber $subscriber ): void {
		try {
			$this->resources->set(
				Customer::class,
				$this->customer_repository->find_by_email( $subscriber->get_email() )
			);
		} catch ( \Exception $e ) {
			$this->logger->error( 'Error during setting a customer from list subscriber. {error}', [
				'error' => $e->getMessage(),
			] );

			return;
		}

		if ( ! $this->fields_data->has( self::PARAM_COMMUNICATION_TYPE ) ) {
			$this->logger->warning( sprintf( "Prevented event dispatch due to insufficient configuration. Missing '%s' parameter",
				self::PARAM_COMMUNICATION_TYPE ) );
			return;
		}

		$expected_list_id = $this->fields_data->get( self::PARAM_COMMUNICATION_TYPE );
		if ( empty( $expected_list_id ) || (int) $expected_list_id === $subscriber->get_list_id() ) {
			$this->trigger_automation();
		}
	}
}
