<?php

namespace App\Models\Purchase;

use Illuminate\Database\Eloquent\Model;
use App\Models\Admins\MaziiAdminUser;

class MaziiPurchase extends Model
{
    const __SUCCESS = 2;
    const __WAITING = 1;
    const __NEW = 0;
    const __DELETE = -1;
    const __TRANSFERED = 3; // Người dùng đã chuyển khoản

    protected $connection = 'mazii';
    protected $table = 'mazii_purchase';

    public function adminUser(){
        return $this->belongsTo(MaziiAdminUser::class,'admin_id','id_admin');
    }

    public function scopeSuccessOnMonth($query, $month, $year){
        return $query->where('status', self::__SUCCESS)->whereMonth('updated_at', $month)->whereYear('updated_at', $year);
    }
    
    public function scopeSuccessOnDay($query, $day){
        return $query->where('status', self::__SUCCESS)->whereBetween('updated_at', ["$day 00:00:00", "$day 23:59:59"]);
    }
   
    public function scopeSuccess($query){
        return $query->where('status', self::__SUCCESS);
    }

    public function scopeTotal($query){
        return $query->where('status', '<>', self::__DELETE);
    }

    public function scopeDate($query, $month, $year){
        return $query->whereMonth('created_at', $month)->whereYear('created_at', $year);
    }

    public function scopeSumPriceSuccess($query, $month, $year){
        return $query->where('status', self::__SUCCESS)->whereMonth('updated_at', $month)->whereYear('updated_at', $year)->sum('price');
    }

    public function scopeBetweenDate($query, $start, $end){
        return $query->whereBetween('created_at', ["$start 00:00:00", "$end 23:59:59"]);
    }

    public function scopeOnDay($query, $day){
        return $query->whereBetween('created_at', ["$day 00:00:00", "$day 23:59:59"]);
    }

    public function scopeMethod($query, $method){
        return $query->whereMethod($method);
    }

    public function scopeDevice($query, $device){
        return $query->where('device', 'like', "%$device%");
    }
    
    public function scopeCountry($query, $country){
        return $query->where('country', 'like', "%$country%");
    }

}
