<?php

namespace App\Providers;

<<<<<<< HEAD
use Illuminate\Support\ServiceProvider;
<<<<<<< HEAD

class AppServiceProvider extends ServiceProvider
{
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
=======
use App\Repositories\Contracts\CustomerRepositoryInterface;
use App\Repositories\Eloquent\CustomerRepository;
=======
use App\Repositories\Contracts\ActivityRepositoryInterface;
use App\Repositories\Eloquent\ActivityRepository;
use Illuminate\Support\ServiceProvider;
>>>>>>> feature/S6-06-activity-backend

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
<<<<<<< HEAD
        $this->app->bind(CustomerRepositoryInterface::class, CustomerRepository::class);
    }

>>>>>>> 72f5237d663e404ee450fd532a2b229ee05201ee
=======
        $this->app->bind(ActivityRepositoryInterface::class, ActivityRepository::class);
    }

>>>>>>> feature/S6-06-activity-backend
    public function boot(): void
    {
        //
    }
<<<<<<< HEAD
<<<<<<< HEAD
}
=======
}
>>>>>>> 72f5237d663e404ee450fd532a2b229ee05201ee
=======
}
>>>>>>> feature/S6-06-activity-backend
