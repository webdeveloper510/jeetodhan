<?php
/**
 * Load admin view for formidable form.
 *
 * @package miniorange-otp-verification/handler
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use OTP\Helper\MoUtility;

echo '		<div class="mo_otp_form" id="' . esc_attr( get_mo_class( $handler ) ) . '"><input type="checkbox" ' . esc_attr( $disabled ) . ' id="formMaker" class="app_enable"
                data-toggle="formMaker_form_options" name="mo_customer_validation_fm_enable" value="1"
                    ' . esc_attr( $form_maker_form_enabled ) . ' /><strong>' . esc_html( $form_name ) . '</strong>';

echo '       <div class = "mo_registration_help_desc" ' . esc_attr( $form_maker_form_hidden ) . '  id="formMaker_form_options">
                <p><input type="radio" ' . esc_attr( $disabled ) . ' id="formMaker_form_email" class="app_enable" data-toggle="fme_instructions"
                    name="mo_customer_validation_fm_enable_type" value="' . esc_attr( $form_maker_form_type_email ) . '"
                    ' . ( esc_attr( $form_maker_form_enabled_type ) === esc_attr( $form_maker_form_type_email ) ? 'checked' : '' ) . ' />
                    <strong>' . esc_html( mo_( 'Enable Email Verification' ) ) . '</strong>
                </p>
                <div ' . ( esc_attr( $form_maker_form_enabled_type ) !== esc_attr( $form_maker_form_type_email ) ? 'hidden' : '' ) . ' class ="mo_registration_help_desc" id="fme_instructions">
                    ' . esc_html( mo_( 'Follow the following steps to enable Email Verification for Form Maker Forms' ) ) . '
                    <ol>
                    <li><a href="' . esc_url( $formmaker_form_list ) . '" target="_blank">' . esc_html( mo_( 'Click Here' ) ) . '</a> ' . esc_html( mo_( ' to see your list of Form Maker forms' ) ) . '</li>
                    <li>' . wp_kses( mo_( 'Click on the <b>Edit</b> option of your Form Maker form.' ), array( 'b' => array() ) ) . '</li>
                    <li>' . esc_html( mo_( 'Add an Email Field to your form. Note the Field label of the email field.' ) ) . '</li>
                    <li>' . esc_html( mo_( 'Add a Verification Field to your form where users will enter the OTP received. Keep the field required. Note the Field label of the verification field.' ) ) . '</li>
                    <li>' . esc_html( mo_( 'Enter your Form ID, the Email Field label and the Verification Field label below' ) ) . ':<br>
                        <br/>' . esc_html( mo_( 'Add Form ' ) ) . ': <input type="button"  value="+" ' . esc_attr( $disabled ) . ' onclick="add_formmaker(\'email\',1);" class="button button-primary" />&nbsp;
                                                    <input type="button" value="-" ' . esc_attr( $disabled ) . ' onclick="remove_formmaker(1);" class="button button-primary" /><br/><br/>';

						$form_results = get_multiple_form_select( $form_maker_form_otp_enabled, true, true, $disabled, 1, 'formmaker', 'Label' );
						$counter1     = ! MoUtility::is_blank( $form_results['counter'] ) ? max( $form_results['counter'] - 1, 0 ) : 0;

echo '					</li>
                        <li>' . esc_html( mo_( 'Click on the Save Button below to save your settings' ) ) . '</li>
                    </ol>
                </div>

                <p><input type="radio" ' . esc_attr( $disabled ) . ' id="formMaker_form_phone" class="app_enable" data-toggle="fmp_instructions"
                    name="mo_customer_validation_fm_enable_type" value="' . esc_attr( $form_maker_form_type_phone ) . '"
                    ' . ( esc_attr( $form_maker_form_enabled_type ) === esc_attr( $form_maker_form_type_phone ) ? 'checked' : '' ) . ' />
                    <strong>' . esc_html( mo_( 'Enable Phone Verification' ) ) . '</strong>
                </p>
                <div ' . ( esc_attr( $form_maker_form_enabled_type ) !== esc_attr( $form_maker_form_type_phone ) ? 'hidden' : '' ) . ' class ="mo_registration_help_desc" id="fmp_instructions">
                     ' . esc_html( mo_( 'Follow the following steps to enable Phone Verification for Form Maker Forms' ) ) . ' 
                     <ol>
                     <li><a href="' . esc_url( $formmaker_form_list ) . '" target="_blank">' . esc_html( mo_( 'Click Here' ) ) . '</a> ' . esc_html( mo_( ' to see your list of Form Maker forms' ) ) . '</li>
                     <li>' . wp_kses( mo_( 'Click on the <b>Edit</b> option of your Form Maker form.' ), array( 'b' => array() ) ) . '</li>
                     <li>' . esc_html( mo_( 'Add an Phone Field to your form. Note the Field label of the Phone field.' ) ) . '</li>
                     <li>' . esc_html( mo_( 'Add a Verification Field to your form where users will enter the OTP received. Keep the field required. Note the Field label of the verification field.' ) ) . '</li>
                     <li>' . esc_html( mo_( 'Enter your Form ID, the Phone Field label and the Verification Field label below' ) ) . ':<br>
                        <br/>' . esc_html( mo_( 'Add Form ' ) ) . ': <input type="button"  value="+" ' . esc_attr( $disabled ) . ' onclick="add_formmaker(\'phone\',2);" class="button button-primary" />&nbsp;
                                                    <input type="button" value="-" ' . esc_attr( $disabled ) . ' onclick="remove_formmaker(2);" class="button button-primary" /><br/><br/>';

						$form_results = get_multiple_form_select( $form_maker_form_otp_enabled, true, true, $disabled, 2, 'formmaker', 'Label' );
						$counter2     = ! MoUtility::is_blank( $form_results['counter'] ) ? max( $form_results['counter'] - 1, 0 ) : 0;

echo '       			</li>
                        <li>' . esc_html( mo_( 'Click on the Save Button below to save your settings' ) ) . '</li>
                    </ol>
                </div>
                <p style="margin-left:2%;">
					<i><b>' . esc_html( mo_( 'Verification Button text' ) ) . ':</b></i>
					<input class="mo_registration_table_textbox" name="mo_customer_validation_fm_button_text" type="text" value="' . esc_attr( $button_text ) . '">
				</p>
            </div>
        </div>';

		multiple_from_select_script_generator( true, true, 'formmaker', 'Label', array( $counter1, $counter2, 0 ) );





