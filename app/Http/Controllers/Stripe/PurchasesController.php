<?php

namespace App\Http\Controllers\Stripe;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Stripe\Customer;
use Stripe\PaymentIntent;
use Stripe\Stripe;

class PurchasesController extends Controller
{
    public function store(Request $request)
    {
        \Log::info($request);
        // Get the customer's billing information from the request
        $name = $request->name;
        $email = $request->email;
        $address = $request->address;
        $city = $request->city;
        $state = $request->state;
        $zip = $request->zip;
        $amount = $request->amount;
        $currency = $request->currency;

        Stripe::setApiKey(config('services.stripe.secret'));

        // Create a new Stripe customer object
        $customer = Customer::create([
            'name' => $name,
            'email' => $email,
            'address' => [
                'line1' => $address,
                'city' => $city,
                'state' => $state,
                'postal_code' => $zip,
                'country' => 'US',
            ],
        ]);

        // Create a new Stripe payment intent object
        $intent = PaymentIntent::create([
            'amount' => $amount,
            'currency' => $currency,
            'customer' => $customer->id,
        ]);

        // Return the client secret of the payment intent object to the Vue 2 component
        return response()->json(['client_secret' => $intent->client_secret]);
//        return view('root', [
//            'intent' => json_encode($intent)
//        ]);
    }
}
