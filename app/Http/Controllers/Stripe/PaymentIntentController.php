<?php

namespace App\Http\Controllers\Stripe;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Stripe\Customer;
use Stripe\PaymentIntent;
use Stripe\Stripe;

class PaymentIntentController extends Controller
{
    public function __invoke (Request $request)
    {
        \Log::info($request);

        Stripe::setApiKey(config('services.stripe.secret'));

        try
        {
            // Create a new Stripe customer object
            $customer = Customer::create([
                'name' => $request->name,
                'email' => $request->email,
                'address' => [
                    'line1' => $request->line1,
                    'city' => $request->city,
                    //'city' => $city,
                    //'state' => $state,
                    //'postal_code' => $zip,
                    'country' => $request->country,
                ],
            ]);
            // Create a new Stripe payment intent object
            $intent = PaymentIntent::create([
                'amount' => $request->amount,
                'currency' => 'eur',
                'customer' => $customer->id,
            ]);

            // Return the client secret of the payment intent object to the Vue 2 component
            return response()->json(['client_secret' => $intent->client_secret]);
        }
        catch (\Exception $exception)
        {
            \Log::info(['PaymentIntentController', $exception->getMessage()]);

            return [
                'success' => false,
                'msg' => 'problem'
            ];
        }
    }
}
