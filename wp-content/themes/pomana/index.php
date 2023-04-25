<?php
 /**
  * The template for displaying archive pages.
  *
  * Learn more: http://codex.WordPress.org/Template_Hierarchy
  *
  */

get_header(); 

$class = "col-md-8";
$sidebar = 'sidebar-1';

if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
    if ( pomana_redux('pomana_blog_layout') == 'pomana_blog_fullwidth' ) {
        $class = "col-md-12";
    }elseif ( pomana_redux('pomana_blog_layout') == 'pomana_blog_right_sidebar' or pomana_redux('pomana_blog_layout') == 'pomana_blog_left_sidebar') {
        $class = "col-md-8";
    }
    if (pomana_redux('pomana_blog_layout_sidebar') != '') {
        $sidebar = pomana_redux('pomana_blog_layout_sidebar');
    }
}

if ( !class_exists( 'ReduxFrameworkPlugin' ) ) {
  $sidebar = 'sidebar-1';
} 
if ( !is_active_sidebar ( $sidebar ) ) { 
  $class = "col-md-12";
}
?>

<div class="modeltheme-breadcrumbs">
    <div id="overlay"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?php if(is_tag()){ ?>
                    <h1 class="page-title"><?php echo esc_html__( 'Tag: ', 'pomana' ) . single_tag_title( '', false ); ?></h1>
                <?php }elseif(is_search()){ ?>
                    <h1 class="page-title"><?php echo esc_html__( 'Search Results for: ', 'pomana' ) . get_search_query(); ?></h1>
                <?php }elseif(is_home()){ ?>
                    <h1 class="page-title"><?php echo esc_html__( 'From the Blog', 'pomana' ); ?></h1>
                <?php }elseif(is_category()){ ?>
                    <h1 class="page-title"><?php echo esc_html__( 'Category: ', 'pomana' ) . single_cat_title( '', false ); ?></h1>
                <?php }elseif(is_author() || is_archive()){ ?>
                    <h1 class="page-title"><?php echo get_the_archive_title() . get_the_archive_description(); ?></h1>
                <?php }else{ ?>
                    <h1 class="page-title"><?php esc_html_e('From the Blog','pomana'); ?></h1>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<!-- Page content -->
<div class="high-padding">
    <!-- Blog content -->
    <div class="container blog-posts">
        <div class="row">
            
            <?php if((class_exists( 'ReduxFrameworkPlugin' ))) {
                if ( pomana_redux('pomana_single_blog_layout') == 'pomana_blog_left_sidebar' && is_active_sidebar( $sidebar )) { ?>
                <div class="col-md-4 sidebar-content">
                    <?php if ( is_active_sidebar ( $sidebar ) ) { ?>
                        <?php  dynamic_sidebar( $sidebar ); ?>
                    <?php } ?>
                </div>
            <?php } 
            } else { ?>
                <div class="col-md-4 sidebar-content">
                    <?php if ( is_active_sidebar ( $sidebar ) ) { ?>
                        <?php  dynamic_sidebar( $sidebar ); ?>
                    <?php } ?>
                </div>
            <?php } ?>

            <div class="<?php echo esc_attr($class); ?> main-content">
                <div class="row">
                    <?php if ( have_posts() ) : ?>
                        <?php /* Start the Loop */ ?>
                        <?php while ( have_posts() ) : the_post(); ?>

                        <?php
                            get_template_part( 'content', get_post_format() );
                        ?>
                    <?php endwhile; ?>

                    <?php else : ?>
                        <?php get_template_part( 'content', 'none' ); ?>
                    <?php endif; ?>
                </div>

                <div class="row">
                    <div class="clearfix"></div>
                    <?php 
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
            <?php } ?> 
        </div>
    </div>
</div>

<div class="clearfix"></div>
<?php get_footer(); ?>