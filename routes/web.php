<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\EbayItemImagesController;
use App\Http\Controllers\UsedPricesController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
//    return Inertia::render('Welcome', [
//        'canLogin' => Route::has('login'),
//        'canRegister' => Route::has('register'),
//        'laravelVersion' => Application::VERSION,
//        'phpVersion' => PHP_VERSION,
//    ]);
    return redirect()->route('usedPrices');
})->name('index');

Route::middleware(['auth:sanctum', 'verified'])->group(function() {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('/purchases', [DashboardController::class, 'purchases'])->name('purchases');
    Route::get('/redemptions', [DashboardController::class, 'redemptions'])->name('redemptions');
    Route::get('/bookmarks', [DashboardController::class, 'bookmarks'])->name('bookmarks');
});

//Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
//    return Inertia::render('Dashboard');
//})->name('dashboard');

Route::middleware(['web'])->group(function () {
    Route::get('/used-prices', UsedPricesController::class)->name('usedPrices');
    Route::get('/used-prices/filter', [UsedPricesController::class, 'filter'])->name('filter');
});
