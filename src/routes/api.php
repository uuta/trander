<?php

// 会員登録
Route::post('/register', 'Auth\RegisterController@register')->name('register');

// ログイン
Route::post('/login', 'Auth\LoginController@login')->name('login');

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

// Twitterログイン
Route::get('/social/twitter', 'Auth\LoginController@socialLogin')->name('social-login');
Route::get('/social/callback/twitter', 'Auth\LoginController@socialCallback')->name('social-callback');

// Facebookログイン
//Route::get('auth/facebook', 'OAuthLoginController@getAuth');
//Route::get('auth/callback/facebook', 'OAuthLoginController@authCallback');

// Googleログイン
//Route::get('auth/google', 'OAuthLoginController@getAuth');
//Route::get('auth/callback/google', 'OAuthLoginController@authCallback');
