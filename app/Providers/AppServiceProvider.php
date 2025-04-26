<?php

namespace App\Providers;

use App\Services\V1\Auth\AuthService;
use App\Services\V1\Interfaces\Auth\IAuthService;
use App\Services\V1\Interfaces\Tasks\IProjectService;
use App\Services\V1\Interfaces\Tasks\ITaskStatusService;
use App\Services\V1\Tasks\ProjectService;
use App\Services\V1\Tasks\TaskStatusService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public $bindings = [
        // Bind interfaces to implementations
       IAuthService::class => AuthService::class,
       ITaskStatusService::class => TaskStatusService::class,
       IProjectService::class => ProjectService::class,
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
