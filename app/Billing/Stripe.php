<?php

namespace App\Billing;

use Stripe\{Charge, Customer};

class Stripe
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

    /**
     * Create customer. 
     *
     * @param  string $email
     * @param  string $stripeToken
     * @return Customer $customer
     */
    public function createCustomer($email, $stripeToken)
    {
        $customer = Customer::create([
            'email' => $email,
            'source' => $stripeToken
        ]);

        return $customer;
    }

    /**
     * Create charge. 
     *
     * @param  integer $customerId
     * @param  string $amount
     * @param  string $currency
     * @return Charge $charge
     */
    public function createCharge($customerId, $amount, $currency = 'usd')
    {
        $charge = Charge::create([
            'customer' => $customerId,
            'amount' => $amount,
            'currency' => $currency
        ]);

        return $charge;
    }
}