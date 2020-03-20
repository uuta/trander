<?php

namespace App\Providers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use App\Components\GeoDBCitiesApi;

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
        $this->app->bind('GeoDBCitiesApi', GeoDBCitiesApi::class);
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
