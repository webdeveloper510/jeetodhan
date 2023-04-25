<?php
/**
 * Load admin view for WooCommerceBillingForm.
 *
 * @package miniorange-otp-verification/views/forms
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

echo '	<div class="mo_otp_form" id="' . esc_attr( get_mo_class( $handler ) ) . '">
	        <input  type="checkbox" ' . esc_attr( $disabled ) . ' 
	                id="wc_billing" 
	                class="app_enable"  
					data-toggle="wc_billing_options" 
					name="mo_customer_validation_wc_billing_enable" 
					value="1"
					' . esc_attr( $wc_billing_enable ) . ' />
			<strong>' . esc_html( mo_( 'Woocommerce Billing Form' ) ) . '</strong>';

echo '		<div class="mo_registration_help_desc" ' . esc_attr( $wc_billing_hidden ) . ' id="wc_billing_options">
				<b>' . esc_html( mo_( 'Choose between Phone or Email Verification' ) ) . '</b>
				<p>
				    <input  type="radio" ' . esc_attr( $disabled ) . ' 
				            id="wc_billing_phone" 
				            class="app_enable" 
				            name="mo_customer_validation_wc_billing_type_enabled" 
				            value="' . esc_attr( $wc_billing_type_phone ) . '"
						    ' . ( esc_attr( $wc_billing_type_enabled ) === esc_attr( $wc_billing_type_phone ) ? 'checked' : '' ) . ' />
                    <strong>' . esc_html( mo_( 'Enable Phone Verification' ) ) . '</strong>
				</p>
				<p>
				    <input  type="radio" ' . esc_attr( $disabled ) . ' 
				            id="wc_billing_email" 
				            class="app_enable" 
				            name="mo_customer_validation_wc_billing_type_enabled" 
				            value="' . esc_attr( $wc_billing_type_email ) . '"
						    ' . ( esc_attr( $wc_billing_type_enabled ) === esc_attr( $wc_billing_type_email ) ? 'checked' : '' ) . ' />
                    <strong>' . esc_html( mo_( 'Enable Email Verification' ) ) . '</strong>
				</p>
				<p>
				    <input  type="checkbox" ' . esc_attr( $disabled ) . ' 
				            name="mo_customer_validation_wc_billing_restrict_duplicates" 
				            value="1"
				            ' . esc_attr( $wc_restrict_duplicates ) . ' />
                    <strong>' .
					esc_html( mo_( 'Do not allow users to use the same Phone number or Email for multiple accounts.' ) ) .
					'</strong>
				</p>
		</div></div>';
