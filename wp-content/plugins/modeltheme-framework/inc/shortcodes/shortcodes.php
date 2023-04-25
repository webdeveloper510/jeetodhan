<?php 
/* ------------------------------------------------------------------
[Modeltheme - SHORTCODES]

[Table of contents]
    Recent Tweets
    Contact Form 1
    Recent Posts
    Subscribe form
    Recent Portfolios
    Skill
    Google map
    Pricing tables
    Progress bars
    Custom content
    Responsive video (YouTube)
    Heading With Border
    Testimonials
    List group
    Thumbnails custom content
    Section heading with title and subtitle
    Section heading with title
    Heading with bottom border
    Portfolio square
    Call to action
    Blog posts
    Social Media
    Banner
    Contact Form 2
    Contact locations
    Our Services
------------------------------------------------------------------ */



global $pomana_redux;

include_once( ABSPATH . 'wp-admin/includes/plugin.php' );


/**

||-> Shortcode: Image List Item

*/


function modeltheme_image_list_item($params, $content) {
  extract( shortcode_atts( 
      array(
          'list_icon'      => '',
          'list_icon_size'      => '',
          'list_icon_colors'      => '',
          'list_icon_backgrounds'      => '',
          'list_icon_title'     => '',
          'list_icon_url'     => '',
          'list_icon_title_size'     => '',
          'list_icon_title_line_height' => '',
          'list_icon_title_font_weight' => '',
          'list_icon_title_color'     => '',

          'list_icon_subtitle'     => '',
          'list_icon_subtitle_size'     => '',
          'list_icon_subtitle_line_height' => '',
          'list_icon_subtitle_font_weight' => '',
          'list_icon_subtitle_color'     => ''
      ), $params ) );


  $html = '';
  $html .= '<div class="mt-image-list-item">';

              if (!empty($list_icon_url)) {
                $html .= '<a href="'.$list_icon_url.'">';
              }

      $html .= '<div class="mt-image-list-image-holder">
                  <div class="mt-image-list-image-holder-inner clearfix">';

                    if (!empty($list_icon)) {
                        $html .= '<i style="font-size:'.$list_icon_size.'; color:'.$list_icon_colors.'; background:'.$list_icon_backgrounds.'; " class="'.esc_attr($list_icon).'"></i>';
                    }
                  
                  $html .= '</div>
                </div>
                <div class="mt-image-list-content">
                    <p class="mt-image-list-text" style="font-size: '.esc_attr($list_icon_title_size).'px;line-height:'.esc_attr($list_icon_title_line_height).'px;font-weight:'.esc_attr($list_icon_title_font_weight).';color: '.esc_attr($list_icon_title_color).'">'.esc_attr($list_icon_title).'
                    </p>
                    <p class="mt-image-list-paragraph" style="font-size: '.esc_attr($list_icon_subtitle_size).'px;line-height:'.esc_attr($list_icon_subtitle_line_height).'px;font-weight:'.esc_attr($list_icon_subtitle_font_weight).';color: '.esc_attr($list_icon_subtitle_color).'">'.esc_attr($list_icon_subtitle).'
                    </p>
                </div>
                ';
              
              if (!empty($list_icon_url)) {
                $html .= '</a>';
              }

            $html .= '</div>';

  return $html;
}
add_shortcode('mt_image_list_item', 'modeltheme_image_list_item');



function twitter_time($a) {
    //get current timestampt
    $b = strtotime("now"); 
    //get timestamp when tweet created
    $c = strtotime($a);
    //get difference
    $d = $b - $c;
    //calculate different time values
    $minute = 60;
    $hour = $minute * 60;
    $day = $hour * 24;
    $week = $day * 7;
        
    if(is_numeric($d) && $d > 0) {
        //if less then 3 seconds
        if($d < 3) return "right now";
        //if less then minute
        if($d < $minute) return floor($d) . " seconds ago";
        //if less then 2 minutes
        if($d < $minute * 2) return "about 1 minute ago";
        //if less then hour
        if($d < $hour) return floor($d / $minute) . " minutes ago";
        //if less then 2 hours
        if($d < $hour * 2) return "about 1 hour ago";
        //if less then day
        if($d < $day) return floor($d / $hour) . " hours ago";
        //if more then day, but less then 2 days
        if($d > $day && $d < $day * 2) return "yesterday";
        //if less then year
        if($d < $day * 365) return floor($d / $day) . " days ago";
        //else return more than a year
        return "over a year ago";
    }
}




/**

||-> Shortcode: Testimonials v1

*/
function modeltheme_shortcode_testimonials($params, $content) {
    extract( shortcode_atts( 
        array(
            'animation'                           =>'',
            'number'                              =>'',
            'visible_items'                       =>'',
            'navigation_arrows_color'             =>'',
            'navigation_arrows_background'        =>'',
            'navigation_arrows_background_hover'  =>'',
            'background_color'                    =>'',
            'content_color'                       =>'',
            'testimonial_name_color'              =>'',
            'testimonial_position_color'          =>'',
            'style_type'                          =>''
        ), $params ) );

    $testiminialID = 'testimonials_shortcode_'.uniqid();



    $html = '';
    
    $html .= '<div class="vc_row">';

        $html .= '<div class="testimonials '.$testiminialID.' wow '.$animation.' testimonials-container-'.$visible_items.' owl-carousel owl-theme">';
        $args_testimonials = array(
                'posts_per_page'   => $number,
                'orderby'          => 'post_date',
                'order'            => 'DESC',
                'post_type'        => 'testimonial',
                'post_status'      => 'publish' 
                ); 
        $testimonials = get_posts($args_testimonials);
            foreach ($testimonials as $testimonial) {
                #metaboxes
                $metabox_job_position = get_post_meta( $testimonial->ID, 'job-position', true );
                $metabox_company = get_post_meta( $testimonial->ID, 'company', true );
                $metabox_univer_img = get_post_meta( $testimonial->ID, 'university_img', true );
                $testimonial_id = $testimonial->ID;
                $content_post   = get_post($testimonial_id);
                $content        = $content_post->post_content;
                $content        = apply_filters('the_content', $content);
                $content        = str_replace(']]>', ']]&gt;', $content);
                #thumbnail
                $thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( $testimonial->ID ),'connection_testimonials_150x150' );
                if ($style_type != "style_2") {
                $html.='
                    <div class="item vc_col-md-12 relative">
                        <div class="testimonial01_item">
                            <div>';

                            if($metabox_univer_img) { 
                                $html .= '<img class="university-img" src="'. $metabox_univer_img . '" alt="university" />';      
                            }

                            $html .= '<div class="testimonail01-content" style="color: '.esc_attr($content_color). ' !important;">'.$content.'</div>
                            </div>

                          <div class="testimonail01-holder-content-bottom">
                            <div class="testimonial01-img-holder pull-left">
                                <div class="testimonial01-img">';
                                if($thumbnail_src) { 
                                    $html .= '<img src="'. $thumbnail_src[0] . '" alt="'. $testimonial->post_title .'" />';
                                }else{ 
                                    $html .= '<img src="http://placehold.it/150x150" alt="'. $testimonial->post_title .'" />'; 
                                }
                        $html.='</div>
                            </div>
                            <div class="testimonial01-info pull-left">
                                <h2 class="name-test" style="color: '.esc_attr($testimonial_name_color).';">'. $testimonial->post_title .'</h2>
                                <p class="position-test" style="color: '.esc_attr($testimonial_position_color). ';">'. $metabox_job_position .'</p>
                            </div>
                          </div>

                            </div>
                    </div>';
                } else {
                    $html.='
                    <div class="item vc_col-md-12 relative">
                        <div class="testimonial01_item blood-clinic">
                            
                          <div class="testimonail01-holder-content-bottom">
                            <div class="testimonial01-img-holder pull-left">
                                <div class="testimonial01-img">';
                                if($thumbnail_src) { 
                                    $html .= '<img src="'. $thumbnail_src[0] . '" alt="'. $testimonial->post_title .'" />';
                                }else{ 
                                    $html .= '<img src="http://placehold.it/150x150" alt="'. $testimonial->post_title .'" />'; 
                                }
                        $html.='</div>
                            </div>
                            <div class="testimonial01-info pull-left">
                                <h2 class="name-test" style="color: '.esc_attr($testimonial_name_color).';">'. $testimonial->post_title .'</h2>
                                <p class="position-test" style="color: '.esc_attr($testimonial_position_color). ';">'. $metabox_job_position .'</p>
                            </div>
                          </div>
                          <div>';

                            $html .= '<div class="testimonail01-content" style="color: '.esc_attr($content_color). ' !important;">'.$content.'</div>
                            <div class="testimonial-stars">
                                <img src="'.plugins_url( 'images/5-stars.svg', __FILE__ ).'">
                            </div>
                          </div>
                        </div>
                    </div>';
                }
            }
    $html .= '</div>
        </div>';
    return $html;

}
add_shortcode('testimonials01', 'modeltheme_shortcode_testimonials');






/**

||-> Shortcode: Skills

*/
function modeltheme_skills_shortcode($params, $content) {
    extract( shortcode_atts( 
        array(
            'icon_or_image' => '', 
            'animation'     => '', 
            'icon'          => '', 
            'title'         => '',
            'skillvalue'    => '',
            'has_border'    => '',
            'image_skill'   => ''
        ), $params ) );

    $image_skill      = wp_get_attachment_image_src($image_skill, "pomana_500x500");
    $image_skillsrc  = $image_skill[0];

    $skill = '';
    $skill .= '<div class="stats-block statistics '.esc_attr($has_border).' animateIn" data-animate="'.esc_attr($animation).'">';
        $skill .= '<div class="stats-head">';
            $skill .= '<p class="stat-number skill">';
            if($icon_or_image == 'choosed_icon'){
                $skill .= '<i class="'.esc_attr($icon).'"></i>';
            }
            elseif($icon_or_image == 'choosed_image') {
                $skill .= '<img class="skill_image" src="'.esc_attr($image_skillsrc).'" data-src="'.esc_attr($image_skillsrc).'" alt="">';
            }
                ////////
            $skill .= '</p>';
        $skill .= '</div>';
        $skill .= '<div class="stats-content percentage" data-perc="'.esc_attr($skillvalue).'">';
            $skill .= '<span class="skill-count">'.esc_attr($skillvalue).'</span>';
            $skill .= '<p>'.esc_attr($title).'</p>';
        $skill .= '</div>';
    $skill .= '</div>';
    return $skill;
}
add_shortcode('skill', 'modeltheme_skills_shortcode');



/**

||-> Shortcode: Pricing Tables

*/

