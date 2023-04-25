<?php
/**
 * Load admin view for WooCommerceCheckoutForm.
 *
 * @package miniorange-otp-verification/views/forms
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use OTP\Helper\MoMessages;

echo ' 	<div class="mo_otp_form" id="' . esc_attr( get_mo_class( $handler ) ) . '">
 	        <input  type="checkbox" ' . esc_attr( $disabled ) . ' 
 	                id="wc_checkout" 
 	                data-toggle="wc_checkout_options" 
 	                class="app_enable" 
 	                name="mo_customer_validation_wc_checkout_enable" 
 	                value="1" 
 	                ' . esc_attr( $wc_checkout ) . ' />
            <strong>' . esc_html( $form_name ) . '</strong>';

echo '		<div class="mo_registration_help_desc" ' . esc_attr( $wc_checkout_hidden ) . ' id="wc_checkout_options">
				<b>' . esc_html( mo_( 'Choose between Phone or Email Verification' ) ) . '</b>
				<p>
				    <input  type="radio" ' . esc_attr( $disabled ) . ' 
				            id="wc_checkout_phone" 
				            class="app_enable" 
				            data-toggle="wc_checkout_phone_options"
				            name="mo_customer_validation_wc_checkout_type" 
				            value="' . esc_attr( $wc_type_phone ) . '"
						    ' . ( esc_attr( $wc_checkout_enable_type ) === esc_attr( $wc_type_phone ) ? 'checked' : '' ) . ' />
                    <strong>' . esc_html( mo_( 'Enable Phone Verification' ) ) . '</strong>
				</p>
				<div    ' . ( esc_attr( $wc_checkout_enable_type ) !== esc_attr( $wc_type_phone ) ? 'hidden' : '' ) . ' 
                        class="mo_registration_help_desc" 
						id="wc_checkout_phone_options" >
                    <input  type="checkbox" ' . esc_attr( $disabled ) . ' 
                            name="mo_customer_validation_wc_checkout_restrict_duplicates" 
                            value="1"
                            ' . esc_attr( $restrict_duplicates ) . ' />
                    <strong>' . esc_html( mo_( 'Do not allow users to use the same phone number for multiple accounts.' ) ) . '</strong>
				</div>
				<p>
				    <input  type="radio" ' . esc_attr( $disabled ) . ' 
				            id="wc_checkout_email" 
				            class="app_enable" 
				            name="mo_customer_validation_wc_checkout_type" 
				            value="' . esc_attr( $wc_type_email ) . '"
						    ' . ( esc_attr( $wc_checkout_enable_type ) === esc_attr( $wc_type_email ) ? 'checked' : '' ) . ' />
                    <strong>' . esc_html( mo_( 'Enable Email Verification' ) ) . '</strong>
				</p>
				<p style="margin-top:3%;">
					<input  type="checkbox" 
					        ' . esc_attr( $disabled ) . ' 
					        ' . esc_attr( $guest_checkout ) . ' 
					        class="app_enable" 
					        name="mo_customer_validation_wc_checkout_guest" 
					        value="1" >
                    <b>' . esc_html( mo_( 'Enable Verification only for Guest Users.' ) ) . '</b>';

				mo_draw_tooltip(
					MoMessages::showMessage( MoMessages::WC_GUEST_CHECKOUT_HEAD ),
					MoMessages::showMessage( MoMessages::WC_GUEST_CHECKOUT_BODY )
				);

				echo '
				</p>
				<p>
					<input  type="checkbox" 
					        ' . esc_attr( $disabled ) . ' 
					        ' . esc_attr( $disable_autologin ) . ' 
					        class="app_enable" 
					        name="mo_customer_validation_wc_checkout_disable_auto_login" 
					        value="1" 
					        type="checkbox">
                    <b>' . esc_html( mo_( 'Disable Auto Login after checkout.' ) ) . '</b>
                    <br/>
				</p>
				<p>
					<input  type="checkbox" 
					        ' . esc_attr( $disabled ) . ' 
					        ' . esc_attr( $checkout_button ) . ' 
					        class="app_enable" 
					        name="mo_customer_validation_wc_checkout_button" 
					        value="1" 
					        type="checkbox">
                    <b>' . esc_html( mo_( 'Show a verification button instead of a link on the WooCommerce Checkout Page.' ) ) . '</b>
                    <br/>
				</p>
				<p>
					<input  type="checkbox" 
					        ' . esc_attr( $disabled ) . ' 
					        ' . esc_attr( $checkout_popup ) . ' 
					        class="app_enable" 
					        name="mo_customer_validation_wc_checkout_popup" 
					        value="1" 
					        type="checkbox">
                    <b>' . esc_html( mo_( 'Show a popup for validating OTP.' ) ) . '</b>
                    <br/>
				</p>
				<p>
					<input  type="checkbox" 
					        ' . esc_attr( $disabled ) . '
					        ' . esc_attr( $checkout_selection ) . ' 
					        class="app_enable" 
					        data-toggle="selective_payment" 
					        name="mo_customer_validation_wc_checkout_selective_payment" 
					        value="1" 
					        type="checkbox">
                    <b>' . esc_html( mo_( 'Validate OTP for selective Payment Methods.' ) ) . '</b>
                    <br/>
				</p>
				<div id="selective_payment" class="mo_registration_help_desc" 
				     ' . esc_attr( $checkout_selection_hidden ) . ' style="padding-left:3%;">
					<b>
					    <label for="wc_payment" style="vertical-align:top;">' .
							esc_html( mo_( 'Select Payment Methods (Hold Ctrl Key to Select multiple):' ) ) .
						'</label> 
                    </b>
				';

				get_wc_payment_dropdown( $disabled, $checkout_payment_plans );

				echo '
				</div>
				<p>
					<i><b>' . esc_html( mo_( 'Verification Button text' ) ) . ':</b></i>
					<input  class="mo_registration_table_textbox" 
					        name="mo_customer_validation_wc_checkout_button_link_text" 
					        type="text" 
					        value="' . esc_attr( $button_text ) . '">					
				</p>
			</div>
		</div>';
