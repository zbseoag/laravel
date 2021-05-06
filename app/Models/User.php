<?php
/**
 * php artisan make:model User
 * php artisan make:model User --migration
 * php artisan make:model User --factory
 * php artisan make:model User --seed
 * php artisan make:model Flight --controller
 * php artisan make:model Flight -mfsc
 *
 */
namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    protected $table = 'users';
    //public $incrementing = true;
    //protected $keyType = 'string';
    //public $timestamps = false;//是否主动维护时间戳
    //protected $dateFormat = 'U';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    //protected $connection = 'connection-name';
    //模型属性的默认值
    protected $attributes = [
        'status' => 0
    ];

    protected $fillable = [
        'name',
        'email',
        'password',
    ];


    protected $hidden = [
        'password',
        'remember_token',
    ];


    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function phone()
    {
        return $this->hasOne('App\Models\Phone', 'user_id', 'id');
    }

    /**
     * 多对多
     * 用户拥有的角色
     */
    public function roles()
    {
        return $this->belongsToMany('App\Models\Role', 'user_role_table', 'user_id', 'role_id')
            ->as('access')//给中间表对象取一个名字
            ->withPivot('created_at')//查询中间表字段
            ->withTimestamps()//自动更新中间表时间
            ->wherePivot('approved', 1)//根据中间表条件过滤
            ->wherePivotIn('priority', [1, 2]);

        //其中的 pivot 表示中间表对象
        //foreach ($user->roles as $role) $role->pivot->created_at;

//        $users = User::with('podcasts')->get();
//        foreach ($users->flatMap->podcasts as $podcast) {
//            echo $podcast->subscription->created_at;
//        }



    }

    public function test(){
        echo 1991;
    }

}
