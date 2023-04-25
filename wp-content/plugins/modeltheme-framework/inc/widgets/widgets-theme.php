<?php 

/**
* 
* [Widgets]
* 
**/

/* ========= social_icons ===================================== */
class address_social_icons extends WP_Widget {

    function __construct() {
        parent::__construct('address_social_icons', esc_html__('pomana - Contact + Social links', 'modeltheme'),array( 'description' => esc_html__( 'pomana - Contact information + Social icons', 'modeltheme' ), ) );
    }

    public function widget( $args, $instance ) {
        global  $pomana_redux;
        $widget_title = $instance[ 'widget_title' ];
        $widget_contact_details = $instance[ 'widget_contact_details' ];
        $widget_social_icons = $instance[ 'widget_social_icons' ];

        echo  wp_kses_post($args['before_widget']); ?>

        <div class="sidebar-social-networks address-social-links">

            <?php if($widget_title) { ?>
               <h1 class="widget-title"><?php echo wp_kses_post($widget_title); ?></h1>
            <?php } ?>


            <?php if('on' == $instance['widget_contact_details']) { ?>
                <div class="contact-details">
                    <p><i class="fa fa-home"></i> <?php echo wp_kses_post($pomana_redux['pomana_contact_address']); ?></p>
                    <p><i class="fa fa-phone-square"></i> <?php echo wp_kses_post($pomana_redux['pomana_contact_phone']); ?></p>
                    <p><i class="fa fa-envelope-square"></i> <?php echo wp_kses_post($pomana_redux['pomana_contact_email']); ?></p>
                </div>
            <?php } ?>


            <?php if('on' == $instance['widget_social_icons']) { ?>
                <h4 class="follow_us widget-title"><?php echo esc_html__('Follow Us: ', 'modeltheme'); ?></h4>
                <ul class="social-links">
                <?php if ( isset($pomana_redux['pomana_social_fb']) && $pomana_redux['pomana_social_fb'] != '' ) { ?>
                    <li><a href="<?php echo wp_kses_post( $pomana_redux['pomana_social_fb'] ) ?>" target="_blank"><i class="fa fa-facebook"></i></a></li>
                <?php } ?>
                <?php if ( isset($pomana_redux['pomana_social_tw']) && $pomana_redux['pomana_social_tw'] != '' ) { ?>
                    <li><a href="https://twitter.com/<?php echo wp_kses_post( $pomana_redux['pomana_social_tw'] ) ?>" target="_blank"><i class="fa fa-twitter"></i></a></li>
                <?php } ?>
                <?php if ( isset($pomana_redux['pomana_social_youtube']) && $pomana_redux['pomana_social_youtube'] != '' ) { ?>
                    <li><a href="<?php echo wp_kses_post( $pomana_redux['pomana_social_youtube'] ) ?>" target="_blank"><i class="fa fa-youtube"></i></a></li>
                <?php } ?>
                <?php if ( isset($pomana_redux['pomana_social_pinterest']) && $pomana_redux['pomana_social_pinterest'] != '' ) { ?>
                    <li><a href="<?php echo wp_kses_post( $pomana_redux['pomana_social_pinterest'] ) ?>" target="_blank"><i class="fa fa-pinterest"></i></a></li>
                <?php } ?>
                <?php if ( isset($pomana_redux['pomana_social_linkedin']) && $pomana_redux['pomana_social_linkedin'] != '' ) { ?>
                    <li><a href="<?php echo wp_kses_post( $pomana_redux['pomana_social_linkedin'] ) ?>" target="_blank"><i class="fa fa-linkedin"></i></a></li>
                <?php } ?>
                <?php if ( isset($pomana_redux['pomana_social_skype']) && $pomana_redux['pomana_social_skype'] != '' ) { ?>
                    <li><a href="<?php echo wp_kses_post( $pomana_redux['pomana_social_skype'] ) ?>" target="_blank"><i class="fa fa-skype"></i></a></li>
                <?php } ?>
                <?php if ( isset($pomana_redux['pomana_social_instagram']) && $pomana_redux['pomana_social_instagram'] != '' ) { ?>
                    <li><a href="<?php echo wp_kses_post( $pomana_redux['pomana_social_instagram'] ) ?>" target="_blank"><i class="fa fa-instagram"></i></a></li>
                <?php } ?>
                <?php if ( isset($pomana_redux['pomana_social_dribbble']) && $pomana_redux['pomana_social_dribbble'] != '' ) { ?>
                    <li><a href="<?php echo wp_kses_post( $pomana_redux['pomana_social_dribbble'] ) ?>" target="_blank"><i class="fa fa-dribbble"></i></a></li>
                <?php } ?>
                <?php if ( isset($pomana_redux['pomana_social_deviantart']) && $pomana_redux['pomana_social_deviantart'] != '' ) { ?>
                    <li><a href="<?php echo wp_kses_post( $pomana_redux['pomana_social_deviantart'] ) ?>" target="_blank"><i class="fa fa-deviantart"></i></a></li>
                <?php } ?>
                <?php if ( isset($pomana_redux['pomana_social_digg']) && $pomana_redux['pomana_social_digg'] != '' ) { ?>
                    <li><a href="<?php echo wp_kses_post( $pomana_redux['pomana_social_digg'] ) ?>" target="_blank"><i class="fa fa-digg"></i></a></li>
                <?php } ?>
                <?php if ( isset($pomana_redux['pomana_social_flickr']) && $pomana_redux['pomana_social_flickr'] != '' ) { ?>
                    <li><a href="<?php echo wp_kses_post( $pomana_redux['pomana_social_flickr'] ) ?>" target="_blank"><i class="fa fa-flickr"></i></a></li>
                <?php } ?>
                <?php if ( isset($pomana_redux['pomana_social_stumbleupon']) && $pomana_redux['pomana_social_stumbleupon'] != '' ) { ?>
                    <li><a href="<?php echo wp_kses_post( $pomana_redux['pomana_social_stumbleupon'] ) ?>" target="_blank"><i class="fa fa-stumbleupon"></i></a></li>
                <?php } ?>
                <?php if ( isset($pomana_redux['pomana_social_tumblr']) && $pomana_redux['pomana_social_tumblr'] != '' ) { ?>
                    <li><a href="<?php echo wp_kses_post( $pomana_redux['pomana_social_tumblr'] ) ?>" target="_blank"><i class="fa fa-tumblr"></i></a></li>
                <?php } ?>
                <?php if ( isset($pomana_redux['pomana_social_vimeo']) && $pomana_redux['pomana_social_vimeo'] != '' ) { ?>
                    <li><a href="<?php echo wp_kses_post( $pomana_redux['pomana_social_vimeo'] ) ?>" target="_blank"><i class="fa fa-vimeo-square"></i></a></li>
                <?php } ?>
                </ul>
            <?php } ?>
         
        </div>
        <?php echo  wp_kses_post($args['after_widget']);
    }


