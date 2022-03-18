<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class RequestLimit extends Model
{
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
