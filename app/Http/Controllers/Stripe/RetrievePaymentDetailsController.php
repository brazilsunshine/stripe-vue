<?php

namespace App\Http\Controllers\Stripe;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Stripe\Exception\ApiErrorException;
use Stripe\PaymentIntent;
use Stripe\PaymentMethod;
use Stripe\Stripe;
use Stripe\StripeClient;

class RetrievePaymentDetailsController extends Controller
{
    /**
     * @throws ApiErrorException
     */
    public function __invoke (Request $request)
    {
        \Log::info($request);
        $stripe = new StripeClient(
            config('services.stripe.secret')
        );

        Stripe::setApiKey($stripe);

        $intentId = $request->input('intent_id');
        $intent = PaymentIntent::retrieve($intentId);
        $clientSecret = $intent->client_secret;

        \Log::info($intentId);

        $paymentMethodId = $intent->payment_method;
        $paymentMethod = PaymentMethod::retrieve($paymentMethodId);

        return response()->json([
            'client_secret' => $clientSecret,
            'payment_method' => $paymentMethod,
            'payment_intent_id' => $intentId
        ]);
    }
}
