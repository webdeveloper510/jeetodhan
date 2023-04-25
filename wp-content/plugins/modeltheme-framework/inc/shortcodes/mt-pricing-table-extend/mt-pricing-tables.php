<?php 
/**
||-> Shortcode: Pricing tables
*/
function mt_shortcode_pricing_table_v4($params,  $content = NULL) {
    extract( shortcode_atts( 
        array(
          'switch_status'     => '',
            'el_class'            => ''
        ), $params ) );

    $pricing_table = '';
      $pricing_table .= '<div class="modeltheme-pricing-vers4">';
      $pricing_table .= '<div class="cd-pricing-container cd-has-margins">';
        
        if($switch_status == 'on') {
          $pricing_table .= '<div class="cd-pricing-switcher">';
            $pricing_table .= '<p class="fieldset">';
              $pricing_table .= '<input type="radio" name="duration-2" value="monthly" id="monthly-2" checked>';
              $pricing_table .= '<label class="monthly-label active" for="monthly-2">'.esc_html__('Monthly','modeltheme').'</label>';
              $pricing_table .= '<input type="radio" name="duration-2" value="yearly" id="yearly-2">';
              $pricing_table .= '<label class="yearly-label" for="yearly-2">'.esc_html__('Yearly','modeltheme').'</label>';
              $pricing_table .= '<span class="cd-switch"></span>';
            $pricing_table .= '</p>';
          $pricing_table .= '</div>';
        }
        $pricing_table .= '<div class="cd-pricing-list-parent">';
          $pricing_table .= '<ul class="row cd-pricing-list cd-bounce-invert">';
            $pricing_table .= do_shortcode($content);
          $pricing_table .= '</ul>'; //cd-bounce-invert
        $pricing_table .= '</div>';

      $pricing_table .= '</div>'; //cd-pricing-container
    $pricing_table .= '</div>'; //modeltheme-pricing-vers4

    return $pricing_table;
}
add_shortcode('mt_pricing_table_short_v4', 'mt_shortcode_pricing_table_v4');
/**
||-> Shortcode: Child Shortcode v1
*/
function mt_shortcode_pricing_table_v4_items($params, $content = NULL) {

    extract( shortcode_atts( 
        array(
          'animation'           => '',
          'svg_or_image'       => '', 
          'number_columns'    => '',
          'package_image'  => '',
          'custom_class'  => '',
          'animated_svg_loop'  => '',
          'start_svg_loop'  => '',
          'svg_color'  => '',    
          'package_svg'  => '',
          'package_title' => '',
          'package_price_per_month' => '',
          'package_price_per_year'  => '',
          'package_price_currency' => '',
          'button_url'  => '',
          'button_text' => '',
          'box_background_color'  => '',
          'button_background_color'  => '',
          'content_pricing_table' => '',
          'header_button_content_color' => '',
          'content_color' => ''
        ), $params ) );

    if(!empty($box_background_color)) {
        $box_background_color_var = 'skin_color_' . $box_background_color;
    } else {
        $box_background_color_var = 'skin_color_none';
    }

    $thumb      = wp_get_attachment_image_src($package_image, "full");
  	$thumb_src  = $thumb[0];
    $typed_unique_id = 'mt_animated_svg_'.uniqid();

    $pricing_table = '';
    $pricing_table .= '<li class="'.esc_attr($box_background_color_var).' '.esc_attr($number_columns).' wow '.$animation.'">';
      $pricing_table .= '<ul class="cd-pricing-wrapper">';
        
        $pricing_table .= '<li style="background:'.esc_attr($box_background_color).'" data-type="monthly" class="pricing-front">';
          $pricing_table .= '<div class="cd-pricing-flat-icon '.esc_attr($custom_class).'" style="background:'.esc_attr($box_background_color).'">';
            $pricing_table .= '<div class="pricing-image">';
               if($svg_or_image == 'choosed_svg'){
                $pricing_table .= '<svg  class="svg-icon" id="'.$typed_unique_id.'" data-type="'.$animated_svg_loop.'" data-start="'.$start_svg_loop.'" style="color:'.esc_attr($svg_color).'" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" enable-background="new 0 0 463 463">'.rawurldecode( base64_decode( $package_svg ) ).'</svg>';
              } elseif($svg_or_image == 'choosed_image') {
                $pricing_table .= '<img alt="pricing-table" src="'.esc_attr($thumb_src).'">';
              }
                
            $pricing_table .= '</div>';
          $pricing_table .= '</div>';
          $pricing_table .= '<header class="cd-pricing-header" style="background:'.esc_attr($box_background_color).'">';
            $pricing_table .= '<h2 style="color:'.esc_attr($header_button_content_color).'" class="package_title">'.esc_attr($package_title).'</h2>';
          $pricing_table .= '</header>';

          $pricing_table .= '<div style="color:'.esc_attr($content_color).'" class="cd-pricing-body">';

                $arr = array('ul' => array(), 'li' => array());
                $pricing_table .= wp_kses($content_pricing_table, $arr);

  				      $pricing_table .= '<div class="package_price_per_month-parent">';
  	              $pricing_table .= '<span class="cd-value-month"><sup>'.esc_attr($package_price_currency).'</sup>'.esc_attr($package_price_per_month).'<span class="line">/</span></span>';
  	              $pricing_table .= '<span class="cd-duration">'.esc_html__('month','modeltheme').'</span>';
  	            $pricing_table .= '</div>';
  	            $pricing_table .= '<div class="package_price_per_year-parent">';
  	              $pricing_table .= '<span class="cd-value-year"><sup>'.esc_attr($package_price_currency).'</sup>'.esc_attr($package_price_per_year).'<span class="line">/</span></span>';
  	              $pricing_table .= '<span class="cd-duration">'.esc_html__('year','modeltheme').'</span>';
  	            $pricing_table .= '</div>';

        				$pricing_table .= '<a style="background:'.esc_attr($button_background_color).'" class="pricing-select-button" href="'.esc_attr($button_url).'">'.esc_attr($button_text).'</a>';

          $pricing_table .= '</div>';

        $pricing_table .= '</li>';

      $pricing_table .= '</ul>'; //cd-pricing-wrapper
    $pricing_table .= '</li>';

      return $pricing_table;
}
add_shortcode('mt_pricing_table_short_v4_item', 'mt_shortcode_pricing_table_v4_items');
/**
||-> Map Shortcode in Visual Composer with: vc_map();
*/
if ( is_plugin_active( 'js_composer/js_composer.php' ) ) {
    //require_once('../vc-shortcodes.inc.arrays.php');
    //Register "container" content element. It will hold all your inner (child) content elements
    vc_map( array(
        "name" => esc_attr__("MT - Pricing tables v4", 'modeltheme'),
        "base" => "mt_pricing_table_short_v4",
        "as_parent" => array('only' => 'mt_pricing_table_short_v4_item'), 
        "content_element" => true,
        "show_settings_on_create" => true,
        "icon" => "smartowl_shortcode",
        "category" => esc_attr__('MT: ModelTheme', 'modeltheme'),
        "is_container" => true,
        "params" => array(
            // add params same as with any other content element
            array(
               "group" => "Options",
               "type" => "dropdown",
               "holder" => "div",
               "class" => "",
               "heading" => esc_attr__("Switch status"),
               "param_name" => "switch_status",
               "std" => '',
               "description" => esc_attr__(""),
               "value" => array(
                    'Enable'           => 'on',
                    'Disable'          => 'off'
               )
            ),    
        ),
        "js_view" => 'VcColumnView'
    ) );
    vc_map( array(
        "name" => esc_attr__("Pricing tables Item", 'modeltheme'),
        "base" => "mt_pricing_table_short_v4_item",
        "content_element" => true,
        "as_child" => array('only' => 'mt_pricing_table_short_v4'), // Use only|except attributes to limit parent (separate multiple values with comma)
        "params" => array(
            // add params same as with any other content element
       array(
           "group" => "Image Setup",
           "type" => "dropdown",
           "holder" => "div",
           "class" => "",
           "heading" => esc_attr__("Icon"),
           "param_name" => "svg_or_image",
           "std" => '',
           "description" => esc_attr__("Choose what you want to use: empty/image/svg"),
           "value" => array(
          'Nothing'     => 'choosed_nothing',
          'Use an image'     => 'choosed_image',
          'Use an svg'      => 'choosed_svg'
            )
        ),
       array(
               "group" => "Image Setup",
               "dependency" => array(
                   'element' => 'svg_or_image',
                   'value' => array( 'choosed_svg' ),
                   ),
               "type" => "colorpicker",
               "holder" => "div",
               "class" => "",
               "heading" => esc_attr__("SVG color", 'modeltheme'),
               "param_name" => "svg_color",
               "value" => esc_attr__("", 'modeltheme'),
               "description" => ""
            ),
        array(
           "group" => "Image Setup",
          "dependency" => array(
           'element' => 'svg_or_image',
           'value' => array( 'choosed_svg' ),
           ),
           "type" => "textarea_raw_html",
           "class" => "",
           "heading" => esc_attr__("SVG Path", 'modeltheme'),
           "description" => "Only add the path strokes of the SVG, without the svg tag",
           "param_name" => "package_svg",
           "value" => "",  
        ),
        array(
          "group" => "Image Setup",
          "type" => "dropdown",
           "holder" => "div",
           "class" => "",
           "heading" => esc_attr__("Loop animation", 'modeltheme'),
           "param_name" => "animated_svg_loop",
           "std" => '',
           "default" => 'delayed',
           "value" => array(
              esc_attr__('delayed', 'modeltheme')  => 'delayed',
              esc_attr__('async', 'modeltheme')    => 'async'           
            ),
        ),
        array(
          "group" => "Image Setup",
           "type" => "dropdown",
           "holder" => "div",
           "class" => "",
           "heading" => esc_attr__("Loop start", 'modeltheme'),
           "param_name" => "start_svg_loop",
           "std" => '',
           "default" => 'autostart',
           "value" => array(
              esc_attr__('autostart', 'modeltheme')  => 'autostart',
              esc_attr__('manual', 'modeltheme')    => 'manual'           
            )
          ),
            array(
              "group" => "Image Setup",
              "dependency" => array(
               'element' => 'svg_or_image',
               'value' => array( 'choosed_image' ),
               ),
              "type" => "attach_images",
              "holder" => "div",
              "class" => "",
              "heading" => esc_attr__( "Choose image", 'modeltheme' ),
              "param_name" => "package_image",
              "value" => "",
              "description" => esc_attr__( "Choose image for pricing table", 'modeltheme' )
            ),
            array(
               "group" => "Image Setup",
               "type" => "textfield",
               "holder" => "div",
               "class" => "",
               "heading" => esc_attr__("Custom class", 'modeltheme'),
               "param_name" => "custom_class",
               "std" => '',
               
              ),
          array(
               "group" => "Options",
               "type" => "dropdown",
               "holder" => "div",
               "class" => "",
               "heading" => esc_attr__("Number of columns"),
               "param_name" => "number_columns",
               "std" => '',
               "description" => esc_attr__(""),
               "value" => array(
                    '2'          => 'col-md-6',
                    '3'          => 'col-md-4'
               )
            ),  
            array(
               "group" => "Box Setup",
               "type" => "textfield",
               "holder" => "div",
               "class" => "",
               "heading" => esc_attr__("Package title", 'modeltheme'),
               "param_name" => "package_title",
               "value" => "",
               "description" => ""
            ),
            array(
               "group" => "Box Setup",
               "type" => "textfield",
               "holder" => "div",
               "class" => "",
               "heading" => esc_attr__("Package price per month", 'modeltheme'),
               "param_name" => "package_price_per_month",
               "value" => "",
               "description" => ""
            ),
            array(
               "group" => "Box Setup",
               "type" => "textfield",
               "holder" => "div",
               "class" => "",
               "heading" => esc_attr__("Package price per year", 'modeltheme'),
               "param_name" => "package_price_per_year",
               "value" => "",
               "description" => ""
            ),
            array(
               "group" => "Box Setup",
               "type" => "textfield",
               "holder" => "div",
               "class" => "",
               "heading" => esc_attr__("Package price currency", 'modeltheme'),
               "param_name" => "package_price_currency",
               "value" => "",
               "description" => ""
            ),
            array(
               "group" => "Box Setup",
               "type" => "textfield",
               "holder" => "div",
               "class" => "",
               "heading" => esc_attr__("Package button url", 'modeltheme'),
               "param_name" => "button_url",
               "value" => "",
               "description" => ""
            ),
            array(
               "group" => "Box Setup",
               "type" => "textfield",
               "holder" => "div",
               "class" => "",
               "heading" => esc_attr__("Package button text", 'modeltheme'),
               "param_name" => "button_text",
               "value" => esc_attr__("", 'modeltheme'),
               "description" => ""
            ),
            array(
               "group" => "Styling",
               "type" => "colorpicker",
               "holder" => "div",
               "class" => "",
               "heading" => esc_attr__("Box background color", 'modeltheme'),
               "param_name" => "box_background_color",
               "value" => esc_attr__("", 'modeltheme'),
               "description" => ""
            ),
            array(
               "group" => "Styling",
               "type" => "colorpicker",
               "holder" => "div",
               "class" => "",
               "heading" => esc_attr__("Button background color", 'modeltheme'),
               "param_name" => "button_background_color",
               "value" => esc_attr__("", 'modeltheme'),
               "description" => ""
            ),
            array(
              "group" => "Options",
              "type" => "textarea_html",
              "holder" => "div",
              "class" => "",
              "heading" => esc_attr__("Content pricing table", 'modeltheme'),
              "param_name" => "content_pricing_table",
              "value" => esc_attr__("", 'modeltheme'),
              "description" => "Create lists for pricing table with li tag"
            ),
            array(
               "group" => "Styling",
               "type" => "colorpicker",
               "holder" => "div",
               "class" => "",
               "heading" => esc_attr__("Content color of the header", 'modeltheme'),
               "param_name" => "header_button_content_color",
               "value" => esc_attr__("", 'modeltheme'),
               "description" => ""
            ),
            array(
               "group" => "Styling",
               "type" => "colorpicker",
               "holder" => "div",
               "class" => "",
               "heading" => esc_attr__("Content color of list", 'modeltheme'),
               "param_name" => "content_color",
               "value" => esc_attr__("", 'modeltheme'),
               "description" => ""
            ),
            array(
              "group" => "Animation",
              "type" => "dropdown",
              "heading" => esc_attr__("Animation", 'modeltheme'),
              "param_name" => "animation",
              "std" => '',
              "holder" => "div",
              "class" => "",
              "description" => "",
              "value" => $animations_list
            )
        )
    ) );
    //Your "container" content element should extend WPBakeryShortCodesContainer class to inherit all required functionality
    if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
        class WPBakeryShortCode_mt_pricing_table_short_v4 extends WPBakeryShortCodesContainer {
        }
    }
    if ( class_exists( 'WPBakeryShortCode' ) ) {
        class WPBakeryShortCode_mt_pricing_table_short_v4_item extends WPBakeryShortCode {
        }
    }
}