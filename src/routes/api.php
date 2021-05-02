<?php

// モーダル用の値変更
Route::post('/change-registration', 'CheckController@changeRegistration')->name('change-registration');

// ログインユーザー
Route::get('/user', function () {
    return Auth::user();
})->name('user');

// Login
Route::namespace('Auth')->group(function () {
    // 会員登録
    Route::post('/register', 'RegisterController@register')->name('register');
    // ログイン
    Route::post('/login', 'LoginController@login')->name('login');
    // ログアウト
    Route::post('/logout', 'LoginController@logout')->name('logout');
    // パスワードリセット
    Route::post('/reset-password', 'ForgotPasswordController@sendPasswordResetLink')->name('reset-password');
    // パスワード再設定
    Route::post('/regenerate-password', 'ForgotPasswordController@callResetPassword')->name('regenerate-password');
    // SNS Login
    Route::get('/social/{social}', 'LoginController@socialLogin')->name('social-login');
    Route::get('/social/callback/{social}', 'LoginController@socialCallback')->name('social-callback');
});

// 外部API
Route::namespace('External')->group(function () {
    Route::post('/external/geo-db-cities', 'GeoDBCitiesApiController@request')->name('geo-db-cities')->middleware('auth');
    Route::get('/external/geo-db-cities', 'GeoDBCitiesApiController@index')->name('geo-db-cities.get')->middleware('auth');
    Route::get('/external/facility', 'FacilityController@index')->name('facility.get')->middleware('auth');
    Route::get('/external/hotel', 'HotelController@index')->name('hotel.get')->middleware('auth');
    Route::get('/external/weather', 'WeatherController@index')->name('weather.get')->middleware('auth');
    Route::get('/external/wiki-city', 'WikiController@city_index')->name('wiki.city.get')->middleware('auth');
    Route::get('/external/near-by-search', 'NearBySearchController@index')->name('near-by-search.get')->middleware('auth');
});

// Distance
Route::get('/distance', 'DistanceController@index')->name('distance.get')->middleware('auth');

// セッティング
Route::get('/setting', 'SettingController@get')->name('setting.get');
Route::post('/setting', 'SettingController@store')->name('setting.store');

// Google Place
Route::get('/google-place', 'GooglePlaceController@show')->name('google-place.get');

// Test
Route::namespace('Test')->group(function () {
    Route::get('/dev-test/weather', 'TestController@weather')->name('test.weather.get');
    Route::get('/dev-test/wiki', 'TestController@wiki')->name('test.wiki.get');
    Route::get('/dev-test/find-place', 'TestController@find_place')->name('test.find-place.get');
    Route::get('/dev-test/near-by-search', 'TestController@near_by_search')->name('test.near-by-search.get');
});