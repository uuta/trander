<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class OAuthLoginController extends Controller
{
    /**
     * OAuth認証 リクエスト
     * @return mixed
     */
    public function getAuth()
    {
        $social = basename(parse_url($this->getUrl(), PHP_URL_PATH));
        return Socialite::driver($social)->redirect();
    }

    private function getUrl()
    {
        return (empty($_SERVER["HTTPS"]) ? "http://" : "https://") . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
    }

    /**
     * OAuth認証　コールバック
     */
    public function authCallback()
    {
        $social = basename(parse_url($this->getUrl(), PHP_URL_PATH));

        // ユーザ属性を取得
        $social_user = Socialite::driver($social)->user();

        // ログイン処理
        // ユーザ情報を元に検索
        // すでにDBにユーザ情報があるならログイン
        // ないならDBに登録の上ログイン
        $user = User::where('email', $social_user->email)->first();

        // デバッグ（デモンストレーション用）
        echo '<pre>';
        print_r($social_user);
        echo '<pre>';
        exit;
    }
}
