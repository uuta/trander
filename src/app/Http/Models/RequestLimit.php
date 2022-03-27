<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class RequestLimit extends Model
{
    const DEFAULT_LIMIT = 10;
    const RESTORE_DATE = '-10 day';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
