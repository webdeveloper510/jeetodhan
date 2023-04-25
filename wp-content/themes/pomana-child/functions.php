<?php
function pomana_child_scripts() {
    wp_enqueue_style( 'pomana-parent-style', get_template_directory_uri(). '/style.css' );
}
add_action( 'wp_enqueue_scripts', 'pomana_child_scripts' );
 
// Your php code goes here
/* Add to the functions.php file of your theme/plugin */

add_filter( 'woocommerce_order_button_text', 'wc_custom_order_button_text' ); 

function wc_custom_order_button_text() {
    return __( 'Buy tickets', 'woocommerce' ); 
}
?>
