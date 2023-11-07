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

if (!function_exists('pomana_woocommerce_show_price_and_review')) {
    function pomana_woocommerce_show_price_and_review() {
        $args = array();
        global $product;
		
		$productt = wc_get_product( get_the_ID() );
		
		$stock_quantity = $productt->stock_quantity; 
		$total_sales    = $productt->total_sales;
		
		$total          = $stock_quantity + $total_sales;
		
		$percentage     = ($total_sales / $total) * 100;
		$round_percentage = number_format($percentage); 
		
		if($percentage == '0'):
		    $sold_percentage = '<div class="sold_percentage">NOT SOLD</div>';
		   else:
		     $sold_percentage = '<div class="sold_percentage">SOLD : '.$round_percentage.' % </div>';  
		endif;
		
        global $pomana_redux;
         echo '<a href="'.esc_url(get_the_permalink(get_the_ID())).'">';
        echo '<div class="details-container">';
            echo '<div class="details-price-container details-item">';
                wc_get_template( 'loop/price.php' );
                   
                echo '<div class="details-review-container details-item">';
                    wc_get_template( 'loop/rating.php' );
                echo '</div>';
            echo '</div>';
           
        echo '</div>';
        
		echo $sold_percentage.'<div class="w3-light-grey outer">
				  <div class="w3-green w3-center" style="width:'.$round_percentage.'%"> '.$total_sales.' </div>
				</div>';
                     echo '<span class="cus_butt">Buy <svg fill="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 21 22" style="fill: currentcolor;"><path d="M17.077 6.739a.92.92 0 01-.746-1.066l.717-4.07a.92.92 0 111.812.319l-.717 4.07a.92.92 0 01-1.066.747zM15.4 4.344a.92.92 0 11.32-1.812l4.07.718a.92.92 0 01-.319 1.812l-4.07-.718z" fill="#0490E9"></path><path fill-rule="evenodd" clip-rule="evenodd" d="M13.732 1.307L8.86.447a4.172 4.172 0 00-4.827 3.38l-2.026 11.49a4.172 4.172 0 003.38 4.827l6.565 1.158a4.172 4.172 0 004.827-3.38l1.701-9.648a5.28 5.28 0 01-1.635-.324l-1.707 9.682a2.5 2.5 0 01-2.896 2.028l-2.462-.434.144-.82a.834.834 0 00-1.641-.29l-.145.82-2.462-.433a2.5 2.5 0 01-2.028-2.897l2.026-11.49A2.5 2.5 0 018.57 2.09l4.866.858a5.28 5.28 0 01.296-1.64zm-.965 13.967a.834.834 0 00-.333-1.503l-4.924-.869a.833.833 0 10-.29 1.642l4.924.868a.833.833 0 00.623-.138z" fill="#0490E9"></path><path fill="#0490E9" d="M10.191 5.778l1.686.297-.97 5.497-1.685-.297z"></path><path d="M14.213 7.068a.833.833 0 00-.333-1.504l-4.924-.868a.833.833 0 10-.29 1.641l4.925.869a.833.833 0 00.622-.138z" fill="#0490E9"></path></svg>
</span>';
          echo '</a>';

    }
    add_action( 'woocommerce_after_shop_loop_item_title', 'pomana_woocommerce_show_price_and_review' );
}

function my_custom_function() {
	
	    global $product;
		
		$productt = wc_get_product( get_the_ID() );
		
		$stock_quantity = $productt->stock_quantity; 
		$total_sales    = $productt->total_sales;
		
		$total          = $stock_quantity + $total_sales;
		
		$percentage     = ($total_sales / $total) * 100;
		
		$round_percentage = number_format($percentage); 
		
		if($percentage == '0'):
		    $sold_percentage = '<div class="sold_percentage">NOT SOLD</div>';
		   else:
		     $sold_percentage = '<div class="sold_percentage">SOLD : '.$round_percentage.' % </div>';  
		endif;

         echo $sold_percentage.'<div class="w3-light-grey outer">
				  <div class="w3-green w3-center" style="width:'.$round_percentage.'%"> '.$total_sales.' </div>
				</div>';
}
add_action('woocommerce_single_product_summary', 'my_custom_function', 25);

// Add a custom link below the "Add to Cart" button in WooCommerce product page
function custom_link_below_add_to_cart_button() {
    global $product;

    // Define your custom link and text here
    $custom_link_url = 'http://www.wellspringinfotech.com/lottery/free-entry/';
    $custom_link_text = 'Free Postal Entry ';

    // Output the custom link
    echo '<p><a href="' . esc_url( $custom_link_url ) . '" class="custom-link-class">' . esc_html( $custom_link_text ) . '</a></p>';
}
add_action( 'woocommerce_after_add_to_cart_button', 'custom_link_below_add_to_cart_button' );