    public function form( $instance ) {

        # Widget Title
        if ( isset( $instance[ 'widget_title' ] ) ) {
            $widget_title = $instance[ 'widget_title' ];
        } else {
            $widget_title = esc_html__( 'Social icons', 'modeltheme' );;
        }
        ?>

        <p>
            <label for="<?php echo wp_kses_post($this->get_field_id( 'widget_title' )); ?>"><?php esc_html_e( 'Widget Title:','modeltheme' ); ?></label> 
            <input class="widefat" id="<?php echo wp_kses_post($this->get_field_id( 'widget_title' )); ?>" name="<?php echo wp_kses_post($this->get_field_name( 'widget_title' )); ?>" type="text" value="<?php echo wp_kses_post( $widget_title ); ?>">
        </p>
        <p>
            <input type="checkbox" <?php checked($instance['widget_contact_details'], 'on'); ?> id="<?php echo wp_kses_post($this->get_field_name('widget_contact_details')); ?>" name="<?php echo wp_kses_post($this->get_field_name('widget_contact_details')); ?>" /> 
            <label for="<?php echo wp_kses_post($this->get_field_name('widget_contact_details')); ?>"><?php esc_html_e( 'Show contact informations box','modeltheme' ); ?></label>
        </p>
        <p>
            <input type="checkbox" <?php checked($instance['widget_social_icons'], 'on'); ?> id="<?php echo wp_kses_post($this->get_field_name('widget_social_icons')); ?>" name="<?php echo wp_kses_post($this->get_field_name('widget_social_icons')); ?>" /> 
            <label for="<?php echo wp_kses_post($this->get_field_name('widget_social_icons')); ?>"><?php esc_html_e( 'Show social icons','modeltheme' ); ?></label>
        </p>

        <p><?php esc_html_e( '* Social Network account must be set from MODELTHEME - Theme Panel.','modeltheme' ); ?></p>
        <?php 
    }

    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['widget_title'] = ( ! empty( $new_instance['widget_title'] ) ) ?  $new_instance['widget_title']  : '';
        $instance['widget_contact_details'] = ( ! empty( $new_instance['widget_contact_details'] ) ) ?  $new_instance['widget_contact_details']  : '';
        $instance['widget_social_icons'] = ( ! empty( $new_instance['widget_social_icons'] ) ) ?  $new_instance['widget_social_icons']  : '';

