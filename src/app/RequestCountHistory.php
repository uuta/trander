<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class RequestCountHistory extends Model
{
    protected $table = 'request_count_historys';

    const TYPE_ID = [
        'getGeoDbCities' => 0,
        'getWikidata' => 1,
        'getYahooLocalSearch' => 2,
        'getSimpleHotelSearch' => 3,
        'getCurrentWeather' => 4,
        'getGeoDbCitiesId' => 5,
        'getNearBySearch' => 6,
    ];

    public $timestamps = false;

    protected $fillable = ['user_id', 'type_id'];

    public function user()
    {
        return $this->hasOne(User::class);
    }

    /**
     * Set a history record
     *
     * @param int $type_id
     * @param int $user_id
     */
    public function setHistory(int $type_id, int $user_id): void
    {
        DB::table('request_count_historys')->insert(
            [
                'user_id' => $user_id,
                'type_id' => $type_id,
            ]
        );
    }
}