function modeltheme_pricing_table_shortcode($params, $content) {
    extract( shortcode_atts( 
        array(
            'package_style'                               => '',
            'package_differential_color_style1'           => '',
            'package_differential_color_style3'           => '',
            'package_background_style3'                   => '',
            'package_background_hover_style3'             => '',
            'package_differential_hover_color_style1'     => '',
            'package_button_color_style3'                 => '',
            'package_button_hover_color_style3'           => '',
            'package_currency'                            => '',
            'package_price'                               => '',
            'package_price2'                               => '',
            'package_price3'                               => '',
            'package_price4'                               => '',
            'package_price5'                               => '',
            'package_price6'                               => '',
            'package_price7'                               => '',
            'package_price8'                               => '',
            'package_price9'                               => '',
            'package_price10'                               => '',
            'package_name'                                => '',
            'package_recommended'                         => '',
            'package_period'                              => '',
            'package_subtitle'                            => '',
            'package_feature1'                            => '',
            'package_feature2'                            => '',
            'package_feature3'                            => '',
            'package_feature4'                            => '',
            'package_feature5'                            => '',
            'package_feature6'                            => '',
            'package_feature7'                            => '',
            'package_feature8'                            => '',
            'package_feature9'                            => '',
            'package_feature10'                            => '',
            'animation'                                   => '',
            'button_url'                                  => '',
            'button_text'                                 => ''
        ), $params ) );


    $package_type = 'pricing--tenzin';

    if($package_style == 'pricing--tenzin') {
        $package_type = 'pricing--tenzin';
    } elseif($package_style == 'pricing--norbu') {
        $package_type = 'pricing--norbu';
    } elseif($package_style == 'pricing--pema') {
        $package_type = 'pricing--pema';
    } 


    $pricing_table = '';
    $pricing_table .= '<div class="row">';
      $pricing_table .= '<div class="pricing-section wow '.esc_attr($animation).'">';
          
          $pricing_table .= '<div class="pricing '.esc_attr($package_type).'">';
          $pricing_table .= '<div class="title-pricing">';

            $pricing_table .= '<div class="pricing__item '.esc_attr($package_recommended).'">';
              $pricing_table .= '<h3 class="pricing__title">'.esc_attr($package_name).'</h3>';
              $pricing_table .= '</div>';

                 $pricing_table .= '<div class="pricing-section2">';

             
        
              $pricing_table .= '<ul class="pricing__feature-list">';
                  if($package_style=='pricing--tenzin') {
                    if (!empty($package_feature1)){
                      $pricing_table .= '<p class="pricing__feature">'.esc_attr($package_feature1).'<span class="pricing__currency">'.esc_attr($package_price).'</span>';

                    }
                    if (!empty($package_feature2)){
                      $pricing_table .= '<p class="pricing__feature">'.esc_attr($package_feature2).'<span class="pricing__currency">'.esc_attr($package_price2).'</span>';

                    }
                    if (!empty($package_feature3)){
                      $pricing_table .= '<p class="pricing__feature">'.esc_attr($package_feature3).'<span class="pricing__currency">'.esc_attr($package_price3).'</span>';

                    }
                    if (!empty($package_feature4)){
                      $pricing_table .= '<p class="pricing__feature">'.esc_attr($package_feature4).'<span class="pricing__currency">'.esc_attr($package_price4).'</span>';

                    }
                    if (!empty($package_feature5)){
                      $pricing_table .= '<p class="pricing__feature">'.esc_attr($package_feature5).'<span class="pricing__currency">'.esc_attr($package_price5).'</span>';

                    }
                     if (!empty($package_feature6)){
                      $pricing_table .= '<p class="pricing__feature">'.esc_attr($package_feature6).'<span class="pricing__currency">'.esc_attr($package_price6).'</span>';

                    }
                     if (!empty($package_feature7)){
                      $pricing_table .= '<p class="pricing__feature">'.esc_attr($package_feature7).'<span class="pricing__currency">'.esc_attr($package_price7).'</span>';

                    }
                     if (!empty($package_feature8)){
                      $pricing_table .= '<p class="pricing__feature">'.esc_attr($package_feature8).'<span class="pricing__currency">'.esc_attr($package_price8).'</span>';

                    }
                     if (!empty($package_feature9)){
                      $pricing_table .= '<p class="pricing__feature">'.esc_attr($package_feature9).'<span class="pricing__currency">'.esc_attr($package_price9).'</span>';


                    }
                     if (!empty($package_feature10)){
                      $pricing_table .= '<p class="pricing__feature">'.esc_attr($package_feature10).'<span class="pricing__currency">'.esc_attr($package_price10).'</span>';

                    }
                  } elseif($package_style=='pricing--norbu') {
                      if (!empty($package_feature1)){
                        $pricing_table .= '<li class="pricing__feature"><i class="icon-arrow-right icons"></i>'.esc_attr($package_feature1).'</li>';
                      }
                      if (!empty($package_feature2)){
                        $pricing_table .= '<li class="pricing__feature"><i class="icon-arrow-right icons"></i>'.esc_attr($package_feature2).'</li>';
                      }
                      if (!empty($package_feature3)){
                        $pricing_table .= '<li class="pricing__feature"><i class="icon-arrow-right icons"></i>'.esc_attr($package_feature3).'</li>';
                      }
                      if (!empty($package_feature4)){
                        $pricing_table .= '<li class="pricing__feature"><i class="icon-arrow-right icons"></i>'.esc_attr($package_feature4).'</li>';
                      }
                      if (!empty($package_feature5)){
                        $pricing_table .= '<li class="pricing__feature"><i class="icon-arrow-right icons"></i>'.esc_attr($package_feature5).'</li>';
                      }
                      
                      if (!empty($package_feature6)){
                        $pricing_table .= '<li class="pricing__feature"><i class="icon-arrow-right icons"></i>'.esc_attr($package_feature6).'</li>';
                      }
                      
                      if (!empty($package_feature7)){
                        $pricing_table .= '<li class="pricing__feature"><i class="icon-arrow-right icons"></i>'.esc_attr($package_feature7).'</li>';
                      }
                      
                      if (!empty($package_feature8)){
                        $pricing_table .= '<li class="pricing__feature"><i class="icon-arrow-right icons"></i>'.esc_attr($package_feature8).'</li>';
                      }
                      
                      if (!empty($package_feature9)){
                        $pricing_table .= '<li class="pricing__feature"><i class="icon-arrow-right icons"></i>'.esc_attr($package_feature9).'</li>';
                      }
                      
                      if (!empty($package_feature10)){
                        $pricing_table .= '<li class="pricing__feature"><i class="icon-arrow-right icons"></i>'.esc_attr($package_feature10).'</li>';
                      }
                    } 
                  elseif($package_style=='pricing--pema') {

                    if (!empty($package_feature1)){
                      $pricing_table .= '<li class="pricing__feature">'.esc_attr($package_feature1).'</li>';
                    }
                    if (!empty($package_feature2)){
                      $pricing_table .= '<li class="pricing__feature">'.esc_attr($package_feature2).'</li>';
                    }
                    if (!empty($package_feature3)){
                      $pricing_table .= '<li class="pricing__feature">'.esc_attr($package_feature3).'</li>';
                    }
                    if (!empty($package_feature4)){
                      $pricing_table .= '<li class="pricing__feature">'.esc_attr($package_feature4).'</li>';
                    }
                    if (!empty($package_feature5)){
                      $pricing_table .= '<li class="pricing__feature">'.esc_attr($package_feature5).'</li>';
                    }
                    if (!empty($package_feature6)){
                      $pricing_table .= '<li class="pricing__feature">'.esc_attr($package_feature6).'</li>';
                    }
                    if (!empty($package_feature7)){
                      $pricing_table .= '<li class="pricing__feature">'.esc_attr($package_feature7).'</li>';
                    }
                    if (!empty($package_feature8)){
                      $pricing_table .= '<li class="pricing__feature">'.esc_attr($package_feature8).'</li>';
                    }
                    if (!empty($package_feature9)){
                      $pricing_table .= '<li class="pricing__feature">'.esc_attr($package_feature9).'</li>';
                    }
                    if (!empty($package_feature10)){
                      $pricing_table .= '<li class="pricing__feature">'.esc_attr($package_feature10).'</li>';
                    }

                  }
                  
              $pricing_table .= '</ul>';
              $pricing_table .= '<a class="pricing__action" href="'.esc_attr($button_url).'">'.esc_attr($button_text).'</a>';
            $pricing_table .= '</div>';
          $pricing_table .= '</div>';
              $pricing_table .= '</div>';
          
      $pricing_table .= '</div>

    </div>
    <style type="text/css" media="screen">
          .pricing--tenzin .pricing__action {
              background: '.esc_attr($package_differential_color_style1).';
          }

          .pricing--tenzin .pricing__action:hover,
          .pricing--tenzin .pricing__action:focus {
              background-color: '.esc_attr($package_differential_hover_color_style1).';
          }
          .pricing--tenzin .pricing__item:hover {
              border-color: '.esc_attr($package_differential_hover_color_style1).';
          }
          .pricing--pema .pricing__sentence {
              color: '.esc_attr($package_differential_color_style3).';
          }
          .pricing--pema .pricing__price {
              color: '.esc_attr($package_differential_color_style3).';
          }
          .pricing--pema .pricing__action {
              background-color: '.esc_attr($package_button_color_style3).';
          }
          .pricing--pema .pricing__action:hover,
          .pricing--pema .pricing__action:focus {
              background-color: '.esc_attr($package_button_hover_color_style3).';
          }
          .pricing--pema .pricing__item {
              background: '.esc_attr($package_background_style3).' none repeat scroll 0 0;
              transition: all 300ms ease-in-out 0ms;
              -ms-transformtransition: all 300ms ease-in-out 0ms;
              -webkit-transformtransition: all 300ms ease-in-out 0ms;
          }
          .pricing--pema .pricing__item:hover {
              background: '.esc_attr($package_background_hover_style3).' none repeat scroll 0 0;
              transition: all 300ms ease-in-out 0ms;
              -ms-transformtransition: all 300ms ease-in-out 0ms;
              -webkit-transformtransition: all 300ms ease-in-out 0ms;
          }
      </style>';
    return $pricing_table;
}
add_shortcode('pricing-table', 'modeltheme_pricing_table_shortcode');


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
    $pricing_table .= '<div class="pricing-table-v2 '.$recommended.'" data-animate="'.$animation.'">';
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
add_shortcode('pricing-table-v2', 'pomana_pricing_table_shortcode');


/**

||-> Shortcode: Progress Bar

*/
function modeltheme_progress_bar_shortcode($params, $content) {
    extract( shortcode_atts( 
        array(
            'bar_scope'  => '', // success/info/warning/danger
            'bar_style'  => '', // normal/progress-bar-striped
            'bar_label_text'  => '', // optional,
            'bar_label_percentage'  => '', // optional
            'bar_value'  => '',
            'animation'  => ''
        ), $params ) );
        $content = '';
        $content .= '<div class="progress_bar_shortcode">';
        if(!isset($bar_label_text) && !isset($bar_label_percentage)){
            $content .= '<div class="label_text_percentange">
                             <span class="sr-only">'.
                                '<span class="label_text">'.$bar_label_text.'</span>'.
                                '<span class="label_percentage">'.$bar_label_percentage.'</span>'.
                            '</span>
                         </div>';
        }else{ 
            $content .= '<div class="label_text_percentange">
                             <span class="label_text">'.$bar_label_text.'</span>'.
                            '<span class="label_percentage">'.$bar_label_percentage.'</span>
                        </div>';
        }
        $content .= '<div class="animateIn progress" data-animate="'.$animation.'" >';
        $content .= '<div class="progress-bar progress-bar-'.$bar_scope . ' ' . $bar_style.'" role="progressbar" aria-valuenow="'.$bar_value.'" aria-valuemin="10" 
        aria-valuemax="100" style="width:'.$bar_value.'">';
        $content .= '</div>';
    $content .= '</div>';
    $content .= '</div>';
    return $content;
}
add_shortcode('progress_bar', 'modeltheme_progress_bar_shortcode');




