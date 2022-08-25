<?php

namespace App\Providers;

use App\Repositories\Interfaces\PropertyRepositoryInterface;
use App\Repositories\PropertyRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(PropertyRepositoryInterface::class, PropertyRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
