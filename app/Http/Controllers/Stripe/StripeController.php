<?php

namespace App\Http\Controllers\Stripe;

use App\Http\Controllers\Controller;

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
}
