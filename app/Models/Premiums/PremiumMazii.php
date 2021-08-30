<?php

namespace App\Models\Premiums;

use App\Models\Users\UserMazii;
use Illuminate\Database\Eloquent\Model;

class PremiumMazii extends Model
{
    protected $connection = 'mazii';
    protected $table = 'premium';
    protected $primaryKey = 'premiumId';
    protected $guarded = [];

    public function user(){
        return $this->belongsTo(UserMazii::class, 'userId', 'userId');
    }

//    public function scopeProvider($query, $provider){
//        return $query->whereProvider($provider);
//    }
//
//    public function scopeOnDay($query, $day){
//        return $query->whereBetween('created_at', ["$day 00:00:00", "$day 23:59:59"]);
//    }
}
