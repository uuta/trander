<?php

namespace App\Providers\Repositories;

use Illuminate\Support\ServiceProvider;

class GooglePlaceIdRepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('GooglePlaceIdRepository', GooglePlaceIdRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
