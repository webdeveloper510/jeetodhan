<?php
/**Load adminstrator changes for Miniorange Gateway
 *
 * @package miniorange-otp-verification/helper
 */

namespace OTP\Helper;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use OTP\Notifications\CustomMessage\MiniOrangeCustomMessage;
use OTP\Addons\PasswordResetwc\WooCommercePasswordReset;
use OTP\Notifications\UmSMSNotification\UltimateMemberSmsNotification;
use OTP\Notifications\WcSMSNotification\WooCommerceSmsNotification;
use OTP\Notifications\DokanNotif;
use OTP\Notifications\WcfmSmsNotification\WCFMSmsNotification;
use OTP\Addons\WpSMSNotification\WordPressSmsNotification;
use OTP\Addons\CountryCode\SelectedCountryCode;
use OTP\Addons\regwithphone\RegisterWithPhoneOnly;
use OTP\Addons\PasscodeOverCalltwilio\VerifyOverCallAddon;
use OTP\Addons\passwordresetwp\WordPressPasswordReset;
use OTP\Addons\ipbasedropdown\EnableIpBaseCountryCode;
use OTP\Addons\APIVerification\APIAddon;
use OTP\Addons\ResendControl\MiniOrangeResendControl;
use OTP\Addons\MoBulkSMS\MoBulkSMSInit;
use OTP\Addons\CountryCodeDropdown\CountryCodeDropdownInit;
use OTP\Addons\WcSelectedCategory\WcSelectedCategory;
use OTP\Objects\IGatewayFunctions;
use OTP\Objects\VerificationType;
use OTP\Objects\NotificationSettings;
use OTP\Traits\Instance;
use OTP\Helper\MoUtility;


/**
 * This class has MiniOrange Gateway Plan specific functions
 *
 * @todo - Segregate the functions
 */
