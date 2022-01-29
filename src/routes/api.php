<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\User;

Route::middleware('request.to.snake')->group(function () {
    Route::middleware('response.to.camel')->group(function () {

        // Authentication
        Route::namespace('Auth')->group(function () {
            Route::post('/register', 'RegisterController@register')->name('register');
            Route::post('/login', 'LoginController@login')->name('login');
            Route::post('/logout', 'LoginController@logout')->name('logout');
            Route::post('/reset-password', 'ForgotPasswordController@sendPasswordResetLink')->name('reset-password');
            Route::put('/password', 'ForgotPasswordController@callResetPassword')->name('password.put');
            Route::get('/social/{social}', 'LoginController@socialLogin')->name('social-login');
            Route::get('/social/callback/{social}', 'LoginController@socialCallback')->name('social-callback');
        });

        // JWT
        Route::middleware('jwt')->group(function () {
            Route::middleware('first_or_create_user')->group(function () {

                // Get Login User
                Route::get('/user', function (Request $request) {
                    return User::where('email', $request->auth0_email)->first();
                })->name('user');

                // モーダル用の値変更
                Route::post('/change-registration', 'CheckController@changeRegistration')->name('change-registration');

                // External API
                Route::namespace('External')->group(function () {
                    Route::post('/external/geo-db-cities', 'GeoDBCitiesApiController@request')->name('geo-db-cities');
                    Route::get('/external/geo-db-cities', 'GeoDBCitiesApiController@index')->name('geo-db-cities.get');
                    Route::get('/external/facility', 'FacilityController@index')->name('facility.get');
                    Route::get('/external/hotel', 'HotelController@index')->name('hotel.get');
                    Route::get('/external/weather', 'WeatherController@index')->name('weather.get');
                    Route::get('/external/wiki-city', 'WikiController@city_index')->name('wiki.city.get');
                    Route::get('/external/near-by-search', 'NearBySearchController@index')->name('near-by-search.get');
                });

                // Distance
                Route::get('/distance', 'DistanceController@index')->name('distance.get');

                // Setting
                Route::get('/setting', 'SettingController@get')->name('setting.get');
                Route::post('/setting', 'SettingController@store')->name('setting.store');

                // Google Place
                Route::get('/google-place', 'GooglePlaceController@show')->name('google-place.get');

                // Rate Limit
                Route::middleware('throttle:2, 0.15')->group(function () {
                    Route::namespace('External')->group(function () {
                        Route::post('/external/geo-db-cities', 'GeoDBCitiesApiController@request')->name('geo-db-cities');
                        Route::get('/external/geo-db-cities', 'GeoDBCitiesApiController@index')->name('geo-db-cities.get');
                        Route::get('/external/near-by-search', 'NearBySearchController@index')->name('near-by-search.get');
                    });
                    // Cities
                    Route::get('/cities', 'CitiesController@index')->name('cities.get');
                });

                // Test
                Route::namespace('Test')->group(function () {
                    Route::get('/dev-test/weather', 'TestController@weather')->name('test.weather.get');
                    Route::get('/dev-test/wiki', 'TestController@wiki')->name('test.wiki.get');
                    Route::get('/dev-test/find-place', 'TestController@find_place')->name('test.find-place.get');
                    Route::get('/dev-test/near-by-search', 'TestController@near_by_search')->name('test.near-by-search.get');
                });
            });
        });
    });
});
