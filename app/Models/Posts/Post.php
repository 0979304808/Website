<?php

namespace App\Models\Posts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laratrust\Traits\LaratrustUserTrait;
use App\Models\Categories\Category;
use App\Models\Tags\Tag;''
use App\Models\Admins\Admin;

class Post extends Model
{
    use LaratrustUserTrait;
    use Notifiable;
    protected $table = "posts";
    protected $guarded = [];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'post_category');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'post_tag');
    }

    public function author()
    {
        return $this->belongsTo(Admin::class,'admin_id');
    }
}
