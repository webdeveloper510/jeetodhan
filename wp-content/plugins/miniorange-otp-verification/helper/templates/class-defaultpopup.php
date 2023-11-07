<?php
/**Load adminstrator changes for DefaultPopup
 *
 * @package miniorange-otp-verification/helper/templates
 */

namespace OTP\Helper\Templates;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use OTP\Objects\MoITemplate;
use OTP\Objects\Template;
use OTP\Traits\Instance;

/**
 * This is the Default Popup class. This class handles all the
 * functionality related to Default popup functionality of the plugin. It extends the Template
 * and implements the MoITemplate class to implement some much needed functions.
 */
if ( ! class_exists( 'DefaultPopup' ) ) {
	/**
	 * DefaultPopup class
	 */
	class DefaultPopup extends Template implements MoITemplate {

		use Instance;
		/**
		 * Constructor to declare variables of the class on initialization
		 **/
		protected function __construct() {
			$this->key                = 'DEFAULT';
			$this->template_editor_id = 'customEmailMsgEditor';
			parent::__construct();
		}

		/**
		 * Function to fetch the HTML body of the default pop-up template.
		 *
		 * @return string
		 */
		private function get_default_pop_up_html() {
			$pop_up_template =
			'<html><head><title></title><meta http-equiv="X-UA-Compatible" content="IE=edge"><meta name="viewport" content="width=device-width,initial-scale=1"><link rel="stylesheet" type="text/css" href="{{MO_CSS_URL}}">{{JQUERY}}</head><body><div class="mo-modal-backdrop"><div class="mo_customer_validation-modal" tabindex="-1" role="dialog" id="mo_site_otp_form"><div class="mo_customer_validation-modal-backdrop"></div><div class="mo_customer_validation-modal-dialog mo_customer_validation-modal-md"><div class="login mo_customer_validation-modal-content"><div class="mo_customer_validation-modal-header"><strong>{{HEADER}}</strong><a class="close" href="#" onclick={{GO_BACK_ACTION_CALL}}>{{GO_BACK}}</a></div><div class="mo_customer_validation-modal-body center"><div>{{MESSAGE}}</div><br><div class="mo_customer_validation-login-container"><form id="{{FORM_ID}}" name="f" method="post" action="">{{OTP_STYLE}} {{VALIDATE_BUTTON_OTP}} {{REQUIRED_FIELDS}}<a style="float:right;cursor:pointer" onclick="mo_otp_verification_resend()">{{RESEND_OTP}}</a></form><div id="{{OTP_MESSAGE_BOX}}" hidden style="background-color:#f7f6f7;padding:1em 2em 1em 1.5em;color:#000">{{LOADER_IMG}}</div></div></div></div></div></div></div>{{REQUIRED_FORMS_SCRIPTS}}</body></html>'; // phpcs:ignore WordPress.WP.EnqueuedResources.NonEnqueuedStylesheet --already enqued file.
			return $pop_up_template;
		}

		/**
		 * This function initializes the default HTML of the PopUp Template
		 * to be used by the plugin. This function is called only during
		 * plugin activation or when user resets the templates. In Both
		 * cases the plugin initializes the template to the default value
		 * that the plugin ships with.
		 *
		 * @param string $templates - the template string to be parsed.
		 *
		 * @note: The html content has been minified for public release
		 * @return array
		 */
		public function get_defaults( $templates ) {
			if ( ! is_array( $templates ) ) {
				$templates = array();
			}
			$pop_up_templates_request = $this->get_default_pop_up_html();

			if ( is_wp_error( $pop_up_templates_request ) ) {
				return $templates;
			}
			$templates[ $this->get_template_key() ] = $pop_up_templates_request;
			return $templates;
		}

		/**
		 * This function is used to parse the template and replace the
		 * tags with the appropriate content. Some of the contents are
		 * not shown if the admin/user is just previewing the pop-up.
		 *
		 * @param string $template the HTML Template.
		 * @param string $message the message to be show in the popup.
		 * @param string $otp_type the otp type invoked.
		 * @param string $from_both does user have the option to choose b/w email and sms verification.
		 * @return mixed|string
		 */
		public function parse( $template, $message, $otp_type, $from_both ) {
			$from_both          = $from_both ? 'true' : 'false';
			$required_scripts   = $this->getRequiredFormsSkeleton( $otp_type, $from_both );
			$extra_post_data    = $this->preview ? '' : extra_post_data();
			$extra_form_fields  = $this->getExtraFormFields( $otp_type, $from_both );
			$extra_form_fields .= '<input type="hidden" name="option" value="miniorange-validate-otp-form" />';
			$extra_form_fields .= '<input type="hidden" id="mopopup_wpnonce" name="mopopup_wpnonce" value="' . wp_create_nonce( $this->nonce ) . '"/>';
			$append_input_field = $this->giveInputField();
			$button_html        = $this->addButtonFieldOtp();

			$template = str_replace( '{{JQUERY}}', $this->jquery_url, $template );
			$template = str_replace( '{{FORM_ID}}', 'mo_validate_form', $template );
			$template = str_replace( '{{GO_BACK_ACTION_CALL}}', 'mo_validation_goback();', $template );
			$template = str_replace( '{{OTP_MESSAGE_BOX}}', 'mo_message', $template );
			$template = str_replace( '{{MO_CSS_URL}}', MOV_CSS_URL, $template );
			$template = str_replace( '{{REQUIRED_FORMS_SCRIPTS}}', $required_scripts, $template );
			$template = str_replace( '{{HEADER}}', mo_( 'Validate OTP (One Time Passcode)' ), $template );
			$template = str_replace( '{{GO_BACK}}', mo_( '&larr; Go Back' ), $template );
			$template = str_replace( '{{MESSAGE}}', mo_( $message ), $template );
			$template = str_replace( '{{OTP_STYLE}}', $append_input_field, $template );
			$template = str_replace( '{{OTP_FIELD_NAME}}', 'mo_otp_token', $template );
			$template = str_replace( '{{OTP_FIELD_TITLE}}', mo_( 'Enter Code' ), $template );
			$template = str_replace( '{{VALIDATE_BUTTON_OTP}}', $button_html, $template );
			$template = str_replace( '{{BUTTON_TEXT}}', mo_( 'Validate OTP' ), $template );
			$template = str_replace( '{{REQUIRED_FIELDS}}', $extra_form_fields, $template );
			$template = str_replace( '{{LOADER_IMG}}', $this->img, $template );
			$template = str_replace( '{{EXTRA_POST_DATA}}', $extra_post_data, $template );
			$template = str_replace( '{{RESEND_OTP}}', mo_( 'Resend OTP' ), $template );

			$template = apply_filters( 'mo_add_script', $template );
			return $template;
		}



		/**
		 * This function is used to add button in the popup according the selected popup template.
		 *
		 * @return mixed|string
		 */
		public function addButtonFieldOtp() {
			$otp_length_mo  = get_mo_option( 'otp_length' ) ? get_mo_option( 'otp_length' ) : 6;
			$selected_popup = get_mo_option( 'selected_popup' );
			if ( 'Catchy' === $selected_popup ) {
				$button = ' <input type="button" id="mo_sec_otp_submit_button" class="miniorange_otp_token_submit" value="{{BUTTON_TEXT}}" />';
			} else {
				$button = ' <input type="submit" name="miniorange_otp_token_submit" id="miniorange_otp_token_submit" class="miniorange_otp_token_submit" value="{{BUTTON_TEXT}}" />';
			}
			return $button;
		}

		/**
		 * This function is used to add OTP input field in the popup according the selected popup template.
		 *
		 * @return mixed|string
		 */
		public function giveInputField() {
			$otp_length_mo  = get_mo_option( 'otp_length' ) ? get_mo_option( 'otp_length' ) : 6;
			$selected_popup = get_mo_option( 'selected_popup' );
			$generate_input = $this->manyInputField();
			if ( 'Default' === $selected_popup ) {
				$input = '<input type="text" autocomplete="one-time-code" name="{{OTP_FIELD_NAME}}" autofocus placeholder="" autofocus required class="mo_customer_validation-textbox" title="{{OTP_FIELD_TITLE}}" /><br />';
			} elseif ( 'Streaky' === $selected_popup ) {
				$input = '<style>.otp-streaky-input{display:block;margin:.08em auto;border:none;padding:0;font:4ch droid sans mono,consolas,monospace;letter-spacing:.5ch; width: ' . $otp_length_mo * 1.5 . 'ch ;   background: repeating-linear-gradient(90deg, dimgrey 0 , dimgrey 1.2ch, transparent 0, transparent 1.5ch) 0 100%/ ' . $otp_length_mo * 1.5 . 'ch 2px no-repeat;}input:focus{outline:0;color:#696969} </style>';
				$input = $input . "<input class='otp-streaky-input' autocomplete='one-time-code' maxlength=" . $otp_length_mo . "  type='text' name='{{OTP_FIELD_NAME}}'    title='{{OTP_FIELD_TITLE}}' value=''/><br />";
			} elseif ( 'Catchy' === $selected_popup ) {
				$input = '<style>.otp-catchy{display:flex;float:none;width:30px;height:30px;margin:2px;text-align:center} .otp-catchy-box{display:flex}</style>
             <div style= "width:100%; margin: 0 auto;">
               <div  class="otp-catchy-box" style= "align-items: center; justify-content: center;">
                 <div class="digit-group otp-catchy-box" data-group-name="digits" data-autosubmit="false" autocomplete="off">
                 ' . $generate_input . '
                 </div>
               </div>
             </div>
                  <br>';
			}
			return $input;
		}

		/**
		 * This function is used to generate input field in catchy popup template.
		 *
		 * @return mixed|string
		 */
		public function manyInputField() {
			$otp_length_mo = get_mo_option( 'otp_length' ) ? get_mo_option( 'otp_length' ) : 6;
			$input         = '<input type="text" id="digit-1" class="otp-catchy"  data-next="digit-2" />';
			$prev_field    = $otp_length_mo - 1;
			for ( $i = 2;$i <= $otp_length_mo - 1;$i++ ) {
				$next  = $i + 1;
				$prev  = $i - 1;
				$input = $input . '<input type="text" id="digit-' . $i . '" class="otp-catchy"  data-next="digit-' . $next . '"  data-previous="digit-' . $prev . '" />';

			}
			$input = $input . '<input type="text" id="digit-' . $otp_length_mo . '" class="otp-catchy"  data-previous="digit-' . $prev_field . '" />';
			$input = $input . '<input type="text" autocomplete="one-time-code" hidden id="hidden_input_field" name="{{OTP_FIELD_NAME}}" autofocus placeholder="" autofocus required class="mo_customer_validation-textbox" title="{{OTP_FIELD_TITLE}}" /><br />';
			return $input;
		}

		/**
		 * This function is used to replace the {{REQUIRED_FORMS_SCRIPTS}} in the template
		 * with the appropriate scripts and forms. These forms and scripts are required
		 * for the popup to work.
		 *
		 * @param string $otp_type - the otp type invoked.
		 * @param string $from_both - does user have the option to choose b/w email and sms verification.
		 * @return mixed|string
		 */
		private function getRequiredFormsSkeleton( $otp_type, $from_both ) {
			$required_fields = '<form name="f" method="post" action="" id="validation_goBack_form">
			<input id="validation_goBack" name="option" value="validation_goBack" type="hidden"/>
		</form>
		<form name="f" method="post" action="" id="verification_resend_otp_form">
			<input type="hidden" id="mopopup_wpnonce" name="mopopup_wpnonce" value="' . wp_create_nonce( $this->nonce ) . '"/>
			<input id="verification_resend_otp" name="option" value="verification_resend_otp" type="hidden"/>
			<input name="otp_type" value="' . $otp_type . '" type="hidden"/>
			<input type="hidden" id="from_both" name="from_both" value="' . $from_both . '"/> {{EXTRA_POST_DATA}}
		</form>
		<form name="f" method="post" action="" id="goBack_choice_otp_form">
			<input id="verification_resend_otp" name="option" value="verification_resend_otp_both" type="hidden"/>
			<input type="hidden" id="from_both" name="from_both" value="true">{{EXTRA_POST_DATA}}</form>{{SCRIPTS}}';
			$required_fields = str_replace( '{{SCRIPTS}}', $this->getRequiredScripts(), $required_fields );
			return $required_fields;
		}

		/**
		 * This function is used to replace the {{SCRIPTS}} in the template
		 * with the appropriate scripts. These scripts are required
		 * for the popup to work. Scripts are not added if the form is in
		 * preview mode.
		 */
		private function getRequiredScripts() {
			$otp_length_mo = get_mo_option( 'otp_length' ) ? get_mo_option( 'otp_length' ) : 6;
			$scripts       = '<style>.mo_customer_validation-modal{display:block!important}</style>';
			if ( ! $this->preview ) {
				$scripts .= '<script>function mo_validation_goback(){
				document.getElementById("validation_goBack_form").submit()}function mo_otp_verification_resend(){
					document.getElementById("verification_resend_otp_form").submit()}function mo_select_goback(){
						document.getElementById("goBack_choice_otp_form").submit()}document.addEventListener("DOMContentLoaded", function() {
						var form = document.querySelector("#mo_validate_form");
						form.addEventListener("submit", function() {
						this.style.display = "none";
						document.querySelector("#mo_message").style.display = "block";
						});
							});</script>';
			} else {
				$scripts .= '<script>document.querySelector("#mo_validate_form").addEventListener("submit", function(e) {
					e.preventDefault();
				  });
				  </script>';
			}
			return $scripts;
		}
		/**
		 * This function is used to load the required script for the catchy template.
		 *
		 * @return void
		 */
		public function getCatchyRequiredScripts() {
			$otp_length_mo = get_mo_option( 'otp_length' ) ? get_mo_option( 'otp_length' ) : 6;
			echo '<script>
			document.querySelectorAll(".digit-group input").forEach(function(input) {
				input.setAttribute("maxlength", "1");
				input.addEventListener("keyup", function(e) {
				  var parent = this.parentElement;
				  if (e.keyCode === 8 || e.keyCode === 37) {
					var prev = parent.querySelector("input#" + this.getAttribute("data-previous"));
					if (prev) {
					  prev.select();
					}
				  } else {
					var next = parent.querySelector("input#" + this.getAttribute("data-next"));
					if (next) {
					  next.select();
					}
				  }
				});
			  });
			  var mo_submit_button=document.getElementById("mo_sec_otp_submit_button");
			  if (mo_submit_button){
			  mo_submit_button.onclick = function(){var fieldstring = "";
				for (var i = 1; i <= ' . esc_attr( $otp_length_mo ) . '; i++) {
				  fieldstring += document.querySelector("#digit-" + i).value;
				}
				document.querySelector("#hidden_input_field").value = fieldstring;
				document.querySelector("#mo_validate_form").submit()};}
			</script>';
		}
		/**
		 * This function is used to add the required input fields to the main otp form.
		 *
		 * @param string $otp_type - the otp type invoked.
		 * @param string $from_both - does user have the option to choose b/w email and sms verification.
		 * @return string
		 */
		private function getExtraFormFields( $otp_type, $from_both ) {
			return ' <input type="hidden" name="otp_type" value="' . $otp_type . '">
                 <input type="hidden" id="from_both" name="from_both" value="' . $from_both . '">
                 {{EXTRA_POST_DATA}}';
		}
	}
}