/**

||-> Shortcode: Heading With Border

*/
function modeltheme_heading_with_border( $params, $content ) {
    extract( shortcode_atts( 
        array(
            'align'       => 'left',
            'animation'   => ''
        ), $params ) );
    $content = do_shortcode($content);
    echo '<h2 data-animate="'.$animation.'" class="'.$align.'-border animateIn">'.$content.'</h2>';
}
add_shortcode('heading-border', 'modeltheme_heading_with_border');





/**

||-> Shortcode: Countdown

*/
function modeltheme_countdown_shortcode( $params, $content ) {
    extract( shortcode_atts( 
        array(
            'date'                       => '',
            'digit_color'                => '',
            'text_color'                 => '',
            'dots_color'                 => '',
            'background_color_count'     => '',
            'border_color_count'         => ''
        ), $params ) );

    $content = '';
    $content .= '<div class="text-center"><div class="modeltheme-countdown" style="background-color:'.$background_color_count.'; border-bottom:5px solid '.$border_color_count.';"></div></div>';
    $content .= '<script type="text/javascript">
                  jQuery( document ).ready(function() {
                      jQuery(".modeltheme-countdown").countdown("'.$date.'", function(event) {
                        jQuery(this).html(
                          event.strftime("<div class=\'days\'><div class=\'days-digit\' style=\'color:'.$digit_color.'\'>%D</div><div class=\'clearfix\'></div><div class=\'days-name\' style=\'color:'.$text_color.'\'>days</div></div><span style=\'color:'.$dots_color.'\'>&middot;</span><div class=\'hours\'><div class=\'hours-digit\'  style=\'color:'.$digit_color.'\'>%H</div><div class=\'clearfix\'></div><div class=\'hours-name\' style=\'color:'.$text_color.'\'>hours</div></div><span style=\'color:'.$dots_color.'\'>&middot;</span><div class=\'minutes\'><div class=\'minutes-digit\' style=\'color:'.$digit_color.'\'>%M</div><div class=\'clearfix\'></div><div class=\'minutes-name\' style=\'color:'.$text_color.'\'>minutes</div></div><span style=\'color:'.$dots_color.'\'>&middot;</span><div class=\'seconds\'><div class=\'seconds-digit\' style=\'color:'.$digit_color.'\'>%S</div><div class=\'clearfix\'></div><div class=\'seconds-name\' style=\'color:'.$text_color.'\'>seconds</div></div>")
                        );
                      });
                  });
                </script>';

    return $content;
}
add_shortcode('modeltheme-countdown', 'modeltheme_countdown_shortcode');




/**

||-> Shortcode: Bootstrap List Group

*/
function modeltheme_list_group_shortcode($params, $content) {
    extract( shortcode_atts( 
        array(
            'heading'       => '',
            'description'   => '',
            'active'        => '',
            'animation'     => ''
        ), $params ) ); 
    $content = '';
    $content .= '<a href="#" class="list-group-item '.$active.' animateIn" data-animate="'.$animation.'">';
        $content .= '<h4 class="list-group-item-heading">'.$heading.'</h4>';
        $content .= '<p class="list-group-item-text">'.$description.'</p>';
    $content .= '</a>';
    return $content;
}
add_shortcode('list_group', 'modeltheme_list_group_shortcode');




/**

||-> Shortcode: Bootstrap Buttons

*/
function modeltheme_btn_shortcode($params, $content) {
    extract( shortcode_atts( 
        array(
            'btn_text'      => '',
            'btn_url'       => '',
            'btn_size'      => '',
            'align'      => '',
            'color'      => '',
            'color_hover'      => '',
            'text_color'      => '',
            'hover_text_color'      => '',
            'animation'     => ''
        ), $params ) ); 
    $content = '';

    $clss = 'modeltheme_button-'.uniqid();

    if (!empty($color_hover)) {
        $color_hover = $color_hover;
    }else{
        $color_hover = '#3394C4';
    }

    if (!empty($color)) {
        $color = $color;
    }else{
        $color = '#3394C4';
    }

    $content .= '<div class="'.$align.' modeltheme_button mt_modeltheme_button '.$clss.' animateIn" data-animate="'.$animation.'" data-identificator="'.$clss.'" data-background-color-hover="'.$color_hover.'" data-background-color="'.$color.'" data-text-color="'.$text_color.'" data-text-color-hover="'.$hover_text_color.'">';
        $content .= '<a href="'.esc_url($btn_url).'" class="rippler rippler-default button-winona '.$btn_size.'" style="color:'.$text_color.';">'.$btn_text.'</a>';
    $content .= '</div>';
    return $content;
}
add_shortcode('pomana_btn', 'modeltheme_btn_shortcode');





/**

||-> Shortcode: Section Heading with Title and Subtitle

*/
function modeltheme_heading_title_subtitle_shortcode($params, $content) {
    extract( shortcode_atts( 
        array(
            'title'               => '',
            'subtitle'            => '',
            'title_color'         => '',
            'subtitle_color'      => '',
            'border_color'        => ''
        ), $params ) ); 
    $content = '<div class="title-subtile-holder">';
    $content .= '<h1 class="section-title '.$title_color.'">'.$title.'</h1>';
    $content .= '<div class="section-border '.$border_color.'"></div>';
    $content .= '<div class="section-subtitle '.$subtitle_color.'">'.$subtitle.'</div>';
    $content .= '</div>';
    return $content;
}
add_shortcode('heading_title_subtitle', 'modeltheme_heading_title_subtitle_shortcode');


/**

||-> Shortcode: Section Heading with Title

*/
function modeltheme_heading_title_shortcode($params, $content) {
    extract( shortcode_atts( 
        array(
            'title'         => '',
            'animation' => ''
        ), $params ) ); 

    $intermediar = explode(" ",$title);
    $last_element = end($intermediar);

    $patial_elements = explode(" ", $title, -1);
    $elements_outside_last = implode(" ", $patial_elements);

    $content = '<div class="title-holder animateIn" data-animate="'.esc_attr($animation).'">';
    $content .= '<h1 class="section-single-title">'.$elements_outside_last.' '.'<span class="title_bored_element">'.$last_element.'</span></h1>';
    $content .= '</div>';
    return $content;
}
add_shortcode('heading_title', 'modeltheme_heading_title_shortcode');




/**

||-> Shortcode: Heading with Bottom Border

*/
function modeltheme_heanding_bottom_border_shortcode( $params, $content ) {
    extract( shortcode_atts( 
        array(
            'heading'    => '',
            'text_align' => '',
            'text_size'  => '',
            'text_line_height'  => '',
            'text_color' => ''
        ), $params ) );
    $content = '<h2 class="heading-bottom '.$text_align.'" style="color:'.$text_color.';font-size:'.$text_size.';line-height:'.$text_line_height.'">'.$heading.'</h2>';
    return $content;
}
add_shortcode('heading_border_bottom', 'modeltheme_heanding_bottom_border_shortcode');




/**

||-> Shortcode: Call to Action

*/
function modeltheme_call_to_action_shortcode( $params, $content ) {
    extract( shortcode_atts( 
        array(
            'heading'       => '',
            'heading_type'  => '',
            'subheading'    => '',
            'align'         => '',
            'button_text'   => '',
            'url'           => ''
        ), $params ) );
    $shortcode_content = '<div class="pomana_call-to-action">';
    $shortcode_content .= '<div class="vc_col-md-12">';
    $shortcode_content .= '<'.$heading_type.' class="'.$align.'">'.$heading.'</'.$heading_type.'>';
    $shortcode_content .= '<p class="'.$align.'">'.$subheading.'</p>';
    $shortcode_content .= '</div>';
    $shortcode_content .= '<div class="clearfix"></div>';
    $shortcode_content .= '</div>';
    return $shortcode_content;
}
add_shortcode('modeltheme-call-to-action', 'modeltheme_call_to_action_shortcode');



/**

||-> Shortcode: Services Activities

*/
function modeltheme_service_activity_shortcode ( $params, $content ) {
    extract( shortcode_atts( 
        array(
            'number' => '',
            'category' => '',
            'style_type' => '',
            'columns' => '',
            'animation' => ''
        ), $params ) );

        $args_recenposts = array(
                'posts_per_page'   => $number,
                'orderby'          => 'post_date',
                'order'            => 'DESC',
                'post_type'        => 'service',
                'tax_query' => array(
                    array(
                        'taxonomy' => 'services',
                        'field' => 'slug',
                        'terms' => $category
                    )
                ),
                'post_status'      => 'publish' 
                );
        $recentposts = get_posts($args_recenposts);
    $shortcode_content  = "";
    $shortcode_content .= '<div class="activities row animateIn" data-animate="'.esc_attr($animation).'">';
        $counter = 0;
        foreach ($recentposts as $post) {
            $counter++;
            $activities_icon = get_post_meta( $post->ID, 'pomana_service_badge_icon', true );
            $activities_badge_background_color = get_post_meta( $post->ID, 'pomana_service_badge_background_color', true );
            $activities_service = $post->ID;
            $content_post   = get_post($activities_service);
            $content        = $content_post->post_content;
            $content        = apply_filters('the_content', $content);
            $content        = str_replace(']]>', ']]&gt;', $content);
            $activities_service_title = get_the_title($activities_service);


            $thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ),'pomana_500x500' );
            



            if ($style_type != "dual_color") {


                $shortcode_content .= '<div class="item '.esc_attr($columns).' '.esc_attr($category).'">';
                    $shortcode_content .= '<div class="activities-content-services row">';
                
                    $shortcode_content .= '<div class="activities-content row">';
                       
                    
                        $shortcode_content .= '<div class="shop_feature_v3">';
                            $shortcode_content .= '<div class="pull-left vc_col-md-3 shop_feature_icon_v3">';
                                        if ( has_post_thumbnail($post->ID) ) {
                                            $shortcode_content .= '<img class="featured_image_services_onecolor" src="'. esc_url($thumbnail_src[0]) . '" alt="" />';
                                        } else {
                                            $shortcode_content .= '<i class="hvr-grow '.esc_attr($activities_icon).'" style="background-color:rgba(255, 255, 255, 0); color: #48A8A7; border: 4px solid #48A8A7;"></i>';
                                        }
                            $shortcode_content .= '</div>';

                            $shortcode_content .= '<div class="pull-left vc_col-md-9 shop_feature_description_v3">';
                                $shortcode_content .= '<a href="'.get_permalink($post->ID).'" class="shop_feature_readmore_v3"><h4 class="shop_feature_heading_v3">'.esc_attr($activities_service_title).'</h4></a>';
                                $shortcode_content .= '<p class="shop_feature_subheading_v3">'.strip_tags(pomana_excerpt_limit($content,16)).' ...</p>';
                            $shortcode_content .= '</div>';
                            $shortcode_content .= '</div>';

                        $shortcode_content .= '</div>';
                    $shortcode_content .= '</div>';
                $shortcode_content .= '</div>';

                if ($style_type != "dual_color" AND $counter%2 == 0) {
                    $shortcode_content .= '<div style="clear: both;"></div>';
                }
             
            }

            else {
                if ($columns == '') {
                    $columns_value = 'col-md-4';
                }elseif ($columns != '') {
                    $columns_value = $columns;
                }else{
                    $columns_value = 'col-md-4';
                }
                $shortcode_content .= '<div class="advantages item '.esc_attr($columns_value).' '.esc_attr($category).'">';
                    $shortcode_content .= '<div class="activities-content row">';
                        $shortcode_content .= '<div class="shop_service_more">';
                        $shortcode_content .= '<div class="vc_col-md-12 shop_feature_description_button v3">';
                        $shortcode_content .= '<div class="shop_feature_v3">';
                            $shortcode_content .= '<div class="pull-left vc_col-md-12 shop_feature_icon_v3">';
                                    if ( has_post_thumbnail($post->ID) ) {
                                        $shortcode_content .= '<img class="featured_image_services_multiplecolor" src="'. esc_url($thumbnail_src[0]) . '" alt="" />';
                                    } else {
                                        $shortcode_content .= '<i class="hvr-grow '.esc_attr($activities_icon).'" style="background-color:'.esc_attr($activities_badge_background_color).';"></i>';
                                    }
                          
                            
                            $shortcode_content .= '<div class="pull-left vc_col-md-12 shop_feature_description_v3">';
                                $shortcode_content .= '<h4 class="shop_feature_heading_v3"><a href="'.get_permalink($post->ID).'">'.esc_attr($activities_service_title).'</a></h4>';
                                $shortcode_content .= '<p class="shop_feature_subheading_v3">'.strip_tags(pomana_excerpt_limit($content,8)).' ...</p>';
                            $shortcode_content .= '</div>';
                            
                            $shortcode_content .= '</div>';
                              $shortcode_content .= '</div>';
                            $shortcode_content .= '</div>';
                        $shortcode_content .= '</div>';
                    $shortcode_content .= '</div>';
                $shortcode_content .= '</div>';

            }

                            
        }
    $shortcode_content .= '</div>';
    return $shortcode_content;
}
add_shortcode('service_activity', 'modeltheme_service_activity_shortcode');