        return $instance;
    }
}





/* ========= pomana_Recent_Posts_Widget ===================================== */
class recent_entries_with_thumbnail extends WP_Widget {

    function __construct() {
        parent::__construct('recent_entries_with_thumbnail', esc_html__('pomana - Recent Posts', 'modeltheme'),array( 'description' => esc_html__( 'pomana - Recent Posts', 'modeltheme' ), ) );
    }

    public function widget( $args, $instance ) {
        $recent_posts_title = $instance[ 'recent_posts_title' ];
        $recent_posts_number = $instance[ 'recent_posts_number' ];

        echo  wp_kses_post($args['before_widget']);

        $args_recenposts = array(
                'posts_per_page'   => $recent_posts_number,
                'orderby'          => 'post_date',
                'order'            => 'DESC',
                'post_type'        => 'post',
                'post_status'      => 'publish' 
                );

        $recentposts = get_posts($args_recenposts);
        $myContent  = "";
        $myContent .= '<h1 class="widget-title">'.wp_kses_post($recent_posts_title).'</h1>';
        $myContent .= '<ul>';

        foreach ($recentposts as $post) {
            $thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ),'pomana_post_widget_pic150x120' );

            $myContent .= '<li class="row">';
                $myContent .= '<div class="post-details">';
                    $myContent .= '<a href="'. get_permalink($post->ID) .'">'. $post->post_title.'</a>';
                    $myContent .= '<span class="post-date">'.get_the_date('F j, Y', $post->ID).'</span>';          
                $myContent .= '</div>';
            $myContent .= '</li>';
        }
        $myContent .= '</ul>';

        echo  wp_kses_post($myContent);
        echo  wp_kses_post($args['after_widget']);
    }

    public function form( $instance ) {
        
        # Widget Title
        if ( isset( $instance[ 'recent_posts_title' ] ) ) {
            $recent_posts_title = $instance[ 'recent_posts_title' ];
        } else {
            $recent_posts_title = esc_html__( 'Recent posts', 'modeltheme' );
        }

        # Number of posts
        if ( isset( $instance[ 'recent_posts_number' ] ) ) {
            $recent_posts_number = $instance[ 'recent_posts_number' ];
        } else {
            $recent_posts_number = '5';
        }

        ?>

        <p>
            <label for="<?php echo wp_kses_post($this->get_field_id( 'recent_posts_title' )); ?>"><?php esc_html_e( 'Widget Title:','modeltheme' ); ?></label> 
            <input class="widefat" id="<?php echo wp_kses_post($this->get_field_id( 'recent_posts_title' )); ?>" name="<?php echo wp_kses_post($this->get_field_name( 'recent_posts_title' )); ?>" type="text" value="<?php echo wp_kses_post( $recent_posts_title ); ?>">
        </p>
        <p>
            <label for="<?php echo wp_kses_post($this->get_field_id( 'recent_posts_number' )); ?>"><?php esc_html_e( 'Number of posts:','modeltheme' ); ?></label> 
            <input class="widefat" id="<?php echo wp_kses_post($this->get_field_id( 'recent_posts_number' )); ?>" name="<?php echo wp_kses_post($this->get_field_name( 'recent_posts_number' )); ?>" type="text" value="<?php echo wp_kses_post( $recent_posts_number ); ?>">
        </p>
        <?php 
    }

    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['recent_posts_title'] = ( ! empty( $new_instance['recent_posts_title'] ) ) ?  $new_instance['recent_posts_title']  : '';
        $instance['recent_posts_number'] = ( ! empty( $new_instance['recent_posts_number'] ) ) ? strip_tags( $new_instance['recent_posts_number'] ) : '';
        return $instance;
    }

} 




