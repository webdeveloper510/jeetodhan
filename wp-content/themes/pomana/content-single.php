<?php
/**
 * @package ModelTheme
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('post high-padding'); ?>>

    <div class="container single-post-layout">
       <div class="row">
            <?php
            $select_post_layout = get_post_meta( get_the_ID(), 'select_post_layout', true );
            $select_post_sidebar = get_post_meta( get_the_ID(), 'select_post_sidebar', true );
            $sidebar = 'sidebar-1';
            if ( function_exists('modeltheme_framework')) {
                if (isset($select_post_sidebar) && $select_post_sidebar != '') {
                    $sidebar = $select_post_sidebar;
                }else{
                    $sidebar = pomana_redux('pomana_blog_layout_sidebar');
                }
            }
            $cols = 'col-md-8 col-sm-12 status-meta-sidebar';
            $sidebars_lr_meta = array("left-sidebar", "right-sidebar");
            if (isset($select_post_layout) && in_array($select_post_layout, $sidebars_lr_meta)) {
                $cols = 'col-md-8 col-sm-12 status-meta-sidebar';
            }elseif(isset($select_post_layout) && $select_post_layout == 'no-sidebar'){
                $cols = 'col-md-12 col-sm-12 status-meta-fullwidth';
            }elseif(class_exists( 'ReduxFrameworkPlugin' )){
                $sidebars_lr_panel = array("pomana_blog_left_sidebar", "pomana_blog_right_sidebar");
                if (in_array(pomana_redux('pomana_single_blog_layout'), $sidebars_lr_panel)) {
                    $cols = 'col-md-8 col-sm-12 status-panel-sidebar';
                }else{
                    $cols = 'col-md-12 col-sm-12 status-panel-no-sidebar';
                }
            }
            else {
                $cols = 'col-md-12 col-sm-12 status-meta-sidebar';
            }
            if (!is_active_sidebar($sidebar)) {
                $cols = "col-md-12";
            }
            // END_WP5
            ?>
            <?php if((class_exists( 'ReduxFrameworkPlugin' ))) {
                if ( pomana_redux('pomana_single_blog_layout') == 'pomana_blog_left_sidebar' && is_active_sidebar( $sidebar )) { ?>
                <div class="col-md-4 sidebar-content">
                    <?php if ( is_active_sidebar ( $sidebar ) ) { ?>
                        <?php  dynamic_sidebar( $sidebar ); ?>
                    <?php } ?>
                </div>
            <?php } 
            }  ?>

            
            <?php $thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ),'pomana_blog_900x550' ); 
            $content_spacing_class = '';
            if(!$thumbnail_src) { ?>
                <?php $content_spacing_class = 'no-featured-image'; ?>
            <?php } ?>
            <!-- POST CONTENT -->
            <div class="<?php echo esc_attr($cols); ?> <?php echo esc_attr($content_spacing_class); ?> main-content">
                <!-- HEADER -->
                <div class="article-header article-header-details">
                    <?php if($thumbnail_src) { ?>
                        <?php the_post_thumbnail( 'pomana_blog_900x550' ); ?>
                    <?php } ?>
                    <div class="clearfix"></div>
                    <div class="article-details">
                        <div class="blog_badge_date">
                            <span><?php echo get_the_date('F j, Y', get_the_ID()); ?></span>
                        </div>
                        <h2 class="post-title">
                            <strong><?php the_title(); ?></strong>
                        </h2>
                        <div class="post-author">
                            <span><i class="fa fa-user-o" aria-hidden="true"></i><?php echo esc_html__('Posted by ', 'pomana') . '<a href="'.esc_url(get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ) )).'"><strong>' . esc_html(get_the_author()) . '</strong></a>'; ?></span> 
                            <span><?php echo get_the_term_list( get_the_ID(), 'category', esc_html__('in ', 'pomana'), ', ' ); ?></span>
                        </div>
                    </div>
                </div>

                <!-- CONTENT -->
                <div class="article-content">

                    <?php the_content(); ?>
                    
                    <div class="clearfix"></div>
                    <?php
                        wp_link_pages( array(
                            'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'pomana' ),
                            'after'  => '</div>',
                        ) );
                    ?>
                    <div class="clearfix"></div>

                    <div class="mt-post-tags-group">
                        <?php if (get_the_tags()) { ?>
                            <span><?php echo get_the_term_list( get_the_ID(), 'post_tag', ' <i class="fa fa-tags"></i> ' , ', ' ); ?></span> 
                        <?php } ?>
                        <div class="clearfix"></div>
                    </div>
                    <div class="clearfix"></div>
                </div>

                <div class="comments_holder col-md-12">
                <?php
                    // If comments are open or we have at least one comment, load up the comment template
                    if ( comments_open() || get_comments_number() ) :
                        comments_template();
                    endif;
                ?>
                </div>
               

            <?php //WP5
            $select_post_layout = get_post_meta( get_the_ID(), 'select_post_layout', true );
            $select_post_sidebar = get_post_meta( get_the_ID(), 'select_post_sidebar', true );
            $sidebar = 'sidebar-1';
            if ( function_exists('modeltheme_framework')) {
                if (isset($select_post_sidebar) && $select_post_sidebar != '') {
                    $sidebar = $select_post_sidebar;
                }else{
                    $sidebar = pomana_redux('pomana_blog_layout_sidebar');
                }
            }
            $cols = 'col-md-12 col-sm-12';
            $sidebars_lr_meta = array("left-sidebar", "right-sidebar");
            if (isset($select_post_layout) && in_array($select_post_layout, $sidebars_lr_meta)) {
                $cols = 'col-md-8 col-sm-8 status-meta-sidebar';
            }elseif(isset($select_post_layout) && $select_post_layout == 'no-sidebar'){
                $cols = 'col-md-12 col-sm-12 status-meta-fullwidth';
            }else{
                if(class_exists( 'ReduxFrameworkPlugin' )){
                    $sidebars_lr_panel = array("pomana_blog_left_sidebar", "pomana_blog_right_sidebar");
                    if (in_array(pomana_redux('pomana_single_blog_layout'), $sidebars_lr_panel)) {
                        $cols = 'col-md-8 col-sm-8 status-panel-sidebar';
                    }else{
                        $cols = 'col-md-12 col-sm-12 status-panel-no-sidebar';
                       
                    }

                }
            }
            if (!is_active_sidebar($sidebar)) {
                $cols = "col-md-12";
            }
            // END_WP5
            ?>

            <div class="clearfix"></div>

            </div>

            <?php if ( pomana_redux('pomana_single_blog_layout') == 'pomana_blog_right_sidebar' && is_active_sidebar( $sidebar )) { ?>
            <div class="col-md-4 sidebar-content">
                <?php if ( is_active_sidebar ( $sidebar ) ) { ?>
                    <?php  dynamic_sidebar( $sidebar ); ?>
                <?php } ?>
            </div>
            <?php } ?>

            <div class="clearfix"></div>
        </div>
    </div>

    <div class="container">
        <div class="">
            <?php if ( class_exists( 'ReduxFrameworkPlugin' ) && function_exists('modeltheme_framework') ) { ?>
                <?php if ( pomana_redux('modeltheme-enable-related-posts') ) { ?>
                    <div class="related-posts sticky-posts col-md-12">
                        <h2 class="heading-bottom"><?php esc_html_e('Related Posts', 'pomana'); ?></h2>
                        <div class="row">
                        <?php 
                            $args=array(  
                                'post__not_in'          => array($post->ID),  
                                'posts_per_page'        => 3, // Number of related posts to display.  
                                'ignore_sticky_posts'   => 1  
                            );
                            $my_query = new wp_query( $args );  
                            while( $my_query->have_posts() ) {  
                                $my_query->the_post(); 
                                ?>  
                                <div class="col-md-4 post">
                                    <div class="related_blog_custom">
                                        <a href="<?php esc_url(the_permalink()); ?>" class="relative">
                                            <?php
                                            $thumbnail_src2 = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'pomana_related_post_pic500x300'); 
                                            $missing_image_class = 'missing-featured-image';
                                            if($thumbnail_src2) {
                                                $missing_image_class = '';
                                                ?>
                                                <img src="<?php echo esc_url($thumbnail_src2[0]); ?>" class="img-responsive" alt="<?php the_title_attribute(); ?>" />
                                            <?php } ?>
                                        </a>
                                        <div class="related_blog_details <?php echo esc_attr($missing_image_class); ?>">
                                            <div class="blog_badge_date">
                                                <span><?php echo get_the_date('F j, Y', get_the_ID()); ?></span>
                                            </div>
                                            <div class="clearfix"></div>
                                            <h3 class="post-name">
                                                <a href="<?php esc_url(the_permalink()); ?>" class="relative"><?php the_title(); ?></a>
                                            </h3>                                               
                                            <div class="post-excerpt row">
                                                <?php echo strip_tags(pomana_excerpt_limit($post->post_content, 8)); ?>
                                            </div>
                                            <div class="clearfix"></div>
                                            <div class="post-read-more">
                                                <a class="rippler rippler-default" href="<?php esc_url(the_permalink()); ?>"><?php echo esc_html__('Read More','pomana')?> <i class="fa fa-angle-right" aria-hidden="true"></i></a>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                <?php }?>
            <?php }?>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="clearfix"></div>
</article>