<?php

namespace Modules\User\Entities;

use Hash;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;
    // Activate
    public static $ACTIVATED = 1;
    public static $DEACTIVATED = 0;
    // Level
    public static $IS_SUPER = 2;
    public static $IS_ADMIN = 1;
    public static $IS_USER = 0;

    protected $table = 'users';
    protected $primaryKey = 'user_id';
    protected $fillable = [
        "user_avatar",
        "user_full_name",
        "user_name",
        "password",
        "user_level",
        "user_token",
        "user_status"
    ];

    protected $hidden = [
        'password',
    ];
    public $timestamps = false;
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function getJWTCustomClaims()
    {
        return [];
    }
}
