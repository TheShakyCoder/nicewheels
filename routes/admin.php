<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AspectMakesController;
use App\Http\Controllers\Admin\CarsController;
use App\Http\Controllers\Admin\MakesController;
use App\Http\Controllers\Admin\SubstitutionsController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified', 'admin'])->group(function() {
    Route::get('/', AdminController::class)->name('index');
    Route::post('/sql', [AdminController::class, 'sql'])->name('sql');
    Route::resource('cars', CarsController::class);
    Route::post('/makes/{make}/up', [MakesController::class, 'up'])->name('makes.up');
    Route::post('/makes/{make}/down', [MakesController::class, 'down'])->name('makes.down');
    Route::resource('makes', MakesController::class);
    Route::resource('aspect-makes', AspectMakesController::class);
    Route::post('/substitutions/{substitution}/up', [SubstitutionsController::class, 'up'])->name('substitutions.up');
    Route::post('/substitutions/{substitution}/down', [SubstitutionsController::class, 'down'])->name('substitutions.down');
    Route::resource('substitutions', SubstitutionsController::class);
});
