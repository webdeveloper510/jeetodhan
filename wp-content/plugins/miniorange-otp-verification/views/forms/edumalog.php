<?php
/**
 * Load admin view for Eduma Login form.
 *
 * @package miniorange-otp-verification/views
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

echo '	<div class="mo_otp_form" id="' . esc_attr( get_mo_class( $handler ) ) . '">' .
		'<input type="checkbox" 
                ' . esc_attr( $disabled ) . ' 
                id="edumalog_default" 
                class="app_enable" 
                data-toggle="edumalog_options" 
                name="mo_customer_validation_edumalog_enable" 
                value="1"
	        ' . esc_attr( $edumalog_enabled ) . ' />
        <strong>' . esc_html( $form_name ) . '</strong>';

echo '		<div class="mo_registration_help_desc" ' . esc_attr( $edumalog_hidden ) . '
          id="edumalog_options">
				  <b>' . esc_html( mo_( 'Choose between Phone or Email Verification' ) ) . '</b>
				  <p>
					 <input  type="radio" ' . esc_attr( $disabled ) . ' id="edumalog_phone" class="app_enable" 
            data-toggle="edumalog_phone_options" name="mo_customer_validation_edumalog_enable_type" value="' . esc_attr( $edumalog_type_phone ) . '" ' . ( esc_attr( $edumalog_enabled_type ) === esc_attr( $edumalog_type_phone ) ? 'checked' : '' ) . '/>
          
            <strong>' . esc_html( mo_( 'Enable Phone Verification' ) ) . '</strong>
          </p>
                  
          <div ' . ( esc_attr( $edumalog_enabled_type ) !== esc_attr( $edumalog_type_phone ) ? 'hidden' : '' ) . ' class="mo_registration_help_desc" id="edumalog_phone_options"">
            <p>
              ' . esc_html( mo_( 'Enter the phone User Meta Key' ) );
echo '        <input    class="mo_registration_table_textbox"
                id="mo_customer_validation_wpf_login_phone_field_key"
                name="mo_customer_validation_edumalog_phone_field_key"
                type="text"
                value="' . esc_attr( $edumalog_phone_field_key ) . '"> 

              <div class="mo_otp_note" style="margin-top:1%">
                ' . esc_html(
					mo_(
						"If you don't know the metaKey against which the phone number " .
						'is stored for all your users then put the default value as telephone.'
					)
				) . '
              </div>                 
            </p>
          </div>
				  <p>
  				  <input  type="radio" ' . esc_attr( $disabled ) . ' id="edumalog_email" class="app_enable" 
  					 name="mo_customer_validation_edumalog_enable_type" value="' . esc_attr( $edumalog_type_email ) . '" ' . ( esc_attr( $edumalog_enabled_type ) === esc_attr( $edumalog_type_email ) ? 'checked' : '' ) . '/>
            <strong>' . esc_html( mo_( 'Enable Email Verification' ) ) . '</strong>
				  </p>
				  <p>
            <input  type="checkbox" ' . esc_attr( $disabled ) . ' class="app_enable"
              data-toggle="mo_send_bypss_password"
              name="mo_customer_validation_edumalog_bypass_admin"
              value="1" ' . esc_attr( $edumalog_log_bypass ) . ' />
            <strong>' . esc_html( mo_( 'Allow the administrator to bypass OTP verification during login.' ) ) . '</strong>
          </p>           
			  </div>
		  </div>';
