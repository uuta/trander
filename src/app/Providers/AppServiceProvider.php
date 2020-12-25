<?php

namespace App\Providers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use App\Services\GeoDBCitiesApi;
use App\Services\GooglePlace\Get as GooglePlaceGet;

use App\Repositories\CheckRepository;
use App\Repositories\SettingRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Services
        $this->app->bind('GeoDBCitiesApi', GeoDBCitiesApi::class);
        $this->app->bind('GooglePlaceGet', GooglePlaceGet::class);

        // Repositories
        $this->app->bind('SettingRepository', SettingRepository::class);
        $this->app->bind('CheckRepository', CheckRepository::class);
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
