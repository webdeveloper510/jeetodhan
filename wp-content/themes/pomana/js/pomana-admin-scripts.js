jQuery(document).ready(function(){

  'use strict';

	var value_selected = jQuery("#page_template").val();
    
  if (value_selected == "templates/template-blog.php" ){
  	jQuery('.blog_header_show').show();
  } else {
  	jQuery('.blog_header_show').hide();
  }

  jQuery('#page_template').on('change', function() {
    if (  jQuery('#page_template').val() == "templates/template-blog.php") { 
          jQuery('.blog_header_show').show();
    } else {
    		jQuery('.blog_header_show').hide();
    }
  });


  //Header Options: Rewrite Theme Options
  var header_custom = jQuery('#pomana_custom_header_options_status').val();
  if (header_custom == "no" ){
    jQuery(".cmb_id_pomana_header_custom_fixed_navigation").hide();
    jQuery(".cmb_id_pomana_header_custom_logo").hide();
    jQuery(".cmb_id_pomana_header_custom_variant").hide();
  }
  jQuery('#pomana_custom_header_options_status').on('change', function() {
    var header_custom = jQuery(this).val();
    if (header_custom == "no" ){
      jQuery(".cmb_id_pomana_header_custom_fixed_navigation").hide();
      jQuery(".cmb_id_pomana_header_custom_logo").hide();
      jQuery(".cmb_id_pomana_header_custom_variant").hide();
    }else{
      jQuery(".cmb_id_pomana_header_custom_fixed_navigation").show();
      jQuery(".cmb_id_pomana_header_custom_logo").show();
      jQuery(".cmb_id_pomana_header_custom_variant").show();
    }
  });


  //Footer Options: Rewrite Theme Options
  var header_custom = jQuery('#mt_custom_footer_options_status').val();
  if (header_custom == "no" ){
    jQuery(".cmb_id_mt_footer_custom_row1_status").hide();
    jQuery(".cmb_id_mt_footer_custom_row2_status").hide();
    jQuery(".cmb_id_mt_footer_custom_row3_status").hide();
  }
  jQuery('#mt_custom_footer_options_status').on('change', function() {
    var header_custom = jQuery(this).val();
    if (header_custom == "no" ){
      jQuery(".cmb_id_mt_footer_custom_row1_status").hide();
      jQuery(".cmb_id_mt_footer_custom_row2_status").hide();
      jQuery(".cmb_id_mt_footer_custom_row3_status").hide();
    }else{
      jQuery(".cmb_id_mt_footer_custom_row1_status").show();
      jQuery(".cmb_id_mt_footer_custom_row2_status").show();
      jQuery(".cmb_id_mt_footer_custom_row3_status").show();
    }
  });


  // COURSE LAYOUT + SIDEBAR OPTIONS (on load)
  var course_layout = jQuery('#pomana_course_layout').val();
  var course_sidebar = jQuery('.cmb_id_pomana_course_sidebar');
  
  if (course_layout != "full_width" ){
    jQuery(course_sidebar).show();
  }else{
    jQuery(course_sidebar).hide();
  }


  // COURSE LAYOUT + SIDEBAR OPTIONS (on change)
  jQuery('#pomana_course_layout').on('change', function() {
    var course_layout = jQuery('#pomana_course_layout').val();
    var course_sidebar = jQuery('.cmb_id_pomana_course_sidebar');
    
    if (course_layout != "full_width" ){
      jQuery(course_sidebar).show();
    }else{
      jQuery(course_sidebar).hide();
    }

  });

  //CUSTOM JS CODE FOR ADMIN PANEL ONLY


});