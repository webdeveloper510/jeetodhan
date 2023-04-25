<?php 
/**
* Template for Listings
* Used in: search.php
**/


$thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' );
$mt_listing_phone_number = get_post_meta( get_the_ID(), 'mt_listing_phone_number', true );
$mt_listing_mail_address = get_post_meta( get_the_ID(), 'mt_listing_mail_address', true );          
$mt_listing_location_address = get_post_meta( get_the_ID(), 'mt_listing_location_address', true );
$listing_img = '<img class="listing_post_image" src="'. esc_url($thumbnail_src[0]) . '" alt="'.get_the_title().'" />';
                  
$listing_term_style = get_term_meta( get_queried_object_id(), 'listing_term_style', true );
$term_column_single_listing = '';
if(empty($listing_term_style) || $listing_term_style == 'style1') {
    $term_column_single_listing = 'col-md-4';
} elseif($listing_term_style == 'style2') {
    $term_column_single_listing = 'col-md-3';
}

?>

<div class="<?php echo esc_attr($term_column_single_listing); ?> single-listing list-view listing-taxonomy-shortcode">
    <div class="col-md-12 listings_custom">
      

      <div class="thumb_img">
       <div class="blog_custom_listings thumbnail-name">
		      <div class="listing-thumbnail">
		          <a class="relative" ><?php echo $listing_img; ?></a>
		      </div>
		 </div>
	 </div>

      <div class="title-n-categories">
        	<div class="single_job_info ">
		        <h4 class="post-name"><?php echo get_the_title(); ?></h4>
		      </div>
      </div>

    </div>
</div>
