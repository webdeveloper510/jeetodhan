<?php
/**
 * Load admin view for Default Registration form.
 *
 * @package miniorange-otp-verification/views
 */

use OTP\Helper\MoMessages;

echo '	<div class="mo_otp_form" id="' . esc_attr( get_mo_class( $handler ) ) . '"><input type="checkbox" ' . esc_attr( $disabled ) . ' id="wp_default" class="app_enable" data-toggle="wp_default_options" 
                name="mo_customer_validation_wp_default_enable" value="1"
			' . esc_attr( $default_registration ) . ' /><strong>' . esc_html( $form_name ) . '</strong>';

echo '		<div class="mo_registration_help_desc" ' . esc_attr( $wp_default_hidden ) . ' id="wp_default_options">';

echo '
                <p>
					<input type="checkbox" ' . esc_attr( $disabled ) . ' ' . esc_attr( $auto_activate_users ) . ' class="app_enable" name="mo_customer_validation_wp_reg_auto_activate" 
					    value="1" type="checkbox"><b>' . esc_html( mo_( 'Auto Activate Users.' ) ) . '</b>';

				mo_draw_tooltip(
					MoMessages::showMessage( MoMessages::AUTO_ACTIVATE_HEAD ),
					MoMessages::showMessage( MoMessages::AUTO_ACTIVATE_BODY )
				);

				echo '           <br/>
				</p>
				<b>' . esc_html( mo_( 'Choose between Phone or Email Verification' ) ) . '</b>
				<p>
					<input type="radio" ' . esc_attr( $disabled ) . ' id="wp_default_phone" class="app_enable" data-toggle="wp_default_phone_options" name="mo_customer_validation_wp_default_enable_type" value="' . esc_attr( $wpreg_phone_type ) . '"
						' . ( esc_attr( $wp_default_type ) === esc_attr( $wpreg_phone_type ) ? 'checked' : '' ) . '/>
						<strong>' . esc_html( mo_( 'Enable Phone Verification' ) ) . '</strong>
				</p>
				<div ' . ( esc_attr( $wp_default_type ) !== esc_attr( $wpreg_phone_type ) ? 'hidden' : '' ) . ' class="mo_registration_help_desc" 
						id="wp_default_phone_options" >
						<input type="checkbox" ' . esc_attr( $disabled ) . ' name="mo_customer_validation_wp_reg_restrict_duplicates" value="1"
								' . esc_attr( $wp_handle_reg_duplicates ) . ' /><strong>' . esc_html( mo_( 'Do not allow users to use the same phone number for multiple accounts.' ) ) . '</strong>
				</div>
				<p>
					<input type="radio" ' . esc_attr( $disabled ) . ' id="wp_default_email" class="app_enable" name="mo_customer_validation_wp_default_enable_type" value="' . esc_attr( $wpreg_email_type ) . '"
						' . ( esc_attr( $wp_default_type ) === esc_attr( $wpreg_email_type ) ? 'checked' : '' ) . '/>
						<strong>' . esc_html( mo_( 'Enable Email Verification' ) ) . '</strong>
				</p>
				<p>
					<input type="radio" ' . esc_attr( $disabled ) . ' id="wp_default_both" class="app_enable" name="mo_customer_validation_wp_default_enable_type" 
						value="' . esc_attr( $wpreg_both_type ) . '" data-toggle="wp_default_both_options"
						' . ( esc_attr( $wp_default_type ) === esc_attr( $wpreg_both_type ) ? 'checked' : '' ) . '/>
						<strong>' . esc_html( mo_( 'Let the user choose' ) ) . '</strong>';
							mo_draw_tooltip(
								MoMessages::showMessage( MoMessages::INFO_HEADER ),
								MoMessages::showMessage( MoMessages::ENABLE_BOTH_BODY )
							);
							echo '			</p>
				<div ' . ( esc_attr( $wp_default_type ) !== esc_attr( $wpreg_both_type ) ? 'hidden' : '' ) . ' class="mo_registration_help_desc" 
						id="wp_default_both_options" >
						<input type="checkbox" ' . esc_attr( $disabled ) . ' name="mo_customer_validation_wp_reg_restrict_duplicates" value="1"
								' . esc_attr( $wp_handle_reg_duplicates ) . ' /><strong>' . esc_html( mo_( 'Do not allow users to use the same phone number for multiple accounts.' ) ) . '</strong>
				</div>
			</div>
		</div>';
