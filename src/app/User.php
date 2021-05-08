<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    // 利用規約
    const NOT_AGREE_TO_TERMS_OF_SERVICE = 0;
    const AGREE_TO_TERMS_OF_SERVICE = 1;

    // プライバシポリシー
    const NOT_AGREE_TO_PRIVACY_POLICY = 0;
    const AGREE_TO_PRIVACY_POLICY = 1;

    // Check Registration
    const REGISTERED = 0;
    const NOT_REGISTERED = 1;

    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'api_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'unique_id',
        'email_verified_at',
        'created_at',
        'updated_at'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Override the mail body for reset password notification mail.
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new \App\Notifications\MailResetPasswordNotification($token));
    }

    public function socialUsers()
    {
        return $this->hasMany(SocialUser::class);
    }

    public function settings()
    {
        return $this->hasOne(Setting::class);
    }

    public function requestCountHistory()
    {
        return $this->hasMany(RequestCountHistory::class);
    }
}