/* ========= post_thumbnails_slider ===================================== */
class post_thumbnails_slider extends WP_Widget {

    function __construct() {
        parent::__construct('post_thumbnails_slider', esc_html__('pomana - Post thumbnails slider', 'modeltheme'),array( 'description' => esc_html__( 'pomana - Post thumbnails slider', 'modeltheme' ), ) );
    }

    public function widget( $args, $instance ) {
        $recent_posts_title = $instance[ 'recent_posts_title' ];
        $recent_posts_number = $instance[ 'recent_posts_number' ];

        echo  wp_kses_post($args['before_widget']);

        $args_recenposts = array(
                'posts_per_page'   => $recent_posts_number,
                'orderby'          => 'post_date',
                'order'            => 'DESC',
                'post_type'        => 'post',
                'post_status'      => 'publish' 
                );

        $recentposts = get_posts($args_recenposts);
        $myContent  = "";
        $myContent .= '<h1 class="widget-title">'.wp_kses_post($recent_posts_title).'</h1>';
        $myContent .= '<div class="slider_holder relative">';
            $myContent .= '<div class="slider_navigation absolute">';
                $myContent .= '<a class="btn prev pull-left"><i class="fa fa-angle-left"></i></a>';
                $myContent .= '<a class="btn next pull-right"><i class="fa fa-angle-right"></i></a>';
            $myContent .= '</div>';
            $myContent .= '<div class="post_thumbnails_slider owl-carousel owl-theme">';

            foreach ($recentposts as $post) {
                $thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ),'pomana_post_pic700x450' );
                $myContent .= '<div class="item">';
                    $myContent .= '<a href="'. get_permalink($post->ID) .'">';
                        if($thumbnail_src) { $myContent .= '<img src="'. $thumbnail_src[0] . '" alt="'. $post->post_title .'" />';
                        }else{ $myContent .= '<img src="http://placehold.it/700x450" alt="'. $post->post_title .'" />'; }
                    $myContent .= '</a>';
                $myContent .= '</div>';
            }
            $myContent .= '</div>';
        $myContent .= '</div>';

        echo  wp_kses_post($myContent);
        echo  wp_kses_post($args['after_widget']);
    }

    public function form( $instance ) {
        
        # Widget Title
        if ( isset( $instance[ 'recent_posts_title' ] ) ) {
            $recent_posts_title = $instance[ 'recent_posts_title' ];
        } else {
            $recent_posts_title = esc_html__( 'Post thumbnails slider', 'modeltheme' );;
        }

        # Number of posts
        if ( isset( $instance[ 'recent_posts_number' ] ) ) {
            $recent_posts_number = $instance[ 'recent_posts_number' ];
        } else {
            $recent_posts_number = esc_html__( '5', 'modeltheme' );;
        }

        ?>

        <p>
            <label for="<?php echo wp_kses_post($this->get_field_id( 'recent_posts_title' )); ?>"><?php esc_html_e( 'Widget Title:','modeltheme' ); ?></label> 
            <input class="widefat" id="<?php echo wp_kses_post($this->get_field_id( 'recent_posts_title' )); ?>" name="<?php echo wp_kses_post($this->get_field_name( 'recent_posts_title' )); ?>" type="text" value="<?php echo wp_kses_post( $recent_posts_title ); ?>">
        </p>
        <p>
            <label for="<?php echo wp_kses_post($this->get_field_id( 'recent_posts_number' )); ?>"><?php esc_html_e( 'Number of posts:','modeltheme' ); ?></label> 
            <input class="widefat" id="<?php echo wp_kses_post($this->get_field_id( 'recent_posts_number' )); ?>" name="<?php echo wp_kses_post($this->get_field_name( 'recent_posts_number' )); ?>" type="text" value="<?php echo wp_kses_post( $recent_posts_number ); ?>">
        </p>
        <?php 
    }

    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['recent_posts_title'] = ( ! empty( $new_instance['recent_posts_title'] ) ) ?  $new_instance['recent_posts_title']  : '';
        $instance['recent_posts_number'] = ( ! empty( $new_instance['recent_posts_number'] ) ) ? strip_tags( $new_instance['recent_posts_number'] ) : '';
        return $instance;
    }

} 


