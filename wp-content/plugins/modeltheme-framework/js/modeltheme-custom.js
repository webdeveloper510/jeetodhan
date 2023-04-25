/*
* ||||||||||||||||||||||||||||||||||||||||||||||||||||||||-> PROGRESS BAR (Shortcode)
*/

jQuery( document ).ready(function() {

  jQuery(function () { 
    jQuery('[data-toggle="tooltip"]').tooltip({trigger: 'manual'}).tooltip('show');
  });  

  jQuery( window ).scroll(function() {
    // if($( window ).scrollTop() > 10){   scroll down abit and get the action   
    jQuery(".progress-bar ").each(function(){
      each_bar_width = jQuery(this).attr('aria-valuenow');
/*      jQuery(this).width(each_bar_width + '%');
*/      jQuery( this ).css( "width", each_bar_width + '%' );
    });
         
   //  }   
  });

  jQuery( ".cd-pricing-switcher .monthly-label" ).on( "click", function() {
      jQuery( ".cd-pricing-switcher .yearly-label" ).removeClass('active');
      jQuery(this).addClass('active');
      jQuery('.package_price_per_year-parent').hide();
      jQuery('.package_price_per_month-parent').show();
    });
    jQuery( ".cd-pricing-switcher .yearly-label" ).on( "click", function() {
      jQuery( ".cd-pricing-switcher .monthly-label" ).removeClass('active');
      jQuery(this).addClass('active');
      jQuery('.package_price_per_month-parent').hide();
      jQuery('.package_price_per_year-parent').show();
    });

    //horizontal pricing table
    jQuery('.pricing__feature-list').children('li').on("hover",function() {
      var index = jQuery(this).index() + 1;
      jQuery('.pricing__feature-list li:nth-child(' + index + ')').toggleClass( "highlight" );
    });
    
  // Perform AJAX login on form submit
  jQuery('form#login').on('submit', function(e){
      jQuery('form#login p.status').show().text(ajax_login_object.loadingmessage);
      jQuery.ajax({
          type: 'POST',
          dataType: 'json',
          url: ajax_login_object.ajaxurl,
          data: { 
              'action': 'ajaxlogin', //calls wp_ajax_nopriv_ajaxlogin
              'username': jQuery('form#login #username').val(), 
              'password': jQuery('form#login #password').val(), 
              'security': jQuery('form#login #security').val() },
          success: function(data){
              jQuery('form#login p.status').text(data.message);
              if (data.loggedin == true){
                  document.location.href = ajax_login_object.redirecturl;
              }
          }
      });
      e.preventDefault();
});

    jQuery(".mt_members1").owlCarousel({
        navigation      : true, // Show next and prev buttons
        navigationText: [
        "<i class='fa fa-angle-left' aria-hidden='true'></i>",
        "<i class='fa fa-angle-right' aria-hidden='true'></i>"
        ],
        pagination      : false,
        autoPlay        : false,
        slideSpeed      : 700,
        paginationSpeed : 700,
        singleItem      : false,
        itemsCustom : [
            [0,     1],
            [450,   1],
            [600,   2],
            [700,   2],
            [1000,  3],
            [1200,  4],
            [1400,  4],
            [1600,  4]
        ]
    });

     /*
    * ||||||||||||||||||||||||||||||||||||||||||||||||||||||||-> CLIENTS SLIDER (Shortcode)
    */
    jQuery(".clients_container_shortcode-1").owlCarousel({
        navigation      : false, // Show next and prev buttons
        pagination      : false,
        autoPlay        : false,
        slideSpeed      : 700,
        paginationSpeed : 700,
        autoPlay : true,
        autoPlayTimeout:10000,
        autoPlayHoverPause:true,
        itemsCustom : [
            [0,     1],
            [450,   1],
            [600,   1],
            [700,   1],
            [1000,  1],
            [1200,  1],
            [1400,  1],
            [1600,  1]
        ]
    });
    jQuery(".clients_container_shortcode-2").owlCarousel({
        navigation      : false, // Show next and prev buttons
        pagination      : false,
        autoPlay        : false,
        slideSpeed      : 700,
        paginationSpeed : 700,
        autoPlay : true,
        autoPlayTimeout:10000,
        autoPlayHoverPause:true,
        itemsCustom : [
            [0,     1],
            [450,   1],
            [600,   2],
            [700,   2],
            [1000,  2],
            [1200,  2],
            [1400,  2],
            [1600,  2]
        ]
    });
    jQuery(".clients_container_shortcode-3").owlCarousel({
        navigation      : false, // Show next and prev buttons
        pagination      : false,
        autoPlay        : false,
        slideSpeed      : 700,
        paginationSpeed : 700,
        autoPlay : true,
        autoPlayTimeout:10000,
        autoPlayHoverPause:true,
        itemsCustom : [
            [0,     1],
            [450,   1],
            [600,   2],
            [700,   2],
            [1000,  3],
            [1200,  3],
            [1400,  3],
            [1600,  3]
        ]
    });

    jQuery(".clients_container_shortcode-4").owlCarousel({
        navigation      : false, // Show next and prev buttons
        pagination      : false,
        autoPlay        : false,
        slideSpeed      : 700,
        paginationSpeed : 700,
        autoPlay : true,
        autoPlayTimeout:10000,
        autoPlayHoverPause:true,
        itemsCustom : [
            [0,     1],
            [450,   1],
            [600,   2],
            [700,   3],
            [1000,  4],
            [1200,  4],
            [1400,  4],
            [1600,  4]
        ]
    });


    jQuery(".clients_container_shortcode-5").owlCarousel({
        navigation      : false, // Show next and prev buttons
        pagination      : false,
        autoPlay        : false,
        slideSpeed      : 700,
        paginationSpeed : 700,
        autoPlay : true,
        autoPlayTimeout:10000,
        autoPlayHoverPause:true,
        itemsCustom : [
            [0,     1],
            [450,   2],
            [600,   2],
            [700,   5],
            [1000,  6],
            [1200,  6],
            [1400,  5],
            [1600,  5]
        ]
    });

    /*Begin: Products Carousel slider*/
        jQuery(".modeltheme_products_carousel").owlCarousel({
            navigation      : false, // Show next and prev buttons
            pagination      : false,
            autoPlay        : true,
            slideSpeed      : 700,
            paginationSpeed : 700,
            itemsCustom : [
                [0,     1],
                [450,   2],
                [600,   2],
                [700,   3],
                [1000,  3],
                [1200,  3],
                [1400,  3],
                [1600,  3]
            ]
        });

    if(jQuery('.modeltheme-breadcrumbs').lenght) {
      jQuery('.modeltheme-breadcrumbs a[href*=#].scroll-down').on('click', function(e) {
        e.preventDefault();
        jQuery('html, body').animate({ scrollTop: jQuery(jQuery(this).attr('href')).offset().top}, 500, 'linear');
      });
    }
});