/**

||-> Shortcode: Blog Posts

*/
function modeltheme_show_blog_post_shortcode( $params, $content ) {
    extract( shortcode_atts( 
        array(
            'number'                => '',
            'category'              => '',
            'columns'               => '',
            'animation'             => '',
            'posts_text_button'     => '',
            'style_type'            => ''
           ), $params ) );

    $args_posts = array(
            'posts_per_page'        => $number,
            'post_type'             => 'post',
            'tax_query' => array(
                array(
                    'taxonomy' => 'category',
                    'field' => 'slug',
                    'terms' => $category
                )
            ),
            'post_status'           => 'publish'
        );
    $posts = get_posts($args_posts);
    $shortcode_content = '<div class="pomana_shortcode_blog vc_row sticky-posts animateIn" data-animate="'.$animation.'">';
    $counter = 0;
    foreach ($posts as $post) {
        $counter++;
        $excerpt = get_post_field('post_content', $post->ID);

        if ($style_type == "style_1") {
            $thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ),'pomana_700x500' );
        } else if ($style_type == "style_2") {
            $thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ),'pomana_500x680' );
        } else {
            $thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ),'pomana_700x500' );
        }
        
        $author_id = $post->post_author;

        $post_background_color = get_post_meta( $post->ID, 'pomana_post_background_color', true );

        $custom_blog_color1 = "";
        if ( !empty($post_background_color) ) { 
            $custom_blog_color1 = "text-white";
        } else { 
            echo ""; 
        }

            $shortcode_content .= '<div class="'.esc_attr($columns).' post '.$style_type.'">';
                $shortcode_content .= '<div class="col-md-12 shortcode_post_content ' .$custom_blog_color1.'">';
                    $shortcode_content .= '<a href="'.get_permalink($post->ID).'">';
                        if ($columns == 'vc_col-sm-6') {
                            $shortcode_content .= '<div class="col-md-5 featured_image_content">';
                        } elseif ( $columns == 'vc_col-sm-4' || $columns == 'vc_col-sm-3') {
                            $shortcode_content .= '<div class="col-md-12 featured_image_content">';
                        }
                            if($thumbnail_src) { 
                                $shortcode_content .= '<img src="'. esc_attr($thumbnail_src[0]) . '" alt="'. $post->post_title .'" />';
                            }else{ 
                                $shortcode_content .= '<img src="http://placehold.it/530x450" alt="'. $post->post_title .'" />'; 
                            }
                        $shortcode_content .= '</div>';
                    $shortcode_content .= '</a>';
                    if ($columns == 'vc_col-sm-6') {
                        $shortcode_content .= '<div class="col-md-7 text_content">';
                    } elseif ( $columns == 'vc_col-sm-4' || $columns == 'vc_col-sm-3' ) {
                        $shortcode_content .= '<div class="col-md-12 text_content">';
                    }
                        $shortcode_content .= '<div class="blog_badge_date">
                                <span>'.esc_attr(get_the_date('F j, Y', $post->ID)).'</span>
                        </div>';
                        $shortcode_content .= '<h4 class="post-name post-name-color"><a href="'.get_permalink($post->ID).'">'.$post->post_title.'</a></h4>';
                        $shortcode_content .= '<div class="post-excerpt">'.strip_tags(pomana_excerpt_limit($post->post_content, 10)).' ...</div>';
                    $shortcode_content .= '</div>';
                $shortcode_content .= '</div>';
            $shortcode_content .= '</div>';

            if ($columns == 'vc_col-sm-6' AND $counter%2 == 0) {
                $shortcode_content .= '<div style="clear: both;"></div>';
            }elseif ($columns == 'vc_col-sm-4' AND $counter%3 == 0) {
                $shortcode_content .= '<div style="clear: both;"></div>';
            }elseif ($columns == 'vc_col-sm-3' AND $counter%4 == 0) {
                $shortcode_content .= '<div style="clear: both;"></div>';
            }
    } 
    $shortcode_content .= '</div>';
    return $shortcode_content;
}
add_shortcode('modeltheme-blog-posts', 'modeltheme_show_blog_post_shortcode');


/**

||-> Shortcode: Video

*/

function modeltheme_shortcode_video($params, $content) {

    extract( shortcode_atts( 
        array(
            'animation'                 => '',
            'source_vimeo'              => '',
            'source_youtube'            => '',
            'video_source'              => '',
            'vimeo_link_id'             => '',
            'youtube_link_id'           => '',
            'button_image'              => ''
        ), $params ) );

    $thumb      = wp_get_attachment_image_src($button_image, "full");
    $thumb_src  = $thumb[0];

    $html = '';

    // custom javascript
    $html .= '<script>
                jQuery(document).ready(function() {
                  jQuery(".popup-vimeo-video").magnificPopup({
                    type:"iframe",
                    disableOn: 700,
                    removalDelay: 160,
                    preloader: false,
                    fixedContentPos: false
                });


                  jQuery(".popup-vimeo-youtube").magnificPopup({
                    type:"iframe",
                    disableOn: 700,
                    removalDelay: 160,
                    preloader: false,
                    fixedContentPos: false});
                });
                
              </script>';
    

      $html .= '<div class="mt_video text-center row">';
        $html .= '<div class="wow '.esc_attr($animation).'">';
        if ($video_source == 'source_vimeo') {
          $html .= '<a class="popup-vimeo-video" href="https://vimeo.com/'.$vimeo_link_id.'"><img class="buton_image_class" src="'.esc_attr($thumb_src).'" data-src="'.esc_attr($thumb_src).'" alt=""></a>';
          } elseif ($video_source == 'source_youtube') {
            $html .= '<a class="popup-vimeo-youtube" href="https://www.youtube.com/watch?v='.$youtube_link_id.'"><img class="buton_image_class" src="'.esc_attr($thumb_src).'" data-src="'.esc_attr($thumb_src).'" alt=""></a>';
          }
        $html .= '</div>';
      $html .= '</div>';

    return $html;
}

add_shortcode('shortcode_video', 'modeltheme_shortcode_video');


/**

||-> Shortcode: Row Separator

*/
function modeltheme_row_separator_shortcode($params, $content) {
    extract( shortcode_atts( 
        array(
            'css'  => '',
            'bg_color'  => '',
            'clouds_position'  => '',
        ), $params ) );

    $vc_css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), 'mt_row_separator', $params );

    $content = '';
    $content .= '<div class="mt-overlay '.esc_attr( $vc_css_class ).'" style="overflow:hidden;">';
                    
    $content .= '</div>';

    return $content;
}
add_shortcode('mt_row_separator', 'modeltheme_row_separator_shortcode');

