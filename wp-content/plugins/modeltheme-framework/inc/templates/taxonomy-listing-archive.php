<?php
/**
 * The template for displaying search results pages.
 */
get_header(); 

?>
<div class="clearfix"></div>

<div class="modeltheme-breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <ol class="breadcrumb">
                    <h3 class="page-title"><?php echo esc_html__('Vending Machine Locations','modeltheme'); ?></h3>
                </ol>
            </div>
        </div>
    </div>
</div>

<?php 

$listing_term_style = get_term_meta( get_queried_object_id(), 'listing_term_style', true );
$term_style = '';
$term_column_map = '';
$term_column_listings = '';
$term_column_single_listing = '';
if(empty($listing_term_style) || $listing_term_style == 'style1') {
    $term_style = 'term-style1';
    $term_column_single_listing = 'col-md-3';
} elseif($listing_term_style == 'style2') {
    $term_style = 'term-style2 row';
    $term_column_map = 'col-md-5';
    $term_column_listings = 'col-md-7';
    $term_column_single_listing = 'col-md-4';
}
?>
<div class="taxonomy-listing-page <?php echo esc_attr($term_style); ?>">
    <!-- Page content -->
    <div class="high-padding <?php echo esc_attr($term_column_listings); ?>">
        <!-- Blog content -->

        <?php if(empty($listing_term_style) || $listing_term_style == 'style1') { ?>
            <div class="container">
        <?php } ?>

                <div class="main-content row">

                    
                    <?php if ( have_posts() ) : ?>
                            <?php /* Start the Loop */ ?>
                            <?php $i = 1; ?>
                            <?php while ( have_posts() ) : the_post(); ?>
                                <?php include('content-listing-archive.php');  ?>

                                <?php $i++; ?>

                            <?php endwhile; ?>

                            <div class="modeltheme-pagination-holder col-md-12">             
                                <div class="modeltheme-pagination pagination">             
                                    <?php the_posts_pagination(); ?>
                                </div>
                            </div>
                    <?php else : ?>
                        <?php get_template_part( 'content', 'none' ); ?>
                    <?php endif; ?>
                </div>
        <?php if(empty($listing_term_style) || $listing_term_style == 'style1') { ?>        
        </div>
        <?php } ?>
    </div>
</div>
<?php get_footer(); ?>