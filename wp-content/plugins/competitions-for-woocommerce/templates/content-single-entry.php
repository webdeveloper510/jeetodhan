
<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product, $post;

/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked woocommerce_output_all_notices - 10
 */
do_action( 'woocommerce_before_single_entry' );
do_action( 'woocommerce_before_single_product' );

?>
<div id="product-<?php the_ID(); ?>" <?php wc_product_class( '', $product ); ?>>


	<div class="summary entry-summary">
		<?php
		/**
		 * Hook: woocommerce_single_entry.
		 *
		 */
		do_action( 'woocommerce_single_entry' );
		?>
	</div>

	<?php
	/**
	 * Hook: woocommerce_after_single_entry.
	 */
	do_action( 'woocommerce_after_single_entry' );
	?>
</div>

<?php do_action( 'woocommerce_after_single_product' ); ?>
