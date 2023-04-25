<?php

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Competitions_for_woocommerce
 * @subpackage Competitions_for_woocommerce/includes
 */
class Competitions_For_Woocommerce_Activator {
	/**
	* Short Description. (use period)
	*
	* Long Description.
	*
	* @since    1.0.0
	*/
	public static function activate() {

		global $wpdb;
		global $wp_version;
		$flag = false;
		$wp   = '4.0';    // min WordPress version
		$php  = '5.5';   // min PHP version

		if ( version_compare( PHP_VERSION, $php, '<' ) ) {
			$flag = 'PHP';
		} elseif ( version_compare( $wp_version, $wp, '<' ) ) {
			$flag = 'WordPress';
		}

		if ( $flag ) {
			$version = $php;
			if ( 'WordPress' === $flag ) {
				$version = $wp;
			}
			deactivate_plugins( basename( __FILE__ ) );
			wp_die(
				'<p>The <strong>Competitions for WooCommerce</strong> plugin requires ' . esc_html( $flag ) . '  version ' . esc_html( $version ) . ' or greater. If you need secure hosting with all requirements for this plugin contact us at <a href="mailto:info@wpinstitut.com">info@wpinstitut.com</a></p>',
				'Plugin Activation Error',
				array(
					'response'  => 200,
					'back_link' => true,
				)
			);
		}


		$data_table  = $wpdb->prefix . 'cfw_log';
		$data_table2 = $wpdb->prefix . 'cfw_log_reserved';

		$sql = " CREATE TABLE IF NOT EXISTS $data_table (
				`id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
				`userid` bigint(20) unsigned NOT NULL,
				`orderid` bigint(20) unsigned NOT NULL,
				`competition_id` bigint(20) unsigned DEFAULT NULL,
				`ticket_number` bigint(20) UNSIGNED DEFAULT NULL,
				`answer_id` bigint(20) UNSIGNED DEFAULT NULL,
				`date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
				PRIMARY KEY (`id`)
		        );";

		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		dbDelta( $sql );
		$sql2 = "
				CREATE TABLE IF NOT EXISTS $data_table2 (
				`competition_id` bigint(20) UNSIGNED NOT NULL,
				`ticket_number` bigint(20) UNSIGNED NOT NULL,
				`date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
				`session_key` char(32) NOT NULL,
				UNIQUE KEY `index` (`competition_id`,`ticket_number`)
				);

		        ";
		dbDelta( $sql2 );

	}

}
