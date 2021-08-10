<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CarsController;
use App\Http\Controllers\Admin\MakesController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified', 'admin'])->group(function() {
    Route::get('/', AdminController::class)->name('index');
    Route::resource('cars', CarsController::class);
    Route::post('/makes/{make}/up', [MakesController::class, 'up'])->name('makes.up');
    Route::post('/makes/{make}/down', [MakesController::class, 'down'])->name('makes.down');
    Route::resource('makes', MakesController::class);
});
