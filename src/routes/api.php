<?php

use Illuminate\Support\Facades\Route;

Route::middleware('request.to.snake', 'response.to.camel')->group(function () {

    // Authentication
    // Route::namespace('Auth')->group(function () {
    //     Route::post('/register', 'RegisterController@register')->name('register');
    //     Route::post('/login', 'LoginController@login')->name('login');
    //     Route::post('/logout', 'LoginController@logout')->name('logout');
    //     Route::post('/reset-password', 'ForgotPasswordController@sendPasswordResetLink')->name('reset-password');
    //     Route::put('/password', 'ForgotPasswordController@callResetPassword')->name('password.put');
    //     Route::get('/social/{social}', 'LoginController@socialLogin')->name('social-login');
    //     Route::get('/social/callback/{social}', 'LoginController@socialCallback')->name('social-callback');
    // });

    // Google Place
    Route::get('/google-place', 'GooglePlaceController@show')->name('google-place.get');

    // Request Limit
    Route::prefix('request-limit')->group(function () {
        Route::put('/', 'RequestLimitController@put')->name('request-limit.put');
    });

    // JWT, craete a user
    Route::middleware('jwt', 'first_or_create_user')->group(function () {

        // User
        Route::prefix('user')->group(function () {
            Route::get('/', 'UserController@show')->name('user.show');
            Route::post('/', 'UserController@create')->name('user.create');
        });

        // モーダル用の値変更
        Route::post('/change-registration', 'CheckController@changeRegistration')->name('change-registration');

        // External API
        Route::prefix('external')->namespace('External')->group(function () {
            Route::get('/facility', 'FacilityController@index')->name('facility.get');
            Route::get('/hotel', 'HotelController@index')->name('hotel.get');
            Route::get('/weather', 'WeatherController@index')->name('weather.get');
            Route::get('/wiki-city', 'WikiController@city_index')->name('wiki.city.get');
        });

        // Distance
        Route::get('/distance', 'DistanceController@index')->name('distance.get');

        // Setting
        Route::prefix('setting')->group(function () {
            Route::get('/', 'SettingController@get')->name('setting.get');
            Route::post('/', 'SettingController@store')->name('setting.store');
        });

        // Rate Limit
        Route::middleware('throttle:4, 0.05', 'verify.subscriber', 'consume.request')->group(function () {
            Route::prefix('external')->namespace('External')->group(function () {
                Route::post('/geo-db-cities', 'GeoDBCitiesController@request')->name('geo-db-cities');
                Route::get('/geo-db-cities', 'GeoDBCitiesController@index')->name('geo-db-cities.get');
                Route::get('/near-by-search', 'NearBySearchController@index')->name('near-by-search.get');
            });
            // Cities
            Route::get('/cities', 'CitiesController@index')->name('cities.get');
        });

        // Test
        Route::prefix('dev-test')->namespace('Test')->group(function () {
            Route::get('/weather', 'TestController@weather')->name('test.weather.get');
            Route::get('/wiki', 'TestController@wiki')->name('test.wiki.get');
            Route::get('/find-place', 'TestController@find_place')->name('test.find-place.get');
            Route::get('/near-by-search', 'TestController@near_by_search')->name('test.near-by-search.get');
        });
    });
});
