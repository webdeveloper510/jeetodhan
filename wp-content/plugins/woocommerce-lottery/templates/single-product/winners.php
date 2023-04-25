<?php
/**
 * Winners block template
 *
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce, $product, $post;

if( $product && $product->is_closed() !== true ){
	return;
}


$current_user = wp_get_current_user();
$lottery_winers = get_post_meta($post->ID, '_lottery_winners');
?>
<?php if(get_post_meta($post->ID, '_order_hold_on')){ ?>
	<p><?php _e('Please be patient. We are waiting for some orders to be paid!','wc_lottery') ?></p>
<?php } else { ?>
	<?php if ( $product->get_lottery_closed() == 2 ) {?>
		<?php if ($product->is_user_participating()) : ?>
				<?php if(in_array($current_user->ID, $lottery_winers)): ?>
						<p><?php _e('Congratulations! You are the winner!','wc_lottery') ?></p>
				<?php else: ?>
						<p><?php _e('Sorry, better luck next time.','wc_lottery') ?></p>
				<?php endif; ?>		
		<?php endif;?>
	<?php } else{ 
		if ( $product->get_lottery_fail_reason() == '1' ) { ?>
			<p><?php _e('Lottery failed because there were no participants','wc_lottery') ?></p>
		<?php } elseif ( $product->get_lottery_fail_reason() == '2' ) { ?>
			<p><?php _e('Lottery failed because there was not enough participants','wc_lottery') ?></p>
		<?php } ?>
	<?php } ?>

<?php } ?>

<?php 	if(!empty($lottery_winers) && !empty($lottery_winers[0])){ 

	if (count($lottery_winers) > 1) { ?>
	<h3><?php _e('Winners:','wc_lottery') ?></h3>

	<ol class="lottery-winners">
	<?php 	

        foreach ($lottery_winers as $winner_id) {
                echo "<li>";
                echo get_userdata($winner_id)->display_name;
                echo "</li>";
        }		
	?>
	</ol>

	<?php } else {?>
		<h3><?php _e('Winner is:','wc_lottery') ?> <?php echo get_userdata($lottery_winers[0])->display_name; ?></h3>
	<?php } ?>

<?php } 