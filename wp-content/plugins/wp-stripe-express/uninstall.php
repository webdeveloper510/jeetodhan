<?php
if (!defined('ABSPATH')) {
  exit; // Exit if accessed directly
}

// if uninstall not called from WordPress exit
if (!defined('WP_UNINSTALL_PLUGIN')) {
  exit;
}

if (!get_option('stripe_express_keep_data')) {
  // Remove options
  delete_option('stripe_express_mode');
  delete_option('stripe_express_currency');
  delete_option('stripe_express_live_key');
  delete_option('stripe_express_live_secret');
  delete_option('stripe_express_test_key');
  delete_option('stripe_express_test_secret');
  delete_option('stripe_express_webhook');
  delete_option('stripe_express_webhook_secret');
  delete_option('stripe_express_success_url');
  delete_option('stripe_express_cancel_url');
  delete_option('stripe_express_debug');
  delete_option('stripe_express_keep_data');
  delete_option('stripe_express_language');
  delete_option('stripe_express_theme');
  delete_option('stripe_express_email');

  // Remove tables
  global $wpdb;
  $tables = array(
    $wpdb->prefix . 'stripe_express_elements'
  );

  foreach ($tables as $table_name) {
    $wpdb->query("DROP TABLE IF EXISTS $table_name");
  }
}
