<?php

namespace App\Providers;

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

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(CustomerRepositoryInterface::class, CustomerRepository::class);
    }

>>>>>>> 72f5237d663e404ee450fd532a2b229ee05201ee
    public function boot(): void
    {
        //
    }
<<<<<<< HEAD
}
=======
}
>>>>>>> 72f5237d663e404ee450fd532a2b229ee05201ee
