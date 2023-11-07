<?php
/**Load administrator changes for MoWhatsApp
 *
 * @package miniorange-otp-verification/helper
 */

namespace OTP\Helper;

use OTP\Traits\Instance;
use OTP\Helper\MoConstants;
use OTP\Helper\MoMessages;
use OTP\Helper\MoUtility;
use OTP\Helper\MocURLCall;
use OTP\Helper\MoPHPSessions;
use OTP\Helper\TransactionCost;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/**
 * This class is for Whatsapp Verification and all its functions
 */
if ( ! class_exists( 'MoWhatsApp' ) ) {
	/**
	 * MoWhatsApp class
	 */
	class MoWhatsApp {

		use Instance;
		/**Constructor
		 **/
		protected function __construct() {
			add_filter( 'mo_wa_send_otp_token', array( $this, 'mo_wp_send_otp_token' ), 99, 4 );
		}

		/**
		 * Calls the server to send OTP to the user's phone or email
		 *
		 * @param string $auth_type  OTP Type - EMAIL or SMS.
		 * @param string $email     Email Address of the user.
		 * @param string $phone     Phone Number of the user.
		 * @param array  $data     Data of the user.
		 * @return array
		 */
		public function mo_wp_send_otp_token( $auth_type, $email, $phone, $data ) {
			$content = $this->send_otp_token( $auth_type, $email, $phone, $data );
			$message = json_decode( $content )->message;
			if ( isset( $message ) ) {
				return wp_json_encode( $message );
			} else {
				return $content;
			}
		}

		/**
		 * Calls the server to send OTP to the user's phone or email
		 *
		 * @param string $auth_type  OTP Type - EMAIL or SMS.
		 * @param string $email     Email Address of the user.
		 * @param string $phone     Phone Number of the user.
		 * @param array  $data     Data of the user.
		 * @return array
		 */
		public function send_otp_token( $auth_type, $email, $phone, $data ) {

			$mo_otp_length = get_mo_option( 'otp_length' ) ? get_mo_option( 'otp_length' ) : 5;
			$otp           = wp_rand( pow( 10, $mo_otp_length - 1 ), pow( 10, $mo_otp_length ) - 1 );
			$otp           = apply_filters( 'mo_alphanumeric_otp_filter', $otp );

			$customer_key   = get_mo_option( 'admin_customer_key' );
			$string_to_hash = $customer_key . $otp;
			$transaction_id = hash( 'sha512', $string_to_hash );
			$message        = 'Dear Customer, Your OTP is ##otp##. Use this Passcode to complete your transaction. Thank you.';
			$message        = str_replace( '##otp##', $otp, $message );

			if ( isset( $data['action'] ) && 'wa_miniorange_get_test_response' === ( $data['action'] ) ) {
				$customer_email = $data['customer_email'];
				$customer_pass  = $data['customer_pass'];

				if ( empty( $customer_email || $customer_pass ) ) {
					return ( 'ERROR: Enter the details before sending the OTP.' );
				}
				$content        = MocURLCall::get_customer_key( $customer_email, $customer_pass );
				$customer_exist = json_decode( $content );

				if ( ! $customer_exist ) {
					return $content;
				}
			}

			$response = $this->send_notif( $message, $phone, $otp, $data );
			return $response;
		}

		/**
		 * Calls the server to send SMS to the user's phone or email
		 *
		 * @param string $message  SMS text.
		 * @param string $phone     Phone Number of the user.
		 * @param string $otp     otp sent to the user.
		 * @param array  $data     Data of the user.
		 * @return array
		 */
		public function send_notif( $message, $phone, $otp, $data ) {

			$message      = str_replace( ' ', '+', $message );
			$url          = MoConstants::HOSTNAME . '/moas/api/plugin/whatsapp/send';
			$customer_key = get_mo_option( 'admin_customer_key' );
			$site_name    = get_bloginfo( 'name' );

			$admin_email   = get_mo_option( 'admin_email' );
			$customer_pass = $data['customer_pass'];

			/*only to send otp via whatsapp on miniOrange and/or custom gateway*/
			$message = 'otp_test_whatsapp';
			$fields  = array(
				'customerId'       => $customer_key,
				'variable'         => array(
					'var1' => $site_name,
					'var2' => $otp,
				),
				'isDefault'        => true,
				'templateId'       => $message,
				'phoneNumber'      => $phone,
				'templateLanguage' => 'en',
				'customerEmail'    => $admin_email,
				'customerPassword' => $customer_pass,
			);
			$arr     = array();
			array_push( $arr, $site_name, $otp );
			$json     = wp_json_encode( $fields );
			$response = MocURLCall::call_api( $url, $json );
			return $response;
		}
	}
}
