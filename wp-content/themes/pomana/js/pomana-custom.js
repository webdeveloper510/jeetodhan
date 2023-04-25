/*
 Project author:     ModelTheme
 File name:          Custom JS
*/

(function ($) {
    'use strict';


    jQuery(window).on("load", function(){
        jQuery( '.linify_preloader_holder' ).fadeOut( 1000, function() {
            jQuery( this ).fadeOut();
        });
    });





    // Set Inline CSS for buttons
    jQuery('.mt_modeltheme_button').each(function(){   
        var btn_identificator = jQuery(this).attr('data-identificator'),
            btn_backgroundColorHover = jQuery(this).attr('data-background-color-hover'),
            btn_textColorHover = jQuery(this).attr('data-text-color-hover'),
            btn_textColor = jQuery(this).attr('data-text-color'),
            btn_backgroundColor = jQuery(this).attr('data-background-color');

        jQuery('.'+btn_identificator+' a.rippler.rippler-default').css("background-color", btn_backgroundColor);
        jQuery('.'+btn_identificator+' a.rippler.rippler-default').hover(function(){
            jQuery(this).css("background-color", btn_backgroundColorHover);
            jQuery(this).css("color", btn_textColorHover);
        }, function(){
            jQuery(this).css("background-color", btn_backgroundColor);
            jQuery(this).css("color", btn_textColor);
        });
    });

  
    /*LOGIN MODAL */
    var ModalEffects = (function() {
            function init_modal() {

                var overlay = document.querySelector( '.modeltheme-overlay' );
                var overlay_inner = document.querySelector( '.modeltheme-overlay-inner' );
                var modal_holder = document.querySelector( '.modeltheme-modal-holder' );
                var html = document.querySelector( 'html' );

                [].slice.call( document.querySelectorAll( '.modeltheme-trigger' ) ).forEach( function( el, i ) {

                    var modal = document.querySelector( '#' + el.getAttribute( 'data-modal' ) ),
                        close = modal.querySelector( '.modeltheme-close' );

                    function removeModal( hasPerspective ) {
                        classie.remove( modal, 'modeltheme-show' );
                        classie.remove( modal_holder, 'modeltheme-show' );
                        classie.remove( html, 'modal-open' );

                        if( hasPerspective ) {
                            classie.remove( document.documentElement, 'modeltheme-perspective' );
                        }
                    }

                    function removeModalHandler() {
                        removeModal( classie.has( el, 'modeltheme-setperspective' ) ); 
                    }

                    el.addEventListener( 'click', function( ev ) {
                        classie.add( modal, 'modeltheme-show' );
                        classie.add( modal_holder, 'modeltheme-show' );
                        classie.add( html, 'modal-open' );
                        overlay.removeEventListener( 'click', removeModalHandler );
                        overlay.addEventListener( 'click', removeModalHandler );

                        overlay_inner.removeEventListener( 'click', removeModalHandler );
                        overlay_inner.addEventListener( 'click', removeModalHandler );

                        if( classie.has( el, 'modeltheme-setperspective' ) ) {
                            setTimeout( function() {
                                classie.add( document.documentElement, 'modeltheme-perspective' );
                            }, 25 );
                        }
                    });

                } );

            }

        if (!jQuery("body").hasClass("login-register-page")) {
            init_modal();
        }

    })();
    
    jQuery('.widget_categories li .children').each(function(){
        jQuery(this).parent().addClass('cat_item_has_children');
    });
    jQuery('.widget_nav_menu li a').each(function(){
        if (jQuery(this).text() == '') {
            jQuery(this).parent().addClass('link_missing_text');
        }
    });


    jQuery(document).on('touchstart click', 'li.vc_tta-tab a,li.vc_tta-tab,.vc_tta-panel-title', function(){
        jQuery('html, body').stop();
    });

    jQuery( ".compare.button" ).on( "click", function() {
        setTimeout( function(){ 
            jQuery(".compare.button.added").empty();
        },3000 );
    });


    // 9th MENU Toggle - Hamburger
    var toggles = document.querySelectorAll(".c-hamburger");

    for (var i = toggles.length - 1; i >= 0; i--) {
      var toggle = toggles[i];
      toggleHandler(toggle);
    };

    function toggleHandler(toggle) {
      toggle.addEventListener( "click", function(e) {
        e.preventDefault();
        (this.classList.contains("is-btn-active") === true) ? this.classList.remove("is-btn-active") : this.classList.add("is-btn-active");
      });
    }

    
    jQuery(document).ready(function() {

        jQuery(".search_products").on({
            mouseenter: function () {
                //stuff to do on mouse enter
                jQuery('.header_search_form').addClass('visibile_contact');
            },
            mouseleave: function () {
                //stuff to do on mouse leave
                jQuery('.header_search_form').removeClass('visibile_contact');
            }
        });

    }); 

    // make woocommerce +/- quantity buttons functional
    if ( ! String.prototype.getDecimals ) {
            String.prototype.getDecimals = function() {
                var num = this,
                    match = ('' + num).match(/(?:\.(\d+))?(?:[eE]([+-]?\d+))?$/);
                if ( ! match ) {
                    return 0;
                }
                return Math.max( 0, ( match[1] ? match[1].length : 0 ) - ( match[2] ? +match[2] : 0 ) );
            }
        }
        // Quantity "plus" and "minus" buttons
        $( document.body ).on( 'click', '.plus, .minus', function() {
            var $qty        = $( this ).closest( '.quantity' ).find( '.qty'),
                currentVal  = parseFloat( $qty.val() ),
                max         = parseFloat( $qty.attr( 'max' ) ),
                min         = parseFloat( $qty.attr( 'min' ) ),
                step        = $qty.attr( 'step' );

            // Format values
            if ( ! currentVal || currentVal === '' || currentVal === 'NaN' ) currentVal = 0;
            if ( max === '' || max === 'NaN' ) max = '';
            if ( min === '' || min === 'NaN' ) min = 0;
            if ( step === 'any' || step === '' || step === undefined || parseFloat( step ) === 'NaN' ) step = 1;

            // Change the value
            if ( $( this ).is( '.plus' ) ) {
                if ( max && ( currentVal >= max ) ) {
                    $qty.val( max );
                } else {
                    $qty.val( ( currentVal + parseFloat( step )).toFixed( step.getDecimals() ) );
                }
            } else {
                if ( min && ( currentVal <= min ) ) {
                    $qty.val( min );
                } else if ( currentVal > 0 ) {
                    $qty.val( ( currentVal - parseFloat( step )).toFixed( step.getDecimals() ) );
                }
            }

            // Trigger change event
            $qty.trigger( 'change' );
        });

    $(document).ready(function() {

        jQuery(".shop_cart").on({
            mouseenter: function () {
                //stuff to do on mouse enter
                jQuery('.header_mini_cart').addClass('visible_cart');
            },
            mouseleave: function () {
                //stuff to do on mouse leave
                jQuery('.header_mini_cart').removeClass('visible_cart');
            }
        });

        jQuery(".header_mini_cart").on({
            mouseenter: function () {
                //stuff to do on mouse enter
                jQuery(this).addClass('visible_cart');
            },
            mouseleave: function () {
                //stuff to do on mouse leave
                jQuery(this).removeClass('visible_cart');
            }
        });
        
        if ( jQuery( "#commentform p:empty" ).length ) {
            jQuery('#commentform p:empty').remove();
        }

        if ( jQuery( ".woocommerce_categories" ).length ) {
            jQuery( ".category a" ).on( "click", function() {
                var attr = jQuery(this).attr("class");
                jQuery(".products_by_category").removeClass("active");
                jQuery(attr).addClass("active");
                jQuery('.category').removeClass("active");
                jQuery(this).parent('.category').addClass("active");
            });  
            jQuery('.products_category .products_by_category:first').addClass("active");
            jQuery('.categories_shortcode .category:first').addClass("active");
        }
        //Begin: Search Form
        if ( jQuery( "#modeltheme-search" ).length ) {
            new UISearch( document.getElementById( 'modeltheme-search' ) );
        }
        //End: Search Form


        // Skip Link Focus
        function pomana_skin_link_focus(){
            var is_webkit = navigator.userAgent.toLowerCase().indexOf( 'webkit' ) > -1,
                is_opera  = navigator.userAgent.toLowerCase().indexOf( 'opera' )  > -1,
                is_ie     = navigator.userAgent.toLowerCase().indexOf( 'msie' )   > -1;

            if ( ( is_webkit || is_opera || is_ie ) && document.getElementById && window.addEventListener ) {
                window.addEventListener( 'hashchange', function() {
                    var element = document.getElementById( location.hash.substring( 1 ) );

                    if ( element ) {
                        if ( ! /^(?:a|select|input|button|textarea)$/i.test( element.tagName ) ) {
                            element.tabIndex = -1;
                        }

                        element.focus();
                    }
                }, false );
            }
        }
        pomana_skin_link_focus();


        // Navigation
        function pomana_navigation(){
            var container, button, menu;

            container = document.getElementById( 'site-navigation' );
            if ( ! container ) {
                return;
            }

            button = container.getElementsByTagName( 'button' )[0];
            if ( 'undefined' === typeof button ) {
                return;
            }

            menu = container.getElementsByTagName( 'ul' )[0];

            // Hide menu toggle button if menu is empty and return early.
            if ( 'undefined' === typeof menu ) {
                button.style.display = 'none';
                return;
            }

            menu.setAttribute( 'aria-expanded', 'false' );

            if ( -1 === menu.className.indexOf( 'nav-menu' ) ) {
                menu.className += ' nav-menu';
            }

            button.onclick = function() {
                if ( -1 !== container.className.indexOf( 'toggled' ) ) {
                    container.className = container.className.replace( ' toggled', '' );
                    button.setAttribute( 'aria-expanded', 'false' );
                    menu.setAttribute( 'aria-expanded', 'false' );
                } else {
                    container.className += ' toggled';
                    button.setAttribute( 'aria-expanded', 'true' );
                    menu.setAttribute( 'aria-expanded', 'true' );
                }
            };
        }
        pomana_navigation();
        

        /*Begin: Testimonials slider*/
        jQuery(".testimonials-container").owlCarousel({
            navigation      : false, // Show next and prev buttons
            pagination      : false,
            autoPlay        : true,
            slideSpeed      : 700,
            paginationSpeed : 700,
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
        jQuery(".testimonials-container-1").owlCarousel({
            navigation      : false, // Show next and prev buttons
            pagination      : true,
            autoPlay        : true,
            slideSpeed      : 700,
            paginationSpeed : 700,
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
        jQuery(".testimonials-container-2").owlCarousel({
            
            pagination      : true,
            navigation:false,
            dots         : true,
            autoPlay        : false,
            slideSpeed      : 700,
            paginationSpeed : 700,
            itemsCustom : [
                [0,     1],
                [450,   1],
                [600,   1],
                [700,   1],
                [1000,  2],
                [1200,  2],
                [1400,  2],
                [1600,  2]
            ]
        });
        jQuery(".testimonials-container-3").owlCarousel({
            navigation      : true, // Show next and prev buttons
            pagination      : false,
            autoPlay        : true,
            slideSpeed      : 700,
            paginationSpeed : 700,
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
        /*End: Testimonials slider*/
        jQuery(".testimonials-container-3").owlCarousel({
            navigation      : false, // Show next and prev buttons
            pagination      : true,
            autoPlay        : true,
            slideSpeed      : 700,
            paginationSpeed : 700,
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
        /*Begin: Clients slider*/
        jQuery(".categories_shortcode").owlCarousel({
            navigation      : false, // Show next and prev buttons
            pagination      : false,
            autoPlay        : false,
            slideSpeed      : 700,
            paginationSpeed : 700,
            navigationText  : ["<i class='fa fa-arrow-left'></i>","<i class='fa fa-arrow-right'></i>"],
            itemsCustom : [
                [0,     1],
                [450,   2],
                [600,   2],
                [700,   5],
                [1000,  5],
                [1200,  5],
                [1400,  5],
                [1600,  5]
            ]
        });
        /*Begin: Products by category*/
        jQuery(".clients-container").owlCarousel({
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
                [1000,  5],
                [1200,  5],
                [1400,  5],
                [1600,  5]
            ]
        });
        /*Begin: Portfolio single slider*/
        jQuery(".portfolio_thumbnails_slider").owlCarousel({
            navigation      : true, // Show next and prev buttons
            pagination      : true,
            autoPlay        : false,
            slideSpeed      : 700,
            paginationSpeed : 700,
            navigationText  : ["",""],
            singleItem      : true
        });
        /*End: Portfolio single slider*/
        /*Begin: Testimonials slider*/
        jQuery(".post_thumbnails_slider").owlCarousel({
            navigation      : false, // Show next and prev buttons
            pagination      : false,
            autoPlay        : false,
            slideSpeed      : 700,
            paginationSpeed : 700,
            singleItem      : true
        });
        var owl = jQuery(".post_thumbnails_slider");
        jQuery( ".next" ).on( "click", function() {
            owl.trigger('owl.next');
        })
        jQuery( ".prev" ).on( "click", function() {
            owl.trigger('owl.prev');
        })
        /*End: Testimonials slider*/
        
        /*Begin: Testimonials slider*/
        jQuery(".testimonials_slider").owlCarousel({
            navigation      : false, // Show next and prev buttons
            pagination      : true,
            autoPlay        : false,
            slideSpeed      : 700,
            paginationSpeed : 700,
            singleItem      : true
        });
        /*End: Testimonials slider*/
        /* Animate */
        jQuery('.animateIn').animateIn();
        // browser window scroll (in pixels) after which the "back to top" link is shown
        var offset = 300,
            //browser window scroll (in pixels) after which the "back to top" link opacity is reduced
            offset_opacity = 1200,
            //duration of the top scrolling animation (in ms)
            scroll_top_duration = 700,
            //grab the "back to top" link
            $back_to_top = jQuery('.back-to-top');
        //hide or show the "back to top" link
        jQuery(window).scroll(function(){
            ( jQuery(this).scrollTop() > offset ) ? $back_to_top.addClass('modeltheme-is-visible') : $back_to_top.removeClass('modeltheme-is-visible modeltheme-fade-out');
            if( jQuery(this).scrollTop() > offset_opacity ) { 
                $back_to_top.addClass('modeltheme-fade-out');
            }
        });
        //smooth scroll to top
        $back_to_top.on('click', function(event){
            event.preventDefault();
            $('body,html').animate({
                scrollTop: 0 ,
                }, scroll_top_duration
            );
        });
        //Begin: Skills
        jQuery('.statistics').appear(function() {
            jQuery('.percentage').each(function(){
                var dataperc = jQuery(this).attr('data-perc');
                jQuery(this).find('.skill-count').delay(6000).countTo({
                    from: 0,
                    to: dataperc,
                    speed: 5000,
                    refreshInterval: 100
                });
            });
        }); 
        //End: Skills 

        jQuery(".testimonials-container-1").owlCarousel({
            navigation      : true, // Show next and prev buttons
            navigationText: [
            "<i class='fa fa-angle-left' aria-hidden='true'></i>",
            "<i class='fa fa-angle-right' aria-hidden='true'></i>"
            ],
            pagination      : false,
            autoPlay        : false,
            slideSpeed      : 700,
            paginationSpeed : 700,
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


    })
} (jQuery) );


// Navigation Submenus dropdown direction (right or left)
(function ($) {
    
    $(document).ready(function () {
        MTDefaultNavMenu.init();
    });
    
    $(window).resize(function(){
        MTDefaultNavMenu.init();
    });
    
    var MTDefaultNavMenu = {
        init: function () {
            var $menuItems = $('#navbar ul.menu > li.menu-item-has-children');
            
            if ($menuItems.length) {
                $menuItems.each(function (i) {
                    var thisItem = $(this),
                        menuItemPosition = thisItem.offset().left,
                        dropdownMenuItem = thisItem.find(' > ul'),
                        dropdownMenuWidth = dropdownMenuItem.outerWidth(),
                        menuItemFromLeft = $(window).width() - menuItemPosition;

                    var dropDownMenuFromLeft;
                    
                    if (thisItem.find('li.menu-item-has-children').length > 0) {
                        dropDownMenuFromLeft = menuItemFromLeft - dropdownMenuWidth;
                    }
                    
                    dropdownMenuItem.removeClass('mt-drop-down--right');
                    
                    if (menuItemFromLeft < dropdownMenuWidth || dropDownMenuFromLeft < dropdownMenuWidth) {
                        dropdownMenuItem.addClass('mt-drop-down--right');
                    }
                });
            }
        }
    };
    
})(jQuery);


//Begin: Sticky Header
(function ($) {
    
    $(document).ready(function () {
        MTStickyHeader.init();
    });
    
    var MTStickyHeader = {
        init: function () {
            var $headerHolder = $("#modeltheme-main-head");
            
            if ($headerHolder.length) {
                $(function(){
                    if ($('body').hasClass('is_nav_sticky')) {
                        $($headerHolder).sticky({
                            topSpacing:0
                        });
                    }
                });
            }
        }
    };
    
})(jQuery);


//Begin: Mobile Navigation
(function ($) {
    
    $(document).ready(function () {
        MTMobileNavigationExpand.init();
    });
    
    $(window).resize(function(){
        MTMobileNavigationExpand.init();
    });
    
    var MTMobileNavigationExpand = {
        init: function () {
            var $nav_submenu = $(".navbar-collapse .menu-item-has-children");
            
            if ($nav_submenu.length) {
                $(function(){
                   if (jQuery(window).width() < 1100) {

                    var expand = '<span class="expand"><a class="action-expand"></a></span>';
                    jQuery('.navbar-collapse .menu-item-has-children, .navbar-collapse .mega1column, .navbar-collapse .mega2columns, .navbar-collapse .mega3columns').append(expand);

                    jQuery('nav #navbar .sub-menu').hide();
                    jQuery(".menu-item-has-children .expand a").on("click",function() {
                        jQuery(this).parent().parent().find(' > ul').toggle();
                        jQuery(this).toggleClass("show-menu");
                    });
                    jQuery(".mega1column .expand a, .mega2columns .expand a, .mega3columns .expand a").on("click",function() {
                        jQuery(this).parent().parent().find(' > .cf-mega-menu').toggle();
                        jQuery(this).toggleClass("show-menu");
                    });
                }
                });
            }
        }
    };
    
})(jQuery);

(function ($) {
//accordeon footer
    $(document).ready(function(){
        if($(window).width() <= 991) {
            jQuery(".footer-row-1 .col-md-2").each(function(){
                var heading = jQuery(this).find('.widget-title');
                jQuery(heading).click(function(){
                    jQuery(heading).toggleClass("active");
                    var siblings = jQuery(this).nextAll();
                    jQuery(siblings).slideToggle();
                })
            });
            jQuery(".footer-row-1 .col-md-6").each(function(){
                var heading = jQuery(this).find('.widget-title').not('.follow_us');
                jQuery(heading).click(function(){
                    jQuery(heading).toggleClass("active");
                    var siblings = jQuery(this).nextAll();
                    jQuery(siblings).slideToggle();
                })
            });
        }
    })
})(jQuery);

jQuery(document).ready(function () {
    if (jQuery('.lottery-checkbox .pomana_is_lottery').is(':checked')) {
        jQuery(".pomana-lottery-settings").show();
        jQuery(".dokan-form-group.dokan-price-container").hide();
    }

    // DOKAN MARKETPLACE Auctions settings
    jQuery( '.lottery-checkbox .pomana_is_lottery' ).on( "click", function() {
        if (jQuery('.lottery-checkbox .pomana_is_lottery').is(':checked')) {
            jQuery(".pomana-lottery-settings").show();
            jQuery(".dokan-form-group.dokan-price-container").hide();
        }else{
            jQuery(".pomana-lottery-settings").hide();
            jQuery(".dokan-form-group.dokan-price-container").show();
        }
    });

    if ( jQuery( ".lottery-checkbox .pomana_is_lottery" ).length ) {
        if (jQuery('.lottery-checkbox .pomana_is_lottery').is(':checked')) {
            jQuery(".dokan-form-group.dokan-price-container").hide();
        }else{
            jQuery(".dokan-form-group.dokan-price-container").show();
        }
    }

    // WCFM MARKETPLACE Auctions settings
    jQuery( '#product_type' ).on('change', function() {
        var product_type_value = jQuery(this).val();
        if (product_type_value == 'lottery') {
            jQuery(".pomana-lottery-settings").show();
        }else{
            jQuery(".pomana-lottery-settings").hide();
        }
    });

    jQuery('.pomana_datetime_picker').each(function(){
        jQuery( this ).datetimepicker({
            format:'Y-m-d H:i',
        });
    });

    var lotterymaxwinners = jQuery('#_lottery_num_winners').val();
    if ( lotterymaxwinners > 1){
        jQuery('.pomana-field-lottery_multiple_winner_per_user').show();
    } else{
        jQuery('.pomana-field-lottery_multiple_winner_per_user').hide();
    }

    jQuery( "#_lottery_num_winners[type=number]" ).on( 'keyup change focusout ', function() {
        var lottery_num_winners_field = jQuery( this );
        var lottery_winers    = parseInt( lottery_num_winners_field.val());

        if ( lottery_winers > 1){
            jQuery('.pomana-field-lottery_multiple_winner_per_user').show();
        } else{
            jQuery('.pomana-field-lottery_multiple_winner_per_user').hide();
        }
    });


});
    