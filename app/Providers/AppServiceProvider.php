<?php

namespace App\Providers;

use App\Models\Task;
use App\Observers\TaskObserver;
use App\Services\V1\Auth\AuthService;
use App\Services\V1\Interfaces\Auth\IAuthService;
use App\Services\V1\Interfaces\Tasks\IProjectService;
use App\Services\V1\Interfaces\Tasks\ITaskCommentService;
use App\Services\V1\Interfaces\Tasks\ITaskService;
use App\Services\V1\Interfaces\Tasks\ITaskStatusService;
use App\Services\V1\Tasks\ProjectService;
use App\Services\V1\Tasks\TaskCommentService;
use App\Services\V1\Tasks\TaskService;
use App\Services\V1\Tasks\TaskStatusService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public $bindings = [
       // Bind interfaces to implementations
       IAuthService::class => AuthService::class,
       ITaskStatusService::class => TaskStatusService::class,
       IProjectService::class => ProjectService::class,
       ITaskService::class => TaskService::class,
       ITaskCommentService::class => TaskCommentService::class,
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
        // Register the observers
        Task::observe(TaskObserver::class);
    }
}
