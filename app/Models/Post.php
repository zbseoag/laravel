<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Post extends Model{
    use Searchable;

    /**
     * Get the index name for the model.
     *
     * @return string
     */
    public function searchableAs()
    {
        return 'post_table';
    }

    /**
     * 获取模型的可搜索数据。
     * @return array
     */
    public function toSearchableArray()
    {
        $array = $this->toArray();
        // 自定义数组
        return $array;
    }

    /**
     * 获取模型主键
     * @return mixed
     */
    public function getScoutKey()
    {
        return $this->email;
    }

    /**
     * 获取模型键名
     * @return string
     */
    public function getScoutKeyName()
    {
        return 'email';
    }

    /**
     * 一对多
     * 获取博客文章的评论
     */
    public function comments()
    {
        return $this->hasMany('App\Models\Comment', 'post_id', 'id');
    }


}
