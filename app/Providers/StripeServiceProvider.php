<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class StripeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
