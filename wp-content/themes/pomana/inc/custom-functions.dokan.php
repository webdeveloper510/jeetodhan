<?php
defined( 'ABSPATH' ) || exit;


/*
* Saving product field data for edit and update
*/
add_action( 'dokan_new_product_added','pomana_dokan_save_add_product_meta', 10, 2 );
add_action( 'dokan_product_updated', 'pomana_dokan_save_add_product_meta', 10, 2 );
function pomana_dokan_save_add_product_meta($product_id, $postdata){
    if ( ! dokan_is_user_seller( get_current_user_id() ) ) {
        return;
    }

    if(isset($postdata['_lottery'])){
        wp_set_object_terms( $product_id, 'lottery', 'product_type' );
    }
    
    if(isset($postdata['_min_tickets'])){
        update_post_meta( $product_id, '_min_tickets', $postdata['_min_tickets'] );
    }
    if(isset($postdata['_max_tickets'])){
        update_post_meta( $product_id, '_max_tickets', $postdata['_max_tickets'] );
    }
    if(isset($postdata['_max_tickets_per_user'])){
        update_post_meta( $product_id, '_max_tickets_per_user', $postdata['_max_tickets_per_user'] );
    }
    if(isset($postdata['_lottery_num_winners'])){
        update_post_meta( $product_id, '_lottery_num_winners', $postdata['_lottery_num_winners'] );
    }
    if(isset($postdata['_lottery_multiple_winner_per_user'])){
        update_post_meta( $product_id, '_lottery_multiple_winner_per_user', 'yes' );
    }else{
        update_post_meta( $product_id, '_lottery_multiple_winner_per_user', 'no' );
    }
    if(isset($postdata['_lottery_price'])){
        update_post_meta( $product_id, '_lottery_price', $postdata['_lottery_price'] );
    }
    if(isset($postdata['_lottery_price'])){
        update_post_meta( $product_id, '_price', $postdata['_lottery_price'] );
    }
    if(isset($postdata['_lottery_sale_price'])){
        update_post_meta( $product_id, '_lottery_sale_price', $postdata['_lottery_sale_price'] );
    }
    if(isset($postdata['_lottery_dates_from'])){
        update_post_meta( $product_id, '_lottery_dates_from', $postdata['_lottery_dates_from'] );
    }
    if(isset($postdata['_lottery_dates_to'])){
        update_post_meta( $product_id, '_lottery_dates_to', $postdata['_lottery_dates_to'] );
    }
}
