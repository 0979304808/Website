<?php

namespace App\Models\Projects;

use App\Core\Traits\Helpful;
use App\Models\Codes\Code;
use App\Models\Orders\Order;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use SoftDeletes, Helpful;

    const _default = 'mazii';

    protected $guarded = [];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];
    /**
     * Relationship
     */

    public function codes(){
        return $this->belongsToMany(Code::class);
    }

    public function orders(){
        return $this->hasMany(Order::class);
    }

//    public function prices(){
//        return $this->hasMany(Price::class);
//    }
    //======== End relationships =========

    //======== Get - Set functions ========
    public function setSlugAttribute($slug){
        $this->attributes['slug'] = str_slug($slug);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function setNameAttribute($name){
        $this->attributes['name'] = strtolower($name);
    }

    public function getNameAttribute(){
        return ucfirst($this->attributes['name']);
    }
}
