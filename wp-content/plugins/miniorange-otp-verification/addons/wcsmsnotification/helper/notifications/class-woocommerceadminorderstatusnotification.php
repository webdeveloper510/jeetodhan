<?php
/**
 * Helper functions for Woocommerce Admin Order Notifications
 *
 * @package miniorange-otp-verification/addons
 */

namespace OTP\Addons\WcSMSNotification\Helper\Notifications;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
use OTP\Addons\WcSMSNotification\Helper\MoWcAddOnMessages;
use OTP\Addons\WcSMSNotification\Helper\MoWcAddOnUtility;
use OTP\Addons\WcSMSNotification\Helper\WcOrderStatus;
use OTP\Helper\MoUtility;
use OTP\Objects\SMSNotification;

/**
 * This class is used to handle all the settings and function related
 * to the WooCommerce Admin Order Status SMS Notification. It initializes the
 * notification related settings and implements the functionality for
 * sending the SMS to the user.
 */
if ( ! class_exists( 'WooCommerceAdminOrderstatusNotification' ) ) {
	/**
	 * WooCommerceAdminOrderstatusNotification class
	 */
	class WooCommerceAdminOrderstatusNotification extends SMSNotification {

		/** Global Variable
		 *
		 * @var instance - initiates the instance of the file.
		 */
		public static $instance;
		/** Global Variable
		 *
		 * @var array statuses - defines the order status.
		 */
		public static $statuses;

		/** Declare Default variables */
		protected function __construct() {
			parent::__construct();
			$this->title             = 'Order Status';
			$this->page              = 'wc_admin_order_status_notif';
			$this->is_enabled        = false;
			$this->tool_tip_header   = 'NEW_ORDER_NOTIF_HEADER';
			$this->tool_tip_body     = 'NEW_ORDER_NOTIF_BODY';
			$this->recipient         = MoWcAddOnUtility::get_admin_phone_number();
			$this->sms_body          = MoWcAddOnMessages::showMessage( MoWcAddOnMessages::ADMIN_STATUS_SMS );
			$this->default_sms_body  = MoWcAddOnMessages::showMessage( MoWcAddOnMessages::ADMIN_STATUS_SMS );
			$this->available_tags    = '{site-name},{order-number},{order-status},{username}{order-date}';
			$this->page_header       = mo_( 'ORDER ADMIN STATUS NOTIFICATION SETTINGS' );
			$this->page_description  = mo_( 'SMS notifications settings for Order Status SMS sent to the admins' );
			$this->notification_type = mo_( 'Administrator' );
			self::$instance          = $this;
			self::$statuses          = WcOrderStatus::get_all_status();
		}


		/**
		 * Checks if there exists an existing instance of the class.
		 * If not then creates an instance and returns it.
		 */
		public static function getInstance() {
			return null === self::$instance ? new self() : self::$instance;
		}


		/**
		 * Initialize all the variables required to modify the sms template
		 * and send the SMS to the user. Checks if the SMS notification
		 * has been enabled and send SMS to the user. Do not send SMS
		 * if phone number of the customer doesn't exist.
		 *
		 * @param  array $args all the arguments required to send SMS.
		 */
		public function send_sms( array $args ) {
			if ( ! $this->is_enabled ) {
				return;
			}
			$order_details = $args['orderDetails'];
			$new_status    = $args['new_status'];
			if ( MoUtility::is_blank( $order_details ) ) {
				return;
			}
			if ( ! in_array( $new_status, self::$statuses, true ) ) {
				return;
			}
			$this->set_notif_in_session( $this->page );
			$userdetails   = get_userdata( $order_details->get_customer_id() );
			$site_name     = get_bloginfo();
			$username      = MoUtility::is_blank( $userdetails ) ? '' : $userdetails->user_login;
			$phone_numbers = maybe_unserialize( $this->recipient );
			$date_created  = $order_details->get_date_created()->date_i18n();
			$order_no      = $order_details->get_order_number();

			$replaced_string = array(
				'site-name'    => $site_name,
				'username'     => $username,
				'order-date'   => $date_created,
				'order-number' => $order_no,
				'order-status' => $new_status,
			);
			$replaced_string = apply_filters( 'mo_wc_admin_order_notif_string_replace', $replaced_string );
			$sms_body        = MoUtility::replace_string( $replaced_string, $this->sms_body );

			if ( MoUtility::is_blank( $phone_numbers ) ) {
				return;
			}
			foreach ( $phone_numbers as $phone_number ) {
				MoUtility::send_phone_notif( $phone_number, $sms_body );
			}
		}
	}
}
