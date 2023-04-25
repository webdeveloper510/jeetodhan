<?php
/**Load administrator changes for PremiumAddonList
 *
 * @package miniorange-otp-verification/helper
 */

namespace OTP\Helper;

use OTP\Objects\BaseAddOnHandler;
use OTP\Objects\FormHandler;
use OTP\Traits\Instance;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * This is the constant class which lists all the texts
 * that need to be supported for the Premium addon List.
 */
if ( ! class_exists( 'PremiumAddonList' ) ) {
	/**
	 * PremiumAddonList class
	 */
	final class PremiumAddonList {

		use Instance;
		/** Variable declaration
		 *
		 * @var $premium_addon
		 */
		private $premium_addon;

		/**Constructor
		 **/
		private function __construct() {
			$this->premium_addon = array(
				'otp_control'               => array(
					'name'        => 'Limit OTP Request ',
					'description' => 'Allows you to block OTP from being sent out before the set timer is up. Click on the button below for further details.',
				),
				'wp_sms_notification_addon' => array(
					'name'        => 'WordPress SMS Notification to Admin & User on Registration',
					'description' => 'Allows your site to send out custom SMS notifications to Customers and Administrators when a new user registers on your Wordpress site. Click on the button below for further details.',
				),
				'wc_pass_reset_addon'       => array(
					'name'        => 'WooCommerce Password Reset Over OTP ',
					'description' => 'Allows your users to reset their password using OTP instead of email links. Click on the button below for further details.',
				),
				'wp_pass_reset_addon'       => array(
					'name'        => 'WordPress Password Reset Over OTP',
					'description' => 'Allows your users to reset their password using OTP instead of email links. Click on the button below for further details.',
				),
				'mo_country_code_dropdown'  => array(
					'name'        => 'Country Code Dropdown ',
					'description' => 'Allows you to enable the country code dropdown on any field of your choice.Includes the country code and the country flag for selection.',
				),
			); }


		/**
		 * Function called to get the addon names
		 */
		public function get_add_on_name() {
			return $this->addon_name; }
		/**
		 * Function called to get the premium addon list
		 */
		public function get_premium_add_on_list() {
			return $this->premium_addon; }

	}
}