/**

||-> Shortcode: Row Separator

*/
function modeltheme_tabs_categories_shortcode($params, $content) {
    extract( shortcode_atts( 
        array(
            'tabs_item_title_tab1'             => '',
            'tabs_item_content1'               => '',
            'tabs_item_button_text1'            => '',
            'tabs_item_button_link1'            => '',
            'tabs_item_img1'                  => '',
            'tabs_item_img2'                  => '',
            'tabs_item_img3'                  => '',
            'tabs_item_img4'                  => '',
            'tabs_item_img5'                  => '',
            'tabs_item_icon1'   => '',
            'tabs_item_icon2'   => '',
            'tabs_item_icon3'   => '',
            'tabs_item_icon4'   => '',
            'tabs_item_icon5'   => '',
            'tabs_item_title_tab2'             => '',
            'tabs_item_content2'               => '',
            'tabs_item_button_text2'            => '',
            'tabs_item_button_link2'            => '',
            'tabs_item_title_tab3'             => '',
            'tabs_item_content3'               => '',
            'tabs_item_button_text3'            => '',
            'tabs_item_button_link3'            => '',
            'tabs_item_title_tab4'             => '',
            'tabs_item_content4'               => '',
            'tabs_item_button_text4'            => '',
            'tabs_item_button_link4'            => '',
            'tabs_item_title_tab5'             => '',
            'tabs_item_content5'               => '',
            'tabs_item_button_text5'            => '',
            'tabs_item_button_link5'            => '',
        ), $params ) );

    //$vc_css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), 'mt_tabs_categories', $params );
    $tabs_item_img1 = wp_get_attachment_image_src($tabs_item_img1, "pomana_50s0x500");
    $tabs_item_img2 = wp_get_attachment_image_src($tabs_item_img2, "pomana_500x50");
    $tabs_item_img3 = wp_get_attachment_image_src($tabs_item_img3, "pomana_500x50");
    $tabs_item_img4 = wp_get_attachment_image_src($tabs_item_img4, "pomana_500x50");
    $tabs_item_img5 = wp_get_attachment_image_src($tabs_item_img5, "pomana_500x50");
    $tabs_item_icon1 = wp_get_attachment_image_src($tabs_item_icon1, "pomana_500x500");
    $tabs_item_icon2 = wp_get_attachment_image_src($tabs_item_icon2, "pomana_500x500");
    $tabs_item_icon3 = wp_get_attachment_image_src($tabs_item_icon3, "pomana_500x500");
    $tabs_item_icon4 = wp_get_attachment_image_src($tabs_item_icon4, "pomana_500x500");
    $tabs_item_icon5 = wp_get_attachment_image_src($tabs_item_icon5, "pomana_500x500");

    $content = '';
    $content .= '<section class="mt-tabs">
            <div class="tabs tabs-style-iconbox">
                <nav>
                    <ul>';

                    if (!empty($tabs_item_img1) || !empty($tabs_item_icon1) || !empty($tabs_item_title_tab1)) {
                        $content .= '<li><a href="#section-iconbox-1" class="list-icon-title">
                            <img class="tabs_icon" src="'.esc_attr($tabs_item_icon1[0]).'" alt="tabs-image">
                            <h5 class="tab-title">'.$tabs_item_title_tab1.'</h5>
                        </a></li>';
                    }

                    if (!empty($tabs_item_img2) || !empty($tabs_item_icon2) || !empty($tabs_item_title_tab2)) {
                        $content .= '<li><a href="#section-iconbox-2" class="list-icon-title">
                            <img class="tabs_icon" src="'.esc_attr($tabs_item_icon2[0]).'" alt="tabs-image">
                            <h5 class="tab-title">'.$tabs_item_title_tab2.'</h5>
                        </a></li>';
                    }
                        
                    if (!empty($tabs_item_img3) || !empty($tabs_item_icon3) || !empty($tabs_item_title_tab3)) {
                        $content .= '<li><a href="#section-iconbox-3" class="list-icon-title">
                            <img class="tabs_icon" src="'.esc_attr($tabs_item_icon3[0]).'" alt="tabs-image">
                            <h5 class="tab-title">'.$tabs_item_title_tab3.'</h5>
                        </a></li>';
                    }
                        
                    if (!empty($tabs_item_img4) || !empty($tabs_item_icon4) || !empty($tabs_item_title_tab4)) {
                        $content .= '<li><a href="#section-iconbox-4" class="list-icon-title">
                            <img class="tabs_icon" src="'.esc_attr($tabs_item_icon4[0]).'" alt="tabs-image">
                            <h5 class="tab-title">'.$tabs_item_title_tab4.'</h5>
                        </a></li>';
                    }
                        
                    if (!empty($tabs_item_img5) || !empty($tabs_item_icon5) || !empty($tabs_item_title_tab5)) {
                        $content .= '<li><a href="#section-iconbox-5" class="list-icon-title">
                            <img class="tabs_icon" src="'.esc_attr($tabs_item_icon5[0]).'" alt="tabs-image">
                            <h5 class="tab-title">'.$tabs_item_title_tab5.'</h5>
                        </a></li>';
                    }
                    $content .= '</ul>
                </nav>
                <div class="content-wrap">
                    <section id="section-iconbox-1">
                        <div class="row">
                            <div class="col-md-6 text-center">
                                <img class="tabs_image" src="'.esc_attr($tabs_item_img1[0]).'" alt="tabs-image">
                            </div>
                            <div class="col-md-6">
                                <h3 class="tabs_title">'.$tabs_item_title_tab1.'</h3>
                                <p class="tabs_content">'.$tabs_item_content1.'</p>
                                <a href="'.$tabs_item_button_link1.'" class="rippler rippler-default button-winona btn btn-lg tabs_button">'.$tabs_item_button_text1.'</a>
                            </div>
                        </div>                     
                    </section>
                   
                    <section id="section-iconbox-2">
                        <div class="row">
                            <div class="col-md-6 text-center">
                                <img class="tabs_image" src="'.esc_attr($tabs_item_img2[0]).'" alt="tabs-image">
                            </div>
                            <div class="col-md-6">
                                <h3 class="tabs_title">'.$tabs_item_title_tab2.'</h3>
                                <p class="tabs_content">'.$tabs_item_content2.'</p>
                                <a href="'.$tabs_item_button_link2.'" class="rippler rippler-default button-winona btn btn-lg tabs_button">'.$tabs_item_button_text2.'</a>
                            </div>
                        </div>
                    </section>
                    
                    <section id="section-iconbox-3">
                        <div class="row">
                            <div class="col-md-6 text-center">
                                <img class="tabs_image" src="'.esc_attr($tabs_item_img3[0]).'" alt="tabs-image">
                            </div>
                            <div class="col-md-6">
                                <h3 class="tabs_title">'.$tabs_item_title_tab3.'</h3>
                                <p class="tabs_content">'.$tabs_item_content3.'</p>
                                <a href="'.$tabs_item_button_link3.'" class="rippler rippler-default button-winona btn btn-lg tabs_button">'.$tabs_item_button_text3.'</a>
                            </div>
                        </div>
                    </section>
                    
                    <section id="section-iconbox-4">
                        <div class="row">
                            <div class="col-md-6 text-center">
                                <img class="tabs_image" src="'.esc_attr($tabs_item_img4[0]).'" alt="tabs-image">
                            </div>
                            <div class="col-md-6">
                                <h3 class="tabs_title">'.$tabs_item_title_tab4.'</h3>
                                <p class="tabs_content">'.$tabs_item_content4.'</p>
                                <a href="'.$tabs_item_button_link4.'" class="rippler rippler-default button-winona btn btn-lg tabs_button">'.$tabs_item_button_text4.'</a>
                            </div>
                        </div>
                    </section>
                    
                    <section id="section-iconbox-5">
                        <div class="row">
                            <div class="col-md-6 text-center">
                                <img class="tabs_image" src="'.esc_attr($tabs_item_img5[0]).'" alt="tabs-image">
                            </div>
                            <div class="col-md-6">
                                <h3 class="tabs_title">'.$tabs_item_title_tab5.'</h3>
                                <p class="tabs_content">'.$tabs_item_content5.'</p>
                                <a href="'.$tabs_item_button_link5.'" class="rippler rippler-default button-winona btn btn-lg tabs_button">'.$tabs_item_button_text5.'</a>
                            </div>
                        </div>
                    </section>
                </div><!-- /content -->
            </div><!-- /tabs -->
        </section>';

    return $content;
}
add_shortcode('mt_tabs_categories', 'modeltheme_tabs_categories_shortcode');


/*---------------------------------------------*/
/*--- Woocommerce Categories with thumbnails ---*/
/*---------------------------------------------*/
function pomana_shop_categories_with_xsthumbnails_shortcode( $params, $content ) {
    extract( shortcode_atts( 
        array( 
            'category'                             => '',
            'overlay_color1'                       => '',
            'overlay_color2'                       => '',
            'products_label_text'                  => '',
            'bg_image'                             => '',
            'hide_empty'                           => ''
        ), $params ) );

    if (isset($bg_image) && !empty($bg_image)) {
        $bg_image = wp_get_attachment_image_src($bg_image, "full");
    }

    $category_style_bg = '';
    if (isset($bg_image) && !empty($bg_image)) {
        $category_style_bg .= 'background: url('.$bg_image[0].') no-repeat center center;';
    }else{
        $category_style_bg .= 'background: radial-gradient('.$overlay_color1.','.$overlay_color2.');';
    }

    if ($products_label_text) {
        $products_label_text_value = $products_label_text;
    }else{
        $products_label_text_value = __('Products', 'modeltheme');
    }

    $cat = get_term_by('slug', $category, 'product_cat');

    $shortcode_content = ''; 

    if ($cat) {
        $shortcode_content .= '<div class="woocommerce_categories2">';
            $shortcode_content .= '<div class="products_category">';
                $shortcode_content .= '<div class="category item col-md-12 " >';
                    $shortcode_content .= '<div style="'.$category_style_bg.'" class="category-wrapper relative">';
                        $shortcode_content .= '<a href="'.get_term_link($cat->slug, 'product_cat').'" class="#categoryid_'.$cat->term_id.'">';

                            $shortcode_content .= '<span class="category_overlay">';

                                $shortcode_content .= '<span class="cat-name">'.$category.'</span>';                    
                                $shortcode_content .= '<span class="cat-count"><strong>'.$cat->count.'</strong> '.esc_html($products_label_text_value).'</span>';

                            $shortcode_content .= '</span>';
                        $shortcode_content .= '</a>'; 
                    $shortcode_content .= '</div>';
                $shortcode_content .= '</div>';    
            $shortcode_content .= '</div>';
        $shortcode_content .= '</div>';

        $shortcode_content .= '<div class="clearfix"></div>';
    }

    wp_reset_postdata();

    return $shortcode_content;
}
add_shortcode('shop-categories-with-xsthumbnails', 'pomana_shop_categories_with_xsthumbnails_shortcode');


/*---------------------------------------------*/
/*--- Woocommerce Products Carousel ---*/
/*---------------------------------------------*/

