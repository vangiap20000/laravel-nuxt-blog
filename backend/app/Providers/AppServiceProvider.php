<?php

namespace App\Providers;

use App\Services\Auth\AuthService;
use App\Services\Auth\AuthServiceInterface;
use App\Services\Task\TaskService;
use App\Services\Task\TaskServiceInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(TaskServiceInterface::class, TaskService::class);
        $this->app->bind(AuthServiceInterface::class, AuthService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
