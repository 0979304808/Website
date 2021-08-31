<?php

namespace App\Models\Socials;

use Illuminate\Database\Eloquent\Model;
use App\Models\Admins\Admin;

class JLPT extends Model
{
    //
    protected $connection = 'mazii';
    protected $table = 'jlpt_info';
    protected $guarded = [];

    public function admin()
    {
        return $this->setConnection('mysql')->belongsTo(Admin::class,'admin_id','id')->withDefault(['username' => 'Admin đã bị xóa']);
    }

    public function language()
    {
        return $this->belongsTo(Language::class,'language_id','id');
    }
}
