<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model
{
    protected $guarded = ['created_at'];

    public function user()
    {
        return $this->belongsTo(User::class, 'email', 'email');
    }
}
