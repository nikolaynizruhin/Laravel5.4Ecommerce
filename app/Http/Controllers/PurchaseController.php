<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\{Stripe, Charge, Customer};
use Illuminate\Support\Facades\Auth;
use Gloudemans\Shoppingcart\Facades\Cart;

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
    public function store(Request $request)
    {
        // Set Stripe api key
        Stripe::setApiKey(config('services.stripe.secret'));

        // Charge the customer
        $customer = Customer::create([
            'email' => Auth::user()->email,
            'source' => request('stripeToken')
        ]);

        // Charge the purchase
        Charge::create([
            'customer' => $customer->id,
            'amount' => str_replace('.', '', \Gloudemans\Shoppingcart\Facades\Cart::total()),
            'currency' => 'usd'
        ]);

        // Empty cart
        Cart::destroy();

        // Redirect to products page with success flash
        return redirect('/products')->with('status', 'Purchase was successful!');
    }
}
