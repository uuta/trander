<?php

namespace App\Providers;

use App\Services\GeoDBCitiesApi;
use App\Repositories\CheckRepository;
use App\Repositories\SettingRepository;

use Illuminate\Support\ServiceProvider;
use App\Services\GooglePlace\Get as GooglePlaceGet;
use App\Services\RequestApis\Subscribers\SubscriberRequestApiService;

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
        $this->app->bind('SubscriberRequestApiService', SubscriberRequestApiService::class);

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
