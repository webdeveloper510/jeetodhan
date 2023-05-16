<?php

if ( !function_exists( 'stripe_express_fs' ) ) {
    // Create a helper function for easy SDK access.
    function stripe_express_fs()
    {
        global  $stripe_express_fs ;
        
        if ( !isset( $stripe_express_fs ) ) {
            // Include Freemius SDK.
            require_once dirname( __FILE__ ) . '/freemius/start.php';
            $stripe_express_fs = fs_dynamic_init( array(
                'id'               => '6441',
                'slug'             => 'wp-stripe-express',
                'type'             => 'plugin',
                'public_key'       => 'pk_58f85bffb01719b39c0a420e0ae2d',
                'is_premium'       => false,
                'has_addons'       => false,
                'has_paid_plans'   => true,
                'is_org_compliant' => false,
                'trial'            => array(
                'days'               => 14,
                'is_require_payment' => true,
            ),
                'menu'             => array(
                'slug'       => 'stripe-express',
                'first-path' => 'admin.php?page=stripe-express#/',
                'support'    => false,
            ),
                'is_live'          => true,
            ) );
        }
        
        return $stripe_express_fs;
    }
    
    // Init Freemius.
    stripe_express_fs();
    // Signal that SDK was initiated.
    do_action( 'stripe_express_fs_loaded' );
}
