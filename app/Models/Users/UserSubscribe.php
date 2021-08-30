<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;
class UserSubscribe extends Model
{
    protected $connection = 'mazii';
    protected $guarded = [];
    protected $table = 'user_subscribes';

    public function user(){
        return $this->belongsTo(UserMazii::class, 'user_id', 'userId');
    }
}
