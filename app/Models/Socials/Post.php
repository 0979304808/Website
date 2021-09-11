<?php

namespace App\Models\Socials;

use App\Models\Users\UserMazii;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    const _spam = -2;
    const _pin = true;
    const _delete = -1;
    const _choice = true;
    const _check = true;
    const _new = false;
    protected $connection = 'mazii';
    protected $table = 'soc_posts';
    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }

    public function user()
    {
        return $this->belongsTo(UserMazii::class, 'user_id', 'userId')->withDefault(['username' => 'Người dùng Mazii']);
    }

    public function pin()
    {
        $this->top = !$this->top;
    }

    public function spam()
    {
        $this->status = self::_spam;
        $this->editor_choice = !Post::_choice;
        $this->top = !Post::_pin;
    }

    public function choice()
    {
        $this->editor_choice = !$this->editor_choice;
        $this->status = self::_check;
    }

    public function delete()
    {
        $this->status = self::_delete;
        $this->editor_choice = !Post::_choice;
        $this->top = !Post::_pin;
    }

    public function check()
    {
        $this->status = !$this->status;
    }

    public function new()
    {
        $this->status = self::_new;
    }

    public function scopeLanguage($query, $language)
    {
        return $query->where('language_id', $language);
    }

    public function scopeAccount($query, $account)
    {
        return $query->where('user_id', $account);
    }

    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeUser($query,array $id)
    {
        return $query->whereIn('user_id', $id);
    }

    public function scopeHasId($query, $id)
    {
        return $query->where('id','!=',$id);
    }

    public function scopeCategory($query, $category)
    {
        return $query->where('category_id', $category);
    }

    public function scopePinTop($query)
    {
        return $query->where('top', 1);
    }

    public function scopeChoiceTop($query)
    {
        return $query->where('editor_choice', 1);
    }


}
