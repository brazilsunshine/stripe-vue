<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Route::group(['middleware' => ['auth:sanctum']], function () {
//});
//Route::post('/process-payment', 'Stripe\PurchasesController@store');

/**
 * Create PaymentIntent
 */
Route::post('/payment-intents', 'Stripe\PaymentIntentController');

Route::post('/create-payment-intent', 'Stripe\RetrievePaymentDetailsController');

//Route::post('/create-payment-intent', 'Stripe\PaymentIntentController');



//Route::post('/webhook', 'Stripe\StripeController@webhook');
