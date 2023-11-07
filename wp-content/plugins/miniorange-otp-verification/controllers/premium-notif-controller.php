<?php
/**
 * Load view for premium SMS Notifications List
 *
 * @package miniorange-otp-verification/controllers
 */

use OTP\Notifications\WcSMSNotification\Helper\moAddOnMessages;
use OTP\Notifications\WcSMSNotification\Controllers;
use OTP\Notifications\UmSMSNotification\Helper\UltimateMemberNotificationsList;
use OTP\Notifications\UmSMSNotification\Helper\UltimateMemberSMSNotificationMessages;
use OTP\Helper\MoUtility;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$dokan_hidden = 'dokanNotifSubTab' !== $subtab ? 'hidden' : '';
if ( MoUtility::is_plugin_installed( 'dokannotif/miniorange-custom-validation.php' ) ) {
	require_once str_replace( MOV_NAME, 'dokannotif', realpath( __DIR__ . DIRECTORY_SEPARATOR . '..' ) ) . '/controllers/main-controller.php';
} else {
	$premium_notif_hidden = 'dokanNotifSubTab' !== $subtab ? 'hidden' : '';
	$premium_notif_id     = 'dokanNotifSubTabContainer';
	if ( is_dir( MOV_DIR . '/notifications/dokannotif' ) ) {
		require_once MOV_DIR . '/notifications/dokannotif/controllers/main-controller.php';
	} else {
		require MOV_DIR . '/views/premium-notifications.php';

	}
}

$wcfm_hidden = 'wcfmNotifSubTab' !== $subtab ? 'hidden' : '';
if ( MoUtility::is_plugin_installed( 'wcfmnotif/miniorange-custom-validation.php' ) ) {
	require_once str_replace( MOV_NAME, 'wcfmnotif', realpath( __DIR__ . DIRECTORY_SEPARATOR . '..' ) ) . '/controllers/main-controller.php';
} else {
	$premium_notif_hidden = 'wcfmNotifSubTab' !== $subtab ? 'hidden' : '';
	$premium_notif_id     = 'wcfmNotifSubTabContainer';
	if ( is_dir( MOV_DIR . '/notifications/wcfmsmsnotification' ) ) {
		require_once MOV_DIR . 'notifications/wcfmsmsnotification/controllers/main-controller.php';
	} else {
		require MOV_DIR . '/views/premium-notifications.php';}
}
