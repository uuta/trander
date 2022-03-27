<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class MWay extends Model
{
    // 移動手段
    const WAYS = [
        'walking' => 1,
        'bycicle' => 2,
        'car' => 3
    ];

    // 推奨度
    const RECOMMEND_FREQUENCY = [
        'none' => 0,
        'middle' => 1,
        'high' => 2
    ];
}
