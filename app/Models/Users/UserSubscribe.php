<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;
use App\User;
class UserSubscribe extends Model
{
    protected $table = "user_subscribe";
    protected $guarded = [];

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