/* ========= social_share ===================================== */
class social_share extends WP_Widget {

    function __construct() {
        parent::__construct('social_share', esc_html__('pomana - Social Share Icons', 'modeltheme'),array( 'description' => esc_html__( 'pomana - Social Share Icons', 'modeltheme' ), ) );
    }

    public function widget( $args, $instance ) {
        global  $pomana_redux;
        $widget_title = $instance[ 'widget_title' ];
        $facebook = $instance['share-facebook'] ? 'true' : 'false';
        $twitter = $instance['share-twitter'] ? 'true' : 'false';
        $linkedin = $instance['share-linkedin'] ? 'true' : 'false';
        $googleplus = $instance['share-googleplus'] ? 'true' : 'false';
        $digg = $instance['share-digg'] ? 'true' : 'false';
        $pinterest = $instance['share-pinterest'] ? 'true' : 'false';
        $reddit = $instance['share-reddit'] ? 'true' : 'false';
        $stumbleupon = $instance['share-stumbleupon'] ? 'true' : 'false';

        echo  wp_kses_post($args['before_widget']);

        $siteurl = get_permalink();
        $sitetitle = get_bloginfo('title');
        $sitedescription = get_bloginfo('description');

        ?>

        <div class="sidebar-share-social-links">
            <h3><?php echo  wp_kses_post($instance[ 'widget_title' ]);?></h3>
            <ul class="share-social-links">
                <?php if('on' == $instance['share-facebook'] ) { ?>
                <li class="facebook">
                    <a href="#" target="_blank"><i class="fa fa-facebook"></i></a>
                    <?php /*<a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo wp_kses_post($siteurl); ?>" target="_blank"><i class="fa fa-facebook"></i></a>*/ ?>
                </li>
                <?php } if('on' == $instance['share-twitter'] ) {?>
                <li class="twitter">
                    <a href="#" target="_blank"><i class="fa fa-twitter"></i></a>
                    <?php /*<a href="https://twitter.com/intent/tweet?url=<?php echo wp_kses_post($siteurl); ?>&amp;text=<?php echo wp_kses_post($sitedescription); ?>" target="_blank"><i class="fa fa-twitter"></i></a>*/ ?>
                </li>
                <?php } if('on' == $instance['share-linkedin'] ) {?>
                <li class="linkedin">
                    <a href="#" target="_blank"><i class="fa fa-linkedin"></i></a>
                    <?php /*<a href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo wp_kses_post($siteurl); ?>" target="_blank"><i class="fa fa-linkedin"></i></a>*/ ?>
                </li>
                <?php } if('on' == $instance['share-googleplus'] ) {?>
                <li class="googleplus">
                    <a href="#" target="_blank"><i class="fa fa-google-plus"></i></a>
                    <?php /*<a href="https://plus.google.com/share?url=<?php echo wp_kses_post($siteurl); ?>" target="_blank"><i class="fa fa-google-plus"></i></a>*/ ?>
                </li>
                <?php } if('on' == $instance['share-digg'] ) {?>
                <li class="digg">
                    <a href="#" target="_blank"><i class="fa fa-digg"></i></a>
                    <?php /*<a href="http://www.digg.com/submit?url=<?php echo wp_kses_post($siteurl); ?>" target="_blank"><i class="fa fa-digg"></i></a>*/ ?>
                </li>
                <?php } if('on' == $instance['share-pinterest'] ) {?>
                <li class="pinterest">
                    <a href="#" target="_blank"><i class="fa fa-pinterest"></i></a>
                    <?php /*<a href="http://pinterest.com/pin/create/button/?url=<?php echo wp_kses_post($siteurl); ?>&amp;media=<?php echo wp_kses_post($pomana_redux['pomana_logo']['url']); ?>&amp;description=<?php echo wp_kses_post($sitedescription); ?>" target="_blank"><i class="fa fa-pinterest"></i></a>*/ ?>
                </li>
                <?php } if('on' == $instance['share-reddit'] ) {?>
                <li class="reddit">
                    <a href="#" target="_blank"><i class="fa fa-reddit"></i></a>
                    <?php /*<a href="http://reddit.com/submit?url=<?php echo wp_kses_post($siteurl); ?>&amp;title=<?php echo wp_kses_post($sitetitle); ?>" target="_blank"><i class="fa fa-reddit"></i></a>*/ ?>
                </li>
                <?php } if('on' == $instance['share-stumbleupon'] ) {?>
                <li class="stumbleupon">
                    <a href="#" target="_blank"><i class="fa fa-stumbleupon"></i></a>
                    <?php /*<a href="http://www.stumbleupon.com/submit?url=<?php echo wp_kses_post($siteurl); ?>&amp;title=<?php echo wp_kses_post($sitetitle); ?>" target="_blank"><i class="fa fa-stumbleupon"></i></a>*/ ?>
                </li>
                <?php } ?>
            </ul>
        </div>
        <?php 
        echo  wp_kses_post($args['after_widget']);
    }

