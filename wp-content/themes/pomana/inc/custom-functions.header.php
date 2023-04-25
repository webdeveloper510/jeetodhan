<?php
/**
CUSTOM HEADER FUNCTIONS
*/

/**
Function name: 				pomana_get_nav_menu()			
Function description:		Get page NAV MENU
*/
function pomana_get_nav_menu(){

    // PAGE METAS
	$page_custom_menu = get_post_meta( get_the_ID(), 'smartowl_page_custom_menu', true );

	$html = '';
    if ( has_nav_menu( 'primary' ) ) {
		$defaults = array(
			'menu'            => '',
			'container'       => false,
			'container_class' => '',
			'container_id'    => '',
			'menu_class'      => 'menu',
			'menu_id'         => '',
			'echo'            => true,
			'fallback_cb'     => false,
			'before'          => '<ul class="menu nav navbar-nav nav-effect nav-menu pull-right">',
			'after'           => '</ul>',
			'link_before'     => '',
			'link_after'      => '',
			'items_wrap'      => '%3$s',
			'depth'           => 0,
			'walker'          => ''
		);

		$defaults['theme_location'] = 'primary';
		if (isset($page_custom_menu)) {
			$html .= wp_nav_menu( array('menu' => $page_custom_menu ));
		}else{
			$html .= wp_nav_menu( $defaults );
		}
	}else {
		if( current_user_can('administrator') ) {
			$html .= '<p class="no-menu text-right">'.esc_html__('Primary navigation menu is missing.','pomana').'</p>';
		}
	}

    return $html;
}


/**
||-> FUNCTION: GET LOGO FUNCTION
*/
if (!function_exists('pomana_get_theme_logo')) {
	function pomana_get_theme_logo(){

		$html = '';

		if (is_page() || is_single() || is_404() || is_archive() || is_search() || is_home()) {

	        $custom_header_activated = get_post_meta( get_the_ID(), 'pomana_custom_header_options_status', true );
			$mt_metabox_header_logo = get_post_meta( get_the_ID(), 'mt_metabox_header_logo', true );

			if ($custom_header_activated && $custom_header_activated == 'yes') {
				if (isset($mt_metabox_header_logo)) {
					$html .= '<img class="page-logo main-static-logo" src="'.esc_url($mt_metabox_header_logo).'" alt="'.esc_attr(get_bloginfo()).'" />';
				}else{
					$html .= get_bloginfo();
				}
			}else{
				if (pomana_redux('pomana_logo','url')) {
					$html .= '<img class="theme-logo main-static-logo" src="'.esc_url(pomana_redux('pomana_logo','url')).'" alt="'.esc_attr(get_bloginfo()).'" />';
				}else{
					$html .= get_bloginfo();
				}
			}
		}

		return $html;
	}
}
if (!function_exists('pomana_get_theme_logo_sticky')) {
	function pomana_get_theme_logo_sticky(){

		$html = '';

    	if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
			if (pomana_redux('pomana_logo_sticky_header','url') != '' && pomana_redux('is_nav_sticky') != false) {
				$html .= '<img class="theme-logo theme-logo-sticky" src="'.esc_url(pomana_redux('pomana_logo_sticky_header','url')).'" alt="'.esc_attr(get_bloginfo()).'" />';
			}else{
				$html .= '<img class="theme-logo theme-logo-sticky" src="'.esc_url(get_template_directory_uri().'/images/theme_pomana_logo_dark.png').'" alt="'.esc_attr(get_bloginfo()).'" />';
			}
		}

		return $html;
	}
}

// Mobile Dropdown Menu Button
if (!function_exists('pomana_get_login_link')) {
    function pomana_get_login_link(){

        if (is_user_logged_in() || is_account_page()) {
            $user_url = get_permalink( get_option('woocommerce_myaccount_page_id') );;
            $data_attributes = '';
        }else{
            $user_url = '#';
            $data_attributes = 'data-modal="modal-log-in" class="modeltheme-trigger"';
        } ?>

        <a href="<?php echo esc_url($user_url); ?>" <?php echo esc_attr($data_attributes); ?>>
            <?php esc_html_e('Sign In','pomana'); ?>
        </a>

        <?php 
    }
    add_action('pomana_login_link_a', 'pomana_get_login_link');
}




