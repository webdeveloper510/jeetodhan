<?php
  $blog_title = get_bloginfo();

  global $woocommerce;
  $cart_url = "#";
  if ( class_exists( 'WooCommerce' ) ) {
    $cart_url = wc_get_cart_url();
  } ?>
  <!-- BOTTOM BAR -->
<?php 
  if ( class_exists( 'ReduxFrameworkPlugin' ) ) { 
      $navigation = 'col-md-6';
      $top_links = 'col-md-3';       
      if ( pomana_redux('header_width') == 'fullwidth') {
          $header_container = 'fullwidth';
      }else{
          $header_container = 'container';
      }
  } else {
    $navigation = 'col-md-8';
    $top_links = 'col-md-1';   
    $header_container = 'fullwidth';
  } 
?>

  <nav class="navbar navbar-default" id="modeltheme-main-head">
    <div class="<?php echo esc_html($header_container); ?>">
      <div class="row">
        <div class="navbar-header col-md-3">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>

          <div class="logo">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
              <?php echo pomana_get_theme_logo(); ?>
              
              <?php if ( class_exists( 'ReduxFrameworkPlugin' ) ) { ?>
                <?php if ( pomana_redux('is_nav_sticky') != false ) { ?>
                  <?php echo pomana_get_theme_logo_sticky(); ?>
                <?php } ?>
              <?php } ?>
            </a>
          </div>
        </div>

        <div id="navbar" class="navbar-collapse collapse <?php echo esc_attr($navigation); ?>">
          <div class="menu nav navbar-nav nav-effect nav-menu">
            <ul>
             <?php
                if ( has_nav_menu( 'primary' ) ) {
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
                  $defaults['theme_location'] = 'primary';
                  wp_nav_menu( $defaults );
                }else{
                  if ( is_user_logged_in() ) {
                    echo '<p class="no-menu text-right">';
                      echo esc_html__('Primary navigation menu is missing.', 'pomana');
                    echo '</p>';
                  }
                }
              ?>
            </ul>
          </div>
        </div>
        
        <div class="top-links <?php echo esc_attr($top_links); ?>">
          <?php if ( class_exists( 'ReduxFrameworkPlugin' ) ) { ?>
            <?php if (class_exists('WooCommerce')) { ?>
              <span class="top-account"><a href="<?php echo esc_url(get_permalink( get_option('woocommerce_myaccount_page_id') )); ?>"><i class="fa fa-user-circle"></i></a></span>
            <?php } ?>
            <?php if (class_exists('WooCommerce')) { ?>
              <span class="top-cart"><a  class="shop_cart" href="<?php echo esc_url($cart_url); ?>"><i class="fa fa-shopping-basket"></i></a></span>
              <!-- Shop Minicart -->
                    <div class="header_mini_cart">
                      <?php the_widget( 'WC_Widget_Cart' ); ?>
                    </div>
            <?php } ?>
            <p class="header-button">
              <a href="<?php echo esc_url(pomana_redux('pomana_header_booking')); ?>"><?php echo apply_filters( 'pomana_header_button_text', esc_html__('Car Giveaways','pomana') ); ?></a>
            </p>
          <?php } ?>
       </div>       
    </div>
  </div>
</nav>