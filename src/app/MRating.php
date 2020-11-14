<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MRating extends Model
{
    const RATING_MIN = 0;
    const RATING_MAX = 5;

    /**
     * Get rating
     *
     * @param float $rating
     * @return ?self
     */
    public function get_rating(float $rating) : ?self
    {
        if ($rating > self::RATING_MIN && $rating <= self::RATING_MAX) {
            return MRating::whereRaw('min <= ' . $rating . ' and max >' . $rating)
                    ->first();
        }
        return NULL;
    }
}
