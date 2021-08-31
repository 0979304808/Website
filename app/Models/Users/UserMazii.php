<?php

namespace App\Models\Users;

use App\Models\Premiums\PremiumMazii;
use App\Models\Socials\Language;
use App\Models\Socials\Profile;
use Illuminate\Database\Eloquent\Model;

class UserMazii extends Model
{
    protected $connection = 'mazii';
    protected $table = 'users';
    protected $primaryKey = 'userId';
    protected $guarded = [];
    const _DELETE = -1;

    public function setPasswordAttribute($value){
        $this->attributes['password'] = bcrypt($value);
    }
    /**
     * Relastionships
     */
    public function premiums(){
        return $this->hasMany(PremiumMazii::class, 'userId', 'userId');
    }
    public function language(){
        return $this->belongsTo(Language::class);
    }

    public function usersubscribes(){
        return $this->hasMany(UserSubscribe::class,'user_id','userId');
    }

    public function profile(){
        return $this->belongsTo(Profile::class, 'userId', 'user_id')->select('user_id', 'name', 'image');
    }

//    public function profile(){
//        return $this->hasOne(ProfileUser::class, 'user_id', 'userId')->select(['profile_id', 'user_id', 'name', 'image', 'info', 'address','phone','email','job','birthday', 'need', 'country', 'level', 'sex','facebook'])
//        ->withDefault();
//    }


}