function mt_carousel_products($params, $content) {
    extract( shortcode_atts( 
        array(
            'animation' => '',
            'number' => '',
            'category' => '',
            'navigation' => 'true',
            'navigationText' => '',
            'order' => 'desc',
            'pagination' => 'true',
            'autoPlay' => 'true',
            'button_text' => '',
            'button_link' => '',
            'button_background' => '',
            'paginationSpeed' => '700',
            'slideSpeed' => '700',
            'number_desktop' => '4',
            'number_tablets' => '2',
            'number_mobile' => '1'
        ), $params ) );


    $html = '';

    // CLASSES
    $class_slider = 'mt_carousel_products_'.uniqid();

    $html .= '<script>
                jQuery(document).ready( function() {
                    jQuery(".'.$class_slider.'").owlCarousel({
                        navigation      : '.$navigation.', // Show next and prev buttons
                        pagination      : '.$pagination.',
                        autoPlay        : '.$autoPlay.',
                        slideSpeed      : '.$paginationSpeed.',
                        paginationSpeed : '.$slideSpeed.',
                        autoWidth: true,
                        itemsCustom : [
                            [0,     '.$number_mobile.'],
                            [450,   '.$number_mobile.'],
                            [600,   '.$number_desktop.'],
                            [700,   '.$number_tablets.'],
                            [1000,  '.$number_tablets.'],
                            [1200,  '.$number_desktop.'],
                            [1400,  '.$number_desktop.'],
                            [1600,  '.$number_desktop.']
                        ]
                    });
                    
                jQuery(".'.$class_slider.' .owl-wrapper .owl-item:nth-child(2)").addClass("hover_class");
                jQuery(".'.$class_slider.' .owl-wrapper .owl-item").hover(
                  function () {
                    jQuery(".'.$class_slider.' .owl-wrapper .owl-item").removeClass("hover_class");
                    if(jQuery(this).hasClass("open")) {
                        jQuery(this).removeClass("open");
                    } else {
                    jQuery(this).addClass("open");
                    }
                  }
                );


                });
              </script>';

        $cat = get_term_by( 'slug', $category, 'product_cat' );

    
        $html .= '<div class="modeltheme_products_carousel '.$class_slider.' row  owl-carousel owl-theme">';
     
        
       $args_prods = array(
              'posts_per_page'   => 11,
              'order'            => 'DESC',
              'post_type'        => 'product',
              'tax_query' => array(
                array(
                    'taxonomy' => 'product_cat',
                    'field' => 'slug',
                    'terms' => $category
                )
                ),
              'post_status'      => 'publish' 
         ); 
        $blogposts = get_posts($args_prods);
        foreach ($blogposts as $blogpost) {
                #metaboxes

                #thumbnail
                 $thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( $blogpost->ID ), 'pomana_portfolio_pic400x400' );
                 $product_cause = get_post_meta( $blogpost->ID, 'product_cause', true );
                if ($thumbnail_src) {
                    $post_img = '<img class="portfolio_post_image" src="'. esc_url($thumbnail_src[0]) . '" alt="'.$blogpost->post_title.'" />';
                    $post_col = 'col-md-12';
                  }else{
                    $post_col = 'col-md-12 no-featured-image';
                    $post_img = '';
                  }
            $html .= '<div id="product-id-'.esc_attr($blogpost->ID).'">
                        <div class="col-md-12 modeltheme-slider ">
                            <div class="modeltheme-slider-wrapper"> 
                              <div class="modeltheme-thumbnail-and-details">
                                <a class="modeltheme_media_image" title="'.esc_attr($blogpost->post_title).'" href="'.esc_url(get_permalink($blogpost->ID)).'"> '.$post_img.'</a>
                              </div>
                              <div class="modeltheme-title-metas text-center">
                                <h3 class="modeltheme-archive-product-title">
                                  <a href="'.esc_url(get_permalink($blogpost->ID)).'" title="'. $blogpost->post_title .'">'. $blogpost->post_title .'</a>
                                </h3>';

                    $html .= '</div>
                            </div>
                        </div>                     
                    </div>';
                }
            
    $html .= '</div>';
    wp_reset_postdata();
    return $html;
}
add_shortcode('mt-products-carousel', 'mt_carousel_products');
/**

||-> Shortcode: Members Slider

*/

function mt_shortcode_members01($params, $content) {
    extract( shortcode_atts( 
        array(
            'animation' => '',
            'number' => '',
        ), $params ) );


    $html = '';



    // CLASSES
    $class_slider = 'mt_slider_members_'.uniqid();


        $html .= '<div class="row mt_members1 '.$class_slider.' row wow '.$animation.'">';
        $args_members = array(
                'posts_per_page'   => $number,
                'orderby'          => 'post_date',
                'post_type'        => 'member',
                'post_status'      => 'publish' 
                ); 
        $members = get_posts($args_members);
            foreach ($members as $member) {
                #metaboxes
                $metabox_member_position = get_post_meta( $member->ID, 'pomana_member_position', true );
                $metabox_member_email = get_post_meta( $member->ID, 'pomana_member_email', true );
                $metabox_member_phone = get_post_meta( $member->ID, 'pomana_member_phone', true );

                $metabox_facebook_profile = get_post_meta( $member->ID, 'pomana_facebook_profile', true );
                $metabox_twitter_profile  = get_post_meta( $member->ID, 'pomana_twitter_profile', true );
                $metabox_linkedin_profile = get_post_meta( $member->ID, 'pomana_linkedin_profile', true );
                $metabox_vimeo_url = get_post_meta( $member->ID, 'pomana_vimeo_url', true );

                $member_title = get_the_title( $member->ID );

                $testimonial_id = $member->ID;
                $content_post   = get_post($member);
                $content        = $content_post->post_content;
                $content        = apply_filters('the_content', $content);
                $content        = str_replace(']]>', ']]&gt;', $content);
                #thumbnail
                $thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( $member->ID ),'pomana_500x500' );

                if($metabox_facebook_profile) {
                    $profil_fb = '<a href="'. $metabox_facebook_profile .'" class="member01_profile-facebook" target="_blank"> <i class="fa fa-facebook" aria-hidden="true"></i></a> ';
                }

                if($metabox_member_email) {
                    $profil_email = '<a href="mailto:'. $metabox_member_email .'" class="member01_profile-email"> <i class="fa fa-envelope" aria-hidden="true"></i></a> ';
                }

                if($metabox_twitter_profile) {
                    $profil_tw = '<a href="https://twitter.com/'. $metabox_twitter_profile .'" class="member01_profile-twitter" target="_blank"> <i class="fa fa-twitter" aria-hidden="true"></i></a> ';
                }

                if($metabox_linkedin_profile) {
                    $profil_in = '<a href="'. $metabox_linkedin_profile .'" class="member01_profile-linkedin" target="_blank"> <i class="fa fa-linkedin" aria-hidden="true"></i> </a> ';
                }

                if($metabox_vimeo_url) {
                    $profil_vi = '<a href="'. $metabox_vimeo_url .'" class="member01_vimeo_url" target="_blank"> <i class="fa fa-vimeo" aria-hidden="true"></i> </a> ';
                }

                
                $html.='
                    <div class="col-md-12 relative">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="members_img_holder">
                                    <div class="memeber01-img-holder">';
                                        if($thumbnail_src) { 
                                            $html .= '<div class="featured_image_member">
                                                            <img src="'. $thumbnail_src[0] . '" alt="'. $member->post_title .'" />
                                                            <div class="flex-zone">
                                                               <div class="flex-zone-inside member01_social social-icons">'. $profil_email . $profil_fb . $profil_in  . '</div>
                                                            </div>
                                                      </div>';
                                        }else{ 
                                            $html .= '<img src="http://placehold.it/150x160" alt="'. $member->post_title .'" />'; 
                                        }
                                    $html.='</div>
                                    <div class="member01-content">
                                        <div class="member01-content-inside">
                                            <h4 class="member01_name">'.$member->post_title.'</h4>
                                            <p class="member01_position">'.$metabox_member_position.'</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>';

            }
        $html.='</div>';
    return $html;
}
add_shortcode('mt_members_slider', 'mt_shortcode_members01');

/**

||-> Shortcode: Clients

*/
function modeltheme_shortcode_clients01($params, $content) {
    extract( shortcode_atts( 
        array(
            'animation'               =>'',
            'visible_items_clients'   =>'',
            'number'                  =>'',
            'background_color_overlay' =>'',
            'order' => ''
        ), $params ) );
    $html = '';
    
        $args_clients = array(
        'posts_per_page'   => $number,
        'orderby'          => 'post_date',
        'order'            => $order,
        'post_type'        => 'clients',
        'post_status'      => 'publish' 
      );
      
        $html .= '<div class="row">';
            $html .= '<div class="wow '.$animation.' mt_clients_slider clients_container_shortcode-'.$visible_items_clients.' owl-carousel owl-theme">';
                $clients = get_posts($args_clients);
                    foreach ($clients as $client) {
                    $thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( $client->ID ),'full' );
                    $html .= '<div class="clients_image_holder post">';
                    $html .= '<div class="item col-md-12">';
                    $html .= '<div class="clients_image_holder_inside post" style="background-color:'.$background_color_overlay.';">';
                        if($thumbnail_src) { 
                        $html .= '<img class="client_image '.$order.'" src="'. $thumbnail_src[0] . '" alt="'. $client->post_title .'" />';
                        }else{ 
                        $html .= '<img src="http://placehold.it/160x100" alt="'. $client->post_title .'" />'; 
                      }
                    $html .= '</div>';
                    $html .= '</div>';
                        $html .= '</div>';
                    }
            $html .= '</div>';
        $html .= '</div>';
        
    return $html;
}
add_shortcode('clients01', 'modeltheme_shortcode_clients01');

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
              $pricing_table .= '<label class="monthly-label active" for="monthly-2">'.esc_html('Monthly','modeltheme').'</label>';
              $pricing_table .= '<input type="radio" name="duration-2" value="yearly" id="yearly-2">';
              $pricing_table .= '<label class="yearly-label" for="yearly-2">'.esc_html('Yearly','modeltheme').'</label>';
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
    $thumb_src = '';
    if ($thumb) {
        $thumb_src  = $thumb[0];
    }
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
                if ($thumb) {
                    $pricing_table .= '<img alt="pricing-table" src="'.esc_url($thumb_src).'">';
                }
              }
                
            $pricing_table .= '</div>';
          $pricing_table .= '</div>';
          $pricing_table .= '<header class="cd-pricing-header" style="background:'.esc_attr($box_background_color).'">';
            $pricing_table .= '<h3 style="color:'.esc_attr($header_button_content_color).'" class="package_title">'.esc_attr($package_title).'</h3>';
          $pricing_table .= '</header>';


          $pricing_table .= '<div style="color:'.esc_attr($content_color).'" class="cd-pricing-body">';
            $pricing_table .= '<div class="package_price_per_month-parent">';
                  $pricing_table .= '<span class="cd-value-month"><sup>'.esc_attr($package_price_currency).'</sup>'.esc_attr($package_price_per_month).'<span class="line">/</span></span>';
                  $pricing_table .= '<span class="cd-duration">'.esc_html__('month','modeltheme').'</span>';
                $pricing_table .= '</div>';
                $pricing_table .= '<div class="package_price_per_year-parent">';
                  $pricing_table .= '<span class="cd-value-year"><sup>'.esc_attr($package_price_currency).'</sup>'.esc_attr($package_price_per_year).'<span class="line">/</span></span>';
                  $pricing_table .= '<span class="cd-duration">'.esc_html__('year','modeltheme').'</span>';
                $pricing_table .= '</div>';
                $arr = array('ul' => array(), 'li' => array());
                $pricing_table .= wp_kses($content_pricing_table, $arr);

                      

                        $pricing_table .= '<a style="background:'.esc_attr($button_background_color).'" class="pricing-select-button" href="'.esc_attr($button_url).'">'.esc_attr($button_text).'</a>';

          $pricing_table .= '</div>';

        $pricing_table .= '</li>';

      $pricing_table .= '</ul>'; //cd-pricing-wrapper
    $pricing_table .= '</li>';

      return $pricing_table;
}
add_shortcode('mt_pricing_table_short_v4_item', 'mt_shortcode_pricing_table_v4_items');


class MT_Icon_Services {

    protected $mt_shortcode_columns;
    
    public function __construct() {
        add_shortcode('mt_icon_services', array($this, 'mt_shortcode_icon_services'));
        add_shortcode('mt_icon_services_item', array($this, 'mt_shortcode_icon_services_items'));
        add_action('init', array($this, 'mt_icon_services_vc_element'));
        add_action('init', array($this, 'mt_shortcode_icon_services_items_vc_element'));
    }




    /*************************************************************************************************************************/
    // PARENT SHORTCODE
    /*************************************************************************************************************************/
    public function mt_shortcode_icon_services($params,  $content = NULL) {
        extract( shortcode_atts( 
            array(
                'style'                 => '',
                'text_align'            => '',
                'columns'               => '',
            ), $params ) );

        $this->mt_shortcode_columns = $columns;

        $html = '';
            
        $html .= '<div class="mt_services-shortcode row '.$text_align.' '.$style.'">';
            $html .= do_shortcode($content);
        $html .= '</div>';
        return $html;
    }
    // add_shortcode('mt_icon_services', 'mt_shortcode_icon_services');







