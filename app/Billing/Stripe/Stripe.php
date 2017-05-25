<?php

namespace App\Billing\Stripe;

abstract class Stripe
{
    /**
     * Set stripe key. 
     *
     * @param  string $key
     * @return void
     */
    function __construct($key)
    {
        \Stripe\Stripe::setApiKey($key);
    }
}