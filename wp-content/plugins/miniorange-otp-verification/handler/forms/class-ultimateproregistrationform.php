<?php
/**
 * Handler Functions for Ultimate Membership Pro Form
 *
 * @package miniorange-otp-verification/handler/forms
 */

namespace OTP\Handler\Forms;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
use OTP\Helper\FormSessionVars;
use OTP\Objects\BaseMessages;
use OTP\Helper\MoMessages;
use OTP\Helper\MoConstants;
use OTP\Helper\MoFormDocs;
use OTP\Helper\MoUtility;
use OTP\Helper\SessionUtils;
use OTP\Objects\FormHandler;
use OTP\Objects\IFormHandler;
use OTP\Objects\VerificationType;
use OTP\Traits\Instance;
use ReflectionException;

/**
 * This is the Ultimate Pro Registration Form class. This class handles all the
 * functionality related to Ultimate Pro Registration Form. It extends the FormHandler
 * and implements the IFormHandler class to implement some much needed functions.
 */
if ( ! class_exists( 'UltimateProRegistrationForm' ) ) {
	/**
	 * UltimateProRegistrationForm class
	 */
	class UltimateProRegistrationForm extends FormHandler implements IFormHandler {

		use Instance;

		/**
		 * Initializes values
		 */
		protected function __construct() {
			$this->is_login_or_social_form = false;
			$this->is_ajax_form            = true;
			$this->form_session_var        = FormSessionVars::ULTIMATE_PRO;
			$this->phone_form_id           = 'input[name=phone]';
			$this->form_key                = 'ULTIMATE_MEM_PRO';
			$this->type_phone_tag          = 'mo_ultipro_phone_enable';
			$this->type_email_tag          = 'mo_ultipro_email_enable';
			$this->form_name               = mo_( 'Ultimate Membership Pro Form' );
			$this->is_form_enabled         = get_mo_option( 'ultipro_enable' );
			$this->form_documents          = MoFormDocs::UM_PRO_LINK;
			parent::__construct();
		}

		/**
		 * Function checks if form has been enabled by the admin and initializes
		 * all the class variables. This function also defines all the hooks to
		 * hook into to make OTP Verification possible.
		 *
		 * @throws ReflectionException Adds exception.
		 */
		public function handle_form() {
			$this->otp_type = get_mo_option( 'ultipro_type' );
			add_action( 'wp_ajax_nopriv_ihc_check_reg_field_ajax', array( $this, 'ultiproHandleSubmit' ), 1 );
			add_action( 'wp_ajax_ihc_check_reg_field_ajax', array( $this, 'ultiproHandleSubmit' ), 1 );

			if ( strcasecmp( $this->otp_type, $this->type_phone_tag ) === 0 ) {
				add_shortcode( 'mo_phone', array( $this, 'phone_shortcode' ) );
			}
			if ( strcasecmp( $this->otp_type, $this->type_email_tag ) === 0 ) {
				add_shortcode( 'mo_email', array( $this, 'email_shortcode' ) );
			}

			$this->routeData();
		}


		/**
		 * * @throws ReflectionException Adds exception.
		 */
		private function routeData() {
			if ( ! array_key_exists( 'option', $_GET ) ) {
				return;
			}
			switch ( trim( sanitize_text_field( wp_unslash( $_GET['option'] ) ) ) ) {
				case 'miniorange-ulti':
					if ( ! check_ajax_referer( $this->nonce, $this->nonce_key ) ) {
						wp_send_json(
							MoUtility::create_json(
								MoMessages::showMessage( BaseMessages::INVALID_OP ),
								MoConstants::ERROR_JSON_TYPE
							)
						);
						exit;
					}
					$this->handle_ulti_form( MoUtility::mo_sanitize_array( $_POST ) );
					break;
			}
		}


		/**
		 * This function hooks into the wp_ajax_nopriv_ihc_check_reg_field_ajax or wp_ajax_ihc_check_reg_field_ajax
		 * hook to validate the form fields being submitted. It's also used to validate the OTP token that was
		 * provided by the user on form submission.
		 */
		public function ultiproHandleSubmit() {
			$field_check_list = array( 'phone', 'user_email', 'validate' );
			$register_msg     = ihc_return_meta_arr( 'register-msg' ); //phpcs:ignore intelephense.diagnostics.undefinedFunctions -- Default function of Ultimate Pro Registration plugin.

			$request = MoUtility::mo_sanitize_array( $_REQUEST ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Nonce verification has been performed.
			if ( isset( $request['type'] ) && isset( $request['value'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Nonce verification has been performed.
				echo esc_attr( ihc_check_value_field( sanitize_text_field( wp_unslash( $request['type'] ) ), sanitize_text_field( wp_unslash( $request['value'] ) ), sanitize_text_field( wp_unslash( $request['second_value'] ) ), $register_msg ) );//phpcs:ignore intelephense.diagnostics.undefinedFunctions -- Default function of Ultimate Pro Registration plugin.
			} elseif ( isset( $request['fields_obj'] ) ) {
				$arr = MoUtility::mo_sanitize_array( wp_unslash( $request['fields_obj'] ) );
				foreach ( $arr as $k => $v ) { //phpcs:ignore -- $data is an array but considered as a string (false positive).
					if ( in_array( $v['type'], $field_check_list, true ) ) {
						$return_arr[] = $this->validate_umpro_submitted_value( $v['type'], $v['value'], $v['second_value'], $register_msg );
					} else {
						$return_arr[] = array(
							'type'  => $v['type'],
							'value' => ihc_check_value_field( //phpcs:ignore intelephense.diagnostics.undefinedFunctions -- Default function of Ultimate Pro Registration plugin.
								$v['type'],
								$v['value'],
								$v['second_value'],
								$register_msg
							),
						);
					}
				}
				echo wp_json_encode( $return_arr );
			}
			die();
		}


		/**
		 * The HTML and script that needs to be added to the page to make the SMS Verification possible
		 */
		public function phone_shortcode() {
			$img  = "<div style='display:table;text-align:center;'><img src='" . MOV_URL . "includes/images/loader.gif'></div>";
			$div  = "<div style='margin-top: 2%;'><button type='button' disabled='disabled' class='button alt' style='width:100%;height:30px;";
			$div .= "font-family: Roboto;font-size: 12px !important;' id='miniorange_otp_token_submit' title='Please Enter an phone to enable this.'>";
			$div .= "Click Here to Verify Phone</button></div><div style='margin-top:2%'><div id='mo_message' hidden='' ";
			$div .= "style='background-color: #f7f6f7;padding: 1em 2em 1em 3.5em;''></div></div>";

			$html  = '<script>jQuery(document).ready(function(){$mo=jQuery; var divElement = "' . $div . '"; ';
			$html .= '$mo("input[name=phone]").change(function(){ if(!$mo(this).val()){ $mo("#miniorange_otp_token_submit").prop("disabled",true);';
			$html .= ' }else{ $mo("#miniorange_otp_token_submit").prop("disabled",false); } });';
			$html .= ' $mo(divElement).insertAfter($mo( "input[name=phone]")); $mo("#miniorange_otp_token_submit").click(function(o){ ';
			$html .= 'var e=$mo("input[name=phone]").val(); $mo("#mo_message").empty(),$mo("#mo_message").append("' . $img . '"),';
			$html .= '$mo("#mo_message").show(),$mo.ajax({url:"' . site_url() . '/?option=miniorange-ulti",type:"POST",';
			$html .= 'data:{security:"' . wp_create_nonce( $this->nonce ) . '", user_phone:e},crossDomain:!0,dataType:"json",success:function(o){ if(o.result=="success"){$mo("#mo_message").empty(),';
			$html .= '$mo("#mo_message").append(o.message),$mo("#mo_message").css("border-top","3px solid green"),';
			$html .= '$mo("input[name=email_verify]").focus()}else{$mo("#mo_message").empty(),$mo("#mo_message").append(o.message),';
			$html .= '$mo("#mo_message").css("border-top","3px solid red"),$mo("input[name=phone_verify]").focus()} ;},';
			$html .= 'error:function(o,e,n){}})});});</script>';
			return $html;
		}


		/**
		 * The HTML and script that needs to be added to the page to make the Email Verification possible
		 */
		public function email_shortcode() {
			$img   = "<div style='display:table;text-align:center;'><img src='" . MOV_URL . "includes/images/loader.gif'></div>";
			$div   = "<div style='margin-top: 2%;'><button type='button' disabled='disabled' class='button alt' ";
			$div  .= "style='width:100%;height:30px;font-family: Roboto;font-size: 12px !important;' id='miniorange_otp_token_submit' ";
			$div  .= "title='Please Enter an email to enable this.'>Click Here to Verify your email</button></div><div style='margin-top:2%'>";
			$div  .= "<div id='mo_message' hidden='' style='background-color: #f7f6f7;padding: 1em 2em 1em 3.5em;''></div></div>";
			$html  = '<script>jQuery(document).ready(function(){$mo=jQuery; var divElement = "' . $div . '"; ';
			$html .= '$mo("input[name=user_email]").change(function(){ if(!$mo(this).val()){ ';
			$html .= '$mo("#miniorange_otp_token_submit").prop("disabled",true); }else{ ';
			$html .= '$mo("#miniorange_otp_token_submit").prop("disabled",false); } }); ';
			$html .= '$mo(divElement).insertAfter($mo( "input[name=user_email]")); $mo("#miniorange_otp_token_submit").click(function(o){ ';
			$html .= 'var e=$mo("input[name=user_email]").val(); $mo("#mo_message").empty(),$mo("#mo_message").append("' . $img . '"),';
			$html .= '$mo("#mo_message").show(),$mo.ajax({url:"' . site_url() . '/?option=miniorange-ulti",type:"POST",data:{security:"' . wp_create_nonce( $this->nonce ) . '", user_email:e},crossDomain:!0,dataType:"json",success:function(o){ if(o.result=="success"){$mo("#mo_message").empty(),$mo("#mo_message").append(o.message),$mo("#mo_message").css("border-top","3px solid green"),$mo("input[name=email_verify]").focus()}else{$mo("#mo_message").empty(),$mo("#mo_message").append(o.message),$mo("#mo_message").css("border-top","3px solid red"),$mo("input[name=phone_verify]").focus()} ;},error:function(o,e,n){}})});});</script>';
			return $html;
		}


		/**
		 * Function to handle Form
		 *
		 * @param array $data - an array containing the user's phone or email to send OTP to.
		 * @throws ReflectionException Adds exception.
		 */
		private function handle_ulti_form( $data ) {

			MoUtility::initialize_transaction( $this->form_session_var );

			if ( strcasecmp( $this->otp_type, $this->type_phone_tag ) === 0 ) {
				SessionUtils::add_phone_verified( $this->form_session_var, $data['user_phone'] );
				$this->send_challenge( '', null, null, $data['user_phone'], VerificationType::PHONE );
			} else {
				SessionUtils::add_email_verified( $this->form_session_var, $data['user_email'] );
				$this->send_challenge( '', $data['user_email'], null, null, VerificationType::EMAIL );
			}
		}


		/**
		 * This function is called to validate each of the phone, user_email or validation
		 * field. Validation field has the OTP which needs to be verified and make sure that
		 * the phone or email that's being submitted is the phone or email that the otp was sent to.
		 *
		 * @param string $type - the field type.
		 * @param string $value - the value of the field.
		 * @param string $second_value - the second_value variable provided by ultimate pro.
		 * @param string $register_msg - the default registration message by the Ultimate pro.
		 * @return array
		 */
		private function validate_umpro_submitted_value( $type, $value, $second_value, $register_msg ) {

			$return = array();
			switch ( $type ) {
				case 'phone':
					$this->processPhone( $return, $type, $value, $second_value, $register_msg );
					break;
				case 'user_email':
					$this->processEmail( $return, $type, $value, $second_value, $register_msg );
					break;
				case 'validate':
					$this->processOTPEntered( $return, $type, $value, $second_value, $register_msg );
					break;
			}
			return $return;
		}


		/**
		 * Process the phone submitted by the user and make sure it's the same phone
		 * number that the OTP was sent to for verification. If not then throw an error.
		 *
		 * @param array  $return       - the array describing the field and if any error has occurred during validation.
		 * @param string $type         - the field type.
		 * @param string $value        - the value of the field.
		 * @param string $second_value - the second_value variable provided by ultimate pro.
		 * @param string $register_msg - the default registration message by the Ultimate pro.
		 */
		private function processPhone( &$return, $type, $value, $second_value, $register_msg ) {
			if ( strcasecmp( $this->otp_type, $this->type_phone_tag ) !== 0 ) {
				$return = array(
					'type'  => $type,
					'value' => ihc_check_value_field( $type, $value, $second_value, $register_msg ), //phpcs:ignore intelephense.diagnostics.undefinedFunctions -- Default function of Ultimate Pro Registration plugin.
				);
			} elseif ( ! SessionUtils::is_otp_initialized( $this->form_session_var ) ) {
				$return = array(
					'type'  => $type,
					'value' => MoMessages::showMessage( MoMessages::PLEASE_VALIDATE ),
				);
			} elseif ( ! SessionUtils::is_phone_verified_match( $this->form_session_var, $value ) ) {
				$return = array(
					'type'  => $type,
					'value' => MoMessages::showMessage( MoMessages::PHONE_MISMATCH ),
				);
			} else {
				$return = array(
					'type'  => $type,
					'value' => ihc_check_value_field( $type, $value, $second_value, $register_msg ), //phpcs:ignore intelephense.diagnostics.undefinedFunctions -- Default function of Ultimate Pro Registration plugin.
				);
			}
		}


		/**
		 * Process the email address submitted by the user and make sure it's the same email
		 * address that the OTP was sent to for verification. If not then throw an error.
		 *
		 * @param array  $return       - the array describing the field and if any error has occurred during validation.
		 * @param string $type         - the field type.
		 * @param string $value        - the value of the field.
		 * @param string $second_value - the second_value variable provided by ultimate pro.
		 * @param string $register_msg - the default registration message by the Ultimate pro.
		 */
		private function processEmail( &$return, $type, $value, $second_value, $register_msg ) {
			if ( strcasecmp( $this->otp_type, $this->type_email_tag ) !== 0 ) {
				$return = array(
					'type'  => $type,
					'value' => ihc_check_value_field( $type, $value, $second_value, $register_msg ), //phpcs:ignore intelephense.diagnostics.undefinedFunctions -- Default function of Ultimate Pro Registration plugin.
				);
			} elseif ( ! SessionUtils::is_otp_initialized( $this->form_session_var ) ) {
				$return = array(
					'type'  => $type,
					'value' => MoMessages::showMessage( MoMessages::PLEASE_VALIDATE ),
				);
			} elseif ( ! SessionUtils::is_email_verified_match( $this->form_session_var, $value ) ) {
				$return = array(
					'type'  => $type,
					'value' => MoMessages::showMessage( MoMessages::EMAIL_MISMATCH ),
				);
			} else {
				$return = array(
					'type'  => $type,
					'value' => ihc_check_value_field( $type, $value, $second_value, $register_msg ), //phpcs:ignore intelephense.diagnostics.undefinedFunctions -- Default function of Ultimate Pro Registration plugin.
				);
			}
		}


		/**
		 * Process the OTP submitted by the user and make sure it's the valid OTP.
		 * If not then throw an error. If verification process was not started
		 * then throw an error as well.
		 *
		 * @param array  $return       - the array describing the field and if any error has occurred during validation.
		 * @param string $type         - the field type.
		 * @param string $value        - the value of the field.
		 * @param string $second_value - the second_value variable provided by ultimate pro.
		 * @param string $register_msg - the default registration message by the Ultimate pro.
		 */
		private function processOTPEntered( &$return, $type, $value, $second_value, $register_msg ) {
			if ( ! SessionUtils::is_otp_initialized( $this->form_session_var ) ) {
				$return = array(
					'type'  => $type,
					'value' => MoMessages::showMessage( MoMessages::PLEASE_VALIDATE ),
				);
			} else {
				$this->validateAndProcessOTP( $return, $type, $value );
			}
		}


		/**
		 * Process and validate the OTP entered by the user
		 *
		 * @param array  $return - the array describing the field and if any error has occurred during validation.
		 * @param string $type - the field type.
		 * @param string $otp_token - OTP token entered by user.
		 */
		private function validateAndProcessOTP( &$return, $type, $otp_token ) {
			$otp_ver_type = $this->get_verification_type();
			$this->validate_challenge( $otp_ver_type, null, $otp_token );
			if ( ! SessionUtils::is_status_match( $this->form_session_var, self::VALIDATED, $otp_ver_type ) ) {
				$return = array(
					'type'  => $type,
					'value' => MoUtility::get_invalid_otp_method(),
				);
			} else {
				$this->unset_otp_session_variables();
				$return = array(
					'type'  => $type,
					'value' => 1,
				);
			}
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

			SessionUtils::add_status( $this->form_session_var, self::VERIFICATION_FAILED, $otp_type );
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

			SessionUtils::add_status( $this->form_session_var, self::VALIDATED, $otp_type );
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
		 * @return array
		 */
		public function get_phone_number_selector( $selector ) {

			if ( $this->is_form_enabled() && $this->otp_type === $this->type_phone_tag ) {
				array_push( $selector, $this->phone_form_id );
			}
			return $selector;
		}


		/**
		 * Handles saving all the Ultimate Pro Registration Form related options by the admin.
		 */
		public function handle_form_options() {
			if ( ! MoUtility::are_form_options_being_saved( $this->get_form_option() ) ) {
				return;
			}

			$this->is_form_enabled = $this->sanitize_form_post( 'ultipro_enable' );
			$this->otp_type        = $this->sanitize_form_post( 'ultipro_type' );
			update_mo_option( 'ultipro_enable', $this->is_form_enabled );
			update_mo_option( 'ultipro_type', $this->otp_type );
		}
	}
}
