<?php
/**Load administrator changes for PremiumFeatureList
 *
 * @package miniorange-otp-verification/helper
 */

namespace OTP\Helper;

use OTP\Objects\BaseAddOnHandler;
use OTP\Objects\FormHandler;
use OTP\Objects\IFormHandler;
use OTP\Traits\Instance;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * This is the constant class which lists all the texts
 * that need to be supported for the Premium addon List.
 */
if ( ! class_exists( 'PremiumFeatureList' ) ) {
	/**
	 * PremiumFeatureList class
	 */
	final class PremiumFeatureList {

		use Instance;
		/** Variable declaration
		 *
		 * @var $premium_addon
		 */
		private $premium_addon;

		/** Variable declaration
		 *
		 * @var $premium_forms
		 */
		private $premium_forms;

		/** Variable declaration
		 *
		 * @var $addon_name
		 */
		private $addon_name;

		/**Constructor
		 **/
		private function __construct() {
			$this->premium_addon = array(
				'otp_control'                   => array(
					'name'        => 'Limit OTP Request ',
					'description' => array(
						mo_( 'Set timer to resend OTP' ),
						mo_( 'Block Sending OTP Until set timer out' ),
						mo_( 'Limit OTPs based on IP' ),
						mo_( 'Restrict user from multiple OTP attempts' ),
					),
					'svg'         => '<svg width="50" height="50" viewBox="0 0 100 100" fill="none">
										<g id="033b90d886830bac50b11c6b379dcafe">
										<rect width="100" height="100" rx="10" fill="url(#3495f85936cfe87c48ae6be73d1ec048)"></rect>
										<g id="910adee180532c09d094ca011b854458">
											<path id="88000f903c64892e337b114c0f69607c" fill-rule="evenodd" clip-rule="evenodd" d="M50 72.5C62.4264 72.5 72.5 62.4264 72.5 50C72.5 37.5736 62.4264 27.5 50 27.5C37.5736 27.5 27.5 37.5736 27.5 50C27.5 62.4264 37.5736 72.5 50 72.5ZM59 51.6875C59.932 51.6875 60.6875 50.932 60.6875 50C60.6875 49.068 59.932 48.3125 59 48.3125H41C40.068 48.3125 39.3125 49.068 39.3125 50C39.3125 50.932 40.068 51.6875 41 51.6875H59Z" fill="white"></path>
										</g>
										</g>
										<defs>
										<linearGradient id="3495f85936cfe87c48ae6be73d1ec048" x1="0" y1="0" x2="100" y2="100" gradientUnits="userSpaceOnUse">
											<stop stop-color="#FF8C8C"></stop>
											<stop offset="1" stop-color="#FF3F3F"></stop>
										</linearGradient>
										</defs>
									</svg>',
					'price'       => '$49',
					'guide_link'  => 'https://plugins.miniorange.com/how-to-configure-limit-otp-request-addon',
					'support_msg' => 'Hi I am interested in the Limit OTP Request addon, could you please tell me more about this addon?',
				),
				'wp_pass_reset_addon'           => array(
					'name'        => 'WordPress Password Reset Over OTP',
					'description' => array(
						mo_( 'Reset password using OTP instead of email links' ),
						mo_( 'OTP Over Phone Supported' ),
						mo_( 'OTP Over Email Supported' ),
						mo_( 'User Friendly Password Reset' ),
					),
					'svg'         => '<svg width="50" height="50" viewBox="0 0 100 100" fill="none" >
										<g id="563f69671e04ffeef3b83ea51e866208">
										<rect width="100" height="100" rx="10" fill="url(#7df1013e6d8f719f861e1022a164bc7d)"></rect>
										<g id="34454dd908cc56c9684f81974317ce7c">
											<g id="38645efbc9a6fbc2f72deb9c7ceb7067">
											<path id="0db6786045b6f3ac2f30450d4a1abca3" fill-rule="evenodd" clip-rule="evenodd" d="M50 75C63.8071 75 75 63.8071 75 50C75 36.1929 63.8071 25 50 25C36.1929 25 25 36.1929 25 50C25 63.8071 36.1929 75 50 75ZM56.2069 34.308C55.8248 33.3455 54.7348 32.8751 53.7724 33.2572C52.8099 33.6394 52.3395 34.7294 52.7216 35.6918L53.156 36.7858C52.139 36.5712 51.0827 36.4582 50 36.4582C42.1848 36.4582 35.625 42.4013 35.625 49.9999C35.625 51.2128 35.7947 52.3909 36.1136 53.5126C36.3968 54.5087 37.4338 55.0866 38.4299 54.8034C39.4259 54.5203 40.0038 53.4832 39.7207 52.4872C39.4953 51.6944 39.375 50.8613 39.375 49.9999C39.375 44.7118 44.008 40.2082 50 40.2082C52.035 40.2082 53.9261 40.7342 55.5312 41.6388C56.2234 42.0288 57.0864 41.9402 57.6849 41.4176C58.2834 40.895 58.4875 40.0519 58.1943 39.3133L56.2069 34.308ZM63.8864 46.4872C63.6032 45.4911 62.5662 44.9132 61.5701 45.1964C60.5741 45.4795 59.9962 46.5165 60.2793 47.5126C60.5047 48.3054 60.625 49.1385 60.625 49.9999C60.625 55.2879 55.992 59.7916 50 59.7916C47.965 59.7916 46.0739 59.2655 44.4688 58.361C43.7766 57.9709 42.9136 58.0595 42.315 58.5821C41.7165 59.1048 41.5124 59.9479 41.8056 60.6864L43.7931 65.6918C44.1752 66.6543 45.2652 67.1247 46.2276 66.7425C47.1901 66.3604 47.6605 65.2704 47.2784 64.308L46.844 63.2139C47.861 63.4286 48.9173 63.5416 50 63.5416C57.8152 63.5416 64.375 57.5985 64.375 49.9999C64.375 48.787 64.2053 47.6089 63.8864 46.4872Z" fill="white"></path>
											</g>
										</g>
										</g>
										<defs>
										<linearGradient id="7df1013e6d8f719f861e1022a164bc7d" x1="0" y1="0" x2="100" y2="100" gradientUnits="userSpaceOnUse">
											<stop stop-color="#FF7AB2"></stop>
											<stop offset="1" stop-color="#EA6CFF"></stop>
										</linearGradient>
										</defs>
									</svg>',
					'price'       => '$19',
					'guide_link'  => 'https://plugins.miniorange.com/how-to-configure-wordpress-password-reset-addon',
					'support_msg' => 'Hi! I am interested in the WordPress Password Reset Over OTP addon, could you please tell me more about this addon?',
				),
				'country_addon'                 => array(
					'name'              => 'Country Code Dropdown ',
					'description'       => array(
						mo_( 'Enable country code dropdown on any phone field' ),
						mo_( 'Country Code with Flags' ),
						mo_( 'All countries supported' ),
					),
					'svg'               => '<svg width="50" height="50" viewBox="0 0 100 100" fill="none">
										<g id="08cefd4fa19f0717074e4fc57bc48504">
										<rect width="100" height="100" rx="10" fill="url(#5988db2d005a8118b81906807593b68e)"></rect>
										<g id="e48dc9d97d17b4c9f6ac59928bd02728">
											<g id="e38251e1d5149b124578b5ec60d2a68d">
											<path id="3f4ac12419c6ede386891125add0d316" d="M31.25 46.25C27.7982 46.25 25 43.4518 25 40C25 36.5482 27.7982 33.75 31.25 33.75C34.7018 33.75 37.5 36.5482 37.5 40C37.5 43.4518 34.7018 46.25 31.25 46.25Z" fill="white"></path>
											<path id="908fde78edfb00996e6f69192a98c613" opacity="0.4" d="M31.25 66.25C27.7982 66.25 25 63.4518 25 60C25 56.5482 27.7982 53.75 31.25 53.75C34.7018 53.75 37.5 56.5482 37.5 60C37.5 63.4518 34.7018 66.25 31.25 66.25Z" fill="white"></path>
											<path id="63d7481f43c66fdf2e48dad539cd5285" opacity="0.4" fill-rule="evenodd" clip-rule="evenodd" d="M43.125 35.625C43.125 34.5895 43.9645 33.75 45 33.75H60C61.0355 33.75 61.875 34.5895 61.875 35.625C61.875 36.6605 61.0355 37.5 60 37.5H45C43.9645 37.5 43.125 36.6605 43.125 35.625Z" fill="white"></path>
											<path id="ac4b2e3e5992a6f9f735439c59649df5" fill-rule="evenodd" clip-rule="evenodd" d="M43.125 55.625C43.125 54.5895 43.9645 53.75 45 53.75H60C61.0355 53.75 61.875 54.5895 61.875 55.625C61.875 56.6605 61.0355 57.5 60 57.5H45C43.9645 57.5 43.125 56.6605 43.125 55.625Z" fill="white"></path>
											<path id="4adc2ca37258b425706c69f37bfba3e9" opacity="0.4" fill-rule="evenodd" clip-rule="evenodd" d="M43.125 44.375C43.125 43.3395 43.9645 42.5 45 42.5L75 42.5C76.0355 42.5 76.875 43.3395 76.875 44.375C76.875 45.4105 76.0355 46.25 75 46.25L45 46.25C43.9645 46.25 43.125 45.4105 43.125 44.375Z" fill="white"></path>
											<path id="0e13eb575cdb0d9e5ebb72e3d301b6b0" fill-rule="evenodd" clip-rule="evenodd" d="M43.125 64.375C43.125 63.3395 43.9645 62.5 45 62.5H75C76.0355 62.5 76.875 63.3395 76.875 64.375C76.875 65.4105 76.0355 66.25 75 66.25H45C43.9645 66.25 43.125 65.4105 43.125 64.375Z" fill="white"></path>
											</g>
										</g>
										</g>
										<defs>
										<linearGradient id="5988db2d005a8118b81906807593b68e" x1="0" y1="0" x2="100" y2="100" gradientUnits="userSpaceOnUse">
											<stop stop-color="#5D94FF"></stop>
											<stop offset="1" stop-color="#1CE7E7"></stop>
										</linearGradient>
										</defs>
									</svg>',
					'price'             => '$19',
					'guide_link'        => '',
					'guide_request_msg' => 'Hi I am interested in the Country Code Dropdown addon, could you please tell me more about this addon?',
					'support_msg'       => 'Hi! Could you please share the payment details for the Country Code Dropdown addon?',
				),
				'reg_only_phone_addon'          => array(
					'name'        => 'Register Using Only Phone Number',
					'description' => array(
						mo_( 'Register with phone number and OTP' ),
						mo_( 'No email required' ),
						mo_( 'Supported Registration forms: Woocommerce, Ultimate Member, Wordpress etc.' ),
					),
					'svg'         => '<svg width="50" height="50" viewBox="0 0 100 100" fill="none">
										<g id="5702c03fcabb879bfe0641db68c0bd60">
										<g id="fc53fd539e2f2cc4097cb8e3ecf1606d">
											<path id="0b5274ab205e435baa8eb19539234e50" d="M90 0H10C4.47715 0 0 4.47715 0 10V90C0 95.5229 4.47715 100 10 100H90C95.5229 100 100 95.5229 100 90V10C100 4.47715 95.5229 0 90 0Z" fill="url(#b166b3f6e9757cea71b85b13ea51b3dd)"></path>
										</g>
										<g id="a68f7d5e1a6388ee04e4eaab3bdff766">
											<g id="7f362f4b2891cb2c9c684ac05e53bb73">
											<path id="b6f186ef9482fd3626edade6146f28c7" fill-rule="evenodd" clip-rule="evenodd" d="M70.25 62.0466V65.75C70.25 68.2353 68.2353 70.25 65.75 70.25C45.8678 70.25 29.75 54.1322 29.75 34.25C29.75 31.7647 31.7647 29.75 34.25 29.75H37.9534C39.7934 29.75 41.4481 30.8703 42.1315 32.5787L43.9622 37.1556C44.8314 39.3286 43.8899 41.8051 41.7965 42.8517L41 43.25C41 43.25 42.125 48.875 46.625 53.375C51.125 57.875 56.75 59 56.75 59L57.1483 58.2035C58.1949 56.1101 60.6714 55.1686 62.8444 56.0378L67.4213 57.8685C69.1297 58.5519 70.25 60.2066 70.25 62.0466ZM66.875 34.25C66.875 36.7353 64.8603 38.75 62.375 38.75C59.8897 38.75 57.875 36.7353 57.875 34.25C57.875 31.7647 59.8897 29.75 62.375 29.75C64.8603 29.75 66.875 31.7647 66.875 34.25ZM66.2 41C68.4368 41 70.25 42.8132 70.25 45.05C70.25 46.5412 69.0412 47.75 67.55 47.75H57.2C55.7088 47.75 54.5 46.5412 54.5 45.05C54.5 42.8132 56.3132 41 58.55 41H66.2Z" fill="white"></path>
											</g>
										</g>
										</g>
										<defs>
										<linearGradient id="b166b3f6e9757cea71b85b13ea51b3dd" x1="0" y1="0" x2="100" y2="100" gradientUnits="userSpaceOnUse">
											<stop stop-color="#EB57E5"></stop>
											<stop offset="1" stop-color="#3FFFFF"></stop>
										</linearGradient>
										</defs>
									</svg>',
					'price'       => '$49',
					'guide_link'  => 'https://plugins.miniorange.com/how-to-configure-register-using-only-phone-addon',
					'support_msg' => 'Hi I am interested in the Register Using Only Phone Number addon, could you please tell me more about this addon?',
				),
				'login_with_phone_addon'        => array(
					'name'              => 'Login Using Only Phone Number',
					'description'       => array(
						mo_( 'Login using Phone Number' ),
						mo_( 'Passwordless login' ),
						mo_( 'Email address is not required' ),
						mo_( 'Customizable as per Login Form' ),
					),
					'svg'               => '<svg width="50" height="50" viewBox="0 0 100 100" fill="none">
										<g id="bdc921d4bff338c999c25cb7f7676a4d">
										<g id="a674357caf83f9024dba8f0d2829d650">
											<path id="aecaee670e9cd3942e0cab0f00858627" d="M90 0H10C4.47715 0 0 4.47715 0 10V90C0 95.5229 4.47715 100 10 100H90C95.5229 100 100 95.5229 100 90V10C100 4.47715 95.5229 0 90 0Z" fill="url(#53015cb3ee762013c785e00d8d673d9b)"></path>
											<g id="5d38c302f1f779775e8cb283f9d116ad">
											<g id="4d60257e005adf16df3159d4e47fbc83">
												<path id="3d1e870026f4185563bc93ab3e256a74" d="M70.25 65.75V62.0466C70.25 60.2066 69.1297 58.5519 67.4213 57.8685L62.8444 56.0378C60.6714 55.1686 58.1949 56.1101 57.1483 58.2035L56.75 59C56.75 59 51.125 57.875 46.625 53.375C42.125 48.875 41 43.25 41 43.25L41.7965 42.8517C43.8899 41.8051 44.8314 39.3286 43.9622 37.1556L42.1315 32.5787C41.4481 30.8703 39.7934 29.75 37.9534 29.75H34.25C31.7647 29.75 29.75 31.7647 29.75 34.25C29.75 54.1322 45.8678 70.25 65.75 70.25C68.2353 70.25 70.25 68.2353 70.25 65.75Z" fill="#28303F"></path>
											</g>
											</g>
										</g>
										</g>
										<defs>
										<linearGradient id="53015cb3ee762013c785e00d8d673d9b" x1="0" y1="0" x2="100" y2="100" gradientUnits="userSpaceOnUse">
											<stop stop-color="#8CFFAC"></stop>
											<stop offset="1" stop-color="#3FFFFF"></stop>
										</linearGradient>
										</defs>
									</svg>',
					'price'             => '$49',
					'guide_link'        => '',
					'guide_request_msg' => 'Hi I am interested in the Login Using Only Phone Number addon, could you please tell me more about this addon?',
					'support_msg'       => 'Hi! Could you please share the payment details for the Login Using Only Phone Number addon?',
				),
				'wp_sms_notification_addon'     => array(
					'name'        => 'WordPress SMS Notification to Admin & User on Registration',
					'description' => array(
						mo_( 'Send SMS Notification on User Registration' ),
						mo_( 'Customizable SMS Template' ),
						mo_( 'Notification to Multiple Admins & Users.' ),
					),
					'svg'         => '<svg width="50" height="50" viewBox="0 0 100 100" fill="none" >
										<g id="7964060c44d36a8760d399f2c150d191">
										<rect width="100" height="100" rx="10" fill="url(#3af86c1638de5d9ea6254087fc809a51)"></rect>
										<g id="92dda51326a520489a53d8be9018dd82">
											<g id="f87bc7354c18ce973747fc33f012f5cf">
											<path id="667687f78268e2dd1ba66e3b8af6f5c7" fill-rule="evenodd" clip-rule="evenodd" d="M37.0013 63.5005H62.9987C67.1125 63.5005 69.4608 59.3625 66.9925 56.4628C65.8998 55.1791 65.2263 53.6565 65.0451 52.0599L64.676 48.8074C64.2901 48.8521 63.8977 48.875 63.4999 48.875C57.908 48.875 53.3749 44.3419 53.3749 38.75C53.3749 36.5655 54.0666 34.5427 55.2431 32.8885C55.198 32.8725 55.1527 32.8568 55.1074 32.8413V32.6079C55.1074 29.7872 52.8207 27.5005 50 27.5005C47.1793 27.5005 44.8926 29.7872 44.8926 32.6079V32.8413C40.0722 34.4917 36.5036 38.4145 35.961 43.1947L34.9549 52.0599C34.7737 53.6565 34.1002 55.1791 33.0075 56.4628C30.5392 59.3625 32.8875 63.5005 37.0013 63.5005ZM70.25 38.75C70.25 42.4779 67.2279 45.5 63.5 45.5C59.7721 45.5 56.75 42.4779 56.75 38.75C56.75 35.0221 59.7721 32 63.5 32C67.2279 32 70.25 35.0221 70.25 38.75ZM50 72.5005C53.0522 72.5005 55.6581 70.6988 56.6872 68.1615C56.7301 68.0557 56.75 67.9421 56.75 67.8279C56.75 67.3016 56.3234 66.875 55.7971 66.875H44.2029C43.6766 66.875 43.25 67.3016 43.25 67.8279C43.25 67.9421 43.2699 68.0557 43.3128 68.1615C44.3419 70.6988 46.9478 72.5005 50 72.5005Z" fill="white"></path>
											</g>
										</g>
										</g>
										<defs>
										<linearGradient id="3af86c1638de5d9ea6254087fc809a51" x1="0" y1="0" x2="100" y2="100" gradientUnits="userSpaceOnUse">
											<stop stop-color="#4790FF"></stop>
											<stop offset="1" stop-color="#896CFF"></stop>
										</linearGradient>
										</defs>
									</svg>',
					'price'       => '$19',
					'guide_link'  => 'https://plugins.miniorange.com/how-to-configure-wordpress-sms-notification-addon',
					'support_msg' => 'Hi I am interested in the WordPress SMS Notification to Admin  User on Registration addon, could you please tell me more about this addon?',
				),
				'wc_pass_reset_addon'           => array(
					'name'        => 'WooCommerce Password Reset Over OTP ',
					'description' => array(
						mo_( 'Reset password using OTP' ),
						mo_( 'OTP Over Phone' ),
						mo_( 'OTP Over Email' ),
						mo_( 'User Friendly Password Reset' ),
					),
					'svg'         => '<svg width="50" height="50" viewBox="0 0 100 100" fill="none" >
											<g id="563f69671e04ffeef3b83ea51e866208">
											<rect width="100" height="100" rx="10" fill="url(#7df1013e6d8f719f861e1022a164bc7d)"></rect>
											<g id="34454dd908cc56c9684f81974317ce7c">
												<g id="38645efbc9a6fbc2f72deb9c7ceb7067">
												<path id="0db6786045b6f3ac2f30450d4a1abca3" fill-rule="evenodd" clip-rule="evenodd" d="M50 75C63.8071 75 75 63.8071 75 50C75 36.1929 63.8071 25 50 25C36.1929 25 25 36.1929 25 50C25 63.8071 36.1929 75 50 75ZM56.2069 34.308C55.8248 33.3455 54.7348 32.8751 53.7724 33.2572C52.8099 33.6394 52.3395 34.7294 52.7216 35.6918L53.156 36.7858C52.139 36.5712 51.0827 36.4582 50 36.4582C42.1848 36.4582 35.625 42.4013 35.625 49.9999C35.625 51.2128 35.7947 52.3909 36.1136 53.5126C36.3968 54.5087 37.4338 55.0866 38.4299 54.8034C39.4259 54.5203 40.0038 53.4832 39.7207 52.4872C39.4953 51.6944 39.375 50.8613 39.375 49.9999C39.375 44.7118 44.008 40.2082 50 40.2082C52.035 40.2082 53.9261 40.7342 55.5312 41.6388C56.2234 42.0288 57.0864 41.9402 57.6849 41.4176C58.2834 40.895 58.4875 40.0519 58.1943 39.3133L56.2069 34.308ZM63.8864 46.4872C63.6032 45.4911 62.5662 44.9132 61.5701 45.1964C60.5741 45.4795 59.9962 46.5165 60.2793 47.5126C60.5047 48.3054 60.625 49.1385 60.625 49.9999C60.625 55.2879 55.992 59.7916 50 59.7916C47.965 59.7916 46.0739 59.2655 44.4688 58.361C43.7766 57.9709 42.9136 58.0595 42.315 58.5821C41.7165 59.1048 41.5124 59.9479 41.8056 60.6864L43.7931 65.6918C44.1752 66.6543 45.2652 67.1247 46.2276 66.7425C47.1901 66.3604 47.6605 65.2704 47.2784 64.308L46.844 63.2139C47.861 63.4286 48.9173 63.5416 50 63.5416C57.8152 63.5416 64.375 57.5985 64.375 49.9999C64.375 48.787 64.2053 47.6089 63.8864 46.4872Z" fill="white"></path>
												</g>
											</g>
											</g>
											<defs>
											<linearGradient id="7df1013e6d8f719f861e1022a164bc7d" x1="0" y1="0" x2="100" y2="100" gradientUnits="userSpaceOnUse">
												<stop stop-color="#FF7AB2"></stop>
												<stop offset="1" stop-color="#EA6CFF"></stop>
											</linearGradient>
											</defs>
										</svg>',
					'price'       => '$19',
					'guide_link'  => 'https://plugins.miniorange.com/how-to-configure-woocommerce-password-reset-addon',
					'support_msg' => 'Hi! I am interested in the WooCommerce Password Reset Over OTP addon, could you please tell me more about this addon?',
				),
				'otp_selected_product_addon'    => array(
					'name'              => 'OTP on Selected Product Category',
					'description'       => array(
						mo_( 'OTP verification will be enabled on the selected product category' ),
						mo_( 'All Woocommerce categories supported' ),
					),
					'svg'               => '<svg width="50" height="50" viewBox="0 0 100 100" fill="none" >
										<g id="678c9a11">
										<rect width="100" height="100" rx="10" fill="url(#1f829a77)"></rect>
										<g id="c8456309">
											<path id="9cbc5e53" fill-rule="evenodd" clip-rule="evenodd" d="M28.5879 28.9171C28.2121 28.7636 27.7444 28.7501 26.3794 28.75L25.0001 28.75H25L24.0001 28.7501C23.5859 28.7502 23.2501 28.4144 23.25 28.0002C23.2499 27.586 23.5857 27.2502 23.9999 27.2501L24.9999 27.25H25L26.3795 27.25L26.5362 27.25C27.6814 27.2495 28.471 27.2491 29.155 27.5285C29.7566 27.7742 30.2841 28.1721 30.6856 28.683C31.1421 29.264 31.3587 30.0233 31.6728 31.1246L31.7158 31.2753L32.28 33.2501H61.7156H61.7521C62.7894 33.2501 63.6182 33.2501 64.276 33.3086C64.9466 33.3682 65.5297 33.4942 66.0359 33.8053C66.8273 34.2918 67.4101 35.0547 67.6711 35.9463C67.8381 36.5165 67.8063 37.1122 67.6873 37.7748C67.5707 38.4248 67.3526 39.2244 67.0797 40.2251L67.07 40.2604L64.0098 51.4814L63.964 51.6494C63.5481 53.176 63.281 54.1567 62.7042 54.9035C62.1963 55.5611 61.5248 56.074 60.7567 56.391C59.8844 56.7509 58.8681 56.7506 57.2858 56.7502L57.1117 56.7501H42.8275L42.6556 56.7502H42.6556C41.0914 56.7506 40.0865 56.7509 39.2212 56.3975C38.4591 56.0862 37.791 55.5823 37.2824 54.9351C36.7049 54.2002 36.4291 53.2339 35.9998 51.7297L35.9526 51.5644L30.9931 34.2062L30.2735 31.6874C29.8985 30.375 29.757 29.929 29.5062 29.6098C29.2653 29.3033 28.9488 29.0645 28.5879 28.9171ZM37.25 66C37.25 63.3766 39.3766 61.25 42 61.25C44.6234 61.25 46.75 63.3766 46.75 66C46.75 68.6233 44.6234 70.75 42 70.75C39.3766 70.75 37.25 68.6233 37.25 66ZM58 61.25C55.3766 61.25 53.25 63.3766 53.25 66C53.25 68.6233 55.3766 70.75 58 70.75C60.6234 70.75 62.75 68.6233 62.75 66C62.75 63.3766 60.6234 61.25 58 61.25Z" fill="white"></path>
										</g>
										</g>
										<defs>
										<linearGradient id="1f829a77" x1="0" y1="0" x2="100" y2="100" gradientUnits="userSpaceOnUse">
											<stop stop-color="#5D94FF"></stop>
											<stop offset="1" stop-color="#1CE7E7"></stop>
										</linearGradient>
										</defs>
									</svg>',
					'price'             => '$49',
					'guide_link'        => '',
					'guide_request_msg' => 'Hi I am interested in the Selected Product Category addon, could you please share the payment details for this addon?',
					'support_msg'       => 'Hi I am interested in the Selected Product Category addon, could you please share the payment details for this addon?',
				),
				'ip_base_country_code_addon'    => array(
					'name'        => 'Geolocation/IP Base Country Code Dropdown',
					'description' => array(
						mo_( 'Alter the country code dropdown based on the users IP address or geolocation data.' ),
						mo_( 'Enhances user experience' ),
						mo_( 'Simplify the country selection process' ),
					),
					'svg'         => '<svg width="50" height="50" viewBox="0 0 100 100" fill="none">
										<g id="c804ab86e06907df4ede7c5996a51eee">
										<rect width="100" height="100" rx="10" fill="url(#c631fb2424936253666f90eb3c760e43)"></rect>
										<g id="215da64cca5e778eae54f3e9be6f6171">
											<g id="255431f8fe3786cf28667958c83417de">
											<path id="103e2c5498800c8069ab033c4ae3fd13" opacity="0.4" d="M61.25 50C61.25 52.4853 59.2353 54.5 56.75 54.5H38.75V61.25C38.75 63.7353 40.7647 65.75 43.25 65.75H65.75C68.2353 65.75 70.25 63.7353 70.25 61.25V43.25C70.25 40.7647 68.2353 38.75 65.75 38.75H61.25V50Z" fill="white"></path>
											<path id="e12d10051d83e3666c506d0426968ce2" d="M31.4375 56.75H56.9912C59.3434 56.75 61.2502 54.7353 61.2502 52.25V34.25C61.2502 31.7647 59.3434 29.75 56.9912 29.75H31.4375V56.75Z" fill="white"></path>
											<path id="96d243b1d831672d9fb31e0117b0435b" opacity="0.4" fill-rule="evenodd" clip-rule="evenodd" d="M29.75 25.8125C30.682 25.8125 31.4375 26.568 31.4375 27.5V72.5C31.4375 73.432 30.682 74.1875 29.75 74.1875C28.818 74.1875 28.0625 73.432 28.0625 72.5V27.5C28.0625 26.568 28.818 25.8125 29.75 25.8125Z" fill="white"></path>
											</g>
										</g>
										</g>
										<defs>
										<linearGradient id="c631fb2424936253666f90eb3c760e43" x1="0" y1="0" x2="100" y2="100" gradientUnits="userSpaceOnUse">
											<stop stop-color="#EDEF83"></stop>
											<stop offset="1" stop-color="#00D6AF"></stop>
										</linearGradient>
										</defs>
									</svg>',
					'price'       => '$39',
					'guide_link'  => '',
					'guide_request_msg' => 'Hi I am interested in the Geolocation/IP Base Country Code Dropdown addon, could you please tell me more about this addon?',
					'support_msg'       => 'Hi! Could you please share the payment details for the Geolocation/IP Base Country Code Dropdown addon?',

				),
				'otp_over_call_addon'           => array(
					'name'        => 'OTP Over Call',
					'description' => array(
						mo_( 'Send OTP Over Call insted of SMS' ),
						mo_( 'User friendly' ),
						mo_( 'Hassle-Free Setup' ),
					),
					'svg'         => '<svg width="50" height="50" viewBox="0 0 100 100" fill="none">
										<g id="bc0e8f986a2ec8b31050a44d5b1b2afb">
										<rect width="100" height="100" rx="10" fill="url(#5151e7ec67142d62c055f74248b0a28e)"></rect>
										<g id="87883360d9a72962dedfce91344b024f">
											<g id="3e3ed55deb713f59daf09bd3365974b6">
											<path id="a21502646450931d25a993ee6ac0962b" d="M70.25 65.75V62.0466C70.25 60.2066 69.1297 58.5519 67.4213 57.8685L62.8444 56.0378C60.6714 55.1686 58.1949 56.1101 57.1483 58.2035L56.75 59C56.75 59 51.125 57.875 46.625 53.375C42.125 48.875 41 43.25 41 43.25L41.7965 42.8517C43.8899 41.8051 44.8314 39.3286 43.9622 37.1556L42.1315 32.5787C41.4481 30.8703 39.7934 29.75 37.9534 29.75H34.25C31.7647 29.75 29.75 31.7647 29.75 34.25C29.75 54.1322 45.8678 70.25 65.75 70.25C68.2353 70.25 70.25 68.2353 70.25 65.75Z" fill="#28303F"></path>
											</g>
										</g>
										</g>
										<defs>
										<linearGradient id="5151e7ec67142d62c055f74248b0a28e" x1="0" y1="0" x2="100" y2="100" gradientUnits="userSpaceOnUse">
											<stop stop-color="#8CFFAC"></stop>
											<stop offset="1" stop-color="#3FFFFF"></stop>
										</linearGradient>
										</defs>
									</svg>',
					'price'       => '$49',
					'guide_link'  => 'https://plugins.miniorange.com/how-to-configure-otp-over-call-addon',
					'support_msg' => 'Hi! I am interested in the OTP Over Phone Call addon, could you please tell me more about this addon?',
				),
				'selected_country_addon'        => array(
					'name'        => 'OTP Verification for Selected Countries Only',
					'description' => array(
						mo_( 'Add countries for which you wish to enable OTP Verification' ),
						mo_( 'Country code dropdown will be altered accordingly' ),
						mo_( 'Block OTP for selected countries' ),
					),
					'svg'         => '<svg width="50" height="50" viewBox="0 0 100 100" fill="none">
										<g id="c804ab86e06907df4ede7c5996a51eee">
										<rect width="100" height="100" rx="10" fill="url(#c631fb2424936253666f90eb3c760e43)"></rect>
										<g id="215da64cca5e778eae54f3e9be6f6171">
											<g id="255431f8fe3786cf28667958c83417de">
											<path id="103e2c5498800c8069ab033c4ae3fd13" opacity="0.4" d="M61.25 50C61.25 52.4853 59.2353 54.5 56.75 54.5H38.75V61.25C38.75 63.7353 40.7647 65.75 43.25 65.75H65.75C68.2353 65.75 70.25 63.7353 70.25 61.25V43.25C70.25 40.7647 68.2353 38.75 65.75 38.75H61.25V50Z" fill="white"></path>
											<path id="e12d10051d83e3666c506d0426968ce2" d="M31.4375 56.75H56.9912C59.3434 56.75 61.2502 54.7353 61.2502 52.25V34.25C61.2502 31.7647 59.3434 29.75 56.9912 29.75H31.4375V56.75Z" fill="white"></path>
											<path id="96d243b1d831672d9fb31e0117b0435b" opacity="0.4" fill-rule="evenodd" clip-rule="evenodd" d="M29.75 25.8125C30.682 25.8125 31.4375 26.568 31.4375 27.5V72.5C31.4375 73.432 30.682 74.1875 29.75 74.1875C28.818 74.1875 28.0625 73.432 28.0625 72.5V27.5C28.0625 26.568 28.818 25.8125 29.75 25.8125Z" fill="white"></path>
											</g>
										</g>
										</g>
										<defs>
										<linearGradient id="c631fb2424936253666f90eb3c760e43" x1="0" y1="0" x2="100" y2="100" gradientUnits="userSpaceOnUse">
											<stop stop-color="#EDEF83"></stop>
											<stop offset="1" stop-color="#00D6AF"></stop>
										</linearGradient>
										</defs>
									</svg>',
					'price'       => '$39',
					'guide_link'  => 'https://plugins.miniorange.com/otp-verification-for-selected-countries',
					'support_msg' => 'Hi I am interested in the OTP Verification for Selected Countries Only addon, could you please tell me more about this addon?',
				),
				'verification_using_email_link' => array(
					'name'              => 'Verification via Email Link instead of One time Passcode',
					'description'       => array(
						mo_( 'Verification via email links' ),
						mo_( 'Verify by clicking on accept or decline links sent over email instead of OTP' ),
						mo_( 'Supported in the free plugin only' ),
					),
					'svg'               => '<svg width="50" height="50" viewBox="0 0 100 100" fill="none" >
										<g id="d793a5c7f1276bb8bd96ed3a45fc2ba1">
										<rect width="100" height="100" rx="10" fill="url(#429fd1d4aa4ecddb39c430be9baf1ab8)"></rect>
										<g id="39642c8164731a0c117c0148c6bf5978">
											<path id="8f236ae67414afd6bb621c61fb227f5e" fill-rule="evenodd" clip-rule="evenodd" d="M56.629 43.3717C57.3613 44.104 57.3613 45.2911 56.629 46.0234L46.0224 56.63C45.2902 57.3622 44.103 57.3622 43.3708 56.63C42.6386 55.8977 42.6386 54.7106 43.3708 53.9783L53.9774 43.3717C54.7096 42.6395 55.8968 42.6395 56.629 43.3717Z" fill="black"></path>
											<path id="aba512741839dadd8362e312019f69c0" fill-rule="evenodd" clip-rule="evenodd" d="M65.3408 34.6595C61.4706 30.7893 55.1959 30.7893 51.3257 34.6595L47.159 38.8262C46.4268 39.5584 45.2396 39.5584 44.5074 38.8262C43.7751 38.094 43.7751 36.9068 44.5074 36.1745L48.674 32.0078C54.0087 26.6732 62.6578 26.6732 67.9925 32.0078C73.3271 37.3425 73.3271 45.9916 67.9925 51.3263L63.8258 55.493C63.0935 56.2252 61.9064 56.2252 61.1741 55.493C60.4419 54.7607 60.4419 53.5735 61.1741 52.8413L65.3408 48.6746C69.211 44.8044 69.211 38.5297 65.3408 34.6595Z" fill="black"></path>
											<path id="2041639debf797014dd7a0c568732528" fill-rule="evenodd" clip-rule="evenodd" d="M34.6589 65.3405C38.5291 69.2107 44.8039 69.2107 48.6741 65.3405L52.8408 61.1738C53.573 60.4416 54.7602 60.4416 55.4924 61.1738C56.2246 61.906 56.2246 63.0932 55.4924 63.8255L51.3257 67.9922C45.9911 73.3268 37.3419 73.3268 32.0073 67.9922C26.6727 62.6575 26.6727 54.0084 32.0073 48.6737L36.174 44.507C36.9062 43.7748 38.0934 43.7748 38.8256 44.507C39.5579 45.2393 39.5579 46.4265 38.8256 47.1587L34.6589 51.3254C30.7888 55.1956 30.7888 61.4703 34.6589 65.3405Z" fill="black"></path>
										</g>
										</g>
										<defs>
										<linearGradient id="429fd1d4aa4ecddb39c430be9baf1ab8" x1="0" y1="0" x2="100" y2="100" gradientUnits="userSpaceOnUse">
											<stop stop-color="#5DECFF"></stop>
											<stop offset="1" stop-color="#1CE7C2"></stop>
										</linearGradient>
										</defs>
									</svg>',
					'price'             => '$49',
					'guide_link'        => '',
					'guide_request_msg' => 'Hi! I am interested in the Verification via Email Link instead of One time Passcode addon, could you please tell me more about this addon?',
					'support_msg'       => 'Hi! Could you please share the payment details for the Verification via Email Link instead of One time Passcode addon?',
				),
				'api_otp_verification_addon'    => array(
					'name'              => 'OTP Verification for Android/IOS Application',
					'description'       => array(
						mo_( 'Get APIs to connect WordPress site and mobile application' ),
						mo_( 'API for Send OTP' ),
						mo_( 'API for Verify OTP' ),
					),
					'svg'               => '<svg width="50" height="50" viewBox="0 0 100 100" fill="none">
										<g id="7e95c2d921a95088816629c37b6984aa">
										<rect width="100" height="100" rx="10" fill="url(#6883cbcb1edf8e76de86908e841df169)"></rect>
										<g id="e7c3768e5f96e7ff7b6e3ecc4f149e28">
											<g id="edd8777e157c12a43d313e76c141f96c">
											<path id="86428f1dfb81a502ab48f6dd9ff2420e" fill-rule="evenodd" clip-rule="evenodd" d="M32 27.5C29.5147 27.5 27.5 29.5147 27.5 32V41C27.5 43.4853 29.5147 45.5 32 45.5H41C43.4853 45.5 45.5 43.4853 45.5 41V32C45.5 29.5147 43.4853 27.5 41 27.5H32ZM36.5 72.5C41.4706 72.5 45.5 68.4706 45.5 63.5C45.5 58.5294 41.4706 54.5 36.5 54.5C31.5294 54.5 27.5 58.5294 27.5 63.5C27.5 68.4706 31.5294 72.5 36.5 72.5ZM54.5 59C54.5 56.5147 56.5147 54.5 59 54.5H68C70.4853 54.5 72.5 56.5147 72.5 59V68C72.5 70.4853 70.4853 72.5 68 72.5H59C56.5147 72.5 54.5 70.4853 54.5 68V59ZM64.625 29.1875C64.625 28.2555 63.8695 27.5 62.9375 27.5C62.0055 27.5 61.25 28.2555 61.25 29.1875V35.375H55.0625C54.1305 35.375 53.375 36.1305 53.375 37.0625C53.375 37.9945 54.1305 38.75 55.0625 38.75H61.25V44.9375C61.25 45.8695 62.0055 46.625 62.9375 46.625C63.8695 46.625 64.625 45.8695 64.625 44.9375V38.75H70.8125C71.7445 38.75 72.5 37.9945 72.5 37.0625C72.5 36.1305 71.7445 35.375 70.8125 35.375H64.625V29.1875Z" fill="white"></path>
											</g>
										</g>
										</g>
										<defs>
										<linearGradient id="6883cbcb1edf8e76de86908e841df169" x1="0" y1="0" x2="100" y2="100" gradientUnits="userSpaceOnUse">
											<stop stop-color="#47DEFF"></stop>
											<stop offset="1" stop-color="#1653EF"></stop>
										</linearGradient>
										</defs>
									</svg>',
					'price'             => '$89',
					'guide_link'        => '',
					'guide_request_msg' => 'Hi! I am interested in the OTP Verification for Android/IOS Application addon, could you please tell me more about this addon?',
					'support_msg'       => 'Hi! Could you please share the payment details for the  OTP Verification for Android/IOS Application addon?',
				),
			);

			$this->premium_forms = array(
				'ELEMENTOR_PRO'                 => array(
					'name'      => 'Elementor Pro Forms ',
					'plan_name' => 'Enterprise Plan',
				),
				'USERREG'                       => array(
					'name'      => 'User Registration Forms - WP Everest ',
					'plan_name' => 'Twilio Gateway Plan',
				),
				'JETENGINEFORM'                 => array(
					'name'      => 'Jet Engine Form ',
					'plan_name' => 'Enterprise Plan',
				),
				'WCFM'                          => array(
					'name'      => 'WooCommerce Frontend Manager Form (WCFM) ',
					'plan_name' => 'Enterprise Plan',
				),
				'HOUZEZ_REG'                    => array(
					'name'      => 'Houzez - Real Estate Theme ',
					'plan_name' => 'Enterprise Plan',
				),
				'TUTOR_LMS_LOGIN'               => array(
					'name'      => 'Tutor LMS Login Form ',
					'plan_name' => 'Twilio Gateway Plan',
				),
				'TUTOR_LMS_INSTRUCTOR_REG_FORM' => array(
					'name'      => 'Tutor LMS Instructor Registration Form ',
					'plan_name' => 'Twilio Gateway Plan',
				),
				'TUTOR_LMS_STUDENT_REG_FORM'    => array(
					'name'      => 'Tutor LMS Student Registration Form ',
					'plan_name' => 'Twilio Gateway Plan',
				),
				'CHECKOUT_WC'                   => array(
					'name'      => 'Checkout WC Form ',
					'plan_name' => 'Woocommerce OTP and Notification Plan',
				),

			);

		}


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

		/**
		 * Function called to get the premium form list
		 */
		public function get_premium_forms() {
			return $this->premium_forms; }

	}
}
