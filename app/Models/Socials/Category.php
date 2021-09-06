<?php

namespace App\Models\Socials;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $connection = 'mazii';
    protected $table = 'soc_category';
    protected $guarded = [];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
