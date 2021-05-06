<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Comment extends Model{


    use Searchable;

    /**
     * 一对多 (反向)
     * 获取该评论的所属文章
     */
    public function post()
    {
        return $this->belongsTo('App\Models\Post', 'post_id', 'id');
    }

}
