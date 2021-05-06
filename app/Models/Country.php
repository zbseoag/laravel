<?php
/*
远程一对多关联
远程一对多关联提供了方便、简短的方式通过中间的关联来获得远层的关联。
例如，一个 Country 模型可以通过中间的 User 模型获得多个 Post 模型。在这个例子中，你可以轻易地收集给定国家的所有博客文章。

countries
id - integer
name - string

users
id - integer
country_id - integer
name - string

posts
id - integer
user_id - integer
title - string


 */
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    /**
     * 当前国家所有文章
     */
    public function posts()
    {
        return $this->hasManyThrough(
            'App\Models\Post',
            'App\Models\User',
            'country_id', // 国家表外键
            'user_id', // 用户表外键
            'id', // 国家表本地键
            'id' // 用户表本地键
        );

    }

}
