<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Stripe\PaymentIntent;
use Stripe\Stripe;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



//Route::post('/create-payment-intent', function (Request $request) {
//    Stripe::setApiKey('your-stripe-secret-key');
//
//    $paymentIntent = PaymentIntent::create([
//        'amount' => $request->amount,
//        'currency' => 'usd',
//        'description' => 'Test payment',
//    ]);
//
//    return response()->json([
//        'client_secret' => $paymentIntent->client_secret,
//    ]);
//});

Route::get('/', function () {
    return view('root');
});

Route::get('/getSession', 'Stripe\StripeController@getSession');



