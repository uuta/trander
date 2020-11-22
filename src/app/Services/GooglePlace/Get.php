<?php

namespace App\Services\GooglePlace;

use App\GooglePlaceId;

class Get
{
    /**
     * Get google place infomation
     *
     * @param string $id
     * @return array
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function get_google_place(string $id) : array
    {
        return json_decode(GooglePlaceId::get_information($id), true);
    }
}