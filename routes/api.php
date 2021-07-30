<?php

use App\Http\Controllers\Api\CarImagesController;
use App\Http\Controllers\Api\EbayItemsController;
use App\Http\Controllers\Api\StripeController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('api_token')->post('/user', function (Request $request) {
    return [
        'user' => User::query()->where('api_token', $request->api_token)->first()
    ];
});



Route::middleware('api_token')->post('/my-cars', [EbayItemsController::class, 'myCars'])->name('myCars');
Route::middleware('api_token')->post('/cars/{ebay_item}/bookmark', [EbayItemsController::class, 'bookmark'])->name('bookmark');
Route::middleware('api_token')->post('/cars/{ebay_item}/redeem', [EbayItemsController::class, 'redeem'])->name('redeem');
Route::get('car-images/{ebayItemImage}', [CarImagesController::class, 'show']);
Route::post('cars', [EbayItemsController::class, 'loadMore']);

Route::get('/get-stripe-publishable', [StripeController::class, 'getPublishable']);
Route::middleware('api_token')->post('/stripe-purchase', [StripeController::class, 'stripePurchase'])->name('stripePurchase');
