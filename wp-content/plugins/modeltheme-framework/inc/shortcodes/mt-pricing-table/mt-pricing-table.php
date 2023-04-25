<?php 
/*---------------------------------------------*/
/*--- 14. Pricing tables ---*/
/*---------------------------------------------*/
function pomana_pricing_table_shortcode($params, $content) {
    extract( shortcode_atts( 
        array(
            'package_currency'  => '',
            'package_price'     => '',
            'package_name'      => '',
            'package_basis'     => '',
            'package_desc'      => '',
            'package_feature1'  => '',
            'package_feature2'  => '',
            'package_feature3'  => '',
            'package_feature4'  => '',
            'package_feature5'  => '',
            'package_feature6'  => '',
            'animation'         => '',
            'button_url'        => '',
            'recommended'       => '',
            'button_text'       => ''
        ), $params ) );
    $pricing_table = '';
    $pricing_table .= '<div class="pricing-table '.$recommended.'" data-animate="'.$animation.'">';
        $pricing_table .= '<div class="table-content">';
            $pricing_table .= '<h2>'.$package_name.'</h2>';
            $pricing_table .= '<small>'.$package_currency.'</small><span class="price">'.$package_price.'</span><span class="basis">'.$package_basis.'</span>';
            if($package_desc) {
                $pricing_table .= '<p class="package_desc">'.$package_desc.'</p>';
            }
            $pricing_table .= '<ul class="text-center">';
                $pricing_table .= '<li>'.$package_feature1.'</li>';
                $pricing_table .= '<li>'.$package_feature2.'</li>';
                $pricing_table .= '<li>'.$package_feature3.'</li>';
                $pricing_table .= '<li>'.$package_feature4.'</li>';
                $pricing_table .= '<li>'.$package_feature5.'</li>';
                $pricing_table .= '<li>'.$package_feature6.'</li>';
            $pricing_table .= '</ul>';
            $pricing_table .= '<div class="button-holder text-center">';
                $pricing_table .= '<a href="'.$button_url.'" class="solid-button button">'.$button_text.'</a>';
            $pricing_table .= '</div>';
        $pricing_table .= '</div>';
    $pricing_table .= '</div>';
    return $pricing_table;
}
add_shortcode('pricing-table', 'pomana_pricing_table_shortcode');

// pomana - Pricing table
        vc_map( 
          array(
           "name" => esc_attr__("pomana - Pricing table", "modeltheme"),
           "base" => "pricing-table",
           "category" => esc_attr__("pomana Theme", "modeltheme"),
            "icon" => plugins_url( 'images/pricing-table.svg', __FILE__ ),
           "params" => array(
              array(
                 "type" => "textfield",
                 "holder" => "div",
                 "class" => "",
                 "heading" => esc_attr__("Package name", "modeltheme"),
                 "param_name" => "package_name",
                 "value" => esc_attr__("BASIC", "modeltheme")
              ),
              array(
                 "type" => "textfield",
                 "holder" => "div",
                 "class" => "",
                 "heading" => esc_attr__("Package price", "modeltheme"),
                 "param_name" => "package_price",
                 "value" => esc_attr__("199", "modeltheme")
              ),
              array(
                 "type" => "textfield",
                 "holder" => "div",
                 "class" => "",
                 "heading" => esc_attr__("Package currency", "modeltheme"),
                 "param_name" => "package_currency"
              ),
              array(
                 "type" => "textfield",
                 "holder" => "div",
                 "class" => "",
                 "heading" => esc_attr__("Package basis", "modeltheme"),
                 "param_name" => "package_basis"
              ),
              array(
                 "type" => "textfield",
                 "holder" => "div",
                 "class" => "",
                 "heading" => esc_attr__("Package Description", "modeltheme"),
                 "param_name" => "package_desc"
              ),
              array(
                 "type" => "textfield",
                 "holder" => "div",
                 "class" => "",
                 "heading" => esc_attr__("Package's 1st feature", "modeltheme"),
                 "param_name" => "package_feature1",
                 "value" => esc_attr__("05 Email Account", "modeltheme")
              ),
              array(
                 "type" => "textfield",
                 "holder" => "div",
                 "class" => "",
                 "heading" => esc_attr__("Package's 2nd feature", "modeltheme"),
                 "param_name" => "package_feature2",
                 "value" => esc_attr__("01 Website Layout", "modeltheme")
              ),
              array(
                 "type" => "textfield",
                 "holder" => "div",
                 "class" => "",
                 "heading" => esc_attr__("Package's 3rd feature", "modeltheme"),
                 "param_name" => "package_feature3",
                 "value" => esc_attr__("03 Photo Stock Banner", "modeltheme")
              ),
              array(
                 "type" => "textfield",
                 "holder" => "div",
                 "class" => "",
                 "heading" => esc_attr__("Package's 4th feature", "modeltheme"),
                 "param_name" => "package_feature4",
                 "value" => esc_attr__("01 Javascript Slider", "modeltheme")
              ),
              array(
                 "type" => "textfield",
                 "holder" => "div",
                 "class" => "",
                 "heading" => esc_attr__("Package's 5th feature", "modeltheme"),
                 "param_name" => "package_feature5",
                 "value" => esc_attr__("01 Hosting", "modeltheme")
              ),
              array(
                 "type" => "textfield",
                 "holder" => "div",
                 "class" => "",
                 "heading" => esc_attr__("Package's 6th feature", "modeltheme"),
                 "param_name" => "package_feature6",
                 "value" => esc_attr__("01 Domain Name Server", "modeltheme")
              ),
              array(
                 "type" => "textfield",
                 "holder" => "div",
                 "class" => "",
                 "heading" => esc_attr__("Package button url", "modeltheme"),
                 "param_name" => "button_url",
                 "value" => esc_attr__("#", "modeltheme")
              ),
              array(
                 "type" => "textfield",
                 "holder" => "div",
                 "class" => "",
                 "heading" => esc_attr__("Package button text", "modeltheme"),
                 "param_name" => "button_text",
                 "value" => esc_attr__("Purchase", "modeltheme")
              ),
              array(
                "type" => "dropdown",
                "heading" => esc_attr__("Animation", "modeltheme"),
                "param_name" => "animation",
                "std" => 'fadeInLeft',
                "holder" => "div",
                "class" => "",
                "value" => $animations_list
              ),
              array(
                "type" => "dropdown",
                "heading" => esc_attr__("Recommended?", "modeltheme"),
                "param_name" => "recommended",
                "value" => array(
                  esc_attr__('Simple', "modeltheme")      => 'simple',
                  esc_attr__('Recommended', "modeltheme") => 'recommended',
                  ),
                "std" => 'simple',
                "holder" => "div",
                "class" => ""
              )
           )
        ));
