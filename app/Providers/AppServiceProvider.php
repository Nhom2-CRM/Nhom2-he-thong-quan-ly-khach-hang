<?php

namespace App\Providers;

use App\Repositories\Contracts\ActivityRepositoryInterface;
use App\Repositories\Eloquent\ActivityRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(ActivityRepositoryInterface::class, ActivityRepository::class);
    }

    public function boot(): void
    {
        //
    }
}