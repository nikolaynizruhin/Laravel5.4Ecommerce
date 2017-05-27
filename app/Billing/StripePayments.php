<?php

namespace App\Billing;

use App\Billing\Payments;
use Stripe\{Stripe, Charge, Customer};

class StripePayments implements Payments
{
    /**
     * Set stripe key. 
     *
     * @param  string $key
     * @return void
     */
    function __construct($key)
    {
        Stripe::setApiKey($key);
    }

    /**
     * Create customer. 
     *
     * @param  string $email
     * @param  string $stripeToken
     * @return Customer
     */
    public function createCustomer($email, $stripeToken)
    {
        return Customer::create([
            'email' => $email,
            'source' => $stripeToken
        ]);
    }

    /**
     * Create charge. 
     *
     * @param  integer $customerId
     * @param  string $amount
     * @param  string $currency
     * @return Charge
     */
    public function createCharge($customerId, $amount, $currency = 'usd')
    {
        return Charge::create([
            'customer' => $customerId,
            'amount' => $amount,
            'currency' => $currency
        ]);
    }
}
