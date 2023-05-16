<?php

class Stripe_Express_Scripts
{
    private function getScriptUrlWithVersion( $path )
    {
        return IT_STRIPE_EXPRESS_URL . 'dist/' . $path;
    }
    
    function admin_scripts()
    {
        $adminFileName = 'free/admin-free';
        wp_register_style(
            'wp-stripe-express-admin',
            $this->getScriptUrlWithVersion( $adminFileName . '.css' ),
            array(),
            IT_STRIPE_EXPRESS_VERSION,
            'all'
        );
        wp_register_script(
            'wp-stripe-express-admin',
            $this->getScriptUrlWithVersion( $adminFileName . '.js' ),
            null,
            IT_STRIPE_EXPRESS_VERSION,
            true
        );
    }
    
    function client_scripts()
    {
        wp_register_style(
            'wp-stripe-express-elements',
            $this->getScriptUrlWithVersion( 'itstripe-elements.min.css' ),
            array(),
            IT_STRIPE_EXPRESS_VERSION,
            'all'
        );
        wp_register_script(
            'wp-stripe-express-elements',
            $this->getScriptUrlWithVersion( 'itstripe-elements.min.js' ),
            null,
            IT_STRIPE_EXPRESS_VERSION,
            true
        );
    }

}