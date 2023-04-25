<?php
/**
 * Load admin view for Contact form 7.
 *
 * @package miniorange-otp-verification/views
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

echo '		<div class="mo_otp_form" id="' . esc_attr( get_mo_class( $handler ) ) . '">
		        <input  type="checkbox" ' . esc_attr( $disabled ) . ' 
                        id="cf7_contact" 
                        class="app_enable" 
                        data-toggle="cf7_contact_options" 
                        name="mo_customer_validation_cf7_contact_enable" 
                        value="1" ' . esc_attr( $cf7_enabled ) . ' /><strong>' . esc_html( $form_name ) . '</strong>';

echo '			<div class="mo_registration_help_desc" ' . esc_attr( $cf7_hidden ) . ' id="cf7_contact_options">
                    <p><input type="radio" ' . esc_attr( $disabled ) . ' id="cf7_contact_email" class="app_enable" 
                        data-toggle="cf7_contact_email_instructions" name="mo_customer_validation_cf7_contact_type" 
                        value="' . esc_attr( $cf7_type_email ) . '"
                        ' . ( esc_attr( $cf7_enabled_type ) === esc_attr( $cf7_type_email ) ? 'checked' : '' ) . ' /><strong>
                        ' . esc_html( mo_( 'Enable Email verification' ) ) . '</strong>
                    </p>
                    <div ' . ( esc_attr( $cf7_enabled_type ) !== esc_attr( $cf7_type_email ) ? 'hidden' : '' ) . ' class="mo_registration_help_desc" 
                            id="cf7_contact_email_instructions" >
                            ' . esc_html( mo_( 'Follow the following steps to enable Email Verification for' ) ) . '
                            Contact form 7: 
                            <ol>
                                <li>
                                    <a href="' . esc_url( $page_list ) . '" target="_blank">' . esc_html( mo_( 'Click Here' ) ) . '</a> ' .
									esc_html( mo_( 'to see your list of pages.' ) ) . '
                                </li>
                                <li>' . wp_kses( mo_( 'Click on the <b>Edit</b> option of the page which has your contact form.' ), array( 'b' => array() ) ) . '</li>
                                <li>
                                    ' . esc_html( mo_( 'Add the following short code just below your Contact Form 7 shortcode' ) ) . ': <code>[mo_verify_email]</code> 
                                </li>
                                <li><a href="' . esc_url( $cf7_field_list ) . '" target="_blank">' . esc_html( mo_( 'Click Here' ) ) . '</a>'
									. esc_html( mo_( ' to see your list of Contact Forms.' ) ) . '</li>
                                <li>' . wp_kses( mo_( 'Click on the <b>Edit</b> option of your form.' ), array( 'b' => array() ) ) . '</li>
                                <li>
                                    ' . esc_html(
									mo_( 'Now place the following code in your form where you wish to ' ) .
											'show the Verify Email button and field '
								) . ': <br>
                                    <pre>&lt;div style="margin-bottom:3%"&gt;<br/>&lt;input type="button" class="button alt" style="width:100%" id="miniorange_otp_token_submit" title="' . esc_attr( mo_( 'Please Enter an Email Address to enable this.' ) ) . '" value="' . esc_html( mo_( 'Click here to verify your Email' ) ) . '"&gt;&lt;div id="mo_message" hidden="" style="background-color: #f7f6f7;padding: 1em 2em 1em 3.5em;"&gt;&lt;/div&gt;<br/>&lt;/div&gt;<br/><br/>&lt;p&gt;' . esc_html( mo_( 'Verify Code (required)' ) ) . ' &lt;br /&gt;<br/>	[text* email_verify]&lt;/p&gt;</pre>
                                </li>
                                <li>' . esc_html( mo_( 'Enter the name of the email field below' ) ) . ': <input class="mo_registration_table_textbox" id="mo_customer_validation_cf7_email_field_key" name="mo_customer_validation_cf7_email_field_key" type="text" value="' . esc_attr( $cf7_field_key ) . '">
                                    <div class="mo_otp_note">' . esc_html( mo_( ' Name of the Email Field is the value after email* in your Contact Form 7 form.' ) ) . ' <br/><i>' . esc_html( mo_( 'For Reference' ) ) . ': [ email* &lt;name of your email field&gt; ]</i></div>
                                </li>
                                <li>' . esc_html( mo_( 'Click on the Save Button to save your settings' ) ) . '</li>
                            </ol>
                    </div>
                    <p><input type="radio" ' . esc_attr( $disabled ) . ' id="cf7_contact_phone" class="app_enable" data-toggle="cf7_contact_phone_instructions" name="mo_customer_validation_cf7_contact_type" value="' . esc_attr( $cf7_type_phone ) . '"
                        ' . ( esc_attr( $cf7_enabled_type ) === esc_attr( $cf7_type_phone ) ? 'checked' : '' ) . ' /><strong>' . esc_html( mo_( 'Enable Phone verification' ) ) . '</strong>
                    </p>
                    <div ' . ( esc_attr( $cf7_enabled_type ) !== esc_attr( $cf7_type_phone ) ? 'hidden' : '' ) . ' class="mo_registration_help_desc" id="cf7_contact_phone_instructions" >
                            ' . esc_html( mo_( 'Follow the following steps to enable Phone Verification for Contact form 7' ) ) . ': 
                            <ol>
                                <li><a href="' . esc_url( $page_list ) . '" target="_blank">' . esc_html( mo_( 'Click Here' ) ) . '</a> ' . esc_html( mo_( 'to see your list of pages.' ) ) . '</li>
                                <li>' . wp_kses( mo_( 'Click on the <b>Edit</b> option of the page which has your contact form.' ), array( 'b' => array() ) ) . '</li>
                                <li>' . esc_html( mo_( 'Add the following short code just below your Contact Form 7 shortcode ' ) ) . ': <code>[mo_verify_phone]</code> </li>
                                <li><a href="' . esc_url( $cf7_field_list ) . '" target="_blank">' . esc_html( mo_( 'Click Here' ) ) . '</a> ' . esc_html( mo_( ' to see your list of Contact Forms.' ) ) . '</li>
                                <li>' . wp_kses( mo_( 'Click on the <b>Edit</b> option of your form.' ), array( 'b' => array() ) ) . '</li>
                                <li>
                                    ' . esc_html( mo_( 'Now place the following code in your form where you wish to show the Verify Phone button and field ' ) ) . ': <br>
                                    <pre>&lt;p&gt;' . esc_html( mo_( 'Phone Number (required)' ) ) . ' &lt;br /&gt;<br/>	[tel* mo_phone class:mo_phone]&lt;/p&gt;<br /><br/>&lt;div style="margin-bottom:3%"&gt;<br/>&lt;input type="button" class="button alt" style="width:100%" id="miniorange_otp_token_submit" title="' . esc_attr( mo_( 'Please Enter a phone number to enable this.' ) ) . '" value="' . esc_html( mo_( 'Click here to verify your Phone' ) ) . '"&gt;&lt;div id="mo_message" hidden="" style="background-color: #f7f6f7;padding: 1em 2em 1em 3.5em;"&gt;&lt;/div&gt;<br/>&lt;/div&gt;<br/><br/>&lt;p&gt;' . esc_html( mo_( 'Verify Code (required)' ) ) . '&lt;br /&gt;<br/>	[text* phone_verify]&lt;/p&gt;</pre>
                                </li>
                                <li>' . esc_html( mo_( 'Click on the Save Button to save your settings' ) ) . '</li>
                            </ol>
                    </div>
                </div>
            </div>';
