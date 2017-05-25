<?php

namespace App\Billing\Stripe;

use App\Billing\Stripe\Stripe;

class Customer extends Stripe
{
    /**
     * Create customer. 
     *
     * @param  string $email
     * @param  string $stripeToken
     * @return Customer $customer
     */
    public function create($email, $stripeToken)
    {
        $customer = \Stripe\Customer::create([
            'email' => $email,
            'source' => $stripeToken
        ]);

        return $customer;
    }
}