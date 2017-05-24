<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Billing\Stripe;

class PurchaseController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Store a purchase.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Stripe $stripe)
    {
        // Create customer
        $customer = $stripe->createCustomer(
            Auth::user()->email, 
            request('stripeToken')
        );

        // Create charge
        $stripe->createCharge(
            $customer->id,
            str_replace('.', '', Cart::total())
        );

        // Empty cart
        Cart::destroy();

        // Redirect to products page with success flash
        return redirect('/products')->with('status', 'Purchase was successful!');
    }
}
