<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Billing\Stripe\{Charge, Customer};

class StripeServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        // Set Customer
        $this->app->singleton(Customer::class, function ($app) {
            return new Customer(config('services.stripe.secret'));
        });

        // Set Charge
        $this->app->singleton(Charge::class, function ($app) {
            return new Charge(config('services.stripe.secret'));
        });
    }
}
