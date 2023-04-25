<?php
/**
 * Header: Top Bar
 */
global  $pomana_redux; ?>

<?php 
  if ( class_exists( 'ReduxFrameworkPlugin' ) ) {        
      if ( pomana_redux('header_width') == 'fullwidth') {
          $header_container = 'fullwidth';
      }else{
          $header_container = 'container';
      }
  } else { 
    $header_container = 'container';
  } 
?>

<div class="pomana-top-bar">
	<div class="<?php echo esc_html($header_container); ?>">
	    <div class="row">
	        <div class="col-md-6">
	             <ul class="social-links">
                <?php if ( isset($pomana_redux['pomana_social_fb']) && $pomana_redux['pomana_social_fb'] != '' ) { ?>
                    <li><a href="<?php echo esc_attr($pomana_redux['pomana_social_fb']); ?>" target="_blank"><i class="fa fa-facebook"></i></a></li>
                <?php } ?>
                <?php if ( isset($pomana_redux['pomana_social_tw']) && $pomana_redux['pomana_social_tw'] != '' ) { ?>
                    <li><a href="https://twitter.com/<?php echo esc_attr($pomana_redux['pomana_social_tw']); ?>" target="_blank"><i class="fa fa-twitter"></i></a></li>
                <?php } ?>
                <?php if ( isset($pomana_redux['pomana_social_youtube']) && $pomana_redux['pomana_social_youtube'] != '' ) { ?>
                    <li><a href="<?php echo esc_attr($pomana_redux['pomana_social_youtube']); ?>" target="_blank"><i class="fa fa-youtube"></i></a></li>
                <?php } ?>
                <?php if ( isset($pomana_redux['pomana_social_pinterest']) && $pomana_redux['pomana_social_pinterest'] != '' ) { ?>
                    <li><a href="<?php echo esc_attr($pomana_redux['pomana_social_pinterest']); ?>" target="_blank"><i class="fa fa-pinterest"></i></a></li>
                <?php } ?>
                <?php if ( isset($pomana_redux['pomana_social_linkedin']) && $pomana_redux['pomana_social_linkedin'] != '' ) { ?>
                    <li><a href="<?php echo esc_attr($pomana_redux['pomana_social_linkedin']); ?>" target="_blank"><i class="fa fa-linkedin"></i></a></li>
                <?php } ?>
                <?php if ( isset($pomana_redux['pomana_social_skype']) && $pomana_redux['pomana_social_skype'] != '' ) { ?>
                    <li><a href="<?php echo esc_attr($pomana_redux['pomana_social_skype']); ?>" target="_blank"><i class="fa fa-skype"></i></a></li>
                <?php } ?>
                <?php if ( isset($pomana_redux['pomana_social_instagram']) && $pomana_redux['pomana_social_instagram'] != '' ) { ?>
                    <li><a href="<?php echo esc_attr($pomana_redux['pomana_social_instagram']); ?>" target="_blank"><i class="fa fa-instagram"></i></a></li>
                <?php } ?>
                <?php if ( isset($pomana_redux['pomana_social_dribbble']) && $pomana_redux['pomana_social_dribbble'] != '' ) { ?>
                    <li><a href="<?php echo esc_attr($pomana_redux['pomana_social_dribbble']); ?>" target="_blank"><i class="fa fa-dribbble"></i></a></li>
                <?php } ?>
                <?php if ( isset($pomana_redux['pomana_social_deviantart']) && $pomana_redux['pomana_social_deviantart'] != '' ) { ?>
                    <li><a href="<?php echo esc_attr($pomana_redux['pomana_social_deviantart']); ?>" target="_blank"><i class="fa fa-deviantart"></i></a></li>
                <?php } ?>
                <?php if ( isset($pomana_redux['pomana_social_digg']) && $pomana_redux['pomana_social_digg'] != '' ) { ?>
                    <li><a href="<?php echo esc_attr($pomana_redux['pomana_social_digg']); ?>" target="_blank"><i class="fa fa-digg"></i></a></li>
                <?php } ?>
                <?php if ( isset($pomana_redux['pomana_social_flickr']) && $pomana_redux['pomana_social_flickr'] != '' ) { ?>
                    <li><a href="<?php echo esc_attr($pomana_redux['pomana_social_flickr']); ?>" target="_blank"><i class="fa fa-flickr"></i></a></li>
                <?php } ?>
                <?php if ( isset($pomana_redux['pomana_social_stumbleupon']) && $pomana_redux['pomana_social_stumbleupon'] != '' ) { ?>
                    <li><a href="<?php echo esc_attr($pomana_redux['pomana_social_stumbleupon']); ?>" target="_blank"><i class="fa fa-stumbleupon"></i></a></li>
                <?php } ?>
                <?php if ( isset($pomana_redux['pomana_social_tumblr']) && $pomana_redux['pomana_social_tumblr'] != '' ) { ?>
                    <li><a href="<?php echo esc_attr($pomana_redux['pomana_social_tumblr']); ?>" target="_blank"><i class="fa fa-tumblr"></i></a></li>
                <?php } ?>
                <?php if ( isset($pomana_redux['pomana_social_vimeo']) && $pomana_redux['pomana_social_vimeo'] != '' ) { ?>
                    <li><a href="<?php echo esc_attr($pomana_redux['pomana_social_vimeo']); ?>" target="_blank"><i class="fa fa-vimeo-square"></i></a></li>
                <?php } ?>
                </ul>
	        </div>

	        <div class="col-md-5">
	        	<div class="menu nav-menu">
	           	<?php
	              if ( has_nav_menu( 'topbar' ) ) {
	                $defaults = array(
	                  'menu'            => '',
	                  'container'       => false,
	                  'container_class' => '',
	                  'container_id'    => '',
	                  'menu_class'      => 'menu',
	                  'menu_id'         => '',
	                  'echo'            => true,
	                  'fallback_cb'     => false,
	                  'before'          => '',
	                  'after'           => '',
	                  'link_before'     => '',
	                  'link_after'      => '',
	                  'items_wrap'      => '%3$s',
	                  'depth'           => 0,
	                  'walker'          => ''
	                );
	                $defaults['theme_location'] = 'topbar';
	                wp_nav_menu( $defaults );
	              }else{
	                if ( is_user_logged_in() ) {
	                  echo '<p class="no-menu text-left">';
	                  echo '</p>';
	                }
	              }
	            ?>
	          </div>
	          
	       	</div>
	       	<div class="col-md-1">
	            <?php if ( class_exists('woocommerce')) { ?>
	              <?php if (is_user_logged_in()) { ?>
	                <div id="dropdown-user-profile" class="ddmenu">
	                  <p id="nav-menu-register" class="nav-menu-account"><a href="<?php echo esc_url(get_permalink( get_option('woocommerce_myaccount_page_id') )); ?>"><?php echo esc_html__('My Account','pomana'); ?></a></p>
	                </div>
	              <?php } else { ?> <!-- logged out -->
	              	<div id="dropdown-user-profile" class="ddmenu">
		                <p id="nav-menu-register" class="pomana-logoin">
		                  <?php do_action('pomana_login_link_a'); ?>
		                </p>
		            </div>
	              <?php } ?>
	            <?php } ?>
	        </div>
	    </div>
	</div>
</div>