    /*************************************************************************************************************************/
    // CHILD SHORTCODE
    /*************************************************************************************************************************/
    public function mt_shortcode_icon_services_items($params, $content = NULL) {
        extract( shortcode_atts( 
            array(
                'menu_item_title'               => '',
                'menu_item_title_color'         => '',
                'menu_item_content'             => '',
                'menu_item_content_color'       => '',
                'menu_item_image'               => '',
                'type'                          => '',
                'icon_fontawesome'              => '',
                'icon_openiconic'               => '',
                'icon_typicons'                 => '',
                'icon_entypo'                   => '',
                'icon_linecons'                 => '',
                'icon_monosocial'               => '',
                'icon_material'                 => '',
                'color'                         => '',
                'custom_color'                  => '',
                'custom_color_hover'            => '',
                'background_style'              => '',
                'background_color'              => '',
                'custom_background_color'       => '',
                'custom_background_color_hover' => '',
                'size'                          => '',
                'align'                         => '',
                'link'                          => '',
            ), $params ) );


        vc_icon_element_fonts_enqueue( $type );

        $has_style = false;
        if ( strlen( $background_style ) > 0 ) {
            $has_style = true;
            if ( false !== strpos( $background_style, 'outline' ) ) {
                $background_style .= ' vc_icon_element-outline'; // if we use outline style it is border in css
            } else {
                $background_style .= ' vc_icon_element-background';
            }
        }

        $style = '';
        if ( 'custom' === $background_color ) {
            if ( false !== strpos( $background_style, 'outline' ) ) {
                $style = 'border-color:' . $custom_background_color;
            } else {
                $style = 'background-color:' . $custom_background_color;
            }
        }
        $style = $style ? 'style="' . esc_attr( $style ) . '"' : '';

        $has_style_vc_icon_element = '';
        if ( $has_style ) { 
            $has_style_vc_icon_element = 'vc_icon_element-have-style'; 
        }


        $has_style_vc_icon_element_inner = '';
        if ( $has_style ) { 
            $has_style_vc_icon_element_inner = 'vc_icon_element-have-style-inner'; 
        }


        $menu_item_title_color_style = '';
        if ($menu_item_title_color) {
            $menu_item_title_color_style = 'color: '.$menu_item_title_color.';';
        }
        $menu_item_content_color_style = '';
        if ($menu_item_content_color) {
            $menu_item_content_color_style = 'color: '.$menu_item_content_color.';';
        }

        // ICON HOVER
        $custom_color_hover_style = '';
        if ($custom_color_hover) {
            $custom_color_hover_style = 'color: '.$custom_color_hover.' !important;';
        }
        $custom_background_color_hover_style = '';
        if ($custom_background_color_hover) {
            $custom_background_color_hover_style = 'background: '.$custom_background_color_hover.' !important; 
                                                    box-shadow: 0 0 15px '.$custom_background_color_hover.';
                                                    -webkit-box-shadow: 0 0 15px '.$custom_background_color_hover.';';
        }



        $html = '';
        $unique_class = 'mt_icon_services_item_'.uniqid();

        $html .= '<div class="mt_icon_services_item mt_icon_services_item_inline style_v1 '.$this->mt_shortcode_columns.' '.$unique_class.'" data-identificator="'.$unique_class.'">';

            $img = wp_get_attachment_image_src($menu_item_image, 'full'); 
            if (isset($menu_item_image)) {
                $html .= '<img class="menu_item_image" src="'.$img[0].'" alt="" />';
            }

            $html .= '<div
                            class="vc_icon_element vc_icon_element-outer vc_icon_element-align-'.esc_attr( $align ).'">
                            <div
                                class="vc_icon_element-inner vc_icon_element-inner vc_icon_element-color-'.esc_attr( $color ).' '.esc_attr($has_style_vc_icon_element_inner).' vc_icon_element-size-'.esc_attr( $size ).'  vc_icon_element-style-'.esc_attr( $background_style ).' vc_icon_element-background-color-'.esc_attr( $background_color ).'" '.$style.'><span
                                    class="vc_icon_element-icon '.esc_attr( ${'icon_' . $type} ).'" '.( 'custom' === $color ? 'style="color:' . esc_attr( $custom_color ) . ';"' : '' ).'></span>';

                                    if ( strlen( $link ) > 0 ) {
                                        $html .= '<' . $link . '></a>';
                                    }

                    $html .= '</div>
                        </div>';



            $html .= '<h3 class="menu_item_title" style="'.$menu_item_title_color_style.'">'.$menu_item_title.'</h3>';
            $html .= '<p class="menu_item_content" style="'.$menu_item_content_color_style.'">'.$menu_item_content.'</p>';
        $html .= '</div>';

        return $html;
    }
    // add_shortcode('mt_icon_services_item', 'mt_shortcode_icon_services_items');






    /*************************************************************************************************************************/
    // VC_MAP THE PARENT SHORTCODE
    /*************************************************************************************************************************/
    function mt_icon_services_vc_element() {
        if (function_exists('vc_map')) {
            vc_map( array(
                "name" => esc_attr__("Icon Services", 'modeltheme'),
                "base" => "mt_icon_services",
                "as_parent" => array('only' => 'mt_icon_services_item, mt_icon_services_item_v2'), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
                'content_element' => true,
                'allowed_container_element' => 'vc_row',
                'show_settings_on_create' => true,
                "icon" => plugins_url( 'images/service-icon-with-text.svg', __FILE__ ),
                "category" => esc_attr__('pomana Theme', 'modeltheme'),
                "params" => array(
                    // add params same as with any other content element
                    array(
                        "type" => "dropdown",
                        "heading" => esc_attr__("Text Align", 'modeltheme'),
                        "param_name" => "text_align",
                        "std" => '',
                        "holder" => "div",
                        "class" => "",
                        "description" => "",
                        "value" => array(
                            esc_attr__('Left', 'modeltheme')  => 'text-left',
                            esc_attr__('Center', 'modeltheme')  => 'text-center',
                            esc_attr__('Right', 'modeltheme')  => 'text-right',
                        )
                    ),
                    array(
                        "type" => "dropdown",
                        "heading" => esc_attr__("Style", 'modeltheme'),
                        "param_name" => "style",
                        "std" => '',
                        "holder" => "div",
                        "class" => "",
                        "description" => "",
                        "value" => array(
                            esc_attr__('Light (For dark background)', 'modeltheme')  => 'skin_light',
                            esc_attr__('Dark (For light background)', 'modeltheme') => 'skin_dark',
                        )
                    ),
                    // add params same as with any other content element
                    array(
                        "type" => "dropdown",
                        "heading" => esc_attr__("Columns", 'modeltheme'),
                        "param_name" => "columns",
                        "std" => '',
                        "holder" => "div",
                        "class" => "",
                        "description" => "",
                        "value" => array(
                            esc_attr__('2 Columns', 'modeltheme')  => 'col-md-6',
                            esc_attr__('3 Columns', 'modeltheme')  => 'col-md-4',
                            esc_attr__('4 Columns', 'modeltheme')  => 'col-md-3',
                            esc_attr__('6 Columns', 'modeltheme')  => 'col-md-2',
                        )
                    ),
                ),
                "js_view" => 'VcColumnView'
            ) );
        }
    }



