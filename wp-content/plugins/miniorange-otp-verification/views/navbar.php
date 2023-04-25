<?php
/**
 * Load admin view for Account Tab.
 *
 * @package miniorange-otp-verification/views
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

echo '	<div class="wrap">
			<div><img style="float:left;" src="' . esc_url( MOV_LOGO_URL ) . '"></div>
			<div class="otp-header">
				' . esc_html( mo_( 'OTP Verification' ) ) . '
				<a class="add-new-h2" id="accountButton" href="' . esc_url( $profile_url ) . '">' . esc_html( mo_( 'Account' ) ) . '</a>
                <a class="add-new-h2" id="LicensingPlanButton" style="background-color:orange;color:black;" href="' . esc_url( $license_url ) . '">' . esc_html( mo_( 'Licensing Plans' ) ) . '</a>
				<a class="add-new-h2" id="faqButton" href="' . esc_url( $help_url ) . '" target="_blank">' . esc_html( mo_( 'FAQs' ) ) . '</a>';


echo '          <a class="mo-otp-demo add-new-h2" onClick="otpSupportOnClick(\'Hi! I am interested in using your plugin and would like to get a demo of the features and functionality. Please schedule a demo for the plugin. \');" id="demoButton">' . esc_html( mo_( 'Need a Demo?' ) ) . '</a>
	            <div class="mo-otp-help-button static" style="z-index:10">';

echo '

                    <a id="show_prem_addons_button" class="button button-primary button-large" style="background:orange;color:black">
                        <span class="dashicons dashicons-admin-tools" style="margin:5% 0 0 0;"></span>
                            ' . esc_html( mo_( 'Premium Addons' ) ) . '
                    </a>';
if ( $is_logged_in && $is_free_plugin ) {
	echo '
                     <a id="mo_check_transactions" class="button button-primary button-large">
                            <span class="dashicons dashicons-visibility" style="margin:5% 0 0 0;"></span>
                                ' . esc_html( mo_( 'View Transactions' ) ) . '
                    </a>';
}



echo '
                </div>
            </div>
		<form id="mo_check_transactions_form" style="display:none;" action="" method="post">';

			wp_nonce_field( 'mo_check_transactions_form', '_nonce' );
echo '<input type="hidden" name="option" value="mo_check_transactions" />
        </form></div>';

echo '	<div id="tab">
			<h2 class="nav-tab-wrapper">';

foreach ( $tab_details->tab_details as $motabs ) {
	if ( $motabs->show_in_nav ) {
		echo '<a  class="nav-tab 
                        ' . ( $active_tab === $motabs->menu_slug ? 'nav-tab-active' : '' ) . '" 
                        href="' . esc_url( $motabs->url ) . '"            
                        style="' . esc_attr( $motabs->css ) . '"
                        id="' . esc_attr( $motabs->id ) . '">
                        ' . esc_attr( $motabs->tab_name ) . '
                    </a>';
	}
}

		echo '</h2>';

if ( ! $registered ) {
	echo '<div  style="background-color:rgba(255,5,0,0.29);font-size:0.9em;" 
                        class="notice notice-error">
                        <h2>' . wp_kses( $register_msg, array( 'a' => array( 'href' => array() ) ) ) . '</h2>
                  </div>';
} elseif ( ! $activated ) {
	echo '<div  style="background-color:rgba(255,5,0,0.29);font-size:0.9em;" 
                        class="notice notice-error">
                        <h2>' . wp_kses( $activation_msg, array( 'a' => array( 'href' => array() ) ) ) . '</h2>
                  </div>';
} elseif ( ! $gatewayconfigured ) {
	echo '<div  style="background-color:rgba(255,5,0,0.29);font-size:0.9em;" 
                        class="notice notice-error">
                        <h2>' . wp_kses( $gateway_msg, array( 'a' => array( 'href' => array() ) ) ) . '</h2>
                  </div>';
}
if ( 'mo_hide_sms_notice' !== $is_sms_notice_closed ) {
	echo '<div  style="background-color:#ffffff;font-size:0.9em; border-left-color: #6088ff;"
                        class="notice mo_sms_notice is-dismissible">
                        <h2>Due to recent changes in the SMS Delivery rules by the government of some countries like UAE, Singapore, Israel, etc , you might face issues with SMS Delivery. In this case, contact us at <a style="cursor:pointer;" onclick="otpSupportOnClick();">otpsupport@xecurify.com</a>.</h2>
          </div>';
}
