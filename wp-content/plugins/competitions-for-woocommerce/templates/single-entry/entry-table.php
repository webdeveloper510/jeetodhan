<?php
/**
 * Competition info template
 *
 */

defined( 'ABSPATH' ) || exit;

global $product, $post;

do_action( 'woocommerce_competition_before_single_entry_table' );

do_action( 'woocommerce_competition_single_entry_table' );

do_action( 'woocommerce_competition_after_single_entry_table' );
