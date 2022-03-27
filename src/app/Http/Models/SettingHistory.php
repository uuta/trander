<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class SettingHistory extends Model
{
    public $timestamps = false;

    public function setting()
    {
        return $this->belongsTo(Setting::class);
    }
}
