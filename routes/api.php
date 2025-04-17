<?php

use App\Http\Controllers\Api\V1\Auth\LoginController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {

    // Auth routes
    Route::prefix('auth')->name('auth.')->group(function () {

        // Guest Auth routes
        Route::middleware('guest')->group(function () {
            Route::post('login', LoginController::class)->name('login');
        });
    });

});
