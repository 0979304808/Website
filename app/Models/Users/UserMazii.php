<?php

namespace App\Models\Users;

use App\Models\Logs\LogCodeActived;
use App\Models\Premiums\PremiumMazii;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Models\Users\UserSubscribe;
use App\Models\Users\ProfileUser;
use App\Models\Users\UserExpiredNote;

class UserMazii extends Model
{
    protected $connection = 'mazii';
    protected $table = 'users';
    protected $primaryKey = 'userId';
    protected $guarded = [];
    const _DELETE = -1;
    /**
     * Relastionships
     */
    public function premiums(){
        return $this->hasMany(PremiumMazii::class, 'userId', 'userId');
    }

    public function logs(){
        return $this->hasMany(LogCodeActived::class);
    }

    public function usersubscribes(){
        return $this->hasMany(UserSubscribe::class,'user_id','userId');
    }

    public function profile(){
        return $this->hasOne(ProfileUser::class, 'user_id', 'userId')->select(['profile_id', 'user_id', 'name', 'image', 'info', 'address','phone','email','job','birthday', 'need', 'country', 'level', 'sex','facebook'])
        ->withDefault();
    }

    public function expirednotes(){
        return $this->hasOne(UserExpiredNote::class,'user_id','userId')->withDefault();
    }
    //========= End ralationships =========

    public static function findToken($token){
        return self::where('tokenId', $token)->whereActive(true)->first();
    }

    public function beginExpired(){
        $now = Carbon::now()->timestamp;
        $premiumExpired = strtotime($this->premium_expired_date);
        return ($now < $premiumExpired) ? $premiumExpired : $now;
    }

    public function getExpired(array $times){
        $expired = $this->beginExpired();
        foreach($times as $time){
            $expired = strtotime("+".$time, $expired);
        }
        return Carbon::parse($expired);
    }

    public function addPremium($expired, $device, $code, $lifetime = false){
        $this->premiums()->create([
            'deviceId' => $device,
            'transaction' => $code,
            'provider' => 'card',
            'expire_at' => $this->getExpired($expired)
        ]);
        $this->premium_expired_date = $this->getExpired($expired);
        $this->premium_date = Carbon::now();
        $this->lastest_update = Carbon::now();
        if($lifetime){
            $this->lifetime = true;
        }
        $this->save();
    }
}
