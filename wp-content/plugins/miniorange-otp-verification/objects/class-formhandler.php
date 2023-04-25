<?php
/**Load Interface FormHandler
 *
 * @package miniorange-otp-verification/objects
 */

namespace OTP\Objects;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
use OTP\Helper\FormList;
use OTP\Helper\FormSessionVars;
use OTP\Helper\MoConstants;
use OTP\Helper\MoMessages;
use OTP\Helper\MoUtility;
use OTP\Helper\SessionUtils;

if ( ! class_exists( 'FormHandler' ) ) {
	/**
	 * Interface class that needs to be extended by each form class.
	 * It defines some of the common actions and functions for each form
	 * class.
	 */
	class FormHandler {

		/**
		 * The phone HTML tag
		 *
		 * @var string
		 */

		protected $type_phone_tag;
		/**
		 * The email HTML tag
		 *
		 * @var string
		 */

		protected $type_email_tag;
		/**
		 * The both HTML tag
		 *
		 * @var string
		 */

		protected $type_both_tag;

		/**
		 * The form key
		 *
		 * @var string
		 */
		protected $form_key;

		/**
		 * The name of the form
		 *
		 * @var string
		 */
		protected $form_name;

		/**
		 * Email or sms verification ( type of otp enabled by admin )
		 *
		 * @var string
		 */
		protected $otp_type;


		/**
		 * The form javascript selector used by the script
		 * file to append country code dropdown
		 *
		 * @var string|array
		 */
		protected $phone_form_id;
		/**
		 * Is form enabled or not
		 *
		 * @var string
		 */

		protected $is_form_enabled;

		/**
		 * Restrict duplicate phone number entries
		 *
		 * @var string
		 */
		protected $restrict_duplicates;

		/**
		 * Option to by pass otp verification for logged in users
		 *
		 * @var string
		 */

		protected $by_pass_login;

		/**
		 * Is the form in question a login or social form
		 *
		 * @var string
		 */

		protected $is_login_or_social_form;
		/**
		 * Is the form an ajax form or not
		 *
		 * @var string
		 */

		protected $is_ajax_form;

		/**
		 * The key value of the phone field
		 *
		 * @var string
		 */
		protected $phone_key;

		/**
		 * The key value of the email field
		 *
		 * @var string
		 */
		protected $email_key;


		/**
		 * Text of the button
		 *
		 * @var string
		 */
		protected $button_text;
		/**
		 * The form details - formid, phonekey / emailkey etc
		 *
		 * @var array
		 */

		protected $form_details;

		/**
		 * Option set by the admin to disable auto activation of users after successful verification
		 *
		 * @var string
		 */

		protected $disable_auto_activate;
		/**
		 * The session variable associated with Form
		 *
		 * @var string
		 */

		protected $form_session_var;

		/**
		 * The session variable associated with WordPress Form
		 *
		 * @var string
		 */
		protected $form_session_var2;

		/**
		 * The nonce key for all forms
		 *
		 * @var string
		 */
		protected $nonce = 'form_nonce';

		/**
		 * The nonce key for the admin actions
		 *
		 * @var string
		 */
		protected $admin_nonce = 'mo_admin_actions';

		/**
		 * The session Id which stores the transaction ids
		 *
		 * @var string
		 */
		protected $tx_session_id = FormSessionVars::TX_SESSION_ID;


		/**
		 * The form options for all forms
		 *
		 * @var string
		 */
		protected $form_option = 'mo_customer_validation_settings';


		/**
		 * The generateOTPAction Key
		 *
		 * @var string
		 */
		protected $generate_otp_action;


		/**
		 * The generateOTPAction Key
		 *
		 * @var string
		 */
		protected $validate_otp_action;

		/**
		 * Nonce key against with the nonce value is passed
		 *
		 * @var string
		 */
		protected $nonce_key = 'security';

		/**
		 * Value that indicates if the form in question is an AddOn Form
		 *
		 * @var bool
		 */
		protected $is_add_on_form = false;

		/**
		 * The form documents array
		 *
		 * @var array
		 */
		protected $form_documents = array();

		const VALIDATED           = 'VALIDATED';
		const VERIFICATION_FAILED = 'verification_failed';
		const VALIDATION_CHECKED  = 'validationChecked';
		/** Constructor */
		protected function __construct() {

			add_action( 'admin_init', array( $this, 'handle_form_options' ), 2 );

			if ( ! $this->is_form_enabled() ) {
				return;
			}

			add_action( 'init', array( $this, 'handle_form' ), 1 );

			add_filter( 'mo_phone_dropdown_selector', array( $this, 'get_phone_number_selector' ), 1, 1 );

			if ( SessionUtils::is_otp_initialized( $this->form_session_var )
			|| SessionUtils::is_otp_initialized( $this->form_session_var2 ) ) {

				add_action( 'otp_verification_successful', array( $this, 'handle_post_verification' ), 1, 7 );

				add_action( 'otp_verification_failed', array( $this, 'handle_failed_verification' ), 1, 4 );

				add_action( 'unset_session_variable', array( $this, 'unset_otp_session_variables' ), 1, 0 );
			}

			add_filter( 'is_ajax_form', array( $this, 'is_ajax_form_in_play' ), 1, 1 );

			add_filter( 'is_login_or_social_form', array( $this, 'is_login_or_social_form' ), 1, 1 );

			$handler_list = FormList::instance();
			$handler_list->add( $this->get_form_key(), $this );
		}
		/**
		 * This function is called by the is_login_or_social_form filter to return
		 * the type of ignore fields to check the POST fields against so that
		 * it can be added as hidden fields to the popup.
		 *
		 * @param string $is_login_or_social_form check if its is social login form.
		 * @return bool
		 */
		public function is_login_or_social_form( $is_login_or_social_form ) {
			return SessionUtils::is_otp_initialized( $this->form_session_var ) ? $this->get_is_login_or_social_form() : $is_login_or_social_form;
		}



		/**
		 * This function is called by the filter is_ajax_form to check
		 * if OTP Verification has started for this form and if it's an
		 * Ajax form. Should return True or False.
		 *
		 * @param bool $is_ajax is ajax form or not.
		 * @return string
		 */
		public function is_ajax_form_in_play( $is_ajax ) {
			return SessionUtils::is_otp_initialized( $this->form_session_var ) ? $this->is_ajax_form : $is_ajax;
		}


		/**
		 * Check the POST output buffer and return the value if a value exists
		 * otherwise return a null or '0'
		 * <br/>Appends {@code mo_customer_validation_} to the key.
		 *
		 * @param string $param - the key to check the post buffer for.
		 * @param string $prefix - prefix to the key if any.
		 * @return bool|String|array
		 */
		public function sanitize_form_post( $param, $prefix = null ) {
			$param = ( null === $prefix ? 'mo_customer_validation_' : '' ) . $param;
			if ( ! current_user_can( 'manage_options' ) || ! check_admin_referer( $this->admin_nonce ) ) {
				return;
			}
			return MoUtility::sanitize_check( $param, $_POST );
		}


		/**
		 * This function is called from every form handler class to start the OTP
		 * Verification process. Keeps certain variables in session and start the
		 * OTP Verification process. Calls the mo_generate_otp hook to start
		 * the OTP Verification process.
		 *
		 * @param string $user_login    username submitted by the user.
		 * @param string $user_email    email submitted by the user.
		 * @param string $errors        error variable ( currently not being used ).
		 * @param string $phone_number  phone number submitted by the user.
		 * @param string $otp_type      email or sms verification.
		 * @param string $password      password submitted by the user.
		 * @param string $extra_data    an array containing all the extra data submitted by the user.
		 * @param bool   $from_both     denotes if user has a choice between email and phone verification.
		 */
		public function send_challenge( $user_login, $user_email, $errors, $phone_number = null, $otp_type = 'email', $password = '', $extra_data = null, $from_both = false ) {
			do_action(
				'mo_generate_otp',
				$user_login,
				$user_email,
				$errors,
				$phone_number,
				$otp_type,
				$password,
				$extra_data,
				$from_both
			);
		}


		/**
		 * This function is called from each form class to validate the otp entered by the
		 * user.
		 *
		 * @param string $otp_type The VerificationType.
		 * @param string $req_var the request variable key which has the value.
		 * @param string $otp_token otp token submitted.
		 */
		public function validate_challenge( $otp_type, $req_var = 'mo_otp_token', $otp_token = null ) {
			do_action( 'mo_validate_otp', $otp_type, $req_var, $otp_token );
		}


		/**
		 * This function check if the admin setting up the form has passed
		 * the basic validation check of setting up the OTP type.
		 *
		 * @param string $message   The Message to be shown in case of an error.
		 * @return bool
		 */
		public function basic_validation_check( $message ) {
			if ( $this->is_form_enabled() && MoUtility::is_blank( $this->otp_type ) ) {
				do_action( 'mo_registration_show_message', MoMessages::showMessage( $message ), MoConstants::ERROR );
				return false;
			}
			return true;
		}

		/**
		 * Checks the otpType currently configured in the settings and returns the appropriate
		 * verification type.
		 * <p></P>
		 * Checks if ajax form and sends back an array or if not an ajax form then simply sends
		 * back a string.
		 *
		 * @return string
		 */
		public function get_verification_type() {
			$map = array(
				$this->type_phone_tag => VerificationType::PHONE,
				$this->type_email_tag => VerificationType::EMAIL,
				$this->type_both_tag  => VerificationType::BOTH,
			);
			return MoUtility::is_blank( $this->otp_type ) ? false : $map[ $this->otp_type ];
		}

		/**
		 * Checks if the request made is a valid ajax request or not.
		 * Only checks the none value for now.
		 */
		protected function validate_ajax_request() {
			if ( ! check_ajax_referer( $this->nonce, $this->nonce_key ) ) {
				wp_send_json(
					MoUtility::create_json(
						MoMessages::showMessage( BaseMessages::INVALID_OP ),
						MoConstants::ERROR_JSON_TYPE
					)
				);
				exit;
			}
		}

		/**Function to process fields
		 *
		 * @return array
		 */
		protected function ajax_processing_fields() {
			$map = array(
				$this->type_phone_tag => array( VerificationType::PHONE ),
				$this->type_email_tag => array( VerificationType::EMAIL ),
				$this->type_both_tag  => array( VerificationType::PHONE, VerificationType::EMAIL ),
			);
			return $map[ $this->otp_type ];
		}

		/**Function for Getter
		 */
		public function get_phone_html_tag() {
			return $this->type_phone_tag; }
		/**Function for Getter
		 */
		public function get_email_html_tag() {
			return $this->type_email_tag; }
		/**Function for Getter
		 */
		public function get_both_html_tag() {
			return $this->type_both_tag; }
		/**Function for Getter
		 */
		public function get_form_key() {
			return $this->form_key; }
		/**Function for Getter
		 */
		public function get_form_name() {
			return $this->form_name; }
		/**Function for Getter
		 */
		public function get_otp_type_enabled() {
			return $this->otp_type; }
		/**Function for Getter
		 */
		public function disable_auto_activation() {
			return $this->disable_auto_activate; }
		/**Function for Getter
		 */
		public function get_phone_key_details() {
			return $this->phone_key; }
		/**Function for Getter
		 */
		public function get_email_key_details() {
			return $this->email_key; }
		/**Function for Getter
		 */
		public function is_form_enabled() {
			return $this->is_form_enabled; }
		/**Function for Getter
		 */
		public function get_button_text() {
			return mo_( $this->button_text ); }
		/**Function for Getter
		 */
		public function get_form_details() {
			return $this->form_details; }
		/**Function for Getter
		 */
		public function restrict_duplicates() {
			return $this->restrict_duplicates; }
		/**Function for Getter
		 */
		public function bypass_for_logged_in_users() {
			return $this->by_pass_login; }
		/**Function for Getter
		 */
		public function get_is_login_or_social_form() {
			return (bool) $this->is_login_or_social_form; }
		/**Function for Getter
		 */
		public function get_form_option() {
			return $this->form_option; }

		/**Function for Getter
		 */
		public function is_ajax_form() {
			return $this->is_ajax_form; }

		/**Function for Getter
		 */
		public function is_add_on_form() {
			return $this->is_add_on_form; }
		/**Function for Getter
		 */
		public function get_form_documents() {
			return $this->form_documents; }
	}
}
