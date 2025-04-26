<?php

use App\Http\Controllers\Api\V1\Auth\{
    ForgotPasswordController,
    LoggedInUserController,
    LoginController,
    LogoutController,
    RegisterController,
    ResetPasswordController,
    ResetVerifyController,
    UpdateAccountPasswordController,
    VerificationController
};
use App\Http\Controllers\Api\V1\Tasks\Projects\CreateProjectController;
use App\Http\Controllers\Api\V1\Tasks\Projects\UpdateProjectController;
use App\Http\Controllers\Api\V1\Tasks\Statuses\{
    CreateTaskStatusController,
    DeleteTaskStatusController,
    GetTaskStatusController,
    UpdateTaskStatusController
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
            Route::post('password-verify', ResetVerifyController::class)->name('password.verify.user');
            Route::post('forgot-password', ForgotPasswordController::class)->name('forgot.password');
        });

        // Protected auth routes
        Route::middleware('auth:sanctum')->group(function () {           
            Route::put('reset-password', ResetPasswordController::class)->name('reset.password');
            Route::get('user', LoggedInUserController::class)->name('user');
            Route::get('logout', LogoutController::class)->name('logout');
            Route::put('update-password', UpdateAccountPasswordController::class)->name('update.password');
        });

    });

    // Task routes
    Route::prefix('tasks')->name('tasks.')->group(function () {
      
        // Protected Task routes
        Route::middleware('auth:sanctum')->group(function () {

            // Task Status routes
            Route::get('statuses', GetTaskStatusController::class)->name('statuses.index');  
            Route::post('statuses', CreateTaskStatusController::class)->name('statuses.create');
            Route::put('statuses/{taskStatus}', UpdateTaskStatusController::class)->name('statuses.update');
            Route::delete('statuses/{taskStatus}', DeleteTaskStatusController::class)->name('statuses.delete');

            // Project routes
            Route::post('projects', CreateProjectController::class)->name('projects.store');
            Route::put('projects/{project}', UpdateProjectController::class)->name('projects.update');

            // Task routes
        });
    });

});
