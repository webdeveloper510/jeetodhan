<?php
/**
 * Custom messages addon handler.
 *
 * @package miniorange-otp-verification/addons
 */

namespace OTP\Notifications\CustomMessage\Handler;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use OTP\Helper\MoConstants;
use OTP\Helper\MoMessages;
use OTP\Helper\MoUtility;
use OTP\Objects\BaseAddOnHandler;
use OTP\Objects\BaseMessages;
use OTP\Traits\Instance;
use OTP\Helper\MoPHPSessions;
use OTP\Helper\MoFormDocs;

/**
 * The class is used to handle all custom message sending related functionality.
 * This class just handles the plugin related functionality to send custom sms
 * or email messages to the user.
 */
if ( ! class_exists( 'CustomMessages' ) ) {
	/**
	 * CustomMessages class
	 */
	class CustomMessages extends BaseAddOnHandler {

		use Instance;

		/**
		 * Define variable .
		 *
		 * @var string
		 */
		protected $addon_session_var;

		/**
		 * Add actions.
		 *
		 *  @var array $admin_actions Admin Actions and their Callback functions
		 */
		public $admin_actions = array(
			'mo_customer_validation_admin_custom_phone_notif' => 'mo_validation_send_sms_notif_msg',
			'mo_customer_validation_admin_custom_email_notif' => 'mo_validation_send_email_notif_msg',
		);

		/**
		 * Constructor checks if add-on has been enabled by the admin and initializes
		 * all the class variables. This function also defines all the hooks to
		 * hook into to make the add-on functionality work.
		 */
		public function __construct() {
			parent::__construct();
			$this->nonce = 'mo_admin_actions';
			if ( ! $this->moAddOnV() ) {
				return;
			}
			$this->addon_session_var = 'custom_message_addon';

			foreach ( $this->admin_actions as $action => $callback ) {
				add_action( "admin_post_{$action}", array( $this, $callback ) );
			}
			add_action( 'wp_ajax_mo_shortcode_send_sms', array( $this, 'mo_send_ajax_custom_sms' ) );
			add_action( 'wp_ajax_mo_shortcode_send_email', array( $this, 'mo_send_ajax_custom_emails' ) );
		}

		/**
		 * Unset all the session variables so that a new form submission starts
		 * a fresh process of OTP verification.
		 */
		public function unset_sessionVariables() {
			MoPHPSessions::unset_session( $this->addon_session_var );
		}
		/**
		 * Callback function is used to send SMS notifications. Processes the
		 * messages being sent and the phone number(s) message needs to be sent
		 * to.
		 */
		public function mo_validation_send_sms_notif_msg() {

			if ( ! current_user_can( 'manage_options' ) || ! check_admin_referer( $this->nonce, 'mosecurity' ) ) {
				wp_die( esc_attr( MoMessages::showMessage( MoMessages::INVALID_OP ) ) );
			}

			$data = MoUtility::mo_sanitize_array( $_POST );
			$this->mo_handle_send_sms( $data );
		}

		/**
		 * Callback function is used to send Email notifications. Processes the
		 * messages being sent and the email address(s) message needs to be
		 * sent to.
		 */
		public function mo_validation_send_email_notif_msg() {
			if ( ! current_user_can( 'manage_options' ) || ! check_admin_referer( $this->nonce, 'mosecurity' ) ) {
				wp_die( esc_attr( MoMessages::showMessage( MoMessages::INVALID_OP ) ) );
			}

			$data = MoUtility::mo_sanitize_array( $_POST );
			$this->mo_handle_send_emails( $data );
		}

		/**
		 * Function to send Custom SMS messages using shortcode
		 */
		public function mo_send_ajax_custom_sms() {
			if ( isset( $_POST[ $this->nonce_key ] ) ) { // phpcs:ignore -- false positive.
				if ( ! check_ajax_referer( $this->nonce, $this->nonce_key ) ) {
					return;
				}
			}

			$data = MoUtility::mo_sanitize_array( $_POST );
			$this->mo_handle_send_sms( $data );
		}

		/**
		 * Function handles the send custom sms functionality.
		 *
		 * @param array $data - Data fetch from the user.
		 */
		private function mo_handle_send_sms( $data ) {

			$phone_numbers = explode( ';', MoUtility::sanitize_check( 'mo_phone_numbers', $data ) );
			$message       = MoUtility::sanitize_check( 'mo_customer_validation_custom_sms_msg', $data );
			$content       = null;

			if ( empty( $phone_numbers && $message ) ) {
				return $this->show_error_messages( $content, $data );
			}

			foreach ( $phone_numbers as $phone ) {
				$content = MoUtility::send_phone_notif( $phone, $message );
			}

			$content ? $this->show_success_messages( $content, $data ) : $this->show_error_messages( $content, $data );
		}

		/**
		 * Function to handle the send custom emails functionality.
		 *
		 * @param Array $data - Fetch the data of the users.
		 */
		private function mo_handle_send_emails( $data ) {

			$email_addresses = explode( ';', MoUtility::sanitize_check( 'toEmail', $data ) );
			$content         = null;

			$from_email = isset( $data['fromEmail'] ) ? sanitize_email( wp_unslash( $data['fromEmail'] ) ) : '';
			$from_name  = isset( $data['fromName'] ) ? sanitize_text_field( wp_unslash( $data['fromName'] ) ) : '';
			$subject    = isset( $data['subject'] ) ? sanitize_text_field( wp_unslash( $data['subject'] ) ) : '';
			$message    = isset( $data['content'] ) ? stripslashes( sanitize_text_field( wp_unslash( $data['content'] ) ) ) : '';

			if ( empty( $from_email && $from_name && $subject && $message ) ) {
				return $this->show_error_messages( $data, $content );
			}

			foreach ( $email_addresses as $email ) {
				$content = MoUtility::send_email_notif(
					$from_email,
					$from_name,
					sanitize_email( $email ),
					$subject,
					$message
				);
			}
			$content ? $this->show_success_messages( $content, $data ) : $this->show_error_messages( $content, $data );
		}


		/**
		 * Function to send Custom SMS messages using shortcode
		 */
		public function mo_send_ajax_custom_emails() {
			if ( isset( $_POST[ $this->nonce_key ] ) ) { // phpcs:ignore -- false positive.
				if ( ! check_ajax_referer( $this->nonce, $this->nonce_key ) ) {
					return;
				}
			}
			$data = MoUtility::mo_sanitize_array( $_POST );
			$this->mo_handle_send_emails( $data );
		}

		/**
		 * This function is used to check the status of the API Call and show user
		 * the appropriate error message.        *
		 *
		 * @param string $content - true or false.
		 * @param array  $data - data of the user.
		 */
		private function show_error_messages( $content, $data ) {

			if ( isset( $data['ajax_mode'] ) && $data['ajax_mode'] ) {
				wp_send_json(
					MoUtility::create_json(
						MoMessages::showMessage( MoMessages::CUSTOM_MSG_SENT_FAIL ),
						MoConstants::ERROR_JSON_TYPE
					)
				);
			} else {
				do_action( 'mo_registration_show_message', MoMessages::showMessage( MoMessages::CUSTOM_MSG_SENT_FAIL ), 'ERROR' );
			}

			$parameters   = array(
				'subpage' => 'customMsgSubTab',
			);
			$redirect_url = add_query_arg( $parameters, wp_get_referer() );

			wp_safe_redirect( $redirect_url );
			exit();
		}

		/**
		 * This function is used to check the status of the API call and then
		 * send an appropriate success response.
		 *
		 * @param string $content form content.
		 * @param array  $data - data of the user.
		 */
		private function show_success_messages( $content, $data ) {

			if ( isset( $data['ajax_mode'] ) && $data['ajax_mode'] ) {
				wp_send_json(
					MoUtility::create_json(
						MoMessages::showMessage( MoMessages::CUSTOM_MSG_SENT ),
						MoConstants::SUCCESS_JSON_TYPE
					)
				);
			} else {
				do_action( 'mo_registration_show_message', MoMessages::showMessage( MoMessages::CUSTOM_MSG_SENT ), 'SUCCESS' );
			}

			$parameters   = array(
				'subpage' => 'customMsgSubTab',
			);
			$redirect_url = add_query_arg( $parameters, wp_get_referer() );

			wp_safe_redirect( $redirect_url );
			exit();
		}

		/*
		|-----------------------------------------------------------------------------------------------
		| Getters & Setters
		|-----------------------------------------------------------------------------------------------
		 */

		/** Set a unique for the AddOn */
		public function set_addon_key() {
			$this->add_on_key = 'custom_messages_addon';
		}

		/** Set a AddOn description */
		public function set_add_on_desc() {
			$this->add_on_desc = mo_( 'Send Customized message to any phone or email directly from the dashboard.' );
		}

		/** Set an AddOnName */
		public function set_add_on_name() {
			$this->addon_name = mo_( 'Custom Messages' );
		}

		/** Set an Addon Docs link */
		public function set_add_on_docs() {
			$this->add_on_docs = MoFormDocs::CUSTOM_MESSAGES_ADDON_LINK['guideLink'];
		}

		/** Set an Addon Video link */
		public function set_add_on_video() {
			$this->add_on_video = MoFormDocs::CUSTOM_MESSAGES_ADDON_LINK['videoLink'];
		}

		/** Set Settings Page URL */
		public function set_settings_url() {
			$request_url        = isset( $_SERVER['REQUEST_URI'] ) ? esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ) ) : ''; // phpcs:ignore -- false positive.
			$this->settings_url = add_query_arg( array( 'addon' => 'custom' ), $request_url );
		}
	}
}
