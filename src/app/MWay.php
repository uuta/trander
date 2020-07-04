<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MWay extends Model
{
    const WAYS = [
        'walking' => 1,
        'bycicle' => 2,
        'car' => 3
    ];
}
