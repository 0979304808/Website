<?php

namespace App\Models\Jobs;

use Illuminate\Database\Eloquent\Model;
use App\Models\Users\UserMazii;

class Job extends Model
{
    //
    protected $table = 'jobs';
    protected $guarded = [];
    protected $connection = 'mazii';

    public function user()
    {
        return $this->belongsTo(UserMazii::class, 'user_id', 'userId');
    }

    public function scopeType($query, $type)
    {
        return $query->whereType($type);
    }

    public function scopeActive($query, $active)
    {
        return $query->whereActive($active);
    }

    public function scopeCountry($query, $country)
    {
        return $query->whereCountry($country);
    }

    public function scopeProvince($query, $province)
    {
        return $query->whereProvince($province);
    }
}
