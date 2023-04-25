<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package Modeltheme
 */

get_header(); 

$page_slider = get_post_meta( get_the_ID(), 'select_revslider_shortcode', true );
$page_sidebar = get_post_meta( get_the_ID(), 'select_page_sidebar', true );
$page_spacing = get_post_meta( get_the_ID(), 'page_spacing', true );
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

    <!-- Revolution slider -->
    <?php 
    if (!empty($page_slider)) {
        echo '<div class="pomana_header_slider">';
        echo do_shortcode('[rev_slider '.esc_attr($page_slider).']');
        echo '</div>';
    }
    ?>

    <!-- Page content -->
    <div id="primary" class="<?php echo esc_attr($page_spacing); ?> content-area no-sidebar">
        <div class="container">
            <main id="main" class="site-main main-content">
                <?php while ( have_posts() ) : the_post(); ?>

                    <?php get_template_part( 'content', 'page' ); ?>

                    <?php
                        // If comments are open or we have at least one comment, load up the comment template
                        if ( comments_open() || get_comments_number() ) :
                            comments_template();
                        endif;
                    ?>

                <?php endwhile; // end of the loop. ?>
            </main>
        </div>
    </div>

<?php get_footer(); ?>