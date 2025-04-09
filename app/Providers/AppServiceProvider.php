<?php

namespace App\Providers;

use App\Services\Impl\GithubService;

use App\Services\GithubServiceInterface;
use App\Services\Impl\UserAgentService;
use App\Services\UserAgentServiceInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        $this->app->singleton(GithubServiceInterface::class, GithubService::class);
        $this->app->singleton(UserAgentServiceInterface::class, UserAgentService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
