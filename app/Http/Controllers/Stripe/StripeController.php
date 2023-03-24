<?php

namespace App\Http\Controllers\Stripe;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StripeController extends Controller
{
   public function getSession()
   {
       $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));

       $checkout = $stripe->checkout->sessions->create([
           'success_url' => 'http://stripe-vue.test/success',
           'cancel_url' => 'http://stripe-vue.test/cancel',
           'line_items' => [
               [
                   'price_data' => [
                       'currency' => 'usd',
                       'unit_amount' => 500,
                       'product_data' => [
                           'name' => 'Cool Product'
                       ],
                   ],
                   'quantity' => 1,
               ],
           ],
           'mode' => 'payment',
       ]);

       $subscription = $stripe->checkout->sessions->create([
           'success_url' => 'http://stripe-vue.test/success',
           'cancel_url' => 'http://stripe-vue.test/cancel',
           'line_items' => [
               [
                   'price' => 'price_1MjN54KfQxRkIXlXj9YsMwJt',
                   'quantity' => 1,
               ],
           ],
           'mode' => 'subscription',
       ]);


       return [
           'success' => true,
           'checkout' => $checkout,
           'subscription' => $subscription,
       ];
   }

   public function webhook (Request $request)
   {
       \Log::info('webhook');

       $endpoint_secret = env('WEBHOOK_KEY');

       if ($endpoint_secret) {
           // Only verify the event if there is an endpoint secret defined
           // Otherwise use the basic decoded event
           $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
           $payload = @file_get_contents('php://input');

           try {
               $event = \Stripe\Webhook::constructEvent(
                   $payload, $sig_header, $endpoint_secret
               );
           } catch(\Stripe\Exception\SignatureVerificationException $e) {
               // Invalid signature
               echo '⚠️  Webhook error while validating signature.';
               http_response_code(400);
               exit();
           }

           if ($request->type == 'checkout.session.completed')
           {
               \Log::info('done');
           }
       }

       return response()->json([
           'success' => true
       ]);
   }
}
