<?php

namespace App;

use DB;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Admin extends Authenticatable implements JWTSubject
{
    protected $table = 'admins';

    static $TableName = 'admins';

    public $timestamps = false;

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    static function EmailCheck($email)
    {
        $return = ['exists' => false];

        $admin = DB::table(self::$TableName)->where('email', $email)->first();
        if (!$admin) {
            return error('账号不存在');
        }
        $return['exists'] = true;

        return $return;
    }
}
