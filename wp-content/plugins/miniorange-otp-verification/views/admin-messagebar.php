<?php
/**
 * Loads View for message bar on admin dashboard.
 *
 * @package miniorange-otp-verification
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
echo '			<!-- Admin Message Bar -->
		<div>';
if ( ! $registered ) {
	echo '<div class="mo-alert-container mo-alert-error">
					<span>' . wp_kses(
		$register_msg,
		array(
			'a' => array( 'href' => array() ),
			'i' => array( 'href' => array() ),
			'u' => array( 'href' => array() ),
		)
	) . '			</span>
				</div>';
} elseif ( ! $activated ) {
	echo '<div class="mo-alert-container mo-alert-error">
					<span>' . wp_kses(
		$activation_msg,
		array(
			'a' => array( 'href' => array() ),
			'i' => array( 'href' => array() ),
			'u' => array( 'href' => array() ),
		)
	) . '			</span>
				</div>';
} elseif ( ! $gatewayconfigured ) {
	echo '<div class="mo-alert-container mo-alert-error">
					<span>' . wp_kses(
		$gateway_msg,
		array(
			'a' => array( 'href' => array() ),
			'i' => array( 'href' => array() ),
			'u' => array( 'href' => array() ),
		)
	) . '			</span>
				</div>';
}
echo '  </div>';


