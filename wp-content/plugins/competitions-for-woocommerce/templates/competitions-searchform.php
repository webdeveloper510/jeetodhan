<form role="search" method="get" class="woocommerce-lotteries-search" action="<?php echo esc_url( home_url( '/'  ) ); ?>">
<label class="screen-reader-text" for="s"><?php esc_html_e( 'Search for:', 'woocommerce' ); ?></label>
<input type="search" class="search-field" placeholder="<?php echo esc_attr_x( 'Search competitions&hellip;', 'placeholder', 'competitions_for_woocommerce' ); ?>" value="<?php echo get_search_query(); ?>" name="s" title="<?php echo esc_attr_x( 'Search for:', 'label', 'woocommerce' ); ?>" />
<input type="submit" value="<?php echo esc_attr_x( 'Search', 'submit button', 'woocommerce' ); ?>" />
<input type="hidden" name="post_type" value="product" />
<input type="hidden" name="search_competitions" value="true" />
</form>
