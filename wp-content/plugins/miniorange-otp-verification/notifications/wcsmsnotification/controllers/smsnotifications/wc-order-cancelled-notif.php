<?php
/**
 * Load view for Customer Order Cancelled SMS Notification
 *
 * @package miniorange-otp-verification/Notifications
 */

use OTP\Helper\MoUtility;
use OTP\Helper\MoMessages;
use OTP\Notifications\WcSMSNotification\Helper\WooCommerceNotificationsList;
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$notification_settings = get_wc_option( 'notification_settings_option' );
$notification_settings = $notification_settings ? maybe_unserialize( $notification_settings )
												: WooCommerceNotificationsList::instance();

$sms_settings       = $notification_settings->get_wc_order_cancelled_notif();
$enable_disable_tag = $sms_settings->page;
$textarea_tag       = $sms_settings->page . '_smsbody';
$recipient_tag      = $sms_settings->page . '_recipient';
$recipient_value    = $sms_settings->recipient;
$enable_disable     = $sms_settings->is_enabled ? 'checked' : '';

require MSN_DIR . '/views/smsnotifications/wc-customer-sms-template.php';
