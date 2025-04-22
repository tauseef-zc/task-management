<?php

namespace App\Providers;

use App\Services\V1\Auth\AuthService;
use App\Services\V1\Interfaces\Auth\IAuthService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public $bindings = [
        // Bind interfaces to implementations
       IAuthService::class => AuthService::class,
    ];

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
