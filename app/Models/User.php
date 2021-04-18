<?php
/**
 * 生成模型
 * php artisan make:model Flight
 *
 * 同时生成数据库迁移
 * php artisan make:model Flight --migration
 * php artisan make:model Flight --factory
 * php artisan make:model Flight --seed
 * php artisan make:model Flight --controller
 *
 * 同时生成 migration factory seed controller
 * php artisan make:model Flight -mfsc
 *
 */
namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Illuminate\Database\Eloquent\SoftDeletes;
use App\Scopes\AgeScope;




class User extends Authenticatable {
    use HasFactory, Notifiable, SoftDeletes;

    protected $table = 'user';

    protected $primaryKey = 'flight_id';
    protected $keyType = 'int'; //主键的类型
    public $incrementing = true; //主键是否自增
    public $timestamps = false;//主动维护时间戳
    protected $dateFormat = 'U'; //模型日期的存储格式

    const CREATED_AT = 'creation_date';
    const UPDATED_AT = 'last_update';
    protected $connection = 'connection-name';

    /**
     * 模型属性的默认值
     * @var array
     */
    protected $attributes = [
        'delayed' => false,
    ];

    /**
     * 可批量赋值属性
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * 不可批量赋值的属性
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];



    /**
     * 模型的事件映射
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'saved' => UserSaved::class,
        'deleted' => UserDeleted::class,
    ];


    /**
     * 模型的 "booted" 方法
     * @return void
     */
    protected static function booted(){
        //添加作用域后，对 User::all() 的查询会生成以下 SQL 查询语句：select * from `users` where `age` > 200
        static::addGlobalScope(new AgeScope);
        //取消
        User::withoutGlobalScope(AgeScope::class)->get();

        //匿名全局作用域
        static::addGlobalScope('age', function (Builder $builder) {
            $builder->where('age', '>', 200);
        });
        User::withoutGlobalScope('age')->get();


        // 取消所有的全局作用域...
        User::withoutGlobalScopes()->get();

        // 取消部分全局作用域...
        User::withoutGlobalScopes([
            FirstScope::class, SecondScope::class
        ])->get();


    }

    /**
     * 模型的 "booted" 方法
     * @return void
     */
    protected static function booted_2()
    {
        //注册事件处理
        static::created(function ($user) {

        });
        //可以在注册模型事件时利用队列匿名事件侦听器 。 这将指示 Laravel 使用 queue 执行模型事件侦听器
        static::created(Illuminate\Events\queueable(function ($user) {

        }));
    }



    /**
     *只查询受欢迎的用户的作用域
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePopular($query){
        return $query->where('votes', '>', 100);

        //使用： App\Models\User::popular()->active()->orderBy('created_at')->get();
        /*
        $users = App\Models\User::popular()->orWhere(function (Builder $query) {
            $query->active();
        })->get();
        */
    }

    /**
     * 只查询 active 用户的作用域
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query){
        return $query->where('active', 1);
    }

    /**
     *将查询作用域限制为仅包含给定类型的用户
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  mixed  $type
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);

        //$users = App\Models\User::ofType('admin')->get();
    }




}