function my_custom_div_after_product_form() {
    echo '
    <div class="pro-icons"><ul>
    <li><svg-icon _ngcontent-sll-c96="" name="entry" fill="none" class="ng-tns-c96-1" _nghost-sll-c63="" role="img"><svg fill="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 25 24" style="fill: none;"><path d="M20.04 13.197l-6.334 6.334a1.765 1.765 0 01-2.5 0l-7.588-7.58V3.119h8.834l7.588 7.588a1.767 1.767 0 010 2.491v0zM8.035 7.535h.009" stroke="#939CA4" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg></svg-icon> ENTRIES ONLY £0.99</li>
    <li><svg-icon _ngcontent-sll-c96="" name="maximize" class="ng-tns-c96-1" _nghost-sll-c63="" role="img"><svg fill="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 25 24" style="fill: currentcolor;"><g clip-path="url(#clip0_697_23022)" fill="#939CA4"><path d="M6.5 5.75h.75v-1.5H6.5v1.5zM3.5 5v-.75V5zm-2 2H.75h.75zm20-2v-.75V5zm-3-.75h-.75v1.5h.75v-1.5zm0 14h-.75v1.5h.75v-1.5zM1.5 17H.75h.75zm5 2.75h.75v-1.5H6.5v1.5zm0-15.5h-3v1.5h3v-1.5zm-3 0c-.73 0-1.429.29-1.945.805l1.061 1.061A1.25 1.25 0 013.5 5.75v-1.5zm-1.945.805A2.75 2.75 0 00.75 7h1.5c0-.332.132-.65.366-.884l-1.06-1.06zM.75 7v5h1.5V7H.75zm23.5 5V7h-1.5v5h1.5zm0-5c0-.73-.29-1.429-.805-1.945l-1.061 1.061c.234.235.366.552.366.884h1.5zm-.805-1.945A2.75 2.75 0 0021.5 4.25v1.5c.331 0 .65.132.884.366l1.06-1.06zM21.5 4.25h-3v1.5h3v-1.5zm-3 15.5h3v-1.5h-3v1.5zm3 0c.73 0 1.429-.29 1.945-.805l-1.061-1.061a1.25 1.25 0 01-.884.366v1.5zm1.945-.805A2.75 2.75 0 0024.25 17h-1.5c0 .331-.132.65-.366.884l1.06 1.06zM24.25 17v-5h-1.5v5h1.5zM.75 12v5h1.5v-5H.75zm0 5c0 .73.29 1.429.805 1.945l1.061-1.061A1.25 1.25 0 012.25 17H.75zm.805 1.945a2.75 2.75 0 001.945.805v-1.5a1.25 1.25 0 01-.884-.366l-1.06 1.06zm1.945.805h3v-1.5h-3v1.5zM4.366 14.725l.646-5.45h1.335l1.122 3.829 1.123-3.83h1.32l.653 5.451H9.194l-.419-3.506.206.007-.859 3.5H6.787l-.865-3.5.227-.008-.41 3.507H4.365zM10.712 14.725l1.614-5.45h1.776l1.614 5.45H14.24l-.22-.865h-1.636l-.213.865h-1.46zm2.003-2.142h.976l-.492-2.098-.484 2.098z"></path><path d="M19.027 14.725l-3.382-5.45h1.57l3.382 5.45h-1.57zm-3.36 0l1.856-3.059.734 1.196-1.02 1.863h-1.57zm3.067-2.333l-.727-1.173 1.057-1.945h1.57l-1.9 3.118z"></path></g><defs><clipPath id="clip0_697_23022"><path fill="#fff" transform="translate(.5)" d="M0 0h24v24H0z"></path></clipPath></defs></svg></svg-icon> MAX ENTRIES 149999</li>
    <li><svg-icon _ngcontent-sll-c96="" name="avatar" class="ng-tns-c96-1" _nghost-sll-c63="" role="img"><svg fill="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 25 24" style="fill: currentcolor;"><path fill-rule="evenodd" clip-rule="evenodd" d="M1.903 12c0-5.852 4.744-10.597 10.597-10.597 5.852 0 10.596 4.745 10.596 10.597 0 5.852-4.744 10.596-10.596 10.596-5.853 0-10.597-4.744-10.597-10.596zM12.5 2.923a9.077 9.077 0 00-6.708 15.191A7.954 7.954 0 0112.5 14.44a7.954 7.954 0 016.709 3.673A9.077 9.077 0 0012.5 2.923zm5.57 16.243a6.437 6.437 0 00-5.57-3.206 6.437 6.437 0 00-5.57 3.207 9.037 9.037 0 005.57 1.91c2.1 0 4.033-.714 5.57-1.911zm-9.33-8.758a3.76 3.76 0 117.52 0 3.76 3.76 0 01-7.52 0zm3.76-2.24a2.24 2.24 0 100 4.48 2.24 2.24 0 000-4.48z" fill="#939CA4"></path></svg></svg-icon> MAX 500 PER PERSON</li>
    </ul></div>
    <div class="custom-div"><h4> Closing date and draw 30-08-2023 @ 8:00PM</h4>
    <ul>
    <li>Draw takes place regardless of sell out</li>
    <li>Competition will close sooner if the maximum entries are received</li>
    </ul>
    </div>';
}
add_action('woocommerce_after_single_product_summary', 'my_custom_div_after_product_form');


?>
