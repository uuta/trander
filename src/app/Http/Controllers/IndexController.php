<?php

namespace App\Http\Controllers;

use App\GooglePlaceId;

class IndexController extends Controller
{
    public function index()
    {
        if (isset($_SERVER["HTTP_USER_AGENT"])) {
            preg_match('/kw\/share\/(.*)/', $_SERVER["REQUEST_URI"], $matches, PREG_OFFSET_CAPTURE);

            if ($matches) {
                $googlePlaceId = $matches[1][0];
                $googlePlace = GooglePlaceId::get_information($googlePlaceId);

                $title = $googlePlace->name . ' | Trander';
                $image_url = 'https://res.cloudinary.com/djnikeo2b/image/upload/l_text:Sawarabi%20Gothic_45_bold:' . $googlePlace->name . ',co_rgb:fff,w_500,c_fit/v1606123351/ogp_dynamic_yjqeow.png';
                $description = '星' . $googlePlace->rating . 'の' .$googlePlace->name . 'が出たよ！未知の領域に飛び出す街発見アプリケーション「Trader」で遊んでみよう。国内・国外で使用可能。現在地から0-100kmの範囲内で観光名所・都市をランダムに提案します。';

                return view('ogp')
                    ->with('title', $title)
                    ->with('image_url', $image_url)
                    ->with('description', $description);
            }
        }
        return view('index');
    }
}