    public function form( $instance ) {

        # Widget Title
        if ( isset( $instance[ 'widget_title' ] ) ) {
            $widget_title = $instance[ 'widget_title' ];
        } else {
            $widget_title = esc_html__( 'Social icons', 'modeltheme' );;
        } ?>

        <p>
            <label for="<?php echo wp_kses_post($this->get_field_id( 'widget_title' )); ?>"><?php esc_html_e( 'Widget Title:','modeltheme' ); ?></label> 
            <input class="widefat" id="<?php echo wp_kses_post($this->get_field_id( 'widget_title' )); ?>" name="<?php echo wp_kses_post($this->get_field_name( 'widget_title' )); ?>" type="text" value="<?php echo wp_kses_post( $widget_title ); ?>">
        </p>
        <p><?php esc_html_e( 'Check what Social SHARE Buttons do you want to display','modeltheme' ); ?></p>
        <p>
            <input class="checkboxsocial" type="checkbox" <?php checked($instance['share-facebook'], 'on'); ?> id="<?php echo wp_kses_post($this->get_field_name('share-facebook')); ?>" name="<?php echo wp_kses_post($this->get_field_name('share-facebook')); ?>" /> 
            <label for="<?php echo wp_kses_post($this->get_field_name('share-facebook')); ?>"><?php esc_html_e( 'Facebook','modeltheme' ); ?></label>
        </p>
        <p>
            <input class="checkboxsocial" type="checkbox" <?php checked($instance['share-twitter'], 'on'); ?> id="<?php echo wp_kses_post($this->get_field_name('share-twitter')); ?>" name="<?php echo wp_kses_post($this->get_field_name('share-twitter')); ?>" /> 
            <label for="<?php echo wp_kses_post($this->get_field_name('share-twitter')); ?>"><?php esc_html_e( 'Twitter','modeltheme' ); ?></label>
        </p>
        <p>
            <input class="checkboxsocial" type="checkbox" <?php checked($instance['share-linkedin'], 'on'); ?> id="<?php echo wp_kses_post($this->get_field_name('share-linkedin')); ?>" name="<?php echo wp_kses_post($this->get_field_name('share-linkedin')); ?>" /> 
            <label for="<?php echo wp_kses_post($this->get_field_name('share-linkedin')); ?>"><?php esc_html_e( 'Linkedin','modeltheme' ); ?></label>
        </p>
        <p>
            <input class="checkboxsocial" type="checkbox" <?php checked($instance['share-googleplus'], 'on'); ?> id="<?php echo wp_kses_post($this->get_field_name('share-googleplus')); ?>" name="<?php echo wp_kses_post($this->get_field_name('share-googleplus')); ?>" /> 
            <label for="<?php echo wp_kses_post($this->get_field_name('share-googleplus')); ?>"><?php esc_html_e( 'Google Plus','modeltheme' ); ?></label>
        </p>
        <p>
            <input class="checkboxsocial" type="checkbox" <?php checked($instance['share-digg'], 'on'); ?> id="<?php echo wp_kses_post($this->get_field_name('share-digg')); ?>" name="<?php echo wp_kses_post($this->get_field_name('share-digg')); ?>" /> 
            <label for="<?php echo wp_kses_post($this->get_field_name('share-digg')); ?>"><?php esc_html_e( 'Digg','modeltheme' ); ?></label>
        </p>
        <p>
            <input class="checkboxsocial" type="checkbox" <?php checked($instance['share-pinterest'], 'on'); ?> id="<?php echo wp_kses_post($this->get_field_name('share-pinterest')); ?>" name="<?php echo wp_kses_post($this->get_field_name('share-pinterest')); ?>" /> 
            <label for="<?php echo wp_kses_post($this->get_field_name('share-pinterest')); ?>"><?php esc_html_e( 'Pinterest','modeltheme' ); ?></label>
        </p>
        <p>
            <input class="checkboxsocial" type="checkbox" <?php checked($instance['share-reddit'], 'on'); ?> id="<?php echo wp_kses_post($this->get_field_name('share-reddit')); ?>" name="<?php echo wp_kses_post($this->get_field_name('share-reddit')); ?>" /> 
            <label for="<?php echo wp_kses_post($this->get_field_name('share-reddit')); ?>"><?php esc_html_e( 'Reddit','modeltheme' ); ?></label>
        </p>
        <p>
            <input class="checkboxsocial" type="checkbox" <?php checked($instance['share-stumbleupon'], 'on'); ?> id="<?php echo wp_kses_post($this->get_field_name('share-stumbleupon')); ?>" name="<?php echo wp_kses_post($this->get_field_name('share-stumbleupon')); ?>" /> 
            <label for="<?php echo wp_kses_post($this->get_field_name('share-stumbleupon')); ?>"><?php esc_html_e( 'Stumbleupon','modeltheme' ); ?></label>
        </p>
        <?php 
    }

    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['widget_title'] = ( ! empty( $new_instance['widget_title'] ) ) ?  $new_instance['widget_title']  : '';
        
