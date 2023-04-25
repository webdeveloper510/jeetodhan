<?php
defined( 'ABSPATH' ) || exit;

if (!function_exists('pomana_save_lottery_metas')) {
    function pomana_save_lottery_metas( $new_product_id, $wcfm_products_manage_form_data ) {

        global $WCFM;
        // if (!class_exists('WCFMu')){
            if(isset($wcfm_products_manage_form_data['_lottery'])){
                wp_set_object_terms( $new_product_id, 'lottery', 'product_type' );
            }
            if(isset($wcfm_products_manage_form_data['_min_tickets'])){
                update_post_meta( $new_product_id, '_min_tickets', $wcfm_products_manage_form_data['_min_tickets'] );
            }
            if(isset($wcfm_products_manage_form_data['_max_tickets'])){
                update_post_meta( $new_product_id, '_max_tickets', $wcfm_products_manage_form_data['_max_tickets'] );
            }
            if(isset($wcfm_products_manage_form_data['_max_tickets_per_user'])){
                update_post_meta( $new_product_id, '_max_tickets_per_user', $wcfm_products_manage_form_data['_max_tickets_per_user'] );
            }
            if(isset($wcfm_products_manage_form_data['_lottery_num_winners'])){
                update_post_meta( $new_product_id, '_lottery_num_winners', $wcfm_products_manage_form_data['_lottery_num_winners'] );
            }
            if(isset($wcfm_products_manage_form_data['_lottery_multiple_winner_per_user'])){
                update_post_meta( $new_product_id, '_lottery_multiple_winner_per_user', 'yes' );
            }else{
                update_post_meta( $new_product_id, '_lottery_multiple_winner_per_user', 'no' );
            }
            if(isset($wcfm_products_manage_form_data['_lottery_price'])){
                update_post_meta( $new_product_id, '_lottery_price', $wcfm_products_manage_form_data['_lottery_price'] );
                update_post_meta( $product_id, '_price', $wcfm_products_manage_form_data['_lottery_price'] );
            }
            if(isset($wcfm_products_manage_form_data['_lottery_sale_price'])){
                update_post_meta( $new_product_id, '_lottery_sale_price', $wcfm_products_manage_form_data['_lottery_sale_price'] );
            }
            if(isset($wcfm_products_manage_form_data['_lottery_dates_from'])){
                update_post_meta( $new_product_id, '_lottery_dates_from', $wcfm_products_manage_form_data['_lottery_dates_from'] );
            }
            if(isset($wcfm_products_manage_form_data['_lottery_dates_to'])){
                update_post_meta( $new_product_id, '_lottery_dates_to', $wcfm_products_manage_form_data['_lottery_dates_to'] );
            }
        // }
    }
    add_action( 'after_wcfm_products_manage_meta_save', 'pomana_save_lottery_metas', 50, 2 );
}
