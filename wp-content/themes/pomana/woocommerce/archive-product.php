<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive.
 *
 * Override this template by copying it to yourtheme/woocommerce/archive-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header( 'shop' ); ?>

<?php
$class = "col-md-12";
$page_spacing = "high-padding";
if ( class_exists( 'ReduxFrameworkPlugin' ) ) { 
	if ( pomana_redux('pomana_shop_layout') == 'pomana_shop_fullwidth' ) {
	    $class = "col-md-12";
	}elseif ( pomana_redux('pomana_shop_layout') == 'pomana_shop_right_sidebar' or pomana_redux('pomana_shop_layout') == 'pomana_shop_left_sidebar') {
	    $class = "col-md-9";
	    if ( pomana_redux('pomana_shop_layout') == 'pomana_shop_right_sidebar' ) {
	    	$side = "right";
	    }else{
	    	$side = "left";
	    }
	}
	$woocommerce_shop_page_id = get_the_title(get_option( 'woocommerce_shop_page_id' ));
	$side = "";
} else {
	$side = "";
	$woocommerce_shop_page_id = esc_html__('Shop', 'pomana');
}
if (function_exists('modeltheme_framework')) {
	$select_page_sidebar = get_post_meta( get_the_ID(), 'select_page_sidebar', true );
}
?>

	<!-- Breadcrumbs -->
    <div class="modeltheme-breadcrumbs">
        <div id="overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="page-title"><?php echo esc_attr($woocommerce_shop_page_id); ?></h1>
                </div>        
            </div>
        </div>
    </div>



	<?php
		/**
		 * woocommerce_before_main_content hook
		 *
		 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
		 * @hooked woocommerce_breadcrumb - 20
		 */
		do_action( 'woocommerce_before_main_content' );
	?>

		<!-- Page content -->
	<div class="<?php echo esc_attr($page_spacing); ?>">
	    <!-- Blog content -->
	    <div class="container blog-posts">
	    	<div class="row">
	    	
	        <?php if ( $side == 'left' ) { ?>
	        <div class="vc_col-md-3 sidebar-content">
	            <?php
					/**
					 * woocommerce_sidebar hook
					 *
					 * @hooked woocommerce_get_sidebar - 10
					 */
					do_action( 'woocommerce_sidebar' );
				?>

	        </div>
	        <?php } ?>

            <div class="<?php echo esc_attr($class); ?> main-content">

				<?php do_action( 'woocommerce_archive_description' ); ?>

				<?php if ( have_posts() ) : ?>

					<?php
						/**
						 * woocommerce_before_shop_loop hook
						 *
						 * @hooked woocommerce_result_count - 20
						 * @hooked woocommerce_catalog_ordering - 30
						 */
						do_action( 'woocommerce_before_shop_loop' );
					?>

					<div class="clearfix"></div>
					<?php woocommerce_product_loop_start(); ?>

						<?php woocommerce_product_subcategories(); ?>
						
						<?php $count = 0; ?>
						<?php while ( have_posts() ) : the_post(); ?>
							<?php $count++; ?>

							<?php wc_get_template_part( 'content', 'product' ); ?>

							<?php if(($count%3==0)){ ?>
								<li class="clearfix keep-on-desktop"></li>
							<?php }?>

							<?php if(($count%2==0)){ ?>
								<li class="clearfix keep-on-mobile"></li>
							<?php }?>

						<?php endwhile; // end of the loop. ?>
						<div class="clearfix"></div>

					<?php woocommerce_product_loop_end(); ?>

					<?php
						/**
						 * woocommerce_after_shop_loop hook
						 *
						 * @hooked woocommerce_pagination - 10
						 */
						do_action( 'woocommerce_after_shop_loop' );
					?>

				<?php elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) : ?>

					<?php wc_get_template( 'loop/no-products-found.php' ); ?>

				<?php endif; ?>

			</div>

	        <?php if ( $side == 'right' ) { ?>
	        <div class="vc_col-md-3 sidebar-content">
	            <?php //dynamic_sidebar( $select_page_sidebar ); ?>
	            <?php
					/**
					 * woocommerce_sidebar hook
					 *
					 * @hooked woocommerce_get_sidebar - 10
					 */
					do_action( 'woocommerce_sidebar' );
				?>
	        </div>
	        <?php } ?>

	    	</div>
	    </div>
	</div>

	<?php
		/**
		 * woocommerce_after_main_content hook
		 *
		 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
		 */
		do_action( 'woocommerce_after_main_content' );
	?>		       

<?php get_footer( 'shop' ); ?>
