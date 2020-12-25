<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MRating extends Model
{
    /**
     * Get rating
     *
     * @param float $rating
     * @return ?self
     */
    public function get_rating(float $rating) : ?self
    {
        return MRating::whereRaw('min <= ' . $rating . ' and max >' . $rating)
                ->first();
    }
}
