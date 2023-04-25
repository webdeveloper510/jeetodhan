<?php
/**
 * @package Modeltheme
 */
?>
<?php 

$master_class = 'col-md-12 col-sm-12 col-xs-12';
$type_class = ' grid-two-columns';
$image_size = 'pomana_700x600';
if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
    if ( pomana_redux('blog-display-type') == 'list' ) {
        $type_class = 'grid-three-columns';
        $image_size = 'pomana_700x600';
    } else {
        $type_class = 'grid-view';
        if ( pomana_redux('blog-grid-columns') == 1 ) {
            $master_class = 'col-md-12';
            $type_class .= ' grid-one-column';
            $image_size = 'pomana_1000x580';
        }elseif ( pomana_redux('blog-grid-columns') == 2 ) {
            $master_class = 'col-md-6';
            $type_class .= ' grid-two-columns';
            $image_size = 'pomana_700x500';
        }elseif ( pomana_redux('blog-grid-columns') == 3 ) {
            $master_class = 'col-md-4';
            $type_class .= ' grid-three-columns';
            $image_size = 'pomana_700x500';
        }elseif ( pomana_redux('blog-grid-columns') == 4 ) {
            $master_class = 'col-md-3';
            $type_class .= ' grid-four-columns';
            $image_size = 'pomana_700x600';
        }

    }
}
// THUMBNAIL
$post_img = '';
$thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), $image_size );
if ($thumbnail_src) {
    $post_col = 'col-md-12';
}else{
    $post_col = 'col-md-12 no-featured-image';
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('single-post grid-view '.esc_attr($master_class).' '.esc_attr($type_class)); ?> >   
    <div class="blog_custom">
        <?php if ($thumbnail_src) { ?>
            <!-- POST THUMBNAIL -->
            <div class="row">
                <div class="col-md-12 post-thumbnail">
                    <a href="<?php esc_url(the_permalink()); ?>" class="relative">
                        <img src="<?php echo esc_url($thumbnail_src[0]); ?>" alt="<?php the_title_attribute(); ?>" />
                    </a>
                </div>
            </div>
        <?php  }  ?>
        <div class="clearfix"></div>
        <!-- POST DETAILS -->
        <div class="<?php echo esc_attr($post_col); ?> post-details">
            <div class="blog_badge_date">
                <span><?php echo get_the_date(get_option('date_format'), get_the_ID()); ?></span>
            </div>
            <h3 class="post-name row">
                <a title="<?php the_title_attribute() ?>" href="<?php esc_url(the_permalink()); ?>">
                    <?php the_title() ?><?php if( is_sticky() ) { echo esc_html__('*', 'pomana'); } ?>
                </a>
            </h3>
            
            <div class="post-excerpt row">
                <?php echo the_excerpt(); ?>
                
                <div class="clearfix"></div>
                <?php
                    wp_link_pages( array(
                        'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'pomana' ),
                        'after'  => '</div>',
                    ) );
                ?>
                <div class="clearfix"></div>
            </div>
            <a class="rippler rippler-default button-winona btn btn-lg" href="<?php esc_url(the_permalink()); ?>"><?php echo esc_html__('Read More','pomana') ?></a>
        </div>
    </div>
</article>