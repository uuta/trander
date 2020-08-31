<?php

// 会員登録
Route::post('/register', 'Auth\RegisterController@register')->name('register');

// ログイン
Route::post('/login', 'Auth\LoginController@login')->name('login');

// モーダル用の値変更
Route::post('/change-registration', 'CheckController@changeRegistration')->name('change-registration');

// ログアウト
Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

// ログインユーザー
Route::get('/user', function () {
    return Auth::user();
})->name('user');

// パスワードリセット
Route::post('/reset-password', 'Auth\ForgotPasswordController@sendPasswordResetLink')->name('reset-password');

// パスワード再設定
Route::post('/regenerate-password', 'Auth\ForgotPasswordController@callResetPassword')->name('regenerate-password');

// SNSログイン
Route::namespace('Auth')->group(function () {
    Route::get('/social/{social}', 'LoginController@socialLogin')->name('social-login');
    Route::get('/social/callback/{social}', 'LoginController@socialCallback')->name('social-callback');
});

// 外部API
Route::namespace('External')->group(function () {
    Route::post('/external/geo-db-cities', 'GeoDBCitiesApiController@request')->name('geo-db-cities');
    Route::get('/external/facility', 'FacilityController@index')->name('facility.get')->middleware('auth');
    Route::get('/external/hotel', 'HotelController@index')->name('hotel.get')->middleware('auth');
});

// セッティング
Route::get('/setting', 'SettingController@get')->name('setting.get');
Route::post('/setting', 'SettingController@store')->name('setting.store');

// Test
Route::namespace('Test')->group(function () {
    Route::get('/dev-test', 'TestController@index')->name('test.get');
});