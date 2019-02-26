<?php

namespace App;

use DB;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    static $TableName = "users";

    static function UserList($filters)
    {
        $return = ['items' => [], 'total' => 0];

        # 接收参数
        // filters
        $id = isset($filters['id']) ? $filters['id'] : '';
        $time = isset($filters['time']) ? $filters['time'] : '';
        // pagination
        $pageSize = isset($filters['pageSize']) ? $filters['pageSize'] : 10;
        $current = isset($filters['current']) ? $filters['current'] : 1;

        # 拼接SQL条件
        $where = [];
        if ($id) {
            array_push($where, ['id', '=', $id]);
        }
        if ($time) {
            array_push($where, ['created_at', '>=', strtotime($time[0])], ['created_at', '<', strtotime($time[1])]);
        }
        # total
        $return['total'] = DB::table(self::$TableName)->where($where)->count();
        if ($return['total'] === 0) {
            return $return;
        }
        # items
        $items = DB::table(self::$TableName)
            ->select('id', 'name', 'created_at')
            ->where($where)
            ->skip(($current - 1) * $pageSize)
            ->take($pageSize)
            ->orderBy('id', 'desc')
            ->get();
        foreach ($items as $item) {
            $return['items'][] = [
                'id' => $item->id,
                'name' => $item->name,
                'created_at' => $item->created_at,
            ];
        }

        return $return;
    }
}