    /*************************************************************************************************************************/
    // VC_MAP THE CHILD SHORTCODE
    /*************************************************************************************************************************/
    function mt_shortcode_icon_services_items_vc_element() {

        if (function_exists('vc_map')) {
            vc_map( array(
                "name" => esc_attr__("Icon Services Item v1", 'modeltheme'),
                "base" => "mt_icon_services_item",
                "content_element" => true,
                "icon" => plugins_url( 'images/service-icon-with-text.svg', __FILE__ ),
                "as_child" => array('only' => 'mt_icon_services'), // Use only|except attributes to limit parent (separate multiple values with comma)
                "params" => array(
                    // add params same as with any other content element
                    array(
                        "group"         => "Icon",
                        'type' => 'dropdown',
                        'heading' => __( 'Icon library', 'modeltheme' ),
                        'value' => array(
                            __( 'Font Awesome', 'modeltheme' ) => 'fontawesome',
                            __( 'Open Iconic', 'modeltheme' ) => 'openiconic',
                            __( 'Typicons', 'modeltheme' ) => 'typicons',
                            __( 'Entypo', 'modeltheme' ) => 'entypo',
                            __( 'Linecons', 'modeltheme' ) => 'linecons',
                            __( 'Mono Social', 'modeltheme' ) => 'monosocial',
                            __( 'Material', 'modeltheme' ) => 'material',
                        ),
                        'admin_label' => true,
                        'param_name' => 'type',
                        'description' => __( 'Select icon library.', 'modeltheme' ),
                    ),
                    array(
                        "group"         => "Icon",
                        'type' => 'iconpicker',
                        'heading' => __( 'Icon', 'modeltheme' ),
                        'param_name' => 'icon_fontawesome',
                        'value' => 'fa fa-adjust',
                        // default value to backend editor admin_label
                        'settings' => array(
                            'emptyIcon' => false,
                            // default true, display an "EMPTY" icon?
                            'iconsPerPage' => 4000,
                            // default 100, how many icons per/page to display, we use (big number) to display all icons in single page
                        ),
                        'dependency' => array(
                            'element' => 'type',
                            'value' => 'fontawesome',
                        ),
                        'description' => __( 'Select icon from library.', 'modeltheme' ),
                    ),
                    array(
                        "group"         => "Icon",
                        'type' => 'iconpicker',
                        'heading' => __( 'Icon', 'modeltheme' ),
                        'param_name' => 'icon_openiconic',
                        'value' => 'vc-oi vc-oi-dial',
                        // default value to backend editor admin_label
                        'settings' => array(
                            'emptyIcon' => false,
                            // default true, display an "EMPTY" icon?
                            'type' => 'openiconic',
                            'iconsPerPage' => 4000,
                            // default 100, how many icons per/page to display
                        ),
                        'dependency' => array(
                            'element' => 'type',
                            'value' => 'openiconic',
                        ),
                        'description' => __( 'Select icon from library.', 'modeltheme' ),
                    ),
                    array(
                        "group"         => "Icon",
                        'type' => 'iconpicker',
                        'heading' => __( 'Icon', 'modeltheme' ),
                        'param_name' => 'icon_typicons',
                        'value' => 'typcn typcn-adjust-brightness',
                        // default value to backend editor admin_label
                        'settings' => array(
                            'emptyIcon' => false,
                            // default true, display an "EMPTY" icon?
                            'type' => 'typicons',
                            'iconsPerPage' => 4000,
                            // default 100, how many icons per/page to display
                        ),
                        'dependency' => array(
                            'element' => 'type',
                            'value' => 'typicons',
                        ),
                        'description' => __( 'Select icon from library.', 'modeltheme' ),
                    ),
                    array(
                        "group"         => "Icon",
                        'type' => 'iconpicker',
                        'heading' => __( 'Icon', 'modeltheme' ),
                        'param_name' => 'icon_entypo',
                        'value' => 'entypo-icon entypo-icon-note',
                        // default value to backend editor admin_label
                        'settings' => array(
                            'emptyIcon' => false,
                            // default true, display an "EMPTY" icon?
                            'type' => 'entypo',
                            'iconsPerPage' => 4000,
                            // default 100, how many icons per/page to display
                        ),
                        'dependency' => array(
                            'element' => 'type',
                            'value' => 'entypo',
                        ),
                    ),
                    array(
                        "group"         => "Icon",
                        'type' => 'iconpicker',
                        'heading' => __( 'Icon', 'modeltheme' ),
                        'param_name' => 'icon_linecons',
                        'value' => 'vc_li vc_li-heart',
                        // default value to backend editor admin_label
                        'settings' => array(
                            'emptyIcon' => false,
                            // default true, display an "EMPTY" icon?
                            'type' => 'linecons',
                            'iconsPerPage' => 4000,
                            // default 100, how many icons per/page to display
                        ),
                        'dependency' => array(
                            'element' => 'type',
                            'value' => 'linecons',
                        ),
                        'description' => __( 'Select icon from library.', 'modeltheme' ),
                    ),
                    array(
                        "group"         => "Icon",
                        'type' => 'iconpicker',
                        'heading' => __( 'Icon', 'modeltheme' ),
                        'param_name' => 'icon_monosocial',
                        'value' => 'vc-mono vc-mono-fivehundredpx',
                        // default value to backend editor admin_label
                        'settings' => array(
                            'emptyIcon' => false,
                            // default true, display an "EMPTY" icon?
                            'type' => 'monosocial',
                            'iconsPerPage' => 4000,
                            // default 100, how many icons per/page to display
                        ),
                        'dependency' => array(
                            'element' => 'type',
                            'value' => 'monosocial',
                        ),
                        'description' => __( 'Select icon from library.', 'modeltheme' ),
                    ),
                    array(
                        "group"         => "Icon",
                        'type' => 'iconpicker',
                        'heading' => __( 'Icon', 'modeltheme' ),
                        'param_name' => 'icon_material',
                        'value' => 'vc-material vc-material-cake',
                        // default value to backend editor admin_label
                        'settings' => array(
                            'emptyIcon' => false,
                            // default true, display an "EMPTY" icon?
                            'type' => 'material',
                            'iconsPerPage' => 4000,
                            // default 100, how many icons per/page to display
                        ),
                        'dependency' => array(
                            'element' => 'type',
                            'value' => 'material',
                        ),
                        'description' => __( 'Select icon from library.', 'modeltheme' ),
                    ),
                    array(
                        "group"         => "Icon",
                        'type' => 'dropdown',
                        'heading' => __( 'Icon color', 'modeltheme' ),
                        'param_name' => 'color',
                        'value' => array_merge( vc_get_shared( 'colors' ), array( __( 'Custom color', 'modeltheme' ) => 'custom' ) ),
                        'description' => __( 'Select icon color.', 'modeltheme' ),
                        'param_holder_class' => 'vc_colored-dropdown',
                    ),
                    array(
                        "group"         => "Icon",
                        'type' => 'colorpicker',
                        'heading' => __( 'Custom color', 'modeltheme' ),
                        'param_name' => 'custom_color',
                        'description' => __( 'Select custom icon color.', 'modeltheme' ),
                        'dependency' => array(
                            'element' => 'color',
                            'value' => 'custom',
                        ),
                    ),                  
                    array(
                        "group"         => "Icon",
                        'type' => 'colorpicker',
                        'heading' => __( 'Custom color - HOVER', 'modeltheme' ),
                        'param_name' => 'custom_color_hover',
                        'description' => __( 'Select custom icon color for HOVER state.', 'modeltheme' ),
                    ),

                    array(
                        "group"         => "Icon",
                        'type' => 'dropdown',
                        'heading' => __( 'Background shape', 'modeltheme' ),
                        'param_name' => 'background_style',
                        'value' => array(
                            __( 'None', 'modeltheme' ) => '',
                            __( 'Circle', 'modeltheme' ) => 'rounded',
                            __( 'Square', 'modeltheme' ) => 'boxed',
                            __( 'Rounded', 'modeltheme' ) => 'rounded-less',
                            __( 'Outline Circle', 'modeltheme' ) => 'rounded-outline',
                            __( 'Outline Square', 'modeltheme' ) => 'boxed-outline',
                            __( 'Outline Rounded', 'modeltheme' ) => 'rounded-less-outline',
                        ),
                        'description' => __( 'Select background shape and style for icon.', 'modeltheme' ),
                    ),
                    array(
                        "group"         => "Icon",
                        'type' => 'dropdown',
                        'heading' => __( 'Background color', 'modeltheme' ),
                        'param_name' => 'background_color',
                        'value' => array_merge( vc_get_shared( 'colors' ), array( __( 'Custom color', 'modeltheme' ) => 'custom' ) ),
                        'std' => 'grey',
                        'description' => __( 'Select background color for icon.', 'modeltheme' ),
                        'param_holder_class' => 'vc_colored-dropdown',
                        'dependency' => array(
                            'element' => 'background_style',
                            'not_empty' => true,
                        ),
                    ),
                    array(
                        "group"         => "Icon",
                        'type' => 'colorpicker',
                        'heading' => __( 'Custom background color', 'modeltheme' ),
                        'param_name' => 'custom_background_color',
                        'description' => __( 'Select custom icon background color.', 'modeltheme' ),
                        'dependency' => array(
                            'element' => 'background_color',
                            'value' => 'custom',
                        ),
                    ),
                    array(
                        "group"         => "Icon",
                        'type' => 'colorpicker',
                        'heading' => __( 'Custom background color - HOVER', 'modeltheme' ),
                        'param_name' => 'custom_background_color_hover',
                        'description' => __( 'Select custom icon background color for HOVER state.', 'modeltheme' ),
                    ),

                    array(
                        "group"         => "Icon",
                        'type' => 'dropdown',
                        'heading' => __( 'Size', 'modeltheme' ),
                        'param_name' => 'size',
                        'value' => array_merge( vc_get_shared( 'sizes' ), array( 'Extra Large' => 'xl' ) ),
                        'std' => 'md',
                        'description' => __( 'Icon size.', 'modeltheme' ),
                    ),
                    array(
                        "group"         => "Icon",
                        'type' => 'dropdown',
                        'heading' => __( 'Icon alignment', 'modeltheme' ),
                        'param_name' => 'align',
                        'value' => array(
                            __( 'Left', 'modeltheme' ) => 'left',
                            __( 'Right', 'modeltheme' ) => 'right',
                            __( 'Center', 'modeltheme' ) => 'center',
                        ),
                        'description' => __( 'Select icon alignment.', 'modeltheme' ),
                    ),
                    array(
                        "group"         => "Icon",
                        'type' => 'vc_link',
                        'heading' => __( 'URL (Link)', 'modeltheme' ),
                        'param_name' => 'link',
                        'description' => __( 'Add link to icon.', 'modeltheme' ),
                    ),



                    // VC_MAP FOR ICON as image TAB
                    array(
                        "group"         => "Icon",
                        "type"          => "attach_image",
                        "holder"        => "div",
                        "class"         => "",
                        "heading"       => esc_attr__( "Thumbnail", 'modeltheme' ),
                        "param_name"    => "menu_item_image",
                        "description"   => ""
                    ),



                    // VC_MAP FOR TITLE TAB
                    array(
                        "group"        => "Title",
                        "type"         => "textfield",
                        "holder"       => "div",
                        "class"        => "",
                        "param_name"   => "menu_item_title",
                        "heading"      => esc_attr__("Title", 'modeltheme'),
                        "description"  => esc_attr__("Enter title for current menu item(Eg: Italian Pizza)", 'modeltheme'),
                    ),
                    array(
                        "group"         => "Title",
                        'type' => 'colorpicker',
                        'heading' => __( 'Custom color', 'modeltheme' ),
                        'param_name' => 'menu_item_title_color',
                        'description' => __( 'Select custom icon color.', 'modeltheme' ),
                    ),



                    // VC_MAP FOR SUBTITLE TAB
                    array(
                        "group"        => "Subtitle",
                        "type"         => "textarea",
                        "holder"       => "div",
                        "class"        => "",
                        "param_name"   => "menu_item_content",
                        "heading"      => esc_attr__("Subtitle", 'modeltheme'),
                        "description"  => esc_attr__("Enter title for current menu item(Eg: 30x30cm with cheese, onion rings, olives and tomatoes)", 'modeltheme'),
                    ),
                    array(
                        "group"         => "Subtitle",
                        'type' => 'colorpicker',
                        'heading' => __( 'Custom color', 'modeltheme' ),
                        'param_name' => 'menu_item_content_color',
                        'description' => __( 'Select custom icon color.', 'modeltheme' ),
                    ),
                )
            ) );
        }
    }

}



new MT_Icon_Services();

//Your "container" content element should extend WPBakeryShortCodesContainer class to inherit all required functionality
if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
    class WPBakeryShortCode_mt_icon_services extends WPBakeryShortCodesContainer {
    }
}
if ( class_exists( 'WPBakeryShortCode' ) ) {
    class WPBakeryShortCode_mt_icon_services_Item extends WPBakeryShortCode {
    }
}

/**

||-> Shortcode: SVG Blob

*/
function modeltheme_svg_blob_shortcode($params, $content) {
    extract( shortcode_atts( 
        array(
            'icon_or_image' => '', 
            'animation'     => '', 
            'back_color'    => '', 
            'clip_path'     => '',
            'skillvalue'    => '',
            'blob_width'    => '',
            'image_skill'   => '',
            'extra_class'   => ''
        ), $params ) );

    $image_skill      = wp_get_attachment_image_src($image_skill, "full");
    $image_skillsrc = '';
    if ($image_skill) {
      $image_skillsrc  = $image_skill[0];
    }
    $id = uniqid();

    $html = '';
    $html .= '<div class="svg-block '.$extra_class.'" >';
        $html .= '<svg viewBox="0 0 480 480" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="width:'.$blob_width.';">';
                    if($icon_or_image == 'choosed_icon'){
                        $html .= '<path fill="'.$back_color.'" d="'.$clip_path.'" />';
                    } else if ($icon_or_image == 'choosed_image') {
                        $html .= '<defs>
                            <clipPath id="blob-'.$id.'">
                                <path fill="#474bff" d="'.$clip_path.'"/>
                            </clipPath>
                            </defs>
                            <image x="0" y="0" width="100%" height="100%" clip-path="url(#blob-'.$id.')" xlink:href="'.esc_attr($image_skillsrc).'" preserveAspectRatio="xMidYMid slice"></image>';
                    }
        $html .= '</svg>';
    $html .= '</div>';
    return $html;
}
add_shortcode('svg-blob', 'modeltheme_svg_blob_shortcode');


// check for plugin using plugin name
if ( function_exists('vc_map')) {
    require_once('vc-shortcodes.inc.php');
} 