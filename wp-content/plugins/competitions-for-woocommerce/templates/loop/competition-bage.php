<?php
/**
 * Competition badge template
 *
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;
?>

<?php if ( method_exists( $product, 'get_type') && 'competition' === $product->get_type() ) : ?>
	<?php echo wp_kses_post( apply_filters('woocommerce_competition_bage', '<span class="competition-bage"></span>', $product) ); ?>
<?php
endif;
