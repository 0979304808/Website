<?php

namespace App\Models\Premiums;

use Illuminate\Database\Eloquent\Model;

class PremiumPackage extends Model
{
    protected $guarded = [];
    protected $hidden = ['created_at', 'updated_at'];

    protected static function boot()
    {
        parent::boot();
        static::deleting(function($model){
            $model->countries()->delete();
        });
    }

    /**
     * ==========
     * Relationship
     * ==========
     */
    public function countries(){
        return $this->hasMany(PremiumPackageCountry::class);
    }


    public function scopePublish($query){
        return $query->wherePublish(true);
    }
}
