<?php

namespace App\Models\Socials;

use App\Models\Users\UserMazii;
use Illuminate\Database\Eloquent\Model;

class ChildComment extends Model
{
    const _spam = -2;
    const _delete = -1;
    const _check = true;
    const _new = false;
    protected $connection = 'mazii';
    protected $table = 'soc_parent_comment';
    protected $guarded = [];


    public function user()
    {
        return $this->belongsTo(UserMazii::class, 'user_id', 'userId')->withDefault(['username' => 'Người dùng Mazii']);
    }

    public function comment()
    {
        return $this->belongsTo(Comment::class);
    }

    public function spam()
    {
        $this->status = self::_spam;
    }

    public function delete()
    {
        $this->status = self::_delete;
    }

    public function check()
    {
        $this->status = !$this->status;
    }

    public function new()
    {
        $this->status = self::_new;
    }

    public function scopeLanguage($query, $lang)
    {
        return $query->whereLanguage_id($lang);
    }

    public function scopeStatus($query, $status)
    {
        return $query->whereStatus($status);
    }
}
