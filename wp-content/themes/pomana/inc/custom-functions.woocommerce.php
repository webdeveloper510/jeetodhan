<?php

/* Custom functions for woocommerce */
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart' );
remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open' );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close' );
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash' );
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail' );
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );


if (!function_exists('pomana_woocommerce_show_top_custom_block')) {
    function pomana_woocommerce_show_top_custom_block() {
        $args = array();
        global $product;
        global $pomana_redux;
        echo '<div class="thumbnail-and-details">';    
                  
            wc_get_template( 'loop/sale-flash.php' );
            
            echo '<div class="overlay-container">';
                echo '<div class="thumbnail-overlay"></div>';
                echo '<div class="overlay-components">';

                    echo '<div class="component add-to-cart">';
                        echo '<a href="'.esc_url(get_the_permalink()).'" class="button product_type_simple add_to_cart_button" data-tooltip="'.esc_attr__('Purchase', 'pomana').'" data-product_id="' . esc_attr($product->get_id()) . '"><i class="fa fa-cart-plus" aria-hidden="true"></i></a>';
                    echo '</div>';

                    if ( class_exists( 'YITH_WCWL' ) ) {
                        echo '<div class="component wishlist">';
                            echo do_shortcode( "[yith_wcwl_add_to_wishlist]" );
                        echo '</div>';
                    }

                    if (  class_exists( 'YITH_WCQV' ) ) {
                        echo '<div class="component quick-view">';
                            echo '<a href="'.esc_url('#').'" class="button yith-wcqv-button" data-tooltip="'.esc_attr__('Quickview', 'pomana').'" data-product_id="' . esc_attr($product->get_id()) . '"><i class="fa fa-eye" aria-hidden="true"></i></a>';
                        echo '</div>';
                    }
                    
                echo '</div>';
            echo '</div>';
            echo '<a class="woo_catalog_media_images" title="'.esc_attr(the_title_attribute('echo=0')).'" href="'.esc_url(get_the_permalink(get_the_ID())).'">'.woocommerce_get_product_thumbnail();
            echo '</a>';
            
        echo '</div>';
    }
    add_action( 'woocommerce_before_shop_loop_item_title', 'pomana_woocommerce_show_top_custom_block' );
}


if (!function_exists('pomana_woocommerce_show_price_and_review')) {
    function pomana_woocommerce_show_price_and_review() {
        $args = array();
        global $product;
        global $pomana_redux;

        echo '<div class="details-container">';
            echo '<div class="details-price-container details-item">';
                wc_get_template( 'loop/price.php' );
                   
                echo '<div class="details-review-container details-item">';
                    wc_get_template( 'loop/rating.php' );
                echo '</div>';
            echo '</div>';
        echo '</div>';
    }
    add_action( 'woocommerce_after_shop_loop_item_title', 'pomana_woocommerce_show_price_and_review' );
}

// always display rating stars
function pomana_filter_woocommerce_product_get_rating_html( $rating_html, $rating, $count ) { 
    $rating_html  = '<div class="star-rating">';
    $rating_html .= wc_get_star_rating_html( $rating, $count );
    $rating_html .= '</div>';

    return $rating_html; 
};  
add_filter( 'woocommerce_product_get_rating_html', 'pomana_filter_woocommerce_product_get_rating_html', 10, 3 ); 


/**
||-> Ensure cart contents update when products are added to the cart via AJAX (place the following in functions.php)
*/
function pomana_woocommerce_header_add_to_cart_fragment( $fragments ) {
    ob_start();
?>
<a class="cart-contents" href="<?php echo esc_url(wc_get_cart_url()); ?>" title="<?php esc_attr_e( 'View your shopping cart','pomana' ); ?>"><?php echo sprintf (_n( '%d item', '%d items', WC()->cart->cart_contents_count, 'pomana' ), WC()->cart->cart_contents_count ); ?> - <?php echo WC()->cart->get_cart_total(); ?></a>
<?php
    $fragments['a.cart-contents'] = ob_get_clean();
    return $fragments;
} 
add_filter( 'woocommerce_add_to_cart_fragments', 'pomana_woocommerce_header_add_to_cart_fragment' );

remove_action( 'wp_head', 'rest_output_link_wp_head' );



/**
 * Modify image width theme support.
 Archive shop
 */
function pomana_modify_theme_support() {
    $theme_support = get_theme_support( 'woocommerce' );
    $theme_support = is_array( $theme_support ) ? $theme_support[0] : array();

    $theme_support['single_image_width'] = 1000;
    $theme_support['thumbnail_image_width'] = 1000;
    $theme_support['gallery_thumbnail_image_width'] = 180;

    remove_theme_support( 'woocommerce' );
    add_theme_support( 'woocommerce', $theme_support );
}
add_action( 'after_setup_theme', 'pomana_modify_theme_support', 10 );

remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0);

/**
 Single product
 */
add_filter( 'woocommerce_get_image_size_single', 'pomana_product_img_size' );
add_filter( 'woocommerce_get_image_size_shop_single', 'pomana_product_img_size' );
add_filter( 'woocommerce_get_image_size_woocommerce_single', 'pomana_product_img_size' );
function pomana_product_img_size()
{
    $size = array(
        'width'  => 700,
        'height' => 800,
        'crop'   => 1,
    );
    return $size;
}


/**
||-> Custom functions for woocommerce
*/
function pomana_woocommerce_get_sidebar() {
    global  $pomana_redux;

    if ( is_shop() ) {
        $sidebar = $pomana_redux['pomana_shop_layout_sidebar'];
    }elseif ( is_product() ) {
        $sidebar = $pomana_redux['pomana_single_shop_sidebar'];
    }else{
        $sidebar = 'woocommerce';
    }

if ( is_active_sidebar ( $sidebar ) ) { 
     dynamic_sidebar( $sidebar ); 
} 

}
add_action ( 'woocommerce_sidebar', 'pomana_woocommerce_get_sidebar' );

add_filter( 'loop_shop_columns', 'pomana_wc_loop_shop_columns', 1, 10 );

/*
 * Return a new number of maximum columns for shop archives
 * @param int Original value
 * @return int New number of columns
 */
function pomana_wc_loop_shop_columns( $number_columns ) {
    global  $pomana_redux;

    if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
        if ( $pomana_redux['modeltheme-shop-columns'] ) {
            return $pomana_redux['modeltheme-shop-columns'];
        }else{
            return 3;
        }
    }else{
        return 3;
    }
}


add_filter( 'woocommerce_output_related_products_args', 'pomana_related_products_args' );
function pomana_related_products_args( $args ) {
    global  $pomana_redux;

    if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
        $args['posts_per_page'] = $pomana_redux['modeltheme-related-products-number'];
    }else{
        $args['posts_per_page'] = 3;
    }
    $args['columns'] = 3;

    return $args;
}

if (!function_exists('pomana_new_loop_shop_per_page')) {
    add_filter( 'loop_shop_per_page', 'pomana_new_loop_shop_per_page', 20 );
    function pomana_new_loop_shop_per_page( $cols ) {
      // $cols contains the current number of products per page based on the value stored on Options -> Reading
      // Return the number of products you wanna show per page.
      $cols = 9;
      return $cols;
    }
}

add_filter( 'woocommerce_widget_cart_is_hidden', 'pomana_always_show_cart', 40, 0 );
function pomana_always_show_cart() {
    return false;
}


// Change Woocommerce css breaktpoint from max width: 768px to 767px  
add_filter('woocommerce_style_smallscreen_breakpoint', 'pomana_woo_custom_breakpoint');
function pomana_woo_custom_breakpoint($px) {
  $px = '767px';
  return $px;
}


//change woocommerce-loop product title from h2 to h3
remove_action( 'woocommerce_template_loop_product_title', 'woocommerce_template_loop_product_title', 10 );
remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );

add_action('woocommerce_template_loop_product_title', 'pomana_change_products_title', 10 );
add_action('woocommerce_shop_loop_item_title', 'pomana_change_products_title', 10 );
function pomana_change_products_title() {
    echo '<h3 class="woocommerce-loop-product_title">' . esc_html(get_the_title()) . '</h3>';
}

