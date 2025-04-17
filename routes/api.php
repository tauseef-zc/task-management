<?php

use App\Http\Controllers\Api\V1\Auth\{
    ForgotPasswordController,
    LoginController,
    RegisterController,
    ResetVerifyController,
    VerificationController
};
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {

    // Auth routes
    Route::prefix('auth')->name('auth.')->group(function () {

        // Guest Auth routes
        Route::middleware('guest')->group(function () {
            Route::post('login', LoginController::class)->name('login');
            Route::post('register', RegisterController::class)->name('register');
            Route::post('email/send-verification', [VerificationController::class, 'sendVerificationMail'])
                ->name('verification.send');
            Route::post('verify', [VerificationController::class, 'verifyUser'])->name('verify.user');
            Route::post('password-verify', [ResetVerifyController::class, 'verifyUser'])->name('verify.user');
            Route::post('forgot-password', ForgotPasswordController::class)->name('forgot.password');
        });

    });

});