/**
||-> FUNCTION: GET DYNAMIC CSS
*/
add_action('wp_enqueue_scripts', 'pomana_dynamic_css' );
function pomana_dynamic_css(){

    global  $pomana_redux;
    $html = '';

	wp_enqueue_style(
	   'pomana-custom-style',
	    get_template_directory_uri() . '/css/custom-editor-style.css'
	);


	// BORDER RADIUS STYLE
    if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
    	if (pomana_redux("pomana_border_radius") == 'default') {
			$btn_border_radius = '5px';
    	} else if (pomana_redux("pomana_border_radius") == 'boxed') {
    		$btn_border_radius = '0px';
    	}  else if (pomana_redux("pomana_border_radius") == 'round') {
    		$btn_border_radius = '30px';
    	} else {
    		$btn_border_radius = '5px';
    	}
   	} else {
   		$btn_border_radius = '5px';
   	}

	$html .= '  .header-v3 .telephone-btn,
	    		.button-winona.btn.btn-lg,
	    		.owl-theme .owl-controls .owl-buttons div,
	    		body .blood-donation input, body .blood-donation select, body .blood-donation textarea,
	    		.blood-donation button.submit-form,
	    		footer .newsletter input[type="email"],
	    		.back-to-top,
	    		.wp-block-search .wp-block-search__input, 
	    		.widget_search .search-field, 
	    		.post-password-form input[type="password"],
	    		.wp-block-search .wp-block-search__button, 
	    		.search-form .search-submit, 
	    		.post-password-form input[type="submit"],
	    		.tag-cloud-link,
	    		.pagination .page-numbers, 
	    		.woocommerce nav.woocommerce-pagination ul li a, 
	    		.woocommerce nav.woocommerce-pagination ul li span,
	    		.comment-form textarea,
	    		.comment-form button#submit,
	    		.modeltheme-pricing-vers4 .cd-pricing-switcher .cd-switch,
	    		.modeltheme-pricing-vers4 .cd-pricing-switcher .fieldset,
	    		.modeltheme-pricing-vers4 .cd-pricing-list li.pricing-front, 
	    		.modeltheme-pricing-vers4 .cd-pricing-list li.pricing-back,
	    		.modeltheme-pricing-vers4 a.pricing-select-button,
	    		.woocommerce .woocommerce-ordering select,
	    		.overlay-components, 
	    		.error404 a.vc_button_404, 
	    		a.sln-btn.sln-btn--borderonly.sln-btn--medium.sln-btn--icon.sln-btn--icon--left.sln-icon--back,
	    		.sln-btn.sln-btn--emphasis.sln-btn--medium.sln-btn--fullwidth, input#sln_time, input#sln_date, 
	    		.woocommerce #respond input#submit, 
	    		.woocommerce a.button, .woocommerce button.button, 
	    		.woocommerce input.button, table.compare-list .add-to-cart td a, 
	    		.woocommerce #respond input#submit.alt, 
	    		.woocommerce a.button.alt, 
	    		.woocommerce button.button.alt, 
	    		.woocommerce input.button.alt, 
	    		.woocommerce.single-product div.product form.cart .button,
	    		.woocommerce ul.products li.product .onsale,
	    		.woocommerce .quantity .qty,
	    		.woocommerce div.product .woocommerce-tabs ul.tabs li a,
	    		body.woocommerce.single-product div.product .woocommerce-tabs ul.tabs li,
	    		.woocommerce.single-product div.product .woocommerce-tabs .panel,
	    		.button-winona.btn.btn-medium,
	    		.wpcf7-form input, .wpcf7-form select,
	    		.woocommerce .woocommerce-info, .woocommerce .woocommerce-message,
	    		select, .woocommerce-cart table.cart td.actions .coupon .input-text, 
	    		.comment-form input, .woocommerce form .form-row input.input-text, .woocommerce .quantity .qty,
	    		.woocommerce form .form-row textarea,
	    		.woocommerce-checkout .select2-container .select2-selection--single,
	    		form#loginform input#user_login,
	    		form#loginform input#wp-submit,
	    		.modeltheme-modal button[type="submit"],
	    		.modeltheme-modal input[type="email"], .modeltheme-modal input[type="text"], .modeltheme-modal input[type="password"],
	    		.is_header_semitransparent #navbar .buy-button a{
	                border-radius: '.$btn_border_radius.' !important;
	            }';


    // PAGE PRELOADER BACKGROUND COLOR
    $mt_page_preloader = get_post_meta( get_the_ID(), 'mt_page_preloader', true );
    $mt_page_preloader_bg_color = get_post_meta( get_the_ID(), 'mt_page_preloader_bg_color', true );
	$mt_preloader_bg_color = '';

    if (isset($mt_page_preloader) && $mt_page_preloader == 'enabled' && isset($mt_page_preloader_bg_color)) {
        $html .= 'body .linify_preloader_holder{
					background-color: '.esc_html($mt_preloader_bg_color).';
        		}';
    }elseif (pomana_redux('mt_preloader_status')) {
        $html .= 'body .linify_preloader_holder{
					background-color: '.pomana_redux('mt_preloader_status').';
        		}';
    }
    // THEME OPTIONS STYLESHEET
    if(!pomana_redux('breadcrumbs-delimitator')) {
    	$delimitator = '/';
    } else {
    	$delimitator = pomana_redux('breadcrumbs-delimitator');
    }

    $thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_id() ),'' );
    if ( is_page()) {
		if ($thumbnail_src) {
	        $html .= '.modeltheme-breadcrumbs { background-image:url("'.esc_url($thumbnail_src[0]).'");}';
		}else{
	    	if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
	    		if (pomana_redux('pomana_header_breadcrumbs_image','url') != '') {
		        	$html .= '.modeltheme-breadcrumbs {background-image:url("'.esc_url(pomana_redux('pomana_header_breadcrumbs_image','url')).'");}';
	    		}else{
		        	$html .= '.modeltheme-breadcrumbs {background-color:#000;}';
	    		}
	        }else{
		        $html .= '.modeltheme-breadcrumbs {background-color:#000;}';
	        }
		}
    } else {
    	if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
    		if (pomana_redux('pomana_header_breadcrumbs_image','url') != '') {
	        	$html .= '.modeltheme-breadcrumbs {background-image:url("'.esc_url(pomana_redux('pomana_header_breadcrumbs_image','url')).'");}';
    		}else{
	        	$html .= '.modeltheme-breadcrumbs {background-color:#000;}';
    		}
        }else{
	        $html .= '.modeltheme-breadcrumbs {background-color:#000;}';
        }
    }

    $custom_header_activated = get_post_meta( get_the_ID(), 'pomana_custom_header_options_status', true );
	$mt_header_custom_bg_color = get_post_meta( get_the_ID(), 'mt_header_custom_bg_color', true );
    $mt_custom_main_color = get_post_meta( get_the_ID(), 'mt_custom_main_color', true );
    $mt_main_texts_color = get_post_meta( get_the_ID(), 'main_texts_color', true );
    $mt_custom_main_hover_color = get_post_meta( get_the_ID(), 'mt_custom_main_hover_color', true );
    $mt_header_semitransparent = get_post_meta( get_the_ID(), 'mt_header_semitransparent', true );
    if (isset($mt_header_semitransparent) == 'enabled') {
		$mt_header_semitransparentr_rgba_value = get_post_meta( get_the_ID(), 'mt_header_semitransparentr_rgba_value', true );
		$mt_header_semitransparentr_rgba_value_scroll = get_post_meta( get_the_ID(), 'mt_header_semitransparentr_rgba_value_scroll', true );
		
		if (isset($mt_header_custom_bg_color)) {
			list($r, $g, $b) = sscanf($mt_header_custom_bg_color, "#%02x%02x%02x");
		}else{
			$hexa = '#04ABE9'; //Theme Options Color
			list($r, $g, $b) = sscanf($hexa, "#%02x%02x%02x");
		}

		$html .= '
			.is_header_semitransparent .logo-infos,
			.is_header_semitransparent .navbar-default{
			    background: rgba('.esc_html($r).', '.esc_html($g).', '.esc_html($b).', '.esc_html($mt_header_semitransparentr_rgba_value).') none repeat scroll 0 0;
			}
			.is_header_semitransparent header{
			    background-color: transparent;
			}
			.is_header_semitransparent .sticky-wrapper.is-sticky .navbar-default {
			    background: rgba('.esc_html($r).', '.esc_html($g).', '.esc_html($b).', '.esc_html($mt_header_semitransparentr_rgba_value_scroll).') none repeat scroll 0 0;
			}';
    }

    // Defaults
	$skin_main_bg = '#EC6623';
	$skin_main_bg_hover = '#000';
	$skin_main_texts_color = '#000';
    if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
    	if (pomana_redux("mt_style_main_backgrounds_color") != '') {
			$skin_main_bg = pomana_redux("mt_style_main_backgrounds_color");
    	}

    	if (pomana_redux("mt_style_main_backgrounds_color_hover") != '') {
			$skin_main_bg_hover = pomana_redux("mt_style_main_backgrounds_color_hover");
    	}

    	if (pomana_redux("mt_style_main_texts_color") != '') {
			$skin_main_texts_color = pomana_redux("mt_style_main_texts_color");
    	}
   	}
    // METABOX COLORPICKER -> Main color
    if($custom_header_activated == 'yes' && isset($mt_custom_main_color) && !empty($mt_custom_main_color)) {
    	$skin_main_bg = $mt_custom_main_color;
	}
    // METABOX COLORPICKER -> Main color - hover
    if($custom_header_activated == 'yes' && isset($mt_custom_main_hover_color) && !empty($mt_custom_main_hover_color)) {
    	$skin_main_bg_hover = $mt_custom_main_hover_color;
	}
    // METABOX COLORPICKER -> Main texts color
    if($custom_header_activated == 'yes' && isset($mt_main_texts_color) && !empty($mt_main_texts_color)) {
    	$skin_main_texts_color = $mt_main_texts_color;
	}
    if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
	    $html .= '.single article .article-content p,
	               p,
	               .post-excerpt,
	               ul,
	               ul.tonsberg-list,
	               ol,
	               th,
	               td,
	               dt,
	               dd,
	               address{
	                    font-family: '.pomana_redux('modeltheme-blog-post-typography','font-family').';
	               }
	               h1,
	               h1 span {
	                    font-family: "'.pomana_redux('modeltheme-heading-h1','font-family').'";
	                    font-size: '.pomana_redux('modeltheme-heading-h1','font-size').';
	               }
	               h2 {
	                    font-family: "'.pomana_redux('modeltheme-heading-h2','font-family').'";
	                    font-size: '.pomana_redux('modeltheme-heading-h2','font-size').';
	               }
	               h3 {
	                    font-family: "'.pomana_redux('modeltheme-heading-h3','font-family').'";
	                    font-size: '.pomana_redux('modeltheme-heading-h3','font-size').';
	               }
	               h4 {
	                    font-family: "'.pomana_redux('modeltheme-heading-h4','font-family').'";
	                    font-size: '.pomana_redux('modeltheme-heading-h4','font-size').';
	               } 
	               h5 {
	                    font-family: "'.pomana_redux('modeltheme-heading-h5','font-family').'";
	                    font-size: '.pomana_redux('modeltheme-heading-h5','font-size').';
	               } 
	               h6 {
	                    font-family: "'.pomana_redux('modeltheme-heading-h6','font-family').'";
	                    font-size: '.pomana_redux('modeltheme-heading-h6','font-size').';
	               } 
	               #navbar .menu-item > a {
	                    font-family: "'.pomana_redux('modeltheme-navigation-typography','font-family').'";
	                    font-weight: '.pomana_redux('modeltheme-navigation-typography','font-weight').';
	               } 
	               input,
	               textarea {
	                    font-family: '.pomana_redux('modeltheme-inputs-typography','font-family').';
	               }
					.woocommerce ul.products li.product .button, 
					button, 
					ul.ecs-event-list li span, 
					.checkout-button, 
					input[type="submit"],
					.button-winona,
					#sln-salon .sln-btn--medium input, 
					#sln-salon .sln-btn--medium button, 
					#sln-salon .sln-btn--medium a,
					.error404 a.vc_button_404,
					.woocommerce ul.products li.product .added_to_cart,
					.woocommerce .woocommerce-message .button,
	               	input[type="submit"] {
	                    font-family: '.pomana_redux('modeltheme-buttons-typography','font-family').';
	               	}';

	    // THEME OPTIONS STYLESHEET - Responsive SmartPhones
	    $html .= '
	    			@media only screen and (max-width: 767px) {
	    				body h1,
	    				body h1 span{
	    					font-size: '.pomana_redux('mt_heading_h1_smartphones', 'font-size').' !important;
	    					line-height: '.pomana_redux('mt_heading_h1_smartphones', 'line-height').' !important;
	    				}
	    				body h2{
	    					font-size: '.pomana_redux('mt_heading_h2_smartphones', 'font-size').' !important;
	    					line-height: '.pomana_redux('mt_heading_h2_smartphones', 'line-height').' !important;
	    				}
	    				body h3{
	    					font-size: '.pomana_redux('mt_heading_h3_smartphones', 'font-size').' !important;
	    					line-height: '.pomana_redux('mt_heading_h3_smartphones', 'line-height').' !important;
	    				}
	    				body h4{
	    					font-size: '.pomana_redux('mt_heading_h4_smartphones', 'font-size').' !important;
	    					line-height: '.pomana_redux('mt_heading_h4_smartphones', 'line-height').' !important;
	    				}
	    				body h5{
	    					font-size: '.pomana_redux('mt_heading_h5_smartphones', 'font-size').' !important;
	    					line-height: '.pomana_redux('mt_heading_h5_smartphones', 'line-height').' !important;
	    				}
	    				body h6{
	    					font-size: '.pomana_redux('mt_heading_h6_smartphones', 'font-size').' !important;
	    					line-height: '.pomana_redux('mt_heading_h6_smartphones', 'line-height').' !important;
	    				}
	    			}';

	    // THEME OPTIONS STYLESHEET - Responsive Tablets
	    $html .= '
	    			@media only screen and (min-width: 768px) and (max-width: 1024px) {
	    				body h1,
	    				body h1 span{
	    					font-size: '.pomana_redux('mt_heading_h1_tablets', 'font-size').' !important;
	    					line-height: '.pomana_redux('mt_heading_h1_tablets', 'line-height').' !important;
	    				}
	    				body h2{
	    					font-size: '.pomana_redux('mt_heading_h2_tablets', 'font-size').' !important;
	    					line-height: '.pomana_redux('mt_heading_h2_tablets', 'line-height').' !important;
	    				}
	    				body h3{
	    					font-size: '.pomana_redux('mt_heading_h3_tablets', 'font-size').' !important;
	    					line-height: '.pomana_redux('mt_heading_h3_tablets', 'line-height').' !important;
	    				}
	    				body h4{
	    					font-size: '.pomana_redux('mt_heading_h4_tablets', 'font-size').' !important;
	    					line-height: '.pomana_redux('mt_heading_h4_tablets', 'line-height').' !important;
	    				}
	    				body h5{
	    					font-size: '.pomana_redux('mt_heading_h5_tablets', 'font-size').' !important;
	    					line-height: '.pomana_redux('mt_heading_h5_tablets', 'line-height').' !important;
	    				}
	    				body h6{
	    					font-size: '.pomana_redux('mt_heading_h6_tablets', 'font-size').' !important;
	    					line-height: '.pomana_redux('mt_heading_h6_tablets', 'line-height').' !important;
	    				}
	    			}';
   	}



	$html .= '.breadcrumb a::after {
	        	content: "'.esc_attr($delimitator).'";
	    	}
		    .logo img,
		    .navbar-header .logo img {
		        max-width: '.pomana_redux('logo_max_width').'px;
		    }

		    ::selection{
		        color: #fff;
		        background: '.esc_html($skin_main_bg).';
		    }
		    ::-moz-selection { /* Code for Firefox */
		        color: #fff;
		        background: '.esc_html($skin_main_bg).';
		    }

		    a,
		    .mt_members1 .flex-zone-inside a,
		    .is_header_semitransparent #navbar .buy-button a,
		    .wishlist_table tr td.product-stock-status span.wishlist-in-stock {
		        color: '.pomana_redux('mt_global_link_styling', 'regular').';
		    }

			.woocommerce ul.products li.product .button,
			.woocommerce.single-product span.amount,
			.archive .blog-posts .post-details .post-name a:hover,
			.page-template-template-blog .blog-posts .post-details .post-name a:hover,
			.modeltheme-breadcrumbs a.button-winona.scroll-down:hover,
			.woocommerce ul.products li.product .price span,
			.mt_members1 .flex-zone-inside a:hover,
			.product_meta > span a:hover,
			.is_header_semitransparent #navbar .sub-menu .menu-item a:hover,
			.woocommerce .star-rating span::before,
			.single-tribe_events .article-header.article-header-details .article-details .post-author i,
			.article-details .post-author a:hover,
			.woocommerce ul.products li.product a:hover,
			.is_header_semitransparent #navbar .buy-button a {
		        color: '.pomana_redux('mt_global_link_styling', 'regular').' !important;
		    }

		    .mt_members1 .flex-zone-inside a:hover,
		    .menu-mainmenu-container ul li a:hover ,
			.menu-mainmenu-container ul li.current_page_item > a,
			.woocommerce ul.products li.product .button:hover {
		    	color: '.pomana_redux('mt_global_link_styling', 'hover').' !important;
		    }
		    a:hover,
		    .is_header_semitransparent #navbar .buy-button a:hover {
		    	color: '.$skin_main_texts_color.';
		    }
		    #sln-salon h1 {
		    	font-family: "'.pomana_redux('modeltheme-heading-h1','font-family').'" !important;
			}
		    /*------------------------------------------------------------------
		        COLOR
		    ------------------------------------------------------------------*/
			.woocommerce a.remove{
		        color: '.esc_html($skin_main_texts_color).' !important;
		    }
		    .woocommerce-cart table.cart.shop_table_responsive td.product-subtotal .amount,
		    #wp-calendar a,
			span.amount,
			.page404-text-h,
			table.compare-list .remove td a .remove,
			.woocommerce form .form-row .required,
			.woocommerce .woocommerce-info::before,
			.woocommerce .woocommerce-message::before,
			.woocommerce div.product p.price, 
			.woocommerce div.product span.price,
			.woocommerce div.product .woocommerce-tabs ul.tabs li.active,
			.widget_popular_recent_tabs .nav-tabs li.active a,
			.widget_product_categories .cat-item:hover,
			.widget_product_categories .cat-item a:hover,
			.widget_archive li:hover,
			.widget_categories .cat-item:hover,
			.woocommerce .star-rating span::before,
			.pricing-table.recomended .button.solid-button, 
			.pricing-table .table-content:hover .button.solid-button,
			.pricing-table.Recommended .button.solid-button, 
			.pricing-table.recommended .button.solid-button, 
			#sync2 .owl-item.synced .post_slider_title,
			#sync2 .owl-item:hover .post_slider_title,
			#sync2 .owl-item:active .post_slider_title,
			.pricing-table.recomended .button.solid-button, 
			.pricing-table .table-content:hover .button.solid-button,
			.testimonial-author,
			.testimonials-container blockquote::before,
			.testimonials-container blockquote::after,
			h1 span,
			h2 span,
			.widget_nav_menu li a:hover,
			label.error,
			.author-name,
			.comment_body .author_name,
			.prev-next-post a:hover,
			.prev-text,
			.wpb_button.btn-filled:hover,
			.next-text,
			.social ul li a:hover i,
			.wpcf7-form span.wpcf7-not-valid-tip,
			.text-dark .statistics .stats-head *,
			.wpb_button.btn-filled,
			article .post-name:hover a,
			.post-excerpt .more-link:hover,			
			.lms-lesson-icon,
			.mt-tabs h5.tab-title,
			.course-quiz .course-item-title:hover,
			.course-item-title.button-load-item:hover,
			.categories_shortcode .category.active, .categories_shortcode .category:hover,
			.widget_recent_entries_with_thumbnail li:hover a,
			.widget_recent_entries li a:hover,
			.widget_categories li:hover > a,
			.widget_pages li a:hover,
			.widget_meta li a:hover,
			.widget_pages li a:hover,
			.course_title a:hover,
			.sidebar-content .widget_nav_menu li a:hover,
			.listing-taxonomy-shortcode .title-n-categories .post-name a:hover,
			.widget_recent_comments li:hover a,
			.widget_recent_comments li a:hover,
			.listing-details-author-info li i,
			a.rsswidget:hover {
		        color: '.esc_html($skin_main_texts_color).';
		    }


		    /*------------------------------------------------------------------
		        BACKGROUND + BACKGROUND-COLOR
		    ------------------------------------------------------------------*/
			.pomana-contact button.submit-form,
			.related-posts .post-read-more i,
			.pricing--tenzin .pricing__item,
			.comment-form button#submit,
			.wp-block-search .wp-block-search__button,
			.search-form .search-submit,
			.post-password-form input[type="submit"],
			.woocommerce a.remove:hover,
			.woocommerce table.shop_table thead,
			.woocommerce a.button.alt,
			.woocommerce a.button,
			.woocommerce button.button.alt, .woocommerce button.button,
			.woocommerce button.button,
			.woocommerce button.button.alt,
			.newsletter button.rippler,
			.tag-cloud-link:hover,
			.modeltheme-icon-search,
			.wpb_button::after,
			.related.products > h2::before,
			.rotate45,
			.latest-posts .post-date-day,
			.latest-posts h3, 
			.latest-tweets h3, 
			.latest-videos h3,
			.button.solid-button, 
			button.vc_btn,
			.pricing-table.recomended .table-content, 
			.pricing-table .table-content:hover,
			.pricing-table.Recommended .table-content, 
			.pricing-table.recommended .table-content, 
			.pricing-table.recomended .table-content, 
			.pricing-table .table-content:hover,
			.block-triangle,
			.owl-theme .owl-controls .owl-page span,
			body .vc_btn.vc_btn-blue, 
			body a.vc_btn.vc_btn-blue, 
			body button.vc_btn.vc_btn-blue,
			.woocommerce input.button,
			table.compare-list .add-to-cart td a,
			.woocommerce #respond input#submit.alt, 
			.woocommerce input.button.alt,
			.woocommerce .widget_price_filter .ui-slider .ui-slider-range,
			.woocommerce nav.woocommerce-pagination ul li a:focus, 
			.woocommerce nav.woocommerce-pagination ul li a:hover, 
			.woocommerce nav.woocommerce-pagination ul li span.current, 
			.pagination .page-numbers.current,
			.pagination .page-numbers:hover,
			.widget_social_icons li a:hover, 
			#subscribe > button[type=\'submit\'],
			.social-sharer > li:hover,
			.prev-next-post a:hover .rotate45,
			.masonry_banner.default-skin,
			.form-submit input,
			.member-header::before, 
			.member-header::after,
			.member-footer .social::before, 
			.member-footer .social::after,
			.subscribe > button[type=\'submit\'],
			.woocommerce.single-product .wishlist-container .yith-wcwl-wishlistaddedbrowse,
			.woocommerce #respond input#submit.alt.disabled, 
			.woocommerce #respond input#submit.alt.disabled:hover, 
			.woocommerce #respond input#submit.alt:disabled, 
			.woocommerce #respond input#submit.alt:disabled:hover, 
			.woocommerce #respond input#submit.alt[disabled]:disabled, 
			.woocommerce #respond input#submit.alt[disabled]:disabled:hover, 
			.woocommerce a.button.alt.disabled, 
			.woocommerce a.button.alt.disabled:hover, 
			.woocommerce a.button.alt:disabled, 
			.woocommerce a.button.alt:disabled:hover, 
			.woocommerce a.button.alt[disabled]:disabled, 
			.woocommerce a.button.alt[disabled]:disabled:hover, 
			.woocommerce button.button.alt.disabled, 
			.woocommerce button.button.alt.disabled:hover, 
			.woocommerce button.button.alt:disabled, 
			.woocommerce button.button.alt:disabled:hover, 
			.woocommerce button.button.alt[disabled]:disabled, 
			.woocommerce button.button.alt[disabled]:disabled:hover, 
			.woocommerce input.button.alt.disabled, 
			.woocommerce input.button.alt.disabled:hover, 
			.woocommerce input.button.alt:disabled, 
			.woocommerce input.button.alt:disabled:hover, 
			.woocommerce input.button.alt[disabled]:disabled, 
			.woocommerce input.button.alt[disabled]:disabled:hover,
			.no-results input[type=\'submit\'],
			table.compare-list .add-to-cart td a,
			h3#reply-title::after,
			.newspaper-info,
			.categories_shortcode .owl-controls .owl-buttons i:hover,
			.widget-title:after,
			h2.heading-bottom:after,
			.wpb_content_element .wpb_accordion_wrapper .wpb_accordion_header.ui-state-active,
			#primary .main-content ul li:not(.rotate45)::before,
			.wpcf7-form .wpcf7-submit,
			ul.ecs-event-list li span,
			.curriculum-sections .section .section-header::after,
			.widget_address_social_icons .social-links a,
			#contact_form2 .solid-button.button,
			.details-container > div.details-item .amount, .details-container > div.details-item ins,
			.modeltheme-search .search-submit,
			.navbar-nav .search_products a i, 
			#learn-press-form-login #wp-submit,
			.navbar-nav .shop_cart a i,
			#wp-calendar #today,
			#comment-nav-above .screen-reader-text::after,
			.pricing-table.recommended .table-content .title-pricing,
			.pricing-table .table-content:hover .title-pricing,
			.pricing-table.recommended .button.solid-button,
			.courses-list a.view-course,
			.mt-tabs .tabs-style-iconbox nav ul li.tab-current a,
			.event-more .read-more-btn,
			.mt-tabs .content-wrap a.tabs_button,
			.pricing-table .table-content:hover .button.solid-button,
			footer .footer-top .menu .menu-item a::before,
			#wp-calendar td#today,
			.post-password-form input[type=\'submit\'],
			.error404 a.vc_button_404,
			.first_header p.header-button a:hover,
			.first_header p.header-button a:hover,
			.woocommerce #respond input#submit,
			span.top-account:hover,
			span.top-cart:hover,
			.first_header p.header-button a,
			.first_header p.header-button a {
		        background: '.esc_html($skin_main_bg).';
		    }
		    .modeltheme-pricing-vers4 .cd-pricing-body li::before,
		    .woocommerce div.product .woocommerce-tabs ul.tabs li a,
		    .woocommerce div.product .woocommerce-tabs ul.tabs li a:hover,
		    .slider_appoint .vc_btn3.vc_btn3-size-lg,
		    .slider_search .vc_btn3.vc_btn3-size-lg:hover,
		    .header-v3 .telephone-btn a,
		    .blog_badge_date span,
		    .woocommerce ul.cart_list li:hover a, 
		    .woocommerce ul.product_list_widget li:hover a,
		    .page-links a:hover{
		    	color: '.esc_html($skin_main_bg).';
		    }
		    .shortcode_post_content .post-name a:hover,
		    .widget_categories li a:hover,
		    .widget_recent_entries_with_thumbnail li a:hover,
		    .sidebar-content .widget li a:hover{
		    	color: '.esc_html($skin_main_bg).' !important;
		    }
		    .tagcloud > a:hover,
		    .woocommerce div.product .woocommerce-tabs ul.tabs li.active,
		    .owl-pagination .owl-page.active span,
			body #mega_main_menu li.default_dropdown .mega_dropdown > li > .item_link:hover, 
			body #mega_main_menu li.widgets_dropdown .mega_dropdown > li > .item_link:hover, 
			body #mega_main_menu li.multicolumn_dropdown .mega_dropdown > li > .item_link:hover, 
			body #mega_main_menu li.grid_dropdown .mega_dropdown > li > .item_link:hover,
			body .tp-bullets.preview1 .bullet,
			.modeltheme-pricing-vers4 .cd-pricing-switcher .cd-switch,
			.slider_search .vc_btn3.vc_btn3-size-lg,
			.slider_appoint .vc_btn3.vc_btn3-size-lg:hover,
			.blood-request-content .request-btn i,
			.pomana-top-bar,
			.modeltheme-modal button[type="submit"],
			.is_header_semitransparent #navbar .buy-button a:hover,
			.picker__day--highlighted:hover, .picker--focused .picker__day--highlighted, 
			.picker__day--infocus:hover, .picker__day--outfocus:hover, 
			.picker__button--today:hover, .picker__button--close:hover, 
			.picker__button--clear:hover,
			.single-post .blog_custom .button-winona{
		        background: '.esc_html($skin_main_bg).' !important;
		    }
		    /* BORDER TOP COLOR */
		    .mt-tabs .tabs-style-iconbox nav ul li.tab-current a::after {
		        border-top-color: '.esc_html($skin_main_bg).';
		    }
		    .header-v3 .telephone-btn,
		    .picker__day--highlighted:hover, 
		    .picker--focused .picker__day--highlighted, .picker__day--infocus:hover, 
		    .picker__day--outfocus:hover, 
		    .picker__button--today:hover, 
		    .picker__button--close:hover, 
		    .picker__button--clear:hover{
		        border-color: '.esc_html($skin_main_bg).' !important;
		    }
		    /* BACK TO TOP */
		    .no-touch .back-to-top {
		    	background-color: '.esc_html($skin_main_bg).';
		    }
		    .woocommerce button.button:disabled:hover,
		    .woocommerce button.button:disabled[disabled]:hover,
		    .mt_members1 .owl-prev, .mt_members1 .owl-next,
		    .single-post .blog_custom .button-winona:hover {
		    	background-color: '.esc_html($skin_main_bg_hover).' !important;
		    }
		    .woocommerce a.button:hover,
		    .no-touch .back-to-top:hover,
		    .woocommerce button.button:hover,
		    .woocommerce button.button.alt:hover {
		    	background-color: '.esc_html($skin_main_bg_hover).';
		    }
		    .pomana-contact button.submit-form:hover,
		    .comment-form button#submit:hover,
		    .sidebar-content .search-form .search-submit:hover,
		    .wp-block-search .wp-block-search__button:hover,
		    .search-form .search-submit:hover,
		    .post-password-form input[type="submit"]:hover,
		    .woocommerce a.button.alt:hover,
		    .newsletter button.rippler:hover,
		    .mt-tabs .content-wrap a.tabs_button:hover,
			.modeltheme-search .search-submit:hover,
			.woocommerce input.button:hover,
			table.compare-list .add-to-cart td a:hover,
			.woocommerce #respond input#submit.alt:hover, 
			.woocommerce input.button.alt:hover,
			.modeltheme-search.modeltheme-search-open .modeltheme-icon-search, 
			.no-js .modeltheme-search .modeltheme-icon-search,
			.modeltheme-icon-search:hover,
			.latest-posts .post-date-month,
			.button.solid-button:hover,
			body .vc_btn.vc_btn-blue:hover, 
			body a.vc_btn.vc_btn-blue:hover, 
			body button.vc_btn.vc_btn-blue:hover,
			#contact_form2 .solid-button.button:hover,
			.subscribe > button[type=\'submit\']:hover,
			.no-results input[type=\'submit\']:hover,
			ul.ecs-event-list li span:hover,
			.pricing-table.recommended .table-content .price_circle,
			.pricing-table .table-content:hover .price_circle,
			table.compare-list .add-to-cart td a:hover,
			.navbar-nav .search_products a:hover i, 
			.navbar-nav .shop_cart a:hover i,
			#modal-search-form .modal-content input.search-input,
			.wpcf7-form .wpcf7-submit:hover,
			#comment-nav-above .nav-previous a:hover, #comment-nav-above .nav-next a:hover,
			.pricing-table.recommended .button.solid-button:hover,
			.pricing-table .table-content:hover .button.solid-button:hover,
			.widget_address_social_icons .social-links a:hover,
			#learn-press-form-login #wp-submit:hover,
			.hover-components .component:hover,
			.post-password-form input[type=\'submit\']:hover,
			blockquote::before,
			.error404 a.vc_button_404:hover,
			.header-v3 .contact-btn,
			.BDD-service::after,
			.woocommerce #respond input#submit:hover
			{
		        background: '.esc_html($skin_main_bg_hover).';
		    }
		    .mt_members1 .owl-prev:hover, .mt_members1 .owl-next:hover,
		    .modeltheme-pricing-vers4 a.pricing-select-button:hover,
		    .blood-request-content .request_infos:hover .request-btn i,
		    .modeltheme-modal button[type="submit"]:hover,
		    .woocommerce-MyAccount-navigation-link:hover a, 
			.woocommerce-MyAccount-navigation-link.is-active a {
		        background: '.esc_html($skin_main_bg_hover).' !important;
		    }
			.woocommerce ul.cart_list li a::before, 
			.woocommerce ul.product_list_widget li a::before,
			.flickr_badge_image a::after,
			.thumbnail-overlay,
			.portfolio-hover,
			.pastor-image-content .details-holder,
			.hover-components .component,
			.item-description .holder-top,
			.comment-edit-link:hover, .comment-reply-link:hover  {
		        background: '.pomana_redux("mt_style_semi_opacity_backgrounds", "color").';
		    }
		    .mt-tabs .tabs nav li.tab-current a {
		    	background: '.esc_html($skin_main_bg_hover).' !important;
		    }

		    /*------------------------------------------------------------------
		        BORDER-COLOR
		    ------------------------------------------------------------------*/
		    .woocommerce form .form-row.woocommerce-validated .select2-container,
			.woocommerce form .form-row.woocommerce-validated input.input-text,
			.woocommerce form .form-row.woocommerce-validated select,
			.author-bio,
			.widget_popular_recent_tabs .nav-tabs > li.active,
			body .left-border, 
			body .right-border,
			body .member-header,
			body .member-footer .social,
			.woocommerce div.product .woocommerce-tabs ul.tabs li.active,
			.woocommerce .woocommerce-info, 
			.woocommerce .woocommerce-message,
			body .button[type=\'submit\'],
			.navbar ul li ul.sub-menu,
			.wpb_content_element .wpb_tabs_nav li.ui-tabs-active,
			.header_mini_cart,
			.header_mini_cart.visible_cart,
			#contact-us .form-control:focus,
			.header_mini_cart .woocommerce .widget_shopping_cart .total, 
			.header_mini_cart .woocommerce.widget_shopping_cart .total,
			.sale_banner_holder:hover,
			.testimonial-img,
			.wpcf7-form input:focus, 
			.wpcf7-form textarea:focus,
			.header_search_form,
			blockquote,
			.blog_badge_date span{
		        border-color: '.esc_html($skin_main_texts_color).';
		    }
		    .blood-request-content .request_infos:hover{
		    	border-color: '.esc_html($skin_main_texts_color).' !important;
		    }
		    .sidebar-content .widget_archive li,
		 	.sidebar-content .widget_categories li,
		 	.member01-content-inside p.member01_position,
		 	.woocommerce ul.products li.product .price span,
		 	.modeltheme_products_carousel h3.modeltheme-archive-product-title a:hover{
		        color: '.esc_html($skin_main_texts_color).';
		    }
		    .shortcode_post_content .text_content .post-read-more i,
		    .post-details .rippler.rippler-default i{
		    	background: '.esc_html($skin_main_texts_color).';
		    }

		    article .post-name:hover a,
		    footer .widget_pages a:hover,
		    footer .widget_meta a:hover,
		    footer .widget_categories li a:hover,
		    footer .widget_categories li.cat-item:hover,
		    footer .widget_archive li a:hover,
		    footer .widget_archive li:hover
		    {
		    	color: '.esc_html($skin_main_bg_hover).';
		    }

		    /*------------------------------------------------------------------
		        HOME OUR PROGRAM - ICON COURSES
		    ------------------------------------------------------------------*/
		    .first_header.is_header_semitransparent nav#modeltheme-main-head {
		    	position:absolute !important;
		    }';

	if(function_exists('pomana_minify_css')){
    	wp_add_inline_style( 'pomana-custom-style', pomana_minify_css($html) );
	}else{
    	wp_add_inline_style( 'pomana-custom-style', $html );
	}

}



/**
||-> FUNCTION: GET GOOGLE FONTS FROM THEME OPTIONS PANEL
*/
function pomana_get_site_fonts(){
    global  $pomana_redux;
    $fonts_string = 'Jost:regular,300,400,500,600,700,bold%7C';
    if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
	    if (isset($pomana_redux['google-fonts-select'])) {
	        $i = 0;
	        $len = count($pomana_redux['google-fonts-select']);
	        foreach(array_keys($pomana_redux['google-fonts-select']) as $key){
	            $font_url = str_replace(' ', '+', $pomana_redux['google-fonts-select'][$key]);
	            
	            if ($i == $len - 1) {
	                // last
	                $fonts_string .= $font_url;
	            }else{
	                $fonts_string .= $font_url . '%7C';
	            }
	            $i++;
	        }
	        // fonts url
	        $fonts_url = add_query_arg( 'family', $fonts_string, "//fonts.googleapis.com/css" );
	        // enqueue fonts
	        wp_enqueue_style( 'pomana-fonts', $fonts_url, array(), '1.0.0' );
	    }
	} else {
        $font_url = str_replace(' ', '+', 'Poppins:300,regular,500,600,700,latin-ext,latin,devanagari%7CJost:regular,300,400,500,600,700,bold');
        $fonts_url = add_query_arg( 'family', $font_url, "//fonts.googleapis.com/css" );
        wp_enqueue_style( 'pomana-fonts-fallback', $fonts_url, array(), '1.0.0' );
    }
}
add_action('wp_enqueue_scripts', 'pomana_get_site_fonts');


/**
||-> FUNCTION: Add specific CSS class by filter
*/
add_filter( 'body_class', 'pomana_body_classes' );
function pomana_body_classes( $classes ) {

    // CHECK IF FEATURED IMAGE IS FALSE(Disabled)
    $post_featured_image = '';
    if (is_singular('post')) {
        if (pomana_redux('post_featured_image')) {
            if (pomana_redux('post_featured_image') == false) {
                $post_featured_image = 'hide_post_featured_image';
            }else{
                $post_featured_image = '';
            }
        }
    }

    // CHECK IF THE NAV IS STICKY
    $is_nav_sticky = '';
    if (pomana_redux('is_nav_sticky')) {
        if (pomana_redux('is_nav_sticky') == true) {
            // If is sticky
            $is_nav_sticky = 'is_nav_sticky';
        }else{
            // If is not sticky
            $is_nav_sticky = '';
        }
    }

     // CHECK IF HEADER IS SEMITRANSPARENT
    $semitransparent_header_meta = get_post_meta( get_the_ID(), 'mt_header_semitransparent', true );
    $semitransparent_header = '';
    if ( class_exists( 'ReduxFrameworkPlugin' ) ) { 
    	$semitransparent_header = 'is_header_semitransparent';
	}

    // CHECK IF ADD-TO-COMPARE option is true
    $widgetMonsterStatus = '';
    if ( class_exists( 'Monster_Widget' ) ) {
        // If is sticky
        $widgetMonsterStatus = 'monster-widget-active';
    }else{
        // If is not sticky
        $widgetMonsterStatus = '';
    }

    $hide_breadcrumbs_area = '';
    if (is_page() || is_singular('post')) {
    	if (function_exists('modeltheme_framework')) {
			$breadcrumbs_on_off = get_post_meta( get_the_ID(), 'breadcrumbs_on_off', true );
			if (isset($breadcrumbs_on_off) && $breadcrumbs_on_off == 'no') {
				$hide_breadcrumbs_area = 'hide_breadcrumbs_area';
			}
			if ($breadcrumbs_on_off == 'no') {
				$hide_breadcrumbs_area = 'hide_breadcrumbs_area';
			}
		}
    }

    // DIFFERENT HEADER LAYOUT TEMPLATES
    $header_version = 'first_header';

    $custom_header_activated = get_post_meta( get_the_ID(), 'pomana_custom_header_options_status', true );
    $header_v = get_post_meta( get_the_ID(), 'pomana_header_custom_variant', true );

    if (is_page() || is_single()) {
        if ($custom_header_activated && $custom_header_activated == 'yes') {
	        if ($header_v == '1') {
	            // Header Layout #1
	            $header_version = 'first_header';
	        }elseif ($header_v == '2') {
	            // Header Layout #2
	            $header_version = 'second_header';
	        }elseif ($header_v == '3') {
	            // Header Layout #3
	            $header_version = 'third_header';
	        }elseif ($header_v == '4') {
	            // Header Layout #4
	            $header_version = 'fourth_header';
	        }elseif ($header_v == '5') {
	            // Header Layout #5
	            $header_version = 'fifth_header';
	        }elseif ($header_v == '6') {
	            // Header Layout #6
	            $header_version = 'sixth_header';
	        }elseif ($header_v == '7') {
	            // Header Layout #7
	            $header_version = 'seventh_header';
	        }elseif ($header_v == '8') {
	            // Header Layout #8
	            $header_version = 'eighth_header';
	        }else{
	            // if no header layout selected show header layout #1
	            $header_version = 'first_header';
	        }
        }else{
		    if (pomana_redux('header_layout')) {
		        if (pomana_redux('header_layout') == 'first_header') {
		            // Header Layout #1
		            $header_version = 'first_header';
		        }elseif (pomana_redux('header_layout') == 'second_header') {
		            // Header Layout #2
		            $header_version = 'second_header';
		        }elseif (pomana_redux('header_layout') == 'third_header') {
		            // Header Layout #3
		            $header_version = 'third_header';
		        }elseif (pomana_redux('header_layout') == 'fourth_header') {
		            // Header Layout #4
		            $header_version = 'fourth_header';
		        }elseif (pomana_redux('header_layout') == 'fifth_header') {
		            // Header Layout #5
		            $header_version = 'fifth_header';
		        }elseif (pomana_redux('header_layout') == 'sixth_header') {
		            // Header Layout #6
		            $header_version = 'sixth_header';
		        }elseif (pomana_redux('header_layout') == 'seventh_header') {
		            // Header Layout #7
		            $header_version = 'seventh_header';
		        }elseif (pomana_redux('header_layout') == 'eighth_header') {
		            // Header Layout #8
		            $header_version = 'eighth_header';
		        }else{
		            // if no header layout selected show header layout #1
		            $header_version = 'first_header';
		        }
		    }
        }
    }else{
	    if (pomana_redux('header_layout')) {
	        if (pomana_redux('header_layout') == 'first_header') {
	            // Header Layout #1
	            $header_version = 'first_header';
	        }elseif (pomana_redux('header_layout') == 'second_header') {
	            // Header Layout #2
	            $header_version = 'second_header';
	        }elseif (pomana_redux('header_layout') == 'third_header') {
	            // Header Layout #3
	            $header_version = 'third_header';
	        }elseif (pomana_redux('header_layout') == 'fourth_header') {
	            // Header Layout #4
	            $header_version = 'fourth_header';
	        }elseif (pomana_redux('header_layout') == 'fifth_header') {
	            // Header Layout #5
	            $header_version = 'fifth_header';
	        }elseif (pomana_redux('header_layout') == 'sixth_header') {
	            // Header Layout #6
	            $header_version = 'sixth_header';
	        }elseif (pomana_redux('header_layout') == 'seventh_header') {
	            // Header Layout #7
	            $header_version = 'seventh_header';
	        }elseif (pomana_redux('header_layout') == 'eighth_header') {
	            // Header Layout #8
	            $header_version = 'eighth_header';
	        }else{
	            // if no header layout selected show header layout #1
	            $header_version = 'first_header';
	        }
	    }
    }


    // FOOTER ROWS CLASSES
    $footer_rows_status = '';
    $mt_footer_custom_row1_status = get_post_meta( get_the_ID(), 'mt_footer_custom_row1_status', true );
    $mt_footer_custom_row2_status = get_post_meta( get_the_ID(), 'mt_footer_custom_row2_status', true );
    $mt_footer_custom_row3_status = get_post_meta( get_the_ID(), 'mt_footer_custom_row3_status', true );
    // Rows #1
    if (isset($mt_footer_custom_row1_status)) {
	    if ($mt_footer_custom_row1_status == 'disabled') {
	    	$footer_rows_status .= ' hide_footer_row1 ';
	    }
    }
    // Rows #2
    if (isset($mt_footer_custom_row2_status)) {
	    if ($mt_footer_custom_row2_status == 'disabled') {
	    	$footer_rows_status .= ' hide_footer_row2 ';
	    }
    }
    // Rows #3
    if (isset($mt_footer_custom_row3_status)) {
	    if ($mt_footer_custom_row3_status == 'disabled') {
	    	$footer_rows_status .= ' hide_footer_row3 ';
	    }
    }

    $plugin_redux_status = '';
    if ( !class_exists( 'ReduxFrameworkPlugin' ) ) {
        $plugin_redux_status = 'missing-redux-framework';
    } else {
    	$plugin_redux_status = 'added-redux-framework';
    }


    $classes[] = esc_attr($hide_breadcrumbs_area) . ' ' . esc_attr($widgetMonsterStatus) . ' ' . esc_attr($footer_rows_status) . ' ' . esc_attr($post_featured_image) . ' ' . esc_attr($is_nav_sticky) . ' ' . esc_attr($header_version) . ' ' . esc_attr($semitransparent_header) . ' ' . esc_attr($plugin_redux_status) . ' ';
    return $classes;

}