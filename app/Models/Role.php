<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Role extends Model{
    use Searchable;
    /**
     * 多对多
     * 拥有此角色的用户
     */
    public function users()
    {
        return $this->belongsToMany('App\Models\User', 'user_role_table', 'user_id', 'role_id');
    }

}
