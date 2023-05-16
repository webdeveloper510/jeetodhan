<?php

class Stripe_Express_Routes
{
    function register_routes()
    {
        // Admin API
        $settingController = new Stripe_Express_Setting_Controller();
        $elementController = new Stripe_Express_Element_Controller();
        $systemController = new Stripe_Express_System_Controller();
        $settingController->register_routes();
        $elementController->register_routes();
        $systemController->register_routes();
        // Stripe Client API
        $stripeAPIController = new Stripe_Express_Stripe_Controller();
        $stripeAPIController->register_routes();
    }

}