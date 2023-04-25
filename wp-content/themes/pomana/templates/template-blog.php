<?php
/*
* Template Name: Blog
*/
get_header(); 

$class = "col-md-8";
$sidebar = 'sidebar-1';

if ( pomana_redux('pomana_blog_layout') == 'pomana_blog_fullwidth' ) {
    $class = "row";
}elseif ( pomana_redux('pomana_blog_layout') == 'pomana_blog_right_sidebar' or pomana_redux('pomana_blog_layout') == 'pomana_blog_left_sidebar') {
    $class = "col-md-8";
}
$sidebar = pomana_redux('pomana_blog_layout_sidebar');

if ( !class_exists( 'ReduxFrameworkPlugin' ) ) {
  $sidebar = 'sidebar-1';
} 
if ( !is_active_sidebar ( $sidebar ) ) { 
  $class = "row";
}

$blog_page_header = get_post_meta( get_the_ID(), 'blog_page_header', true );
$select_page_sidebar = get_post_meta( get_the_ID(), 'select_page_sidebar', true );
?>

<!-- Breadcrumbs -->
<div class="modeltheme-breadcrumbs">
    <div id="overlay"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="page-title"><?php echo get_the_title(); ?></h1>
            </div>
            <?php $breadcrumbs_text = get_post_meta( get_the_ID(), 'breadcrumbs_text', true ); ?>
            <?php if(isset($breadcrumbs_text) && !empty($breadcrumbs_text)) { ?>
                <div class="col-md-12 breadcrumbs-content">
                    <p><?php echo esc_html($breadcrumbs_text); ?></p>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<!-- Page content -->
<div id="primary" class="high-padding">
    <?php
    wp_reset_postdata();
    $paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
    $args = array(
        'post_type'        => 'post',
        'post_status'      => 'publish',
        'paged'            => $paged,
    );
    $posts = new WP_Query( $args );
    ?>
    <!-- Blog content -->
    <div class="container blog-posts">
        <div class="row">
            <?php if ( pomana_redux('pomana_blog_layout') == 'pomana_blog_left_sidebar') { ?>
            <div class="col-md-4 sidebar-content">
                <?php if ( is_active_sidebar ( $select_page_sidebar ) ) { 
                    dynamic_sidebar( $select_page_sidebar ); 
                } ?>
            </div>
            <?php } ?>

            <div class="<?php echo esc_attr($class); ?> main-content">
                <div class="row">
                    <?php if ( $posts->have_posts() ) : ?>
                        <?php /* Start the Loop */ ?>
                        <?php
                        while ( $posts->have_posts() ) : $posts->the_post(); 
                        ?>

                            <?php
                                get_template_part( 'content', get_post_format() );
                            ?>

                        <?php endwhile; ?>
                        <div class="clearfix"></div>
                        
                    <?php else : ?>
                        <?php get_template_part( 'content', 'none' ); ?>
                    <?php endif; ?>
                    <div class="clearfix"></div>
                    <?php 
                    $wp_query = new WP_Query($args);
                    global  $wp_query;
                    if ($wp_query->max_num_pages != 1) { ?>                 
                        <div class="modeltheme-pagination pagination col-md-12">             
                            <?php pomana_pagination(); ?>
                        </div>
                    <?php } ?>
                </div>
                
            </div>

            
            <?php if ( class_exists( 'ReduxFrameworkPlugin' ) ) { ?>    
                <?php if ( pomana_redux('pomana_blog_layout') == 'pomana_blog_right_sidebar' && is_active_sidebar( $sidebar )) { ?>
                    <div class="col-md-4 sidebar-content">
                    <?php  if ( is_active_sidebar ( $sidebar ) ) { 
                        dynamic_sidebar( $sidebar ); 
                    }  ?>
                    </div>
                <?php } ?>
            <?php }else{ ?>
                <?php if ($class == 'col-md-8') { ?>
                    <div class="col-md-4 sidebar-content">
                    <?php  if ( is_active_sidebar ( $sidebar ) ) { 
                        dynamic_sidebar( $sidebar ); 
                    }  ?>
                    </div>
                <?php } ?> 
            <?php } ?>
            
        </div>
    </div>
</div>


<div class="clearfix"></div>
<?php
get_footer();
?>