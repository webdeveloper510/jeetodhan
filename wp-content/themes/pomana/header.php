<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php esc_attr(bloginfo( 'charset' )); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php if ( ! function_exists( 'has_site_icon' ) || ! has_site_icon() ) { ?>
        <link rel="shortcut icon" href="<?php echo esc_url(pomana_redux('pomana_favicon','url')); ?>">
    <?php } ?>

    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php
        if ( function_exists( 'wp_body_open' ) ) {
            wp_body_open();
        }

        /**
        * Login/Register popup hooked
        */
        do_action('pomana_after_body_open_tag');
        
        if (pomana_redux('mt_preloader_status')) {
            echo  '<div class="linify_preloader_holder v4_ball_clip_rotate">
                        <div class="linify_preloader v4_ball_clip_rotate">
                            <div class="loaders">
                                <div class="loader">
                                    <div class="loader-inner ball-clip-rotate">
                                        <div></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>';
        } 

    ?>

    <div class="modeltheme-modal modeltheme-effect-16" id="modal-search-form">
        <div class="modeltheme-content">
            <div class="modal-content relative">
                <?php echo pomana_custom_search_form(); ?>
                <span class="modeltheme-close absolute"><i class="fa fa-times"></i></span>
            </div>
        </div>
    </div>



<div class="modeltheme-overlay"></div>
<!-- smoothbody -->
<div id="page" class="hfeed site">
    <?php if ( class_exists( 'ReduxFrameworkPlugin' ) ) { ?>
        <?php if ( pomana_redux('is_top_bar') != false ) { ?>
            <?php get_template_part('top-bar'); ?>
        <?php } ?>
    <?php } ?>
    
    <?php
        $custom_header_activated = get_post_meta( get_the_ID(), 'pomana_custom_header_options_status', true );
        $header_v = get_post_meta( get_the_ID(), 'pomana_header_custom_variant', true );

        if (is_page() || is_single()) {
            if ($custom_header_activated && $custom_header_activated == 'yes') {
                get_template_part( 'templates/header-template'.esc_attr($header_v) );
            }else{
                // DIFFERENT HEADER LAYOUT TEMPLATES
                if (pomana_redux('header_layout')) {
                    if (pomana_redux('header_layout') == 'first_header') {
                        // Header Layout #1
                        get_template_part( 'templates/header-template1' );
                    }elseif (pomana_redux('header_layout') == 'second_header') {
                        // Header Layout #2
                        get_template_part( 'templates/header-template2' );
                    }elseif (pomana_redux('header_layout') == 'third_header') {
                        // Header Layout #3
                        get_template_part( 'templates/header-template3' );
                    }elseif (pomana_redux('header_layout') == 'fourth_header') {
                        // Header Layout #4
                        get_template_part( 'templates/header-template4' );
                    }elseif (pomana_redux('header_layout') == 'fifth_header') {
                        // Header Layout #5
                        get_template_part( 'templates/header-template5' );
                    }elseif (pomana_redux('header_layout') == 'sixth_header') {
                        // Header Layout #6
                        get_template_part( 'templates/header-template6' );
                    }elseif (pomana_redux('header_layout') == 'seventh_header') {
                        // Header Layout #7
                        get_template_part( 'templates/header-template7' );
                    }elseif (pomana_redux('header_layout') == 'eighth_header') {
                        // Header Layout #8
                        get_template_part( 'templates/header-template8' );
                    }else{
                        // if no header layout selected show header layout #1
                        get_template_part( 'templates/header-template1' );
                    }
                }else{
                    get_template_part( 'templates/header-template1' );
                }
            }
        }else{
            // DIFFERENT HEADER LAYOUT TEMPLATES
            if (pomana_redux('header_layout')) {
                if (pomana_redux('header_layout') == 'first_header') {
                    // Header Layout #1
                    get_template_part( 'templates/header-template1' );
                }elseif (pomana_redux('header_layout') == 'second_header') {
                    // Header Layout #2
                    get_template_part( 'templates/header-template2' );
                }elseif (pomana_redux('header_layout') == 'third_header') {
                    // Header Layout #3
                    get_template_part( 'templates/header-template3' );
                }elseif (pomana_redux('header_layout') == 'fourth_header') {
                    // Header Layout #4
                    get_template_part( 'templates/header-template4' );
                }elseif (pomana_redux('header_layout') == 'fifth_header') {
                    // Header Layout #5
                    get_template_part( 'templates/header-template5' );
                }elseif (pomana_redux('header_layout') == 'sixth_header') {
                    // Header Layout #6
                    get_template_part( 'templates/header-template6' );
                }elseif (pomana_redux('header_layout') == 'seventh_header') {
                    // Header Layout #7
                    get_template_part( 'templates/header-template7' );
                }elseif (pomana_redux('header_layout') == 'eighth_header') {
                    // Header Layout #8
                    get_template_part( 'templates/header-template8' );
                }else{
                    // if no header layout selected show header layout #1
                    get_template_part( 'templates/header-template1' );
                }
            }else{
                get_template_part( 'templates/header-template1' );
            }
        }