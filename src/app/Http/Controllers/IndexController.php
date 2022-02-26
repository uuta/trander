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
                $image_url = 'https://res.cloudinary.com/djnikeo2b/image/upload/l_text:Sawarabi%20Gothic_45_bold:' . $googlePlace->name . ',co_rgb:fff,w_500,c_fit/v1606123351/ogp_detail_da9r4t.png';
                $description = $googlePlace->name . '. Play with Trader, a city discovery application that takes you out into uncharted territory. Can be used domestically and internationally. Randomly suggests tourist attractions and cities within a range of 0-100km from your current location.';

                return view('ogp')
                    ->with('title', $title)
                    ->with('image_url', $image_url)
                    ->with('description', $description);
            }
        }
        return view('index');
    }
}
