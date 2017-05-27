<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Billing\StripePayments;

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
        $this->app->bind('App\Billing\Payments', 'App\Billing\StripePayments');

        $this->app->singleton(StripePayments::class, function ($app) {
            return new StripePayments(config('services.stripe.secret'));
        });
    }
}
