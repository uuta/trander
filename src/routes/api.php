<?php

use Illuminate\Http\Request;

// 会員登録
Route::post('/register', 'Auth\RegisterController@register')->name('register');

// ログイン
Route::post('/login', 'Auth\LoginController@login')->name('login');

// ログアウト
Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

// Twitterログイン
//Route::get('auth/twitter', 'OAuthLoginController@getAuth');
//Route::get('auth/callback/twitter', 'OAuthLoginController@authCallback');

// Facebookログイン
//Route::get('auth/facebook', 'OAuthLoginController@getAuth');
//Route::get('auth/callback/facebook', 'OAuthLoginController@authCallback');

// Googleログイン
//Route::get('auth/google', 'OAuthLoginController@getAuth');
//Route::get('auth/callback/google', 'OAuthLoginController@authCallback');
