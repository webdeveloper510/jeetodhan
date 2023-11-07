<?php
/**
 * Manin view loader.
 *
 * @package miniorange-otp-verification/addons
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

echo '	<div id="customMsgSubTabContainer" class="mo-subpage-container ' . esc_attr( $cm_hidden ) . '">';
			require 'customsms.php';
			require 'customemail.php';
echo '	</div>';
