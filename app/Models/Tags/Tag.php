<?php

namespace App\Models\Tags;

use Illuminate\Database\Eloquent\Model;
use  App\Models\Posts\Post; 

class Tag extends Model
{
    protected $table = "tags";
    protected $guarded = [];

    public function posts()
    {
        return $this->belongsToMany(Post::class, 'post_tag', 'tag_id', 'post_id');
    }
}
