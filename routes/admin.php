<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CarsController;
use App\Http\Controllers\Admin\EbayItemsController;
use App\Http\Controllers\Admin\MakesController;
use App\Http\Controllers\Admin\UsersController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified', 'admin'])->group(function() {
    Route::get('/', AdminController::class)->name('index');
    Route::resource('cars', CarsController::class);
    Route::resource('makes', MakesController::class);
});