        $instance['share-facebook'] = ( ! empty( $new_instance['share-facebook'] ) ) ?  $new_instance['share-facebook']  : '';
        $instance['share-twitter'] = ( ! empty( $new_instance['share-twitter'] ) ) ?  $new_instance['share-twitter']  : '';
        $instance['share-linkedin'] = ( ! empty( $new_instance['share-linkedin'] ) ) ?  $new_instance['share-linkedin']  : '';
        $instance['share-googleplus'] = ( ! empty( $new_instance['share-googleplus'] ) ) ?  $new_instance['share-googleplus']  : '';
        $instance['share-digg'] = ( ! empty( $new_instance['share-digg'] ) ) ?  $new_instance['share-digg']  : '';
        $instance['share-pinterest'] = ( ! empty( $new_instance['share-pinterest'] ) ) ?  $new_instance['share-pinterest']  : '';
        $instance['share-reddit'] = ( ! empty( $new_instance['share-reddit'] ) ) ?  $new_instance['share-reddit']  : '';
        $instance['share-stumbleupon'] = ( ! empty( $new_instance['share-stumbleupon'] ) ) ?  $new_instance['share-stumbleupon']  : '';

        return $instance;
    }
}


// Register Widgets
function pomana_register_widgets() {
    register_widget( 'address_social_icons' );
    register_widget( 'social_share' );
    register_widget( 'recent_entries_with_thumbnail' );
    register_widget( 'post_thumbnails_slider' );
}
add_action( 'widgets_init', 'pomana_register_widgets' );