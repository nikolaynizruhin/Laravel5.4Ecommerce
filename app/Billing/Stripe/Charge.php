<?php

namespace App\Billing\Stripe;

use App\Billing\Stripe\Stripe;

class Charge extends Stripe
{
    /**
     * Create charge. 
     *
     * @param  integer $customerId
     * @param  string $amount
     * @param  string $currency
     * @return Charge $charge
     */
    public function create($customerId, $amount, $currency = 'usd')
    {
        $charge = \Stripe\Charge::create([
            'customer' => $customerId,
            'amount' => $amount,
            'currency' => $currency
        ]);

        return $charge;
    }
}