/**
*
* Adds the blue lotterys box to marketplace plugins such as dokan/wcfm
*
* @since 3.3
*
* @package pomana
*/
if (!function_exists('pomana_custom_lottery_blue_box')) {
    function pomana_custom_lottery_blue_box($product_id){

        $style = 'display: none;';
        if ($product_id) {
            $_product = wc_get_product( $product_id );
            if( $_product->is_type( 'lottery' ) ) {
                $style = 'display: block;';
            }
        }

        ?>

        <div class="pomana-lottery-settings" style="<?php echo esc_attr($style); ?>">

            <?php do_action('pomana_before_add_lottery_form', $product_id); ?>

            <?php
                // Auction Fields
                $_min_tickets = get_post_meta( $product_id, '_min_tickets', true );
                $_max_tickets = get_post_meta( $product_id, '_max_tickets', true );
                $_max_tickets_per_user = get_post_meta( $product_id, '_max_tickets_per_user', true );
                
                $_lottery_num_winners = get_post_meta( $product_id, '_lottery_num_winners', true );
                $_lottery_multiple_winner_per_user = get_post_meta( $product_id, '_lottery_multiple_winner_per_user', true );
                $_lottery_price = get_post_meta( $product_id, '_lottery_price', true );
                
                $_lottery_sale_price = get_post_meta( $product_id, '_lottery_sale_price', true );
                $_lottery_dates_from = get_post_meta( $product_id, '_lottery_dates_from', true );
                $_lottery_dates_to = get_post_meta( $product_id, '_lottery_dates_to', true );

                //$_relist_lottery_dates_from = get_post_meta( $product_id, '_relist_lottery_dates_from', true );
                //$_relist_lottery_dates_to = get_post_meta( $product_id, '_relist_lottery_dates_to', true );
            ?>
            <!-- Lottery Settings -->
            <h4><?php esc_html_e( 'Lottery Settings', 'pomana' ); ?></h4>
            <div id="lottery_tab" class="panel woocommerce_options_panel" style="display: block;">

                <div class="row">
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <p class="form-field ">
                            <label for="_min_tickets"><?php esc_html_e( 'Min tickets', 'pomana' ); ?><?php pomana_dokan_wcfm_tooltip(esc_attr__('Minimum tickets to be sold', 'pomana')); ?></label>
                            <input type="number" autocomplete="off" class="form-control" name="_min_tickets" id="_min_tickets" value="<?php echo esc_attr($_min_tickets); ?>" step="any" min="0">
                        </p>
                    </div>
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <p class="form-field ">
                            <label for="_max_tickets"><?php esc_html_e( 'Max tickets', 'pomana' ); ?><?php pomana_dokan_wcfm_tooltip(esc_attr__('Maximum tickets to be sold', 'pomana')); ?></label>
                            <input type="number" autocomplete="off" class="form-control" name="_max_tickets" id="_max_tickets" value="<?php echo esc_attr($_max_tickets); ?>" step="any" min="0">
                        </p>
                    </div>
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <p class="form-field ">
                            <label for="_max_tickets_per_user"><?php esc_html_e( 'Max tickets per user', 'pomana' ); ?><?php pomana_dokan_wcfm_tooltip(esc_attr__('Maximum tickets sold per user', 'pomana')); ?></label>
                            <input type="number" autocomplete="off" class="form-control" name="_max_tickets_per_user" id="_max_tickets_per_user" value="<?php echo esc_attr($_max_tickets_per_user); ?>" step="any" min="0">
                        </p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <p class="form-field ">
                            <label for="_lottery_num_winners"><?php esc_html_e( 'Number of winners', 'pomana' ); ?><?php pomana_dokan_wcfm_tooltip(esc_attr__('Number of possible winners', 'pomana')); ?></label>
                            <input type="number" autocomplete="off" class="form-control" name="_lottery_num_winners" id="_lottery_num_winners" value="<?php echo esc_attr($_lottery_num_winners); ?>" step="any" min="0">
                        </p>
                    </div>

                    <div class="col-md-4 col-sm-6 col-xs-12 pomana-field-lottery_multiple_winner_per_user">
                        <p class=" form-field">
                            <input type="checkbox" class="wcfm-checkbox wcfm_half_ele_checkbox checkbox" style="" name="_lottery_multiple_winner_per_user" id="_lottery_multiple_winner_per_user" value="<?php if($_lottery_multiple_winner_per_user == 'yes'){echo 'yes';} ?>" <?php if($_lottery_multiple_winner_per_user == 'yes'){echo 'checked';} ?>><label for="_lottery_multiple_winner_per_user"><?php esc_html_e( 'Multiple prizes per user?', 'pomana' ); ?><?php pomana_dokan_wcfm_tooltip(esc_attr__('Allow multiple prizes for single user if there are multiple lottery winners', 'pomana')); ?></label>
                        </p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <p class="form-field ">
                            <label for="_lottery_price"><?php esc_html_e( 'Price', 'pomana' ); ?> <?php echo esc_html( get_woocommerce_currency_symbol() ); ?><?php pomana_dokan_wcfm_tooltip(esc_attr__('Lottery regular price', 'pomana')); ?></label>
                            <input type="number" autocomplete="off" class="form-control wc_input_price short wc_input_price" name="_lottery_price" id="_lottery_price" value="<?php echo esc_attr($_lottery_price); ?>" step="any" min="0">
                        </p>
                    </div>
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <p class="form-field ">
                            <label for="_lottery_sale_price"><?php esc_html_e( 'Sale Price', 'pomana' ); ?> <?php echo esc_html( get_woocommerce_currency_symbol() ); ?><?php pomana_dokan_wcfm_tooltip(esc_attr__('Lottery sale price', 'pomana')); ?></label>
                            <input type="number" autocomplete="off" class="form-control wc_input_price short wc_input_price" name="_lottery_sale_price" id="_lottery_sale_price" value="<?php echo esc_attr($_lottery_sale_price); ?>" step="any" min="0">
                        </p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <p class="lottery_dates_fields">
                            <label for="_lottery_dates_from"><?php esc_html_e( 'Lottery from date', 'pomana' ); ?><?php pomana_dokan_wcfm_tooltip(esc_attr__('The start date and time of this lottery', 'pomana')); ?></label>
                            <input type="text" autocomplete="off" class="form-control hasDatepicker pomana_datetime_picker" name="_lottery_dates_from" id="_lottery_dates_from" value="<?php echo esc_attr($_lottery_dates_from); ?>" autocomplete="off" placeholder="<?php esc_attr_e( 'From… YYYY-MM-DD HH:MM', 'pomana' ); ?>">
                            
                        </p>
                    </div>
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <p class="lottery_dates_fields">
                            <label for="_lottery_dates_to"><?php esc_html_e( 'Lottery to date', 'pomana' ); ?><?php pomana_dokan_wcfm_tooltip(esc_attr__('The end date and time of this lottery', 'pomana')); ?></label>
                            <input type="text" autocomplete="off" class="form-control hasDatepicker pomana_datetime_picker" name="_lottery_dates_to" id="_lottery_dates_to" value="<?php echo esc_attr($_lottery_dates_to); ?>" autocomplete="off" placeholder="<?php esc_attr_e( 'To… YYYY-MM-DD HH:MM', 'pomana' ); ?>">
                            
                        </p>
                    </div>
                </div>

                <!-- <div class="row">
                    <button type="button" id="pomana-relist-lottery" class="button" data-editor="excerpt"><?php //echo esc_html__('Relist Lottery', 'pomana'); ?></button>
                    <div class="col-md-4 col-sm-6 col-xs-12 relist_lottery_dates_fields">
                        <p class="lottery_dates_fields">
                            <label for="_relist_lottery_dates_from"><?php //esc_html_e( 'Relist Dates (Start)', 'pomana' ); ?><?php //pomana_dokan_wcfm_tooltip(esc_attr__('Relist: The start date and time of this lottery', 'pomana')); ?></label>
                            <input type="text" autocomplete="off" class="form-control hasDatepicker pomana_datetime_picker" name="_relist_lottery_dates_from" id="_relist_lottery_dates_from" value="<?php //echo esc_attr($_relist_lottery_dates_from); ?>" autocomplete="off" placeholder="<?php //esc_attr_e( 'From… YYYY-MM-DD HH:MM', 'pomana' ); ?>">
                            
                        </p>
                    </div>
                    <div class="col-md-4 col-sm-6 col-xs-12 relist_lottery_dates_fields">
                        <p class="lottery_dates_fields">
                            <label for="_relist_lottery_dates_to"><?php //esc_html_e( 'Relist Dates (End)', 'pomana' ); ?><?php //pomana_dokan_wcfm_tooltip(esc_attr__('Relist: The end date and time of this lottery', 'pomana')); ?></label>
                            <input type="text" autocomplete="off" class="form-control hasDatepicker pomana_datetime_picker" name="_relist_lottery_dates_to" id="_relist_lottery_dates_to" value="<?php //echo esc_attr($_relist_lottery_dates_to); ?>" autocomplete="off" placeholder="<?php //esc_attr_e( 'To… YYYY-MM-DD HH:MM', 'pomana' ); ?>">
                            
                        </p>
                    </div>
                </div> -->
            </div>

            <?php do_action('pomana_after_add_lottery_form', $product_id); ?>

        </div>

        <?php
    }
}
if(class_exists( 'wc_lottery' )){
    add_action('pomana_dokan_edit_product_before_short_description', 'pomana_custom_lottery_blue_box');
    // if (class_exists('WCFM') && !class_exists('WCFMu')) {
    if (class_exists('WCFM')) {
        add_action('pomana_wcfm_edit_product_before_tabs', 'pomana_custom_lottery_blue_box');
    }
}

if (!function_exists('pomana_dokan_wcfm_tooltip')) {
    function pomana_dokan_wcfm_tooltip($text = '' ){
        // if (class_exists('WCFM') && !class_exists('WCFMu')) {
        if (class_exists('WCFM')) {
            echo '<span class="img_tip far fa-question-circle" data-tip="'.esc_attr($text).'" data-hasqtip="39" aria-describedby="qtip-39"></span>';
        }else{
            echo '<span class="far fa-question-circle tips" aria-hidden="true" data-title="'.esc_attr($text).'"></span>';
        }
    }
}