if ( ! class_exists( 'MiniOrangeGateway' ) ) {
	/**
	 * MiniOrangeGateway class
	 */
	class MiniOrangeGateway implements IGatewayFunctions {

		use Instance;

		/**
		 * Global variable
		 *
		 * @var Array
		 */
		private $nonce;

		/**Constructor
		 **/
		public function __construct() {
			$this->nonce = 'mo_admin_actions';
			$this->load_hooks();
		}

		/**Loads Hooks for ajax
		 **/
		public function load_hooks() {
			add_action( 'wp_ajax_wa_miniorange_get_test_response', array( $this, 'get_gateway_response' ) );
			add_action( 'wp_ajax_miniorange_get_test_response', array( $this, 'get_gateway_response' ) );
		}

		/**Global variable
		 *
		 * @var string application_name used in API calls */
		private $application_name = 'wp_otp_verification';

		/**
		 * ---------------------------------------------------------------------------------------
		 * FUNCTIONS RELATED TO ADDONS
		 * ---------------------------------------------------------------------------------------
		 **/
		public function register_addons() {
			MiniOrangeCustomMessage::instance();
			UltimateMemberSmsNotification::instance();
			WooCommerceSmsNotification::instance();
			if ( file_exists( MOV_DIR . 'addons/passwordresetwc' ) ) {
				WooCommercePasswordReset::instance();
			}
			if ( file_exists( MOV_DIR . 'addons/regwithphone' ) ) {
				RegisterWithPhoneOnly::instance();
			}
			if ( file_exists( MOV_DIR . 'addons/wpsmsnotification' ) ) {
				WordPressSmsNotification::instance();
			}
			if ( file_exists( MOV_DIR . 'addons/passcodeovercalltwilio' ) ) {
				VerifyOverCallAddon::instance();
			}
			if ( file_exists( MOV_DIR . 'addons/passwordresetwp' ) ) {
				WordPressPasswordReset::instance();
			}
			if ( file_exists( MOV_DIR . 'addons/apiverification' ) ) {
				APIAddon::instance();
			}
			if ( file_exists( MOV_DIR . 'addons/resendcontrol' ) ) {
				MiniOrangeResendControl::instance();
			}
			if ( file_exists( MOV_DIR . 'addons/countrycode' ) ) {
				SelectedCountryCode::instance();
			}
			if ( file_exists( MOV_DIR . 'addons/mobulksms' ) ) {
				MoBulkSMSInit::instance();
			}
			if ( file_exists( MOV_DIR . 'addons/countrycodedropdown' ) ) {
				CountryCodeDropdownInit::instance();
			}
			if ( file_exists( MOV_DIR . 'addons/ipbasedropdown' ) ) {
				EnableIpBaseCountryCode::instance();
			}
			$dokan_sms_notification = MOV_DIR . 'notifications/dokannotif';
			if ( file_exists( $dokan_sms_notification ) ) {
				require MOV_DIR . 'notifications/dokannotif/miniorange-custom-validation.php';
			}
			$wcfm_sms_notification = MOV_DIR . 'notifications/wcfmsmsnotification';
			if ( file_exists( $wcfm_sms_notification ) ) {
				WCFMSmsNotification::instance();
			}

			if ( file_exists( MOV_DIR . 'addons/wcselectedcategory' ) ) {
				WcSelectedCategory::instance();
			}
		}

		/**Function for showing addonlist
		 * */
		public function show_addon_list() {
			$addon_list = AddOnList::instance();
			$addon_list = $addon_list->get_list();

			$circle_icon = '
							<svg class="min-w-[8px] min-h-[8px]" width="8" height="8" viewBox="0 0 18 18" fill="none">
								<circle id="a89fc99c6ce659f06983e2283c1865f1" cx="9" cy="9" r="7" stroke="rgb(99 102 241)" stroke-width="4"></circle>
							</svg>
						';

			$premium_feature_list = PremiumFeatureList::instance();
			$premium_addon_list   = $premium_feature_list->get_premium_add_on_list();

			foreach ( $addon_list as $addon ) {
				$addon_key = $premium_addon_list[ $addon->getAddOnKey() ];

				echo '			<div class="mo-addon-card">
									<div class="grow">' .
										wp_kses( $addon_key['svg'], MoUtility::mo_allow_svg_array() ) . '
							            <span class="grow"></span>
										<p class="my-mo-6 font-semibold text-md">' . esc_html( $addon_key['name'] ) . '</p>
					';
				foreach ( $addon_key['description'] as $key ) {
					echo '				<li class="feature-snippet">
											<span class="mt-mo-1">' . wp_kses( $circle_icon, MoUtility::mo_allow_svg_array() ) . '</span>
									<p class="m-mo-0">' . esc_html( $key ) . '</p>
										</li>';
				}
				echo '				</div>
									<div class="flex w-full mt-mo-4 justify-center item-center">
										<a href="' . esc_url( $addon->getSettingsUrl() ) . '" class="flex-1 mr-mo-1  mo-button inverted "  >  Settings </a>
									</div>
								</div>';
			}

			foreach ( $premium_addon_list as $key => $value ) {
				if ( ! array_key_exists( $key, $addon_list ) ) {
					echo '			<div class="mo-addon-card">
										<div class="grow">
											<div class="flex">';
						echo '                 	' . wp_kses( $value['svg'], MoUtility::mo_allow_svg_array() ) . '
												<div class="flex-1"><span style="float:right;margin-top:15px; font-size:160%; font-weight:bold;">' . esc_html( $value['price'] ) . '</span></div>
											</div>
											<p class="my-mo-6 font-semibold text-md">' . esc_html( $value['name'] ) . '</p>
						';
					foreach ( $value['description'] as $f_key ) {
								echo '			<li class="feature-snippet">
											<span class="mt-mo-1">' . wp_kses( $circle_icon, MoUtility::mo_allow_svg_array() ) . '</span>
											<p class="m-mo-0">' . esc_html( $f_key ) . '</p>
										</li>';
					}
					echo '			</div>
									<div class="flex w-full mt-mo-4 justify-center item-center">';
					if ( '' !== $value['guide_link'] ) {
						echo '       	<a href="' . esc_url( $value['guide_link'] ) . '" target="_blank" class="flex-1 mr-mo-1  mo-button secondary "  >  Know More </a>';
					} else {
						echo '			<a class="flex-1 mo-button secondary mr-mo-2" style="cursor:pointer;" onClick="otpSupportOnClick(\'' . esc_html( $value['guide_request_msg'] ) . '\');" > Know More</a>';
					}
						echo '			<a class="flex-1 mo-button inverted ml-mo-2 " style="cursor:pointer;"  onclick="otpSupportOnClick(\'' . esc_html( $value['support_msg'] ) . '\')"> Get Addon</a>
									</div>
								</div>';
				}
			}
		}

		/**
		 * ---------------------------------------------------------------------------------------
		 * FUNCTIONS RELATED TO LICENSING AND SYNC
		 * ---------------------------------------------------------------------------------------
		 */
		public function hourly_sync() {
			$customer_key = get_mo_option( 'admin_customer_key' );
			$api_key      = get_mo_option( 'admin_api_key' );
			if ( isset( $customer_key ) && isset( $api_key ) ) {
				MoUtility::handle_mo_check_ln( false, $customer_key, $api_key );
			}
		}
		/** Flushing Cache
		 */
		public function flush_cache() {

		}

		/** MoInternal Function
		 *
		 * @param object $post postarray.
		 */
		public function vlk( $post ) {

		}

		/** MoInternal Function
		 *
		 * @return bool
		 */
		public function mclv() {
			return true;
		}


		/** MoInternal Function
		 *
		 * @return bool
		 */
		public function is_gateway_config() {
			return true;
		}


		/** MoInternal Function
		 *
		 * @return bool
		 */
		public function is_mg() {
			return $this->mclv();
		}

		/**
		 * Returns the application Name for the gateway
		 *
		 * @return string
		 */
		public function get_application_name() {
			return $this->application_name;
		}

		/**
		 * ---------------------------------------------------------------------------------------
		 * FUNCTIONS RELATED TO CUSTOM SMS AND EMAIL TEMPLATES
		 * ---------------------------------------------------------------------------------------
		 *
		 * @param string $original_email_from email of user.
		 */
		public function custom_wp_mail_from_name( $original_email_from ) {
			return $original_email_from;
		}
		/**
		 * Returns the sms template
		 *
		 * @param object $posted post values.
		 */
		public function mo_configure_sms_template( $posted ) {

		}
		/**
		 * Returns the email template
		 *
		 * @param object $posted post values.
		 */
		public function mo_configure_email_template( $posted ) {

		}

		/**
		 * Save Gateway settings.
		 *
		 * @param array $posted the template data set by the admin.
		 */
		public function mo_configure_gateway( $posted ) {
		}
		/**
		 * Returns if Configuration page to be shown
		 *
		 * @param bool $disabled value.
		 */
		public function show_configuration_page( $disabled ) {
			require MOV_DIR . '/views/mgatewaysettings.php';
		}
		/**
		 * Returns if Configuration page to be shown
		 *
		 * @param bool $disabled value.
		 */
		public function template_configuration_page( $disabled ) {
			$request_uri = remove_query_arg( array( 'addon', 'form', 'subpage' ), isset( $_SERVER['REQUEST_URI'] ) ? esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ) ) : '' ); // phpcs:ignore -- false positive.
			$license_url = add_query_arg( array( 'page' => 'mootppricing' ), $request_uri );
			require MOV_DIR . '/views/mtemplatesettings.php';
		}
		/**
		 * Function for test SMS Configuration for Whatsapp Feature
		 */
		public function get_gateway_response() {
			if ( ! check_ajax_referer( $this->nonce, 'security', false ) ) {
				return;
			}

			$data                      = MoUtility::mo_sanitize_array( $_POST );
			$test_configuration_number = isset( $data['test_config_number'] ) ? $data['test_config_number'] : '';
			$test_configuration_type   = isset( $data['action'] ) ? $data['action'] : '';
			$test_gateway_response     = 'wa_miniorange_get_test_response' === $test_configuration_type ? $this->mo_send_otp_token( 'WHATSAPP', '', $test_configuration_number, $data ) : $this->mo_send_otp_token( 'SMS', '', $test_configuration_number, $data );
			echo esc_attr( $test_gateway_response );
			die();
		}

		/**
		 * Calls the server to send OTP to the user's phone or email
		 *
		 * @param string $auth_type  OTP Type - EMAIL or SMS.
		 * @param string $email     Email Address of the user.
		 * @param string $phone     Phone Number of the user.
		 * @param array  $data     Data submitted by the user.
		 * @return array
		 */
		public function mo_send_otp_token( $auth_type, $email, $phone, $data = array() ) {
			if ( MO_TEST_MODE ) {
				return array(
					'status' => 'SUCCESS',
					'txId'   => MoUtility::rand(),
				);
			} else {
				$auth_type = apply_filters( 'otp_over_call_activation', $auth_type );
				$content   = 'WHATSAPP' === $auth_type ? apply_filters( 'mo_wa_send_otp_token', $auth_type, $email, $phone, $data ) : MocURLCall::mo_send_otp_token( $auth_type, $email, $phone );
				if ( isset( $data['action'] ) && 'wa_miniorange_get_test_response' === ( $data['action'] ) ) {
					return $content;
				}
				return json_decode( $content, true );
			}
		}

		/**
		 * Calls server apis to send email or sms message to the user
		 *
		 * @param NotificationSettings $settings notification object.
		 * @return string
		 */
		public function mo_send_notif( NotificationSettings $settings ) {
			$url = '';
			if ( $settings->send_email ) {
				$url = MoConstants::HOSTNAME . '/moas/api/notify/send';
			} else {
				$url = MoConstants::HOSTNAME . '/moas/api/plugin/notify/send';
			}

			$customer_key = get_mo_option( 'admin_customer_key' );
			$api_key      = get_mo_option( 'admin_api_key' );

			$fields      = array(
				'customerKey' => $customer_key,
				'sendEmail'   => $settings->send_email,
				'sendSMS'     => $settings->send_sms,
				'email'       => array(
					'customerKey' => $customer_key,
					'fromEmail'   => $settings->from_email,
					'bccEmail'    => $settings->bcc_email,
					'fromName'    => $settings->from_name,
					'toEmail'     => $settings->to_email,
					'toName'      => $settings->to_email,
					'subject'     => $settings->subject,
					'content'     => $settings->message,
				),
				'sms'         => array(
					'customerKey' => $customer_key,
					'phoneNumber' => $settings->phone_number,
					'message'     => $settings->message,
				),
			);
			$json        = wp_json_encode( $fields );
			$auth_header = MocURLCall::create_auth_header( $customer_key, $api_key );
			$response    = MocURLCall::call_api( $url, $json, $auth_header );
			$verify_type = isset( $settings->send_email ) ? VerificationType::EMAIL : VerificationType::PHONE;
			MoUtility::mo_update_sms_email_transations( $response, $verify_type );
			return $response;
		}

		/**
		 * Calls the server to validate the OTP
		 *
		 * @param string $tx_id      Transaction ID from session.
		 * @param string $otp_token OTP Token to validate.
		 * @return array
		 */
		public function mo_validate_otp_token( $tx_id, $otp_token ) {
			if ( MO_TEST_MODE ) {
				return MO_FAIL_MODE ? array( 'status' => '' ) : array( 'status' => 'SUCCESS' );
			} else {
				$content = '';
				if ( get_mo_option( 'wa_only' ) || get_mo_option( 'wa_otp' ) ) {
					$content = apply_filters( 'mo_wa_validate_otp_token', $tx_id, $otp_token );
				}
				if ( ! $content ) {
					$content = MocURLCall::validate_otp_token( $tx_id, $otp_token );
				}
				return json_decode( $content, true );
			}
		}

		/** FUNCTIONS RELATED TO VISUAL TOUR
		 *
		 * @return array
		 */
		public function get_config_page_pointers() {
			$visual_tour = MOVisualTour::instance();
			return array(
				$visual_tour->tour_template(
					'configuration_instructions',
					'right',
					'',
					'<br>Check the links here to see how to change email/sms template, custom gateway, senderID, etc.',
					'Next',
					'emailSms.svg',
					1
				),
			);
		}
	}
}
