<?php
/**
 * Handles the OTP verification logic for UltimateMemberRegistrationForm form.
 *
 * @package miniorange-otp-verification/handler
 */

namespace OTP\Handler\Forms;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
use OTP\Helper\FormSessionVars;
use OTP\Helper\MoConstants;
use OTP\Helper\MoMessages;
use OTP\Helper\MoFormDocs;
use OTP\Helper\MoUtility;
use OTP\Helper\SessionUtils;
use OTP\Objects\BaseMessages;
use OTP\Objects\FormHandler;
use OTP\Objects\IFormHandler;
use OTP\Objects\VerificationLogic;
use OTP\Objects\VerificationType;
use OTP\Traits\Instance;
use ReflectionException;
use um\core\Form;
use WP_Error;

/**
 * This is the Ultimate Member Registration Form class. This class handles all the
 * functionality related to Ultimate Member Registration Form. It extends the FormHandler
 * and implements the IFormHandler class to implement some much needed functions.
 */
if ( ! class_exists( 'UltimateMemberRegistrationForm' ) ) {
	/**
	 * UltimateMemberRegistrationForm class
	 */
	class UltimateMemberRegistrationForm extends FormHandler implements IFormHandler {

		use Instance;
		/**
		 * Initializes values
		 */
		protected function __construct() {
			$this->is_login_or_social_form = false;
			$this->is_ajax_form            = get_mo_option( 'um_is_ajax_form' );
			$this->form_session_var        = FormSessionVars::UM_DEFAULT_REG;
			$this->type_phone_tag          = 'mo_um_phone_enable';
			$this->type_email_tag          = 'mo_um_email_enable';
			$this->type_both_tag           = 'mo_um_both_enable';
			$this->phone_key               = get_mo_option( 'um_phone_key' );
			$this->phone_key               = $this->phone_key ? $this->phone_key : 'mobile_number';
			$this->phone_form_id           = "input[name^='" . $this->phone_key . "']";
			$this->form_key                = 'ULTIMATE_FORM';
			$this->form_name               = mo_( 'Ultimate Member Registration Form' );
			$this->is_form_enabled         = get_mo_option( 'um_default_enable' );
			$this->restrict_duplicates     = get_mo_option( 'um_restrict_duplicates' );
			$this->button_text             = get_mo_option( 'um_button_text' );
			$this->button_text             = ! MoUtility::is_blank( $this->button_text ) ? $this->button_text : mo_( 'Click Here to send OTP' );
			$this->form_key                = get_mo_option( 'um_verify_meta_key' );
			$this->form_documents          = MoFormDocs::UM_ENABLED;
			parent::__construct();
		}

		/**
		 * Function checks if form has been enabled by the admin and initializes
		 * all the class variables. This function also defines all the hooks to
		 * hook into to make OTP Verification possible.
		 *
		 * @throws ReflectionException .
		 */
		public function handle_form() {
			$this->otp_type = get_mo_option( 'um_enable_type' );
			if ( $this->isUltimateMemberV2Installed() ) {
				add_action( 'um_submit_form_errors_hook__registration', array( $this, 'miniorange_um2_phone_validation' ), 99, 1 );
				add_filter( 'um_registration_user_role', array( $this, 'miniorange_um2_user_registration' ), 99, 2 );
			} else {
				add_action( 'um_submit_form_errors_hook_', array( $this, 'miniorange_um_phone_validation' ), 99, 1 );
				add_action( 'um_before_new_user_register', array( $this, 'miniorange_um_user_registration' ), 99, 1 );
			}
			if ( $this->is_ajax_form && $this->otp_type !== $this->type_both_tag ) {
				add_action( 'wp_enqueue_scripts', array( $this, 'miniorange_register_um_script' ) );
				$this->routeData();
			}
		}

		/**
		 * Checks if the plugin is installed or not. Returns true or false.
		 *
		 * @return boolean
		 */
		private function isUltimateMemberV2Installed() {
			if ( ! function_exists( 'is_plugin_active' ) ) {
				include_once ABSPATH . 'wp-admin/includes/plugin.php';
			}
			return is_plugin_active( 'ultimate-member/ultimate-member.php' );
		}

		/**
		 * Checks the option set in GET request and starts OTP verification flow.
		 *
		 * @throws ReflectionException .
		 */
		private function routeData() {

			if ( ! array_key_exists( 'mo_umreg_option', $_GET ) ) {
				return;
			}
			if ( ! check_ajax_referer( $this->nonce, 'security', false ) ) {
				wp_send_json( MoUtility::create_json( MoMessages::showMessage( MoMessages::UNKNOWN_ERROR ), MoConstants::ERROR_JSON_TYPE ) );
			}

			$data                  = MoUtility::mo_sanitize_array( $_POST );
			$send_otp_check_option = isset( $_GET['mo_umreg_option'] ) ? sanitize_text_field( wp_unslash( $_GET['mo_umreg_option'] ) ) : '';
			switch ( trim( $send_otp_check_option ) ) {
				case 'miniorange-um-ajax-verify':
					$this->sendAjaxOTPRequest( $data );
					break;
			}
		}


		/**
		 * This function handles the send ajax otp request. Initializes the session,
		 * checks to see if phone or email transaction have been enabled and sends
		 * OTP to the appropriate delivery point.
		 *
		 * @param array $data -the post data on send OTP request.
		 */
		private function sendAjaxOTPRequest( $data ) {
			MoUtility::initialize_transaction( $this->form_session_var );
			$mobile_number = MoUtility::sanitize_check( 'user_phone', $data );
			$user_email    = MoUtility::sanitize_check( 'user_email', $data );
			if ( $this->otp_type === $this->type_phone_tag ) {
				$this->checkDuplicates( $mobile_number, $this->phone_key, null );
				SessionUtils::add_phone_verified( $this->form_session_var, $mobile_number );
			} else {
				SessionUtils::add_email_verified( $this->form_session_var, $user_email );
			}
			$this->startOtpTransaction( null, $user_email, null, $mobile_number, null, null );
		}


		/**
		 * This function registers the js file for enabling OTP Verification
		 * for Ultimate Member using AJAX calls.
		 */
		public function miniorange_register_um_script() {
			wp_register_script( 'movum', MOV_URL . 'includes/js/umreg.min.js', array( 'jquery' ), MOV_VERSION, true );
			wp_localize_script(
				'movum',
				'moumvar',
				array(
					'siteURL'    => site_url(),
					'otpType'    => $this->otp_type,
					'nonce'      => wp_create_nonce( $this->nonce ),
					'buttontext' => mo_( $this->button_text ),
					'field'      => $this->otp_type === $this->type_phone_tag ? $this->phone_key : 'user_email',
					'imgURL'     => MOV_LOADER_URL,
				)
			);
			wp_enqueue_script( 'movum' );
		}


		/**
		 * This is a utility function specific to this class which checks if
		 * SMS Verification has been enabled by the admin for Ultimate Member
		 * Registration form.
		 */
		private function isPhoneVerificationEnabled() {
			$otpver_type = $this->get_verification_type();
			return VerificationType::PHONE === $otpver_type || VerificationType::BOTH === $otpver_type;
		}


		/**
		 * The function hooks into the um_registration_user_role filter to process
		 * the data submitted by the user and start the OTP Verification process.
		 * We are calling the filter here because this the last hook that the plugin can
		 * hook into after all the userdata has been processed by Ultimate Member
		 *
		 * @param string $user_role - user role passed by the filter.
		 * @param array  $args - passed by the hook containing keys value pair of field and value submitted by user.
		 * @return array mixed
		 * @throws ReflectionException .
		 */
		public function miniorange_um2_user_registration( $user_role, $args ) {

			$otpver_type = $this->get_verification_type();
			if ( SessionUtils::is_status_match( $this->form_session_var, self::VALIDATED, $otpver_type ) ) {
				$this->unset_otp_session_variables();
				return $user_role;
			} elseif ( ! SessionUtils::is_otp_initialized( $this->form_session_var ) && $this->is_ajax_form ) {
				wp_send_json(
					MoUtility::create_json(
						MoMessages::showMessage( MoMessages::PLEASE_VALIDATE ),
						MoConstants::ERROR_JSON_TYPE
					)
				);
			} else {
				MoUtility::initialize_transaction( $this->form_session_var );
				$args = $this->extractArgs( $args );
				$this->startOtpTransaction(
					$args['user_login'],
					$args['user_email'],
					new WP_Error(),
					$args[ $this->phone_key ],
					$args['user_password'],
					null
				);
			}
			return $user_role;
		}

		/**
		 * Extracts required data out of the arguments passed in the hook and returns an array.
		 * This is used instead of extract as extract doesn't work properly when we obfuscate
		 * the plugin.
		 *
		 * @param array $args - passed by the hook containing keys value pair of field and value submitted by user.
		 * @return array
		 */
		private function extractArgs( $args ) {
			return array(
				'user_login'     => $args['user_login'],
				'user_email'     => $args['user_email'],
				$this->phone_key => $args[ $this->phone_key ],
				'user_password'  => $args['user_password'],
			);
		}

		/**
		 * This function hooks in to the um_before_new_user_register hook for the
		 * older versions of Ultimate Members to initiate the OTP Verification
		 * step.
		 *
		 * @param array $args - passed by the hook containing keys value pair of field and value submitted by user.
		 * @throws ReflectionException .
		 */
		public function miniorange_um_user_registration( $args ) {

			$errors = new WP_Error();
			MoUtility::initialize_transaction( $this->form_session_var );
			foreach ( $args as $key => $value ) {
				if ( 'user_login' === $key ) {
					$username = $value;
				} elseif ( 'user_email' === $key ) {
					$email = $value;
				} elseif ( 'user_password' === $key ) {
					$password = $value;
				} elseif ( $key === $this->phone_key ) {
					$phone_number = $value;
				} else {
					$extra_data[ $key ] = $value;
				}
			}
			$this->startOtpTransaction( $username, $email, $errors, $phone_number, $password, $extra_data );
		}


		/**
		 * The function is called to start the OTP Transaction based on the OTP Type
		 * set by the admin in the settings.
		 *
		 * @param string $username     - the username passed by the registration_errors hook.
		 * @param string $email        - the email passed by the registration_errors hook.
		 * @param string $errors       - the errors variable passed by the registration_errors hook.
		 * @param string $phone_number - the phone number posted by the user during registration.
		 * @param string $password     - the password submitted by the user during registration.
		 * @param array  $extra_data   - the extra data submitted by the user during registration.
		 */
		private function startOtpTransaction( $username, $email, $errors, $phone_number, $password, $extra_data ) {
			if ( strcasecmp( $this->otp_type, $this->type_phone_tag ) === 0 ) {
				$this->send_challenge( $username, $email, $errors, $phone_number, VerificationType::PHONE, $password, $extra_data );
			} elseif ( strcasecmp( $this->otp_type, $this->type_both_tag ) === 0 ) {
				$this->send_challenge( $username, $email, $errors, $phone_number, VerificationType::BOTH, $password, $extra_data );
			} else {
				$this->send_challenge( $username, $email, $errors, $phone_number, VerificationType::EMAIL, $password, $extra_data );
			}
		}


		/**
		 * This function hooks into um_submit_form_errors_hook__registration hook to validate the
		 * phone number being entered so that an error message can be shown to the user
		 * if it is invalid before starting the OTP Verification process.
		 * <br/><br/>
		 *
		 * @param array $args passed by the hook which contains key value pair of form submitted value.
		 */
		public function miniorange_um2_phone_validation( $args ) {

			$form = UM()->form();
			foreach ( $args as $key => $value ) {
				if ( $this->is_ajax_form && $key === $this->form_key ) {
					$this->checkIntegrityAndValidateOTP( $form, $value, $args );
				} elseif ( $key === $this->phone_key ) {
					$this->process_phone_numbers( $value, $key, $form );
				}
			}
		}

		/**
		 * Process the phone number to check it's a valid number and ensure it's
		 * not a duplicate phone number in the system if admin set the option
		 * to do so.
		 *
		 * @param string $value - the phone number for phone number validation checks.
		 * @param String $key - meta_key for phone number.
		 * @param Form   $form - object of the Ultimate member form.
		 */
		private function process_phone_numbers( $value, $key, $form = null ) {

			global $phone_logic;
			if ( ! MoUtility::validate_phone_number( $value ) ) {
				$message = str_replace( '##phone##', $value, $phone_logic->get_otp_invalid_format_message() );
				$form->add_error( $key, $message );
			}
			$this->checkDuplicates( $value, $key, $form );
		}


		/**
		 * Check if admin has set the option where each user needs to have a unique
		 * phone number. If the option is set then make sure the phone number entered
		 * by the user is unique.
		 *
		 * @param string $value - the phone number for phone number validation checks.
		 * @param String $key - meta_key for phone number.
		 * @param Form   $form - object of the Ultimate member form.
		 */
		private function checkDuplicates( $value, $key, $form = null ) {
			if ( $this->restrict_duplicates && $this->isPhoneNumberAlreadyInUse( $value, $key ) ) {
				$message = MoMessages::showMessage( MoMessages::PHONE_EXISTS );
				if ( $this->is_ajax_form && SessionUtils::is_otp_initialized( $this->form_session_var ) ) {
					wp_send_json( MoUtility::create_json( $message, MoConstants::ERROR_JSON_TYPE ) );
				} else {
					$form->add_error( $key, $message );
				}
			}
		}

		/**
		 * Check Integrity of the email or phone number. i.e. Ensure that the Email or
		 * Phone that the OTP was sent to is the same Email or Phone that is being submitted
		 * with the form.
		 * <br/<br/>
		 * Once integrity check passes validate the OTP to ensure that the user has entered
		 * the correct OTP.
		 *
		 * @param Form   $form - object of the Ultimate member form.
		 * @param String $value - the phone number for phone number validation checks.
		 * @param array  $args - passed by the hook which contains key value pair of form submitted value.
		 */
		private function checkIntegrityAndValidateOTP( $form, $value, array $args ) {

			$otpver_type = $this->get_verification_type();
			if ( ! SessionUtils::is_otp_initialized( $this->form_session_var ) ) {
				$form->add_error( $this->form_key, MoMessages::showMessage( MoMessages::ENTER_VERIFY_CODE ) );
				return;
			}
			$this->checkIntegrity( $form, $args, $otpver_type );
			$this->validate_challenge( $otpver_type, null, $value );
			if ( ! SessionUtils::is_status_match( $this->form_session_var, self::VALIDATED, $otpver_type ) ) {
				$form->add_error( $this->form_key, MoUtility::get_invalid_otp_method() );
			}
		}


		/**
		 * This function checks the integrity of the phone or email value that was submitted
		 * with the form. It needs to match with the email or value that the OTP was
		 * initially sent to.
		 *
		 * @param Form   $um_form - object of the Ultimate member form.
		 * @param array  $args - passed by the hook which contains key value pair of form submitted value.
		 * @param string $otpver_type - otp verification type.
		 */
		private function checkIntegrity( $um_form, array $args, $otpver_type ) {
			if ( strcasecmp( $this->otp_type, $this->type_phone_tag ) === 0 ) {
				if ( ! SessionUtils::is_phone_verified_match( $this->form_session_var, $args[ $this->phone_key ] ) ) {
					$um_form->add_error( $this->form_key, MoMessages::showMessage( MoMessages::PHONE_MISMATCH ) );
				}
			} elseif ( strcasecmp( $this->otp_type, $this->type_email_tag ) === 0 ) {
				if ( ! SessionUtils::is_email_verified_match( $this->form_session_var, $args['user_email'] ) ) {
					$um_form->add_error( $this->form_key, MoMessages::showMessage( MoMessages::EMAIL_MISMATCH ) );
				}
			}
		}


		/**
		 * This function hooks into um_submit_form_errors_hook_ hook to validate the
		 * phone number being entered so that an error message can be shown to the user
		 * if it is invalid before starting the OTP Verification process.
		 *
		 * @param array $args - passed by the hook which contains key value pair of form submitted value.
		 */
		public function miniorange_um_phone_validation( $args ) {
			global $ultimatemember;
			foreach ( $args as $key => $value ) {
				if ( $this->is_ajax_form && $key === $this->form_key ) {
					$this->checkIntegrityAndValidateOTP( $ultimatemember->form, $value, $args );
				} elseif ( $key === $this->phone_key ) {
					$this->process_phone_numbers( $value, $key, $ultimatemember->form );
				}
			}
		}

		/**
		 * Checks if the phone number is already in use by another user on the site.
		 * Returns true or false based on the data fetched.
		 *
		 * @param string $phone - phone number.
		 * @param string $key - meta key for the Ultimate Member Registration form.
		 * @return bool
		 */
		private function isPhoneNumberAlreadyInUse( $phone, $key ) {
			global $wpdb;
			MoUtility::process_phone_number( $phone );
			$results = $wpdb->get_row( $wpdb->prepare( "SELECT `user_id` FROM `{$wpdb->prefix}usermeta` WHERE `meta_key` = %s AND `meta_value` =  %s", array( $key, $phone ) ) ); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.NoCaching, WordPress.DB.DirectDatabaseQuery.DirectQuery, Direct database call without caching detected -- DB Direct Query is necessary here.
			return ! MoUtility::is_blank( $results );
		}


		/**
		 * This function hooks into the otp_verification_failed hook. This function
		 * details what is done if the OTP verification fails.
		 *
		 * @param string $user_login the username posted by the user.
		 * @param string $user_email the email posted by the user.
		 * @param string $phone_number the phone number posted by the user.
		 * @param string $otp_type the verification type.
		 */
		public function handle_failed_verification( $user_login, $user_email, $phone_number, $otp_type ) {

			if ( ! SessionUtils::is_otp_initialized( $this->form_session_var ) ) {
				return;
			}
			$otpver_type = $this->get_verification_type();
			$from_both   = VerificationType::BOTH === $otpver_type ? true : false;
			if ( ! $this->is_ajax_form ) {
				miniorange_site_otp_validation_form(
					$user_login,
					$user_email,
					$phone_number,
					MoUtility::get_invalid_otp_method(),
					$otpver_type,
					$from_both
				);
			}
		}


		/**
		 * This function hooks into the otp_verification_successful hook. This function is
		 * details what needs to be done if OTP Verification is successful.
		 *
		 * @param string $redirect_to the redirect to URL after new user registration.
		 * @param string $user_login the username posted by the user.
		 * @param string $user_email the email posted by the user.
		 * @param string $password the password posted by the user.
		 * @param string $phone_number the phone number posted by the user.
		 * @param string $extra_data any extra data posted by the user.
		 * @param string $otp_type the verification type.
		 */
		public function handle_post_verification( $redirect_to, $user_login, $user_email, $password, $phone_number, $extra_data, $otp_type ) {

			if ( ! function_exists( 'is_plugin_active' ) ) {
				include_once ABSPATH . 'wp-admin/includes/plugin.php';
			}
			if ( $this->isUltimateMemberV2Installed() ) {
				SessionUtils::add_status( $this->form_session_var, self::VALIDATED, $otp_type );
			} else {
				$this->register_ultimateMember_user( $user_login, $user_email, $password, $phone_number, $extra_data );
			}
		}


		/**
		 * Register a Ultimate Member user. This function should only be called for the
		 * older version of Ultimate Member.
		 *
		 * @param string $user_login - username of the user to be registered.
		 * @param string $user_email - email of the user to be registered.
		 * @param string $password - password of the user to be registered.
		 * @param string $phone_number - phone_number of the user to be registered.
		 * @param string $extra_data - any extra data posted by the user.
		 */
		public function register_ultimateMember_user( $user_login, $user_email, $password, $phone_number, $extra_data ) {
			$args                  = array();
			$args['user_login']    = $user_login;
			$args['user_email']    = $user_email;
			$args['user_password'] = $password;
			$args                  = array_merge( $args, $extra_data );
			$user_id               = wp_create_user( $user_login, $password, $user_email );
			$this->unset_otp_session_variables();
			do_action( 'um_after_new_user_register', $user_id, $args );
		}


		/**
		 * Unset all the session variables so that a new form submission starts
		 * a fresh process of OTP verification.
		 */
		public function unset_otp_session_variables() {
			SessionUtils::unset_session( array( $this->tx_session_id, $this->form_session_var ) );
		}


		/**
		 * This function is called by the filter mo_phone_dropdown_selector
		 * to return the Jquery selector of the phone field. The function will
		 * push the formID to the selector array if OTP Verification for the
		 * form has been enabled.
		 *
		 * @param array $selector - the Jquery selector to be modified.
		 * @return array $selector - the Jquery selector to be modified.
		 */
		public function get_phone_number_selector( $selector ) {

			if ( $this->is_form_enabled() && $this->isPhoneVerificationEnabled() ) {
				array_push( $selector, $this->phone_form_id );
			}
			return $selector;
		}


		/**
		 * Handles saving all the Ultimate Member Registration Form related options by the admin.
		 */
		public function handle_form_options() {
			if ( ! MoUtility::are_form_options_being_saved( $this->get_form_option() ) ) {
				return;
			}

			$this->is_form_enabled     = $this->sanitize_form_post( 'um_default_enable' );
			$this->otp_type            = $this->sanitize_form_post( 'um_enable_type' );
			$this->restrict_duplicates = $this->sanitize_form_post( 'um_restrict_duplicates' );

			$this->is_ajax_form = $this->sanitize_form_post( 'um_is_ajax_form' );
			$this->button_text  = $this->sanitize_form_post( 'um_button_text' );
			$this->form_key     = $this->sanitize_form_post( 'um_verify_meta_key' );
			$this->phone_key    = $this->sanitize_form_post( 'um_phone_key' );

			if ( $this->basic_validation_check( BaseMessages::UM_CHOOSE ) ) {
				update_mo_option( 'um_phone_key', $this->phone_key );
				update_mo_option( 'um_default_enable', $this->is_form_enabled );
				update_mo_option( 'um_enable_type', $this->otp_type );
				update_mo_option( 'um_restrict_duplicates', $this->restrict_duplicates );
				update_mo_option( 'um_is_ajax_form', $this->is_ajax_form );
				update_mo_option( 'um_button_text', $this->button_text );
				update_mo_option( 'um_verify_meta_key', $this->form_key );
			}
		}
	}
}

