<?php

namespace App\Billing;

interface Payments
{
    /**
     * Create customer. 
     *
     * @param  string $email
     * @param  string $stripeToken
     * @return Customer $customer
     */
    public function createCustomer($email, $token);

    /**
     * Create charge. 
     *
     * @param  integer $customerId
     * @param  string $amount
     * @param  string $currency
     * @return Charge $charge
     */
    public function createCharge($customerId, $amount, $currency = 'usd');
}