<?php
/**
 * Load admin view for miniorange profile details.
 *
 * @package miniorange-otp-verification/views
 */

echo '
<div class="mo_registration_divided_layout mo-otp-full">
	<div class="mo_registration_table_layout mo-otp-center">	
    <div>
        <div style="width:50%;float:left;"><h4>Thank you for registering with us.</h4></div>
        <span style="width:50%;float:left;text-align:right;margin: 1em 0 1.33em 0">
            <input  type="button" ' . esc_attr( $disabled ) . ' 
                    name="check_btn" 
                    id="check_btn" 
                    class="button button-primary button-large" 
                    value="' . esc_attr( mo_( 'Check License' ) ) . '"/>
            <input  type="button" ' . esc_attr( $disabled ) . ' 
                    name="remove_accnt" 
                    id="remove_accnt" 
                    class="button button-primary button-large" 
                    value="' . esc_attr( mo_( 'Remove Account' ) ) . '"/>
        </span>
	</div>
		<h3>' . esc_html( mo_( 'Your Profile' ) ) . '</h3>
		<table border="1" class="profile-table">
			<tr>
				<td style="width:45%; padding: 10px;"><b>' . esc_html( mo_( 'Registered Email' ) ) . '</b></td>
				<td style="width:55%; padding: 10px;">' . esc_attr( $email ) . '</td>
			</tr>
			<tr>
				<td style="width:45%; padding: 10px;"><b>' . esc_html( mo_( 'Customer ID' ) ) . '</b></td>
				<td style="width:55%; padding: 10px;">' . esc_attr( $customer_id ) . '</td>
			</tr>
			<tr>
				<td style="width:45%; padding: 10px;"><b>' . esc_html( mo_( 'API Key' ) ) . '</b></td>
				<td style="width:55%; padding: 10px;">' . esc_attr( $api_key ) . '</td>
			</tr>
			<tr>
				<td style="width:45%; padding: 10px;"><b>' . esc_html( mo_( 'Token Key' ) ) . '</b></td>
				<td style="width:55%; padding: 10px;">' . esc_attr( $token ) . '</td>
			</tr>
		</table><br/><hr>
		<form id="mo_ln_form" style="display:none;" action="" method="post">';
			wp_nonce_field( $nonce );
echo '<input type="hidden" name="option" value="check_mo_ln" />
		</form>
		<form id="remove_accnt_form" style="display:none;" action="" method="post">';
			wp_nonce_field( $regnonce );
echo '		<input type="hidden" name="option" value="remove_account" />
		</form>
		<br/>
	</div>
</div>';
