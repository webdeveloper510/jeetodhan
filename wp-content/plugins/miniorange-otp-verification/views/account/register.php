<?php
/**
 * Load admin view for miniorange Login Form.
 *
 * @package miniorange-otp-verification/views
 */

echo '
	<form name="f" method="post" action="" id="register-form">';
		wp_nonce_field( $nonce );
echo '	<input type="hidden" name="option" value="mo_registration_register_customer" />
		<div class="mo_registration_divided_layout mo-otp-full">
			<div class="mo_registration_table_layout mo-otp-center">
				<h2>
				    ' . esc_html( mo_( 'REGISTER WITH MINIORANGE' ) ) . '
				    <span style="float:right;margin-top:-10px;">
                        <a href="#goToLoginPage" class="button button-primary button-large">' . esc_html( mo_( 'Already Have an Account? Sign In' ) ) . '</a>
                    </span>
                </h2>
                <hr>
				<p>
				    <div class="mo_idp_help_desc">
                        You are using a third party service for Email and SMS Delivery. In order to make it easy to 
                        manage licenses, download reports, track transactions and generate leads we ask you set up an account 
                        before using the plugin. The plugin ships with 10 free email and 10 free SMS transactions.<br/>
                        We use the personal information you provide for account creation purposes only. It allows us to 
                        reach out to you easily in case of any support.   
                    </div>
                </p>
				<table class="mo_registration_settings_table">
					<tr>
						<td><b><span style="color:#FF0000">*</span>' . esc_html( mo_( 'Email:' ) ) . '</b></td>
						<td><input class="mo_registration_table_textbox" type="email" name="email"
							required placeholder="person@example.com"
							value="' . esc_attr( $mo_current_user->user_email ) . '" /></td>
					</tr>

					<tr>
						<td><b><span style="color:#FF0000">*</span>' . esc_html( mo_( 'Website/Company Name:' ) ) . '</b></td>
						<td><input class="mo_registration_table_textbox" type="text" name="company"
							required placeholder="' . esc_attr( mo_( 'Enter your companyName' ) ) . '"
							value="' . esc_attr( isset( $_SERVER['SERVER_NAME'] ) ? sanitize_text_field( wp_unslash( $_SERVER['SERVER_NAME'] ) ) : '' ) . '" /></td>
						<td></td>
					</tr>

					<tr>
						<td><b>&nbsp;&nbsp;' . esc_html( mo_( 'FirstName:' ) ) . '</b></td>
						<td><input class="mo_registration_table_textbox" type="text" name="fname"
							placeholder="' . esc_attr( mo_( 'Enter your First Name' ) ) . '"
							value="' . esc_attr( $mo_current_user->user_firstname ) . '" /></td>
						<td></td>
					</tr>

					<tr>
						<td><b>&nbsp;&nbsp;' . esc_html( mo_( 'LastName:' ) ) . '</b></td>
						<td><input class="mo_registration_table_textbox" type="text" name="lname"
							placeholder="' . esc_attr( mo_( 'Enter your Last Name' ) ) . '"
							value="' . esc_attr( $mo_current_user->user_lastname ) . '" /></td>
						<td></td>
					</tr>
					
					<tr>
						<td><b><span style="color:#FF0000">*</span>' . esc_html( mo_( 'Password:' ) ) . '</b></td>
						<td><input class="mo_registration_table_textbox" required type="password"
							name="password" placeholder="' . esc_attr( mo_( 'Choose your password (Min. length 6)' ) ) . '" /></td>
					</tr>
					<tr>
						<td><b><span style="color:#FF0000">*</span>' . esc_html( mo_( 'Confirm Password:' ) ) . '</b></td>
						<td><input class="mo_registration_table_textbox" required type="password"
							name="confirmPassword" placeholder="' . esc_attr( mo_( 'Confirm your password' ) ) . '" /></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>
						    <br /><input type="submit" name="submit" value="' . esc_attr( mo_( 'Register' ) ) . '" style="width:100px;"
							class="button button-primary button-large" />
						</td>
					</tr>
				</table>
			</div>
		</div>
	</form>
	<form id="goToLoginPageForm" method="post" action="">';
		wp_nonce_field( $nonce );
echo '	<input type="hidden" name="option" value="mo_go_to_login_page" />
	</form>
	<script>
		jQuery(document).ready(function(){
			$mo(\'a[href="#forgot_password"]\').click(function(){
				$mo("#forgotpasswordform").submit();
			});

			$mo(\'a[href="#goToLoginPage"]\').click(function(){
				$mo("#goToLoginPageForm").submit();
			});
		});
	</script>';
