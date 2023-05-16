<?php
class Stripe_Express_Security_Util {
  public static function admin_check($request) {
    $data = sanitize_post($request->get_params());
		if( !static::verify_nonce( $data ) ) {
			return false;
    }
    return true;
  }

	public static function verify_nonce( $data ) {
		if( empty($data) || !$data['_wpnonce'] ) {
			return false;
		} else {
			$verify = wp_verify_nonce( $data['_wpnonce'], 'wp_rest' );
			if( $verify > 0 ) {
				return true;
			} else {
				return false;
			}
		}
	}
}