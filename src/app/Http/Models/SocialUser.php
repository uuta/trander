<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class SocialUser extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