(function() {
    [].slice.call( document.querySelectorAll( ".mt-tabs .tabs" ) ).forEach( function( el ) {
        new CBPFWTabs( el );
    });

})();

jQuery(document).ready(function($){
    jQuery(document).on('click','.mt-all-answers li',function(e){
        var answer_id = jQuery(this).attr('attr');
        if(jQuery(this).hasClass('selected')){
            answer_id = -2;
        }
        jQuery('input[name=lottery_answer]').val( parseInt(answer_id) );
        jQuery(this).siblings("li.selected").removeClass("selected").removeClass("false");
        jQuery(this).toggleClass("selected");

        if ( jQuery('input[name=mt_true_answers]').val() ) {
            mt_true_answers = $('input[name=mt_true_answers]').val().split(',');

            if( answer_id == -2) {
                jQuery(':input[name=add-to-cart]').addClass('mt-only-answer-true');
            }else if(jQuery.inArray( answer_id.toString(), mt_true_answers ) === -1) {
                jQuery(this).toggleClass('false');
                jQuery(':input[name=add-to-cart]').addClass('mt-only-answer-true');
            } else{
                jQuery(':input[name=add-to-cart]').removeClass('mt-only-answer-true');
            }
        }
    });
});


jQuery(document).on('submit', function(e){
    if ( jQuery(':input[name=add-to-cart]').hasClass('mt-only-answer-true') ){
        alert('The answer is not correct.');
        return false;
    }
});