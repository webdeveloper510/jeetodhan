<?php
class Stripe_Express_Activator {
  public static function activate() {
    Stripe_Express_Logger::info('activate');

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    
    global $wpdb;
    // Check table exists
    $table_name = $wpdb->prefix . 'stripe_express_elements';
    $query = $wpdb->prepare( 'SHOW TABLES LIKE %s', $wpdb->esc_like($table_name));
    if ( $wpdb->get_var( $query ) == $table_name) {
      return;
    }

    // Create Table
    $sql = 'CREATE TABLE `' . $wpdb->prefix . 'stripe_express_elements` (
      `id` bigint(20) unsigned NOT NULL auto_increment,
      `type` varchar(200) NOT NULL,
      `uiConfig` text,
      `paymentConfig` text NOT NULL,
      `createAt` INT(11) NOT NULL,
      PRIMARY KEY (`id`)
      ) ' . $wpdb->get_charset_collate();
    dbDelta($sql);

	